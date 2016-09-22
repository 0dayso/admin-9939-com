<?php
/**
 * @version 0.0.0.1
 */

namespace wapjb\controllers;


use common\models\CacheHelper;
use common\models\Disease;
use common\models\disease\Article;
use common\models\doctor\Doctor;
use common\models\Image;
use common\models\Relate;
use common\models\Symptom;
use librarys\controllers\wapjb\WapController;
use wapjb\models\ArticleService;
use wapjb\models\DiseaseService;
use common\models\FSearchTrait as SearchTrait;
use yii\base\Module;
use yii\web\NotFoundHttpException;

class ArticleController extends WapController
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
                'enabled'=>true,
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
        $images = Image::search($icondition);
        $imagesList = $images['list'];

        //获取相关疾病图集
        $relDiseaseImages = ArticleService::getRelDiseaseImages($disease['id'], 6);
        
        $return_img_list = [];
        foreach ($imagesList as $k=>$v){
            $v['url'] =  \librarys\helpers\utils\Url::getuploadfileUrl(1, $v['name']);
            $return_img_list[] = $v;
        }

        $params = [
            'disease' => $disease,
            'imagesList' => $return_img_list,
            'relDiseaseImages' => $relDiseaseImages,
        ];
        return $this->renderPartial($view, $params);
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
            $article['keywords_init'] = $article['keywords'];
            $article['keywords'] = explode(' ', $article['keywords']);
        }
        //获取当前文章对应的疾病信息
        $disease = $this->diseaseService->getDiseaseByArtid($aid);
        
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

        //获取相关疾病文章
        $relArtsAndAsks = CacheHelper::getCache('frontend_article_detail_xgwz',
            ['title' => $article['title'], 'id' => $aid, 'diseaseid' => $article['diseaseid'], 'iswapjb' => true]
        );
        $relArticles = isset($relArtsAndAsks['relArticles']['list'])?$relArtsAndAsks['relArticles']['list']:array();

        //相关问答
        $asks = isset($relArtsAndAsks['relAsks']['list'])?$relArtsAndAsks['relAsks']['list']:array();

        //推荐专家
        $doctors = $this->getDoctors();

        $params = [
            'article' => $article,
            'preArticle' => $preArticle,
            'nextArticle' => $nextArticle,
            'relArticles' => $relArticles,
            'asks' => $asks,
            'disease' => $disease,
            'doctors' => $doctors,
        ];
        return $this->renderPartial($view, $params);
    }

    /**
     * 文章列表页
     * @author gaoqing
     * @date 2016-03-25
     * @return string 视图
     */
    public function actionList(){
        $data = [];
        $limit = 10;
        $paging = $this->helpPaging('pager_disease_wapjb_article_list')->setSize($limit);
        $offset = $paging->getOffset();
        $records = Article::search(['status' => 99], $offset, $limit, ['id' => SORT_DESC], true);
        $paging->setTotal($records['total']);
        $article = $records['list'];

        $data['article'] = $article;
        $data['paging'] = $paging;
        return $this->renderPartial('article_list', $data);
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
     * 得到全科医生的数据集
     * @author gaoqing
     * @date 2016-04-05
     * @return array 全科医生的数据集
     */
    private function getDoctors(){
        $doctors = [];

        $doctorIDs = $this->doctorsIDs();

        //得到随机的医生 id 集
        $doctorIDArr = [];
        while (count($doctorIDArr) != 4){
            $index = rand(0, 9);
            if (!in_array($index, $doctorIDArr)){
                $doctorIDArr[] = $doctorIDs[$index];
            }
        }
        $doctorids = implode(',', $doctorIDArr);
        $doctor = new Doctor();
        $doctors = $doctor->getDoctorById($doctorids);

        return $doctors;
    }

    private function doctorsIDs(){
        return [830765, 830774, 831181, 1785, 831253, 831200, 1440561, 1442194, 221102, 329006];
    }

}