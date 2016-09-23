<?php

/**
 * 疾病关键词热搜专题
 * lc@2016-6-24
 */

namespace frontend\controllers;

use yii\helpers\Url;
use librarys\controllers\frontend\FrontController;
use librarys\helpers\utils\Utils;
use common\models\CacheHelper;
use common\models\KeyWords;
use common\models\disease\Article;
use common\models\Disease;
use common\models\Symptom;
use common\models\ask\Ask;
use common\models\Search;
use common\models\HotDepPart;
use common\models\ads\Ads;

class ZhuantiController extends FrontController {

    private $URL;
    private $keywords;
    private $diseaseArticle;
    private $disease;
    private $symptom;
    private $ask;

    public function init() {
        parent::init();
        $this->setLayout('zhuanti');

        $URL = [];
        $domainname = 'jb';
        $URL['domainname'] = $domainname;
        $URL['domainurl'] = 'http://' . $domainname . '.9939.com/so/';
        $URL['base_include_path'] = 'http://www.9939.com/9939/res/hot/' . $domainname;
        $URL['searchurl'] = 'http://' . $domainname . '.9939.com/so/';
        $URL['letterurl'] = 'http://' . $domainname . '.9939.com/so/';
        $URL['souurl'] = 'http://' . $domainname . '.9939.com/so/kw';
        $URL = (object) $URL;
        $this->URL = $URL;
    }

