<?php

/**
 * @version 0.0.0.1
 */

namespace common\models;

use common\models\ask\Ask;
use common\models\Disease;
use common\models\disease\Article as DArticle;
use librarys\controllers\BaseController;
use librarys\helpers\utils\SearchHelper;

/**
 * 缓存工具类
 * @author gaoqing
 */
class CacheHelper {

    use FSearchTrait;

    const DURATION = 3600;

    /**
     * 根据标识，得到对应标识的缓存信息
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @param mixed $variable 方法执行参数
     * @return mixed 缓存信息
     */
    public static function getCache($cacheKey, $variable) {
        /*
         * 1、根据 $cacheKey，得到对应的处理缓存的function
         * 2、调用当前得到的 function
         */
        if (isset($cacheKey) && !empty($cacheKey)) {
            $method = self::getMethod($cacheKey);
            return self::$method($cacheKey, $variable);
        }
        return [];
    }

    /**
     * 根据缓存标识，得到缓存处理的方法
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @return string 缓存处理的方法名
     */
    public static function getMethod($cacheKey) {
        $cacheMethodMap = [
            'frontend_symptom_index_knjb' => 'cacheSymptomRelateDisease', //症状 首页 可能疾病 缓存数据
            'frontend_symptom_index_xgwd' => 'cacheSymptomRelateAsk', //症状 首页 相关问答 缓存数据
            'frontend_symptom_zixun_xgwd' => 'cacheSymptomRelateAsk', //症状 在线咨询 相关问答 缓存数据
            'frontend_disease_index_wzjd' => 'readArticleByDisease', //疾病首页--文章解读
            'frontend_article_detail_xgwz' => 'getDisArticleRelArts', //疾病文章--相关文章
            'frontend_symptom_detail_xgwz' => 'getSymImgRelArts', //症状图集--相关文章
            'frontend_disease_detail_xgwz' => 'getDisImgRelArts', //疾病图集--相关文章
            'frontend_article_detail_rmksbw' => 'getCommonDiseaseDepartment', //疾病文章--热门科室，热门部位
            'frontend_article_detail_rmksbw_404' => 'getCommonDiseaseDepartmentFor404', //疾病文章--热门科室，热门部位 (404 页面使用)
            'frontend_404_page' => 'cache404Page', //404 静态页面
            'frontend_disease_index_gzwt' => 'getDiseaseCareAsks', //疾病首页--患者关注问题
            'frontend_index_inc_mid_news' => 'cacheIndexNewsBySphinx', //首页 疾病资讯 inc_mid_news文件里的数据缓存
            'frontend_index_makehtml' => 'makeHtmlIndex', //生成首页
        ];
        return $cacheMethodMap[$cacheKey];
    }

    /**
     * 生成 404 静态页面
     * @author gaoqing
     * @date 2016-04-20
     * @param string $cacheKey 缓存的唯一标识
     * @return boolean$generateFlag是否生成成功
     */
    public static function cache404Page($cacheKey, $param = [], $forceCache = false) {
        $generateFlag = false;

        $frontend = \Yii::getAlias('@frontend');
        $page404FileName = $frontend . '/web/404.shtml';

        if (!file_exists($page404FileName)) {
            $forceCache = true;
        }
        if ($forceCache) {

            $view = "404";

            //获取最新的资讯文章
            $article = new Article();
            $where = ' status=20';
            $order = ' articleid DESC';
            $lastestNews = $article->List_Articles($where, $order, 5, 0);

            //获取 疾病健康 文章
            $darticle = new \common\models\disease\Article();
            $lastestJibingArticle = $darticle->getLatestArticle(5, 0);

            //精彩问答
            $ask = new Ask();
            $where1 = ' 1';
            $order1 = ' id DESC';
            $lastestAsk = $ask->getList($where1, $order1, 5, 0);

            //字母部分
            $letters = range('A', 'Z');
            $condition = array('typeid' => array(0, 2, 3, 4, 5, 6, 7, 8, 9));
            $rand_words = KeyWords::getCacheRandWords(100, $condition);

            //热门疾病、热门部位
            $commonDisDep = CacheHelper::getCache('frontend_article_detail_rmksbw_404', []);

            $params = [
                'lastestNews' => $lastestNews,
                'lastestJibingArticle' => $lastestJibingArticle,
                'lastestAsk' => $lastestAsk,
                'letters' => $letters,
                'rand_words' => $rand_words,
                'commonDisDep' => $commonDisDep,
                'searchurl' => 'http://www.9939.com/zhuanti/',
            ];
            $controller = new BaseController('base404', null);
            $controller->id = "base404";
            $page404FilePath = $frontend . '/views/site';
            $controller->viewPath = $page404FilePath;
            $page404 = $controller->renderPartial($view, $params);

            if (isset($page404) && !empty($page404)) {
                if (file_put_contents($page404FileName, $page404)) {
                    $generateFlag = true;
                }
            }
        }
        return $generateFlag;
    }

