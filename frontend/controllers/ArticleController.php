<?php
/**
 * @version 0.0.0.1
 */

namespace frontend\controllers;


use common\models\ads\Ads;
use common\models\CacheHelper;
use common\models\Disease;
use common\models\disease\Article;
use common\models\FSearchTrait as SearchTrait;
use common\models\Image;
use common\models\KeyWords;
use common\models\Relate;
use common\models\Symptom;
use common\models\SymptomContent;
use frontend\models\DiseaseService;
use librarys\controllers\frontend\FrontController;
use librarys\helpers\utils\SearchHelper;
use yii\base\Module;
use yii\web\NotFoundHttpException;

class ArticleController extends FrontController
{
	use SearchTrait;
    private $article = null;
    private $diseaseService = null;
    private $symptom;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->article = new Article();
        $this->diseaseService = new DiseaseService();
        $this->symptom = new Symptom();
    }

    public function init()
    {
        $this->article = new Article();
        $this->diseaseService = new DiseaseService();
        parent::init();
        $this->setLayout('article');
    }
    
     public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled'=> true,
                //'only' => ['*'], //需要添加缓存的方法列表
                'duration' => 12 * 60 * 60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }
    
    /**
     * 疾病图集
     * @author gaoqing
     * @date 2016-03-25
     * @return string 视图
     */
    public function actionDisimages(){
        $view = "disease_images";
        $dname = $this->helpGparam('dname', "");
        $dname = trim($dname, '/');
        $domudle = $this->helpGparam('dmodule', 'tuji');
        $domudle = trim($domudle, '/');
        $pageStr = trim(trim($domudle, 'tuji'), '_');
        $page = 1;
        if (!empty($pageStr)){
            $page = intval($pageStr);
        }
        $disease = $this->diseaseService->getDiseasesByPinyin($dname, false, false, false, false);
        //图集信息
        $icondition = ['flag' => 1, 'relid' => $disease['id']];
        $size = 1;
        $paging = $this->helpPaging('pager')->setSize($size)->setPageSetSize(9)->setUrlFormat('/' . $dname . '/tuji_%d'. '/')->setCurrentClass('cupat');
        $offset = $paging->getOffset();
        $images = Image::search($icondition, $offset, $size, 'id DESC',true);
        $imagesList = $images['list'];
        $paging->setTotal($images['total']);

        //获取相关疾病文章
        $relArtsAndAsks = CacheHelper::getCache('frontend_disease_detail_xgwz', ['title' => $disease['name'], 'id' => $disease['id'], 'diseaseid' => $disease['id'], 'pinyin' => $disease['pinyin']]);
        $relArticles = $relArtsAndAsks['relArticles'];

        //相关问答
        $asks = $relArtsAndAsks['relAsks'];

        //大家还在找部分
        $stillFind = $this->getStillFindDatas($disease['name']);

        //右侧：最新文章
        $lastestArticles = $this->getLatestArticles();
        
        $return_img_list = [];
        foreach ($imagesList as $k=>$v){
            $v['url'] =  \librarys\helpers\utils\Url::getuploadfileUrl(1, $v['name']);
            $return_img_list[] = $v;
        }

        $params = [
            'disease' => $disease,
            'imagesList' => $return_img_list,
            'relArticles' => $relArticles,
            'paging' => $paging,
            'asks' => $asks,
            'lastestArticles' => $lastestArticles,
            'stillFind' => $stillFind,
        ];
        return $this->render($view, $params);
    }

    /**
     * 症状图集
     * lc 2016-4-1
     * @return string 视图
     */
    public function actionSymimages(){
        $view = "symptom_images";
        $dname = $this->helpGparam('dname', "");
        $dname = trim($dname, '/');
        $domudle = $this->helpGparam('dmodule', 'tuji');
        $domudle = trim($domudle, '/');
        $pageStr = trim(trim($domudle, 'tuji'), '_');
        $page = 1;
        if (!empty($pageStr)){
            $page = intval($pageStr);
        }
        
        $condition = ["{{%symptom}}.pinyin_initial"=>$dname];
        $disease = $this->symptom->getSymptomByCondition($condition, [], 1, 0);
        if (!isset($disease) || empty($disease)){
            throw new NotFoundHttpException("当前访问的页面不存在！");
        }
        $disease = $disease[0];
        if (!empty($disease)){
            $symptomContent = SymptomContent::find()->select('examine')->where(['id' => $disease['id']])->asArray(true)->one();
            if (isset($symptomContent) && !empty($symptomContent)){
                $disease = array_merge($disease, $symptomContent);
            }
        }

        //图集信息
        $icondition = ['flag' => 2, 'relid' => $disease['id']];
        $size = 1;
        $paging = $this->helpPaging('pager')->setSize($size)->setPageSetSize(9)->setUrlFormat('/' . $dname . '/tuji_%d'. '/')->setCurrentClass('cupat');
        $offset = $paging->getOffset();
        $images = Image::search($icondition, $offset, $size, 'id DESC',true);
        $imagesList = $images['list'];
        $paging->setTotal($images['total']);

        //获取相关疾病文章
        $relArtsAndAsks = CacheHelper::getCache('frontend_symptom_detail_xgwz', ['title' => $disease['name'], 'id' => $disease['id'], 'diseaseid' => $disease['id'], 'pinyin' => $disease['pinyin']]);
        $relArticles = $relArtsAndAsks['relArticles'];

        //相关问答
        $asks = $relArtsAndAsks['relAsks'];

        //大家还在找部分
        $stillFind = $this->getStillFindDatas($disease['name']);

        //右侧：最新文章
        $lastestArticles = $this->getLatestArticles();
        
        $return_img_list = [];
        foreach ($imagesList as $k=>$v){
            $v['url'] =  \librarys\helpers\utils\Url::getuploadfileUrl(2, $v['name']);
            $return_img_list[] = $v;
        }
        

        $params = [
            'disease' => $disease,
            'imagesList' => $return_img_list,
            'relArticles' => $relArticles,
            'paging' => $paging,
            'asks' => $asks,
            'lastestArticles' => $lastestArticles,
            'stillFind' => $stillFind,
        ];
        return $this->render($view, $params);
    }
    
    
    
    
    /**
     * 文章页
     * @author gaoqing
     * @date 2016-03-25
     * @return string 视图
     */
    public function actionDetail(){
        $view = "detail";
        $aid = $this->helpGparam("aid", "-1");
        
        //获取文章的信息
        $condition = ['id' => $aid];
        $article = Article::search($condition, 0, 1);
        $article = $article['list'];
        
        if (!isset($article) || empty($article)){
           throw new NotFoundHttpException('当前访问的页面不存在！');
        }
        
        if ($this->isNotNull($article)){
            $article = $article[0];
            $article['inputtime'] = date('Y-m-d H:i:s', $article['inputtime']);
            $article['keywords_init'] = $article['keywords'];
            $article['keywords'] = explode(' ', $article['keywords']);
        }
        //文章内容添加疾病、症状词的链接
        //lc@2016-5-24
        $cache_all = Article::getAllDiseaseSymptom2Redis();
        $content = $article['content'];
        $link_num = 5;//每页内链个数
        $single_link_num = 1;//单个词链接个数
        $i = 1;
        $str = '';
        $count = 0;
        foreach($cache_all as $k=>$v){
            $searchArr = '('.$k.')';
            $replaceArr = '<a href="'.$v.'" title="'.$k.'" target="_blank">'.$k.'</a>';
            if($i > $link_num){
                break;
            }
            if(stripos($str, $k)===false){
                $content = preg_replace($searchArr, $replaceArr, $content, $single_link_num, $count);
                if($count > 0){
                    $str .= $k;
                    $i++;
                }
            }
        }
        $article['content'] = $content;

        //获取当前文章对应的疾病信息
        $isSymptom = 0;
        if ($article['diseaseid'] > 0) {
            $disease_obj = new Disease();
            $res = $disease_obj->getDiseaseById($article['diseaseid']);
            $disease = $res['disease'];
            $disease['inspect'] = $res['diseaseContent']['inspect'];
        } elseif($article['symptomid']>0) {
            $symptom = Symptom::getSymptomByid($article['symptomid'],true);
            $disease = $symptom;
            $disease['inspect'] = $symptom['examine'];
            $isSymptom = 1;
        }
        
        //上一篇
        $preCondition = ['<', 'id', $aid];
        $preArticle = Article::search($preCondition, 0, 1, 'id DESC');
        $preArticle = $preArticle['list'];
        if ($this->isNotNull($preArticle)){
            $preArticle = $preArticle[0];
        }
        //下一篇
        $nextCondition = ['>', 'id', $aid];
        $nextArticle = Article::search($nextCondition, 0, 1, 'id ASC');
        $nextArticle = $nextArticle['list'];
        if ($this->isNotNull($nextArticle)){
            $nextArticle = $nextArticle[0];
        }

        $relArtsAndAsks = CacheHelper::getCache('frontend_article_detail_xgwz', ['title' => $article['title'], 'id' => $aid, 'diseaseid' => $article['diseaseid'],'symptomid'=>$article['symptomid']]);
        $relArticles = $relArtsAndAsks['relArticles'];

        //相关问答
        $asks = $relArtsAndAsks['relAsks'];

        //hot words part
        $letter_list = range('A','Z');
        $randwords = $this->rand_words();
        $hotWords = ['letter'=>$letter_list,'words'=>$randwords];

        //common diseases and hot departments part
        $commonDisDep = CacheHelper::getCache('frontend_article_detail_rmksbw', []);

        //大家还在找部分
        $stillFind = $this->getStillFindDatas($disease['name']);

        //右侧：最新文章
        $lastestArticles = $this->getLatestArticles();

        $params = [
            'article' => $article,
            'preArticle' => $preArticle,
            'nextArticle' => $nextArticle,
            'relArticles' => $relArticles,
            'asks' => $asks,
            'isSymptom' => $isSymptom,
            'disease' => $disease,
            'hotWords' => $hotWords,
            'commonDisDep' => $commonDisDep,
            'stillFind' => $stillFind,
            'lastestArticles' => $lastestArticles,
        ];
        return $this->render($view, $params);
    }

    private function getStillFindDatas($diseaseName){
        $queries[]=array(
            'word' => $diseaseName,
            'indexer' => 'index_9939_com_v2_keywords_all',
            'offset' => 0,
            'size' => 12,
            'condition' => array(array('filter' => 'filter', 'args' => array('typeid', array(99)))));

        $all_word_ids =SearchHelper::batchSearch($queries);

        $arr_ids = array();
        foreach ($all_word_ids as $k => $ret) {
            if (!empty($ret['matches'])) {
                foreach ($ret['matches'] as $kk => $kv) {
                    $arr_ids[] = $kk;
                }
            }
        }
        $wd_obj = new KeyWords();
        $result = $wd_obj->List_ByIds($arr_ids);

        return $result;
    }
    
    //随机热词
    private function rand_words() {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 100;
        $max_dis_length = 28;
        $filter_array = $this->getFilterArray();
        $cache_rand_words = KeyWords::getCacheRandWords($max_kw_length, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            if(array_key_exists($wd, $cache_rand_words)){
                $ret = $cache_rand_words[$wd];
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
            }else{
                $return_list[$wd] = array(); 
            }
        }
        return $return_list;
    }
    
    private function getFilterArray(){
        return array(
            array(
                'filter'=>'filter',
                'args'=>array('typeid', array(99))
                )
        );
//        return array(
//            array(
//                'filter'=>'filter',
//                'args'=>array('typeid', array(0,2,3,4,5,6,7,8,9,99))
//                )
//        );
    }
    
    

    /**
     * 文章列表页
     * @author gaoqing
     * @date 2016-03-25
     * @return string 视图
     */
    public function actionList(){
        $data = [];
        $limit = 40;
        $paging = $this->helpPaging('pager_disease_article')->setSize($limit)->setPageSetSize(5);
        $offset = $paging->getOffset();
        $records = Article::search(['status' => 99], $offset, $limit, ['id' => SORT_DESC], true);
        $paging->setTotal($records['total']);
        $article = $records['list'];

        $letters = range('A','Z');
        $rand_words =  $this->rand_words(); // KeyWords::getCacheRandWords();
        $randWords['letter'] = $letters;
        $randWords['words'] = $rand_words;

        //广告
        $obj_ads = new Ads();
        $ads_interest = $obj_ads->ads(4543);
        
        
        //右侧：最新文章
        $lastestArticles = $this->getLatestArticles(20);
        
        $data['article'] = $article;
        $data['paging'] = $paging;
        $data['ads_interest'] = $ads_interest;
        $data['randWords'] = $randWords;
        $data['lastestArticles'] =$lastestArticles;
        return $this->render('article_list', $data);
    }

    /**
     * 参数不为空的判断
     * @author gaoqing
     * @date 2016-03-25
     * @param mixed $param 参数
     * @return boolean true: 不为空；false: 为空
     */
    private function isNotNull($param){
        $isNotNull = false;
        if (isset($param) && !empty($param)){
            $isNotNull = true;
        }
        return $isNotNull;
    }

    /**
     * 得到疾病文件右侧的最新文章
     * @author gaoqing
     * @date 2016-07-13
     * @return array 疾病文件右侧的最新文章
     */
    private function getLatestArticles($count = 10)
    {
        $redisKey = 'article_detail_right_latest_news_' . $count;
        $redis = \Yii::$app->redis;
        $lastestArticles = $redis->get($redisKey);
        if(empty($lastestArticles)){
            $lastestArticles = $this->article->getLatestArticle($count);
            $redis->set($redisKey, $lastestArticles, 1 * 60 * 60);
            return $lastestArticles;
        }
        return $lastestArticles;
    }

}