    public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => TRUE, //是否开启缓存
                'only' => ['index', 'letter', 'detail'], //需要添加缓存的方法列表
                'duration' => 24 * 60 * 60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }

    /**
     * 专题首页
     * @return type
     */
    public function actionIndex() {
        //设置title,keywords,description
        $name = '';
        $actionName = \Yii::$app->controller->action->id;
        $this->setMeta($name, $actionName);

        //最新热词
        $this->keywords = new KeyWords();
        $wd_dis_num = 23; //热词数量
        $where = ' typeid>1 ';
        $order = ' id DESC';
        $hotwords = $this->keywords->list_forpaging($where, $order, $wd_dis_num, 0);

        //疾病资讯
        $this->diseaseArticle = new Article();
        $art_dis_num = 24;
        $where = [
            ['status' => 99]
        ];
        $order = ' id DESC ';
        $art_new_list = $this->diseaseArticle->listByCondition($where, $art_dis_num, 0, $order);

        //专家咨询
        $ads = new Ads();
        $doctor_ads_text = $ads->ads(4591, 1, 0);

        //推荐医院
        $hospital_ads_text = $ads->ads(4592, 1, 0);

        //疾病大全
        $this->disease = new Disease();
        $totalnum = $this->disease->getCount();
        srand((double) microtime() * 10000000); //生成随机数种子
        $limit = rand(0, $totalnum - 1); //从0到最大记录数取随机数
        $disease_show_num = 24;
        $where = [
            'status' => 2
        ];
        $diseases = $this->disease->getDiseaseLimit($where, $limit, $disease_show_num);

        //症状大全
        $this->symptom = new Symptom();
        $totalnum = $this->symptom->getCount();
        srand((double) microtime() * 10000000); //生成随机数种子
        $limit = rand(0, $totalnum - 1); //从0到最大记录数取随机数
        $symptom_show_num = 24;
        $where = [
            'status' => 3
        ];
        $symptoms = $this->symptom->getSymptomLimit($where, $limit, $symptom_show_num);

        //热门问答
        $this->ask = new Ask();
        $where = ' 1 ';
        $order = ' id DESC ';
        $count = 24;
        $offset = 0;
        $asklist = $this->ask->getList($where, $order, $count, $offset);

        //热词
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = [];
        $filter_array = $this->getFilterArray();
        $cache_rand_words = KeyWords::getCacheRandWords(100, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $ret = isset($cache_rand_words[$wd]) ? $cache_rand_words[$wd] : array();
            if (count($ret) > 0) {
                $return_list[$wd] = array_splice($ret, 0, 10);
            } else {
                $return_list[$wd] = array();
            }
        }

        //字母导航
        $letterNav = $this->letterNav();

        //友情链接
        $links = $ads->ads_content(4610, 30);

        $model = [
            'url' => $this->URL,
            'hotwords' => $hotwords, //最新热词
            'diseaseArticle' => $art_new_list, //疾病资讯
            'diseases' => $diseases, //疾病大全
            'symptoms' => $symptoms, //症状大全
            'asklist' => $asklist, //热门问答
            'doctor_ads_text' => $doctor_ads_text, //专家咨询
            'hospital_ads_text' => $hospital_ads_text, //推荐医院
            'letterNav' => $letterNav, //字母导航
            'list' => $return_list, //热词
            'links' => $links, //友情链接
        ];
        return $this->render('index', [
                    'model' => $model
        ]);
    }

    /**
     * 专题字母页
     */
    public function actionLetter() {
        $wd = $this->helpGparam('pinyin', '');
        $currLetter = empty($wd) ? 'A' : strtoupper($wd);
        $page = $this->helpGparam('page', 1);

        //设置title,keywords,description
        $name = ['name' => $currLetter, 'page' => $page == '' ? 1 : $page];
        $actionName = \Yii::$app->controller->action->id;
        $this->setMeta($name, $actionName);

        //字母导航
        $letterNav = $this->letterNav(['letter' => $currLetter, 'cssname' => 'cusnt']);

        //每页数量
        $size = 200;
        $dis_page_num = 7;
        $format = $this->URL->domainurl . "{$wd}_%u/";
        $total_res = $this->getwordslist($wd, 0, $size); //获取总页码数
        $total = $total_res['total'];
        $paging = $this->helpPaging('pagerzt')->setSize($size)->setPageSetSize($dis_page_num)->setUrlFormat($format)->setTotal($total);
        $return_info = $this->getwordslist($wd, $paging->getCurrent(), $size);
        $list = $return_info['list'];

        $model = [
            'url' => $this->URL,
            'total' => $total,
            'paging' => $paging,
            'list' => $list,
            'letterNav' => $letterNav, //字母导航
        ];
        return $this->render('letter', [
                    'model' => $model
        ]);
    }

    /**
     * 专题详情页
     */
    public function actionDetail() {
        //处理关键词相关
        $wd = $this->helpGparam('pinyin', '');
        $detail['pinyinKeywords'] = $wd;

        $cn_key_name = '';
        if (!empty($wd)) {
            $this->keywords = new KeyWords();
            $wd_arr_info = $this->keywords->getKeywordName($wd);
            $cn_key_name = $wd_arr_info['keywords'];
        }
        $detail['cn_key_name'] = strip_tags($cn_key_name);

        //设置title,keywords,description
        $name = strip_tags($cn_key_name);
        $actionName = \Yii::$app->controller->action->id;
        $this->setMeta($name, $actionName);

        $size = 31;
        $condition = array(
            array(
                'filter' => 'filter_range',
                'args' => array('createtime', mktime(0, 0, 0, 11, 1, 2015), time())//2015.11.1-至今
            )
        );
        $return_art_info = $this->get_relartlist($cn_key_name, 0, $size, $condition);
        $rel_art_list = $return_art_info['list'];


        //问答
        $return_ask_info = $this->get_relasklist($cn_key_name, 0, 20);
        $ask_list = $return_ask_info['list'];
        $rel_ask_list = array();
        foreach ($ask_list as $k => $v) {
            $ask_record = $v['ask'];
            $ask_record['cntime'] = $this->formatAskTime($ask_record['ctime']);
            $ask_record['askurl'] = "http://ask.9939.com/id/" . $ask_record['id'];
            $rel_ask_list[] = $ask_record;
        }

        //随机关键词
        $randwords['letter'] = $letter = strtoupper($wd{0});
        $randwords['letter_list'] = $this->loadletterlist($letter);
        $randwords['randwords'] = $this->rand_words();

        //热门科室
        $hotDepPart = new HotDepPart();
        $disease_list = $hotDepPart->getCommonDisDep(5);

        //最新疾病资讯
        $this->diseaseArticle = new Article();
        $art_dis_num = 10;
        $where = [
            ['status' => 99]
        ];
        $order = ' id DESC ';
        $art_new_list = $this->diseaseArticle->listByCondition($where, $art_dis_num, 0, $order);


        //热门问答上广告位
        $ads = new Ads();
        $mid_ads_text = $ads->ads(4454, 1, 0);

        //推荐专家
        $mid_ads_docs = $ads->ads_content(4455, 4);

        //推荐医院
        $hospital_ads_text = $ads->ads(4592, 1, 0);

        $model = [
            'url' => $this->URL,
            'detail' => $detail,
            'mid_ads_text' => $mid_ads_text,
            'mid_ads_docs' => $mid_ads_docs,
            'hospital_ads_text' => $hospital_ads_text, //推荐医院
            'rel_art_list' => $rel_art_list,
            'rel_ask_list' => $rel_ask_list,
            'disease_list' => $disease_list,
            'diseaseArticle' => $art_new_list,
            'randwords' => $randwords,
        ];
        return $this->render('detail', [
                    'model' => $model
        ]);
    }

    //随机热词
    private function rand_words() {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 100;
        $max_dis_length = 18;
        $filter_array = $this->getFilterArray();
        $cache_rand_words = KeyWords::getCacheRandWords($max_kw_length, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $ret = isset($cache_rand_words[$wd]) ? $cache_rand_words[$wd] : array();
            if (count($ret) > 0) {
                $rand_num = count($ret) > $max_dis_length ? $max_dis_length : count($ret);
                $rand_keys = array_rand($ret, $rand_num);
                if (is_array($rand_keys)) {
                    foreach ($rand_keys as $k) {
                        $return_list[$wd][] = $ret[$k];
                    }
                } else {
                    $return_list[$wd][] = $ret[0];
                }
            } else {
                $return_list[$wd] = array();
            }
        }
        return $return_list;
    }

    private function loadletterlist($letter) {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        for ($i = 0; $i < $len; $i++) {
            $l = strtoupper($letter_list{$i});
            $return_list[$l] = array(
                'url' => sprintf('%s%s/', $this->URL->letterurl, $l),
                'selected' => ($letter == $l) ? 1 : 0
            );
        }
        return $return_list;
    }

    //获取相关词
    private function getwordslist($wd, $offset, $size) {
        $filter_array = $this->getFilterArray();
        return Search::search_words_byinitial($wd, $offset, $size, $filter_array);
    }

    //获取相关文章
    private function get_relartlist($wd, $offset, $size, $condition) {
//        return Search::search_article($wd, $offset, $size);
        $explain_ext_config = array(
            'is_ext_words' => 1
        );
        $explainflag = 1;
        return Search::search_jb_article($wd, $offset, $size, $condition,$explainflag,$explain_ext_config);
    }

    //获取相关问答
    private function get_relasklist($wd, $offset, $size) {
        $explain_ext_config = array(
            'is_ext_words' => 1
        );
        $explainflag = 1;
        $condition = $this->rand_condition();
        return Search::search_ask($wd, $offset, $size,$condition,$explainflag,$explain_ext_config);
    }

    //格式化时间
    private function formatAskTime($ctime) {
        $max_diff = 24 * 60 * 60;
        $one_hour_diff = 1 * 60 * 60;
//        $one_minu_diff = 60*60;
        $curr_time = time();
        $diff_time = $curr_time - $ctime;
        if ($diff_time > $max_diff) {
            return date('Y-m-d', $ctime);
        } else if ($diff_time > $one_hour_diff) {
            return sprintf('%d小时前', ceil($diff_time / 3600));
        } else {
            return sprintf('%d分钟前', ceil($diff_time / 60));
        }
    }

    /**
     * 字母导航
     * @param type $params
     * @return string
     */
    public function letterNav($params = array('letter' => 'A', 'cssname' => 'cusnt1')) {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $letter['curr_letter'] = strtoupper($params['letter']);
        $letter['curr_cssname'] = $params['cssname'];
        for ($i = 0; $i < $len; $i++) {
            $l = strtoupper($letter_list{$i});
            $return_list[$l] = array(
                'url' => $this->URL->letterurl . $l . '/',
                'selected' => ($letter['curr_letter'] == $l) ? 1 : 0
            );
        }
        $letter['return_list'] = $return_list;
        return $letter;
    }

    /**
     * 设置网站title,keywords,description
     * lc 2016-6-24
     * @param type $name
     * @param type $page
     */
    public function setMeta($result, $page = 'index') {
        if (is_array($result)) {
            $pageno = $result['page'];
            $name = $result['name'];
        } else {
            $name = $result;
        }

        switch ($page) {
            //首页
            case 'index':
                $meta['title'] = "病初期症状_病症查询_疾病知识大全_疾病专题_久久健康网";
                $meta['keywords'] = "病症查询,病初期症状,疾病知识";
                $meta['description'] = "久久健康网疾病专题囊括了疾病健康知识大全,病初期症状,病症查询,疾病专题等相关内容，从疾病症状到治疗方法，为您提供最专业、科学的指导和帮助。";
                break;

            //字母导航页
            case 'letter':
                $meta['title'] = "{$name}_第{$pageno}页_疾病热搜_疾病专题_久久健康网";
                $meta['keywords'] = "疾病热搜,疾病搜索,{$name},第{$pageno}页";
                $meta['description'] = "久久健康网疾病专题囊括了疾病热搜,疾病搜索,{$name}等相关内容，从疾病症状到治疗方法，为您提供更专业、科学的指导和帮助。";
                break;

            //详情页
            case 'detail':
                $meta['title'] = "{$name}_疾病专题_久久健康网";
                $meta['keywords'] = "{$name},{$name}专题,{$name}知识 ";
                $meta['description'] = "久久健康网疾病专题囊括了{$name},{$name}专题,{$name}知识等相关内容，从疾病症状到治疗方法，为您提供更专业、科学的指导和帮助。";
                break;
        }
        $this->getView()->title = $meta;
    }

    private function getFilterArray() {
        return array(
            array(
                'filter' => 'filter',
                'args' => array('typeid', array(99))
            )
        );
    }

     //随机相关文章与相关问答的查询日期条件
    private function rand_condition() {
//        $condi_create_time=array(
//            array(0,1262188800),//0-2009.12.31
//            array(1262188800,1293724800),//2009.12.31-2010.12.31
//            array(1293724800,1419955200),//2010.12.31-2014.12.31
//            array(1419955200,1451491200),//2014.12.31-2015.12.31
//            array(1451491200,1483113600),//2015.12.31-2016.12.31
//        );
        $curr_time = time();
        $condi_create_time = array(
            array(0, 1293724800), //0-2010.12.31
            array(1293724800, 1419955200), //2010.12.31-2014.12.31
            array(1419955200, 1451491200), //2014.12.31-2015.12.31
            array(1451491200, $curr_time), //2015.12.31-2016.12.31
        );

        $len = count($condi_create_time);
        $rd = mt_rand(0, $len - 1);
        $min = $condi_create_time[$rd][0];
        $max = ($rd == $len - 1) ? time() : $condi_create_time[$rd][1];
        return array(
            array(
                'filter' => 'filter_range',
                'args' => array('createtime', $min, $max)
            )
        );
    }

}