    /**
     * 得到疾病文章页中的 热门科室，热门部位
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @param array $disease 疾病信息
     * @param boolean $forceCache 强制缓存 （false: 不强制缓存缓存；true: 强制缓存（清除之前的缓存，重新生成新的缓存））
     * @return array 疾病文章页中的 热门科室，热门部位
     */
    public static function getDiseaseCareAsks($cacheKey, $disease, $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey . '_' . $disease['id'];
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $asks = Search::search_ask($disease['keywords'], 0, 5);
            if (isset($asks) && !empty($asks)) {
                $data = $asks;
                $cache->set($cacheFileName, $asks, self::DURATION);
            }
        }
        return $data;
    }

    /**
     * 得到疾病文章页中的 热门科室，热门部位 （404 页面使用）
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @param array $column 所需的参数
     * @return array 疾病文章页中的 热门科室，热门部位
     */
    public static function getCommonDiseaseDepartmentFor404($cacheKey, $param = [], $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey;
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $commonDisDep = HotDepPart::getCommonDisDep(7);
            if (isset($commonDisDep) && !empty($commonDisDep)) {
                $data = $commonDisDep;
                $cache->set($cacheFileName, $commonDisDep);
            }
        }
        return $data;
    }

    /**
     * 得到疾病文章页中的 热门科室，热门部位
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @param array $column 所需的参数
     * @return array 疾病文章页中的 热门科室，热门部位
     */
    public static function getCommonDiseaseDepartment($cacheKey, $param = [], $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey;
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
//            $commonDisDep = HotDepPart::getCommonDepPart(8);
            $commonDisDep = HotDepPart::getCommonDepPart();
            if (isset($commonDisDep) && !empty($commonDisDep)) {
                $data = $commonDisDep;
                $cache->set($cacheFileName, $commonDisDep);
            }
        }
        return $data;
    }

    /**
     * 获取疾病文章的相关文章与问答
     * 文章需要获取22条.相似的文章:12条,右侧相关文章:10条
     * @author gaoqing
     * @date 2016-04-15
     * @param string $cacheKey 缓存的唯一标识
     * @param int $article 疾病文章
     * @return array 疾病文章的相关文章集
     */
    public static function getDisArticleRelArts($cacheKey, $article, $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey . '_' . $article['id'];
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $relArticles = array();
            //首先通过 diseaseid 得到其 相关文章集
            $diseaseid = $article['diseaseid'];
            $iswapjb = isset($article['iswapjb']) ? $article['iswapjb'] : false;
            if ($diseaseid > 0) {
                $relArticles = self::getRelArticles($diseaseid, $iswapjb);
            } else {
                $symptomid = $article['symptomid'];
                $relArticles = self::getRelArticlesBySymptomid($symptomid, $iswapjb);
            }

            //batch sphinx search for relevant articles and relevant asks
            $keywords = array(
                array('word' => $article['title'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 22),
                array('word' => $article['title'], 'indexer' => 'index_wd_ask,index_wd_ask_history_1,index_wd_ask_history_2,index_wd_ask_history_3,index_wd_ask_history_4,index_wd_ask_history_5,index_wd_ask_history_6,index_wd_ask_history_7', 'offset' => 0, 'size' => 4)
            );
            $isGetArticle = true;
            if (!empty($relArticles)){
                $isGetArticle = false;
                array_shift($keywords);
            }
            $data = self::getRelArtsAndAsksInArticle($keywords, $isGetArticle);
            if (!empty($relArticles)){
                $data['relArticles'] =  array('list' => $relArticles);
            }
            $cache->set($cacheFileName, $data, self::DURATION);
        }
        return $data;
    }
    public static function getSymImgRelArts($cacheKey, $article, $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey . '_' . $article['id'];
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {

            $relArticles = array();
            $diseaseid = $article['diseaseid'];
            $iswapjb = isset($article['iswapjb']) ? $article['iswapjb'] : false;
            $relArticles = self::getRelArticlesBySymptomid($diseaseid, $iswapjb);

            //batch sphinx search for relevant articles and relevant asks
            $keywords = array(
                array('word' => $article['title'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 22),
                array('word' => $article['title'], 'indexer' => 'index_wd_ask,index_wd_ask_history_1,index_wd_ask_history_2,index_wd_ask_history_3,index_wd_ask_history_4,index_wd_ask_history_5,index_wd_ask_history_6,index_wd_ask_history_7', 'offset' => 0, 'size' => 4)
            );

            $isGetArticle = true;
            if (!empty($relArticles)) {
                $isGetArticle = false;
                array_shift($keywords);
            }
            $data = self::getRelArtsAndAsksInArticle($keywords, $isGetArticle);
            if (!empty($relArticles)) {
                $data['relArticles'] = array('list' => $relArticles);
            }
            $cache->set($cacheFileName, $data, self::DURATION);
        }
        return $data;
    }
    public static function getDisImgRelArts($cacheKey, $article, $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey . '_' . $article['id'];
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {

            $relArticles = array();
            //首先通过 diseaseid 得到其 相关文章集
            $diseaseid = $article['diseaseid'];
            $iswapjb = isset($article['iswapjb']) ? $article['iswapjb'] : false;
            $relArticles = self::getRelArticles($diseaseid, $iswapjb);

            //batch sphinx search for relevant articles and relevant asks
            $keywords = array(
                array('word' => $article['title'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 22),
                array('word' => $article['title'], 'indexer' => 'index_wd_ask,index_wd_ask_history_1,index_wd_ask_history_2,index_wd_ask_history_3,index_wd_ask_history_4,index_wd_ask_history_5,index_wd_ask_history_6,index_wd_ask_history_7', 'offset' => 0, 'size' => 4)
            );
            $isGetArticle = true;
            if (!empty($relArticles)){
                $isGetArticle = false;
                array_shift($keywords);
            }
            $data = self::getRelArtsAndAsksInArticle($keywords, $isGetArticle);
            if (!empty($relArticles)){
                $data['relArticles'] =  array('list' => $relArticles);
            }
            $cache->set($cacheFileName, $data, self::DURATION);
        }
        return $data;
    }

    /**
     * 获取疾病文章的相关文章
     * @author gaoqing
     * @date 2016-04-26
     * @param array $params 参数
     * @return array 疾病文章的相关文章集
     */
    private static function getRelArticles($diseaseid, $iswapjb = false)
    {
        $articleids = [];
        $rarticles = Relate::getRelArticlesByDisid($diseaseid,0,22,'id desc');
        if (!empty($rarticles)) {
            foreach ($rarticles as $rarticle) {
                if(count($articleids)<22){
                    $articleids[] = $rarticle['articleid'];
                }
            }
        }
        $relCondition = ['id' => $articleids];
        $relArticles = DArticle::search($relCondition, 0, 22, 'id desc');
        if (isset($relArticles['list']) && !empty($relArticles['list'])){
            $relArticles = $relArticles['list'];
            if ($iswapjb){
                foreach ($relArticles as &$relArticle){
                    $date_path = date('Y/md',$relArticle['inputtime']);
                    $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$relArticle['id']);
                    $relArticle['url'] = sprintf('%s/%s', \Yii::getAlias('@jb_domain'), $article_path);
                    $relArticle['wap_url']=sprintf('%s/%s', \Yii::getAlias('@mjb_domain'), $article_path);
                }
            }
        }else{
            $relArticles = [];
        }
        return $relArticles;
    }
    /**
     * 获取疾病文章的相关文章
     * @author gaoqing
     * @date 2016-04-26
     * @param array $params 参数
     * @return array 疾病文章的相关文章集
     */
    private static function getRelArticlesBySymptomid($symptomid, $iswapjb = false) {
        $articleids = [];
        $darticle = new DArticle();
        $rarticles = $darticle->listByCondition([['status' => '99'], ['symptomid' => $symptomid]], 22, 0, 'id DESC');

        if (isset($rarticles) && !empty($rarticles)) {
            $relArticles = $rarticles;
            if ($iswapjb) {
                foreach ($relArticles as &$relArticle) {
                    $date_path = date('Y/md', $relArticle['inputtime']);
                    $article_path = sprintf("%s/%s/%d.shtml", 'article', $date_path, $relArticle['id']);
                    $relArticle['url'] = sprintf('%s/%s', \Yii::getAlias('@jb_domain'), $article_path);
                    $relArticle['wap_url'] = sprintf('%s/%s', \Yii::getAlias('@mjb_domain'), $article_path);
                }
            }
        } else {
            $relArticles = [];
        }
        return $relArticles;
    }

    /**
     * 疾病首页 下的 文章解读缓存部分
     * @author gaoqing
     * @date 2016-04-15
     * @param sting $cacheKey 缓存的唯一标识
     * @param array $diseaseid 疾病id
     * @return array 文章解读数据集
     */
    public static function readArticleByDisease($cacheKey, $disease, $forceCache = false) {
        $cache = \Yii::$app->cache_data_file;
        $cacheFileName = $cacheKey . '_' . $disease['id'];
        $data = $cache->get($cacheFileName);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $conditions = array(
                array('word' => $disease['name'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 4, 'condition' => array(array('filter' => 'filter', 'args' => array('tmp_type_id', array(2, 7))))),
                array('word' => $disease['name'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 4, 'condition' => array(array('filter' => 'filter', 'args' => array('tmp_type_id', array(1, 3, 4))))),
                array('word' => $disease['name'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 4, 'condition' => array(array('filter' => 'filter', 'args' => array('tmp_type_id', array(5))))),
                array('word' => $disease['name'], 'indexer' => 'index_9939_com_jb_art', 'offset' => 0, 'size' => 4, 'condition' => array(array('filter' => 'filter', 'args' => array('tmp_type_id', array(6, 8))))),
            );
            $diseaseArtids = SearchHelper::batchSearch($conditions);

            $result = array();
            $keys = ['病因是什么', '症状有哪些', '怎么治疗', '如何护理'];
            foreach ($diseaseArtids as $key => $ret) {
                $indexer_name = $ret['indexer'];
                $sphinx_result = Search::parse_search_data($ret, $indexer_name);
                $ret_list = [];
                if (!empty($sphinx_result['list'])) {
                    $ret_list = $sphinx_result['list'];
                }
                $result[$keys[$key]] = $ret_list;
            }
            if (!empty($result)) {
                $data = $result;
                $cache->set($cacheFileName, $result, self::DURATION);
            }
        }
        return $data;

        /* $cache = \Yii::$app->cache_data_file;
          $cacheFileName = $cacheKey . '_' . $disease['id'];
          $data = $cache->get($cacheFileName);
          if ($forceCache){
          $data = false;
          }
          if (!isset($data) || empty($data)){
          $article = new DArticle();
          $allReads = [];
          $moduleMap = [
          '病因是什么' => [2, 7],
          '症状有哪些' => [1, 3, 4],
          '怎么治疗' => [5],
          '如何护理' => [6, 8],
          ];
          foreach ($moduleMap as $key => $types){
          $preList = $article->getListByDiseaseid(['diseaseid' => $disease['id'], 'type' => $types], 0, 4);
          $allReads[$key] = $preList;
          }
          if (!empty($allReads)){
          $data = $allReads;
          $cache->set($cacheFileName, $allReads);
          }
          }
          return $data; */
    }

    /**
     * 症状首页可能疾病缓存数据
     * lc 2016-4-15
     * @param type $cacheKey 缓存的唯一标识
     * @param type $parms 单条症状所有字段内容数组
     * @param type $forceCache 是否强制缓存，默认不强制缓存
     * @return type
     */
    public static function cacheSymptomRelateDisease($cacheKey, $parms, $forceCache = false) {
        $symptomid = $parms['id'];

        $cache = \Yii::$app->cache_data_file;
        $key = $cacheKey . '_' . $symptomid;
        $data = $cache->get($key);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $relate = new Relate();
            $disease = new Disease();
            $department = new Department();
            $diseaseList = $relate->getRelateDiseases($symptomid); //根据关联表查询出疾病id,该症状对应的疾病下的所有疾病信息
//            print_r($diseaseList);exit;
            if (!empty($diseaseList)) {
                $diseaseId = [];
                foreach ($diseaseList as $k => $v) {
                    $diseaseId[] = $v['diseaseid'];
                }
                $diseaseMap = $disease->batchGetDiseaseById($diseaseId); //该症状对应的疾病下的所有疾病信息
                $symptomMap = $relate->batchGetSymptomsByDisid($diseaseId); //该症状对应的疾病下对应的所有相关症状
                $diseaseIdStr = implode(',', $diseaseId);
                $departmentMap = $department->batchGetDepartmentsByDisid($diseaseIdStr); //该症状对应的疾病对应的所有科室
                //                print_r($departmentMap);exit;
                foreach ($symptomMap as $k => $v) {
                    $disId = $v['diseaseid'];
                    $symId = $v['symptomid'];
                    foreach ($diseaseMap as $kk => $vv) {
                        $pinyin = $vv['pinyin_initial'];
                        if ($vv['id'] == $disId) {
                            $tmp[$pinyin][] = $v;
                        }
                    }
                }
                $diseaseTmp['relDisease'] = $diseaseMap;
                $diseaseTmp['relSymptom'] = $tmp;
                $disTmp = [
                    'diseaseMap' => $diseaseMap,
                    'symptomMap' => $symptomMap,
                    'departmentMap' => $departmentMap,
                    'diseaseTmp' => $diseaseTmp,
                    'diseaseId' => $diseaseId,
                ];

                $cache->set($key, $disTmp);
                return $disTmp;
            }
            return array();
        } else {
            return $data;
        }
    }

    /**
     * 症状首页相关问答缓存数据
     * lc 2016-4-15
     * @param type $parms
     * @return type
     */
    public static function cacheSymptomRelateAsk($cacheKey, $parms, $forceCache = false) {
        $search = new Search();
        $symptomid = $parms['id'];
        $name = $parms['name'];

        $cache = \Yii::$app->cache_data_file;
        $key = $cacheKey . '_' . $symptomid;
        $data = $cache->get($key);
        if ($forceCache) {
            $data = false;
        }
        if (!isset($data) || empty($data)) {
            $questions = Search::search_ask($name, 0, 5);
            $cache->set($key, $questions, self::DURATION);
            return $questions;
        } else {
            return $data;
        }
    }

    /**
     * 生成首页，待解决
     * lc 2016-4-25
     * @param string $cacheKey
     * @param array $param
     * @param boolean $forceCache
     */
    public static function makeHtmlIndex($cacheKey, $param = [], $forceCache = false) {
        $url = \Yii::getAlias('@frontdomain') . '/create/jb_index?forcemakehtml=1';
        $ret = @file_get_contents($url);
        return $ret;
    }

    /**
     * 使用curl请求url地址
     * @param string $durl
     * @return string
     */
    public static function curl_file_get_contents($durl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

}
