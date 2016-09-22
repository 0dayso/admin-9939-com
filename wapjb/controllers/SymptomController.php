<?php

namespace wapjb\controllers;

use yii\helpers\Url;
use common\models\Symptom;
use common\models\SymptomContent;
use common\models\Relate;
use common\models\Disease;
use common\models\Department;
use common\models\ask\Answer;
use common\models\disease\Article;
use common\models\doctor\Doctor;
use common\models\Search;
use librarys\controllers\wapjb\WapController;
use librarys\helpers\utils\Utils;
use common\models\FSearchTrait as SearchTrait;
use yii\web\NotFoundHttpException;
use common\models\CacheHelper;

class SymptomController extends WapController {

    use SearchTrait;

    private $symptom;
    private $symptomContent;
    private $article;
    private $relate;
    private $disease;
    private $answer;
    private $doctor;
    private $department;
    private $cacheHelper;
    //全科医生id
    private $quankeDoctors = [
        830765, 830774, 831181, 1785, 831253, 831200, 1440561, 1442194, 221102, 329006
    ];

    public function init() {
        parent::init();
        $this->setLayout('symptom');
        $this->symptom = new Symptom();
        $this->symptomContent = new SymptomContent();
        $this->relate = new Relate();
        $this->disease = new Disease();
        $this->department = new Department();
        $this->answer = new Answer();
        $this->article = new Article();
        $this->doctor = new Doctor();
        $this->cacheHelper = new CacheHelper();
    }

    public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => true, //是否开启缓存
                'only' => ['dispatch', 'index', 'article'], //需要添加缓存的方法列表
                'duration' => 24 * 60 * 60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }

    public function actionDispatch() {
        $routerMap = [
            'test' => 'album',
            'jianjie' => 'introd',
            'zzqy' => 'cause',
            'yufang' => 'prevent',
            'jiancha' => 'examine',
            'shiliao' => 'food',
            'zixun' => 'online',
            'yiyao' => 'medicine',
            'tuji' => 'article/symimages',
        ];
        $act = $this->helpGparam('act');
        $pinyin = $this->helpGparam('pinyin');
        if (strpos($routerMap[$act], '/')) {
            $route = $routerMap[$act];
        } else {
            $route = 'symptom/' . $routerMap[$act];
        }
        $params = ['pinyin' => $pinyin];
        return $this->run($route, $params);
    }

    /**
     * 疾病症状 首页
     */
    public function actionIndex() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn(['cause', 'examine', 'diagnose', 'goodfood', 'relieve'], $pinyin); //获取基本信息及字段对应信息
        $relieve = $result;
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $symptom['id'] = $symptomid;
        $symptom['info'] = $result['info'];
        $symptom['content'] = $result['info']['description'];
        $symptom['pinyin_initial'] = $pinyin;
        $symptom['thumbnail'] =$result['info']['thumbnail'];
        $symptom['imgPath'] = '/images/';

        $symptom['symptomContent'] = $result;

        //症状首页缩略图信息
        //默认图片
        $defaultThumb = \yii\helpers\Url::to("@domain") . '/images/dise_02.jpg';
        $symptom['thumb']['src']=empty($symptom['thumbnail'])?$defaultThumb: \librarys\helpers\utils\Url::getuploadfileUrl(2,$symptom['thumbnail']);
        
//        $thumbCondition = [
//            'relid' => $symptomid,
//            'flag' => 2,
//            'weight' => 1,
//        ];
//        $imgArr = $this->relate->getImage($thumbCondition);
//        if (count($imgArr) > 0) {
//            $symptom['thumb'] = $imgArr[0]; //症状首页缩略图
//            $symptom['thumb']['src'] = $symptom['imgPath'] . $symptom['thumb']['name'];
//        } else {
//            $symptom['thumb'] = [
//                'src' => '/images/dise_02.jpg',
//                'name' => '默认图片',
//            ];
//        }

        //相关问答 15条sql语句
        $cacheKey = 'frontend_symptom_index_xgwd';
        $parms = [
            'id' => $symptomid,
            'name' => $name,
        ];
        $questions = $this->cacheHelper->getCache($cacheKey, $parms);
        $symptom['questions'] = $questions['list'];

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid);
        foreach ($rightTmp as $k => $v) {
            $symptom[$k] = $v;
        }

        //伴随症状 省略号显示
        if (isset($symptom['disease'])) {
            $relDisease = $symptom['disease']['relDisease'];
            $relSymptom = $symptom['disease']['relSymptom'];
            $diseaseSymptomCustom = [];
            if (!empty($relDisease)) {//如果有关联疾病
                foreach ($relDisease as $k => $v) {
                    $pinyin = $v['pinyin_initial'];
                    //伴随症状 省略号显示
                    $diseaseSymptomCustom[$pinyin] = $this->fitwidthdata($relSymptom[$pinyin], 21);
                    //就诊科室 省略号显示
                    $departTmp = explode(' ', $v['treat_department']);
                    $diseaseDepartmentCustom[$k] = $this->fitwidthdata($departTmp, 9);
                }
            } else {
                $diseaseSymptomCustom = '';
                $diseaseDepartmentCustom = '';
            }

            $symptom['diseaseSymptomCustom'] = $diseaseSymptomCustom;
            $symptom['diseaseDepartmentCustom'] = $diseaseDepartmentCustom;
        }
        return $this->render('index', ['symptom' => $symptom]);
    }

    /**
     * 疾病症状 在线问诊
     */
    public function actionOnline() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('cause', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['info']['description'];
        $model['pinyin_initial'] = $pinyin;
        $model['imgPath'] = '/images/';

        $model['doctor'] = $this->getOnlineDoctor(); //获取三位固定医生
        //设置title,keywords,description
        $this->setMeta($name, 'online');

        $asks = $this->getRelAsks($result['info']['name'], 0, 5); //相关问答
        $model['asks'] = $asks;

        return $this->render('online', $model);
    }

    public function actionLoadAsk() {
        $keywords = $this->helpGpost('keywords', '');
        $offset = $this->helpGpost('offset', 0);
        $length = $this->helpGpost('length', 5);
        $data = [];
        $asks = $this->getRelAsks($keywords, (int)$offset, (int)$length); //相关问答
        $data['asks'] = $asks;
        return $this->renderPartial('inc_related_ask', $data);
    }

    /**
     * 疾病症状 常用药品
     */
    public function actionMedicine() {
        $this->disableLayout();
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('cause', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['info']['description'];
        $model['pinyin_initial'] = $pinyin;
        $model['imgPath'] = '/images/';

        //设置title,keywords,description
        $this->setMeta($name, 'medicine');

        return $this->render('medicine', $model);
    }

    /**
     * 疾病症状 简介
     * @return type
     */
    public function actionIntrod() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('cause', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['name'] = $result['info']['name'];
        $model['info'] = $result['info'];
        $model['content'] = $result['info']['description'];
        $model['pinyin_initial'] = $pinyin;
        //设置title,keywords,description
        $this->setMeta($name, 'cause');



        return $this->render('introd', [
                    'model' => $model
        ]);
    }

    /**
     * 疾病症状 症状起因
     * @return type
     */
    public function actionCause() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('cause', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];

        //症状基本信息
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];

        //设置title,keywords,description
        $this->setMeta($name, 'cause');

        return $this->render('cause', $model);
    }

    /**
     * 疾病症状 预防
     * @return type
     */
    public function actionPrevent() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('relieve', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];

        //症状基本信息
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];

        //设置title,keywords,description
        $this->setMeta($name, 'prevent');

        return $this->render('prevent',$model);
    }

    /**
     * 疾病症状 常用检查
     * @return type
     */
    public function actionExamine() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('examine', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['name'] = $result['info']['name'];
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'examine');

        return $this->render('examine', [
                    'model' => $model
        ]);
    }

    /**
     * 疾病症状 食疗
     * @return type
     */
    public function actionFood() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn(['goodfood', 'badfood'], $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['name'] = $result["info"]['name'];
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'food');
//        print_r($model);exit;
        return $this->render('food', [
                    'model' => $model
        ]);
    }

    /**
     * 疾病症状 饮食护理
     * @return type
     */
    public function actionArticle() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('cause', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'article');

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['disease', 'articles', 'doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        //症状相关文章
        if (isset($model['disid'])) {
            /**
             * 原来的逻辑
            $articleCondition = [
                ["in", "9939_article_disease_rel.diseaseid", $model['disid']]
            ];
            $articlesArr = $this->relate->getDiseaseByCondition($articleCondition);
            $articleIdArr = [];
            foreach ($articlesArr as $v) {
                $articleIdArr[] = $v['articleid'];
            }
            $articleCondition = [
                ['in', 'id', $articleIdArr]
            ];

            $articles = $this->article->listByCondition($articleCondition, 10, 0); //查询结果
             */
            
            //疾病手机站症状文章列表调取方式
            $diseaseIdStr = implode(',', $model['disid']);
            $articles = $this->article->listBySqlCondition($diseaseIdStr, 10, 0); //查询结果
            
            $model['articles'] = $articles;
        } else {
            $model['articles'] = [];
        }
        return $this->render('article', $model);
    }

    /**
     * ajax html
     *  返回更多文章
     */
    public function actionLoadArticle() {

        $symptomid = $this->helpGpost('symptomid', '');
        $offset = $this->helpGpost('offset', 0);
        $length = $this->helpGpost('length', 5);
        $data = [];
        $rightTmp = $this->getRightInfo($symptomid, ['disease']);

        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }
        /**
         * 原来的逻辑
        $articleCondition = [
            ["in", "9939_article_disease_rel.diseaseid", $model['disid']]
        ];
        $articlesArr = $this->relate->getDiseaseByCondition($articleCondition);
        $articleIdArr = [];
        foreach ($articlesArr as $v) {
            $articleIdArr[] = $v['articleid'];
        }
        $articleCondition = [
            ['in', 'id', $articleIdArr]
        ];
        $articles = $this->article->listByCondition($articleCondition, $length, $offset); //查询结果
         */
        
        //现在的逻辑：通过疾病id查找【疾病与疾病文章关联表】得到疾病文章id
        $diseaseIdStr = implode(',', $model['disid']);
        $articles = $this->article->listBySqlCondition($diseaseIdStr, $length, $offset); //查询结果
        $data['articles'] = $articles;

        return $this->renderPartial('inc_article', $data);
    }

    /**
     * 右侧公共信息，跟疾病有关的
     * lc 2016-4-6
     * @param type $symptomid
     * @param array $filter  ['disease','relSymptom'] 筛选需要的数据 
     * @return type
     */
    public function getRightInfo($symptomid, $filter = []) {
        $filter = !empty($filter) ? $filter : ['disease', 'articles', 'doctorInfos', 'leftDoctor', 'medicalDepartment', 'relSymptom'];

        $model = [];
        $diseaseList = [];
        $parms = [
            'id' => $symptomid,
        ];
        $diseaseCache = $this->cacheHelper->getCache('frontend_symptom_index_knjb', $parms);

        if (in_array('medicalDepartment', $filter) || in_array('disease', $filter)) {
            if (!empty($diseaseCache)) {
                $model['disid'] = $diseaseCache['diseaseId'];
                //症状首页左侧可能疾病及伴随症状
                $model['disease'] = $diseaseCache['diseaseTmp'];
            }
        }

        //症状相关文章
        if (in_array('articles', $filter)) {
            if (!empty($diseaseCache)) {
                $diseaseId = $diseaseCache['diseaseId'];
//                $articleCondition = [
//                    ["in", "9939_article_disease_rel.diseaseid", $diseaseId]
//                ];
//                $articlesArr = $this->relate->getDiseaseByCondition($articleCondition);
//                $articleIdArr = [];
//                foreach ($articlesArr as $v) {
//                    $articleIdArr[] = $v['articleid'];
//                }
//                $articleCondition = [
//                    ['in', 'id', $articleIdArr]
//                ];
//
//                $articles = $this->article->listByCondition($articleCondition, 8, 0);
                
                $disease_ids = implode(',',$diseaseId);
                $articles = $this->article->listBySqlCondition($disease_ids, 8, 0);
                
                $model['articles'] = $articles;
            }
        }
        return $model;
    }

    /**
     * 根据拼音获取症状的基本信息
     * lc 2016-4-14
     * @param type $pinyin_initial
     * @return type
     * @throws NotFoundHttpException
     */
    public function getSymptomBaseInfo($pinyin_initial) {
        $condition = ["{{%symptom}}.pinyin_initial" => $pinyin_initial];
        $info = $this->symptom->getSymptomByCondition($condition, [], 1, 0);
        if (empty($info)) {//如果不存在抛出404
            throw new NotFoundHttpException;
        }
        return $info;
    }

    /**
     * 公用方法，根据记录id调用表某一个或多个字段的值
     * @param type $column cause,examine,diagnose,relieve,goodfood,badfood
     * @param type $id
     * @return type
     */
    public function getColumn($column, $pinyin_initial) {
        $tmp = $this->getSymptomBaseInfo($pinyin_initial);
        $tmpCont = $this->symptomContent->getSymptomContentById($column, $tmp[0]['id']);
        $res['info'] = $tmp[0];
        if (is_array($column)) {//如果是多个字段
            foreach ($column as $v) {
                $res['content'][$v] = $tmpCont[$v];
            }
        } else {
            $res['content'] = $tmpCont[$column];
        }
        return $res;
    }

    /**
     * 通过疾病id 获取 医生
     * lc 2016-3-30
     * @param type $diseaseid
     * @return type
     */
    public function getDoctor($diseaseid, $offset = 0, $limit = 3) {
        require '../data/doctorid.php';
        $this->doctor = new Doctor();
        $this->department = new Department();

        $department = $this->department->getDepartmentsByDisid($diseaseid);
        $uid = array_key_exists($department[0]['name'], $_DOCTORID) ? $_DOCTORID[$department[0]['name']] : $_DOCTORID['内科']; //科室名称获取医生id信息
        $arruid = array_slice($uid, $offset, $limit);
        $uidstr = implode(',', $arruid);
        $doctor = $this->doctor->getDoctorById($uidstr);
        return $doctor;
    }

    /**
     * 是否删除缓存
     * lc 2016-3-31
     * @return string
     */
    public function removeCache() {
        return '1';
    }

    /**
     * 设置网站title,keywords,description
     * lc 2016-4-1
     * @param type $name
     * @param type $page
     */
    public function setMeta($name, $page = 'index') {
        switch ($page) {
            case 'index':
                $meta['title'] = "{$name}的原因_{$name}的表现_{$name}的治疗方法_症状查询_久久健康网";
                $meta['keywords'] = "{$name}的原因,{$name}的表现,{$name}的治疗方法";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}的原因、{$name}的表现、{$name}的治疗方法等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'introd':
                $meta['title'] = "{$name}的原因_{$name}发病原因_{$name}是怎么引起的_症状查询_久久健康网";
                $meta['keywords'] = "{$name}的原因{$name}发病原因{$name}是怎么引起的";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}的原因{$name}发病原因{$name}是怎么引起的等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'cause':
                $meta['title'] = "{$name}的原因_{$name}发病原因_{$name}是怎么引起的_症状查询_久久健康网";
                $meta['keywords'] = "{$name}的原因{$name}发病原因{$name}是怎么引起的";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}的原因{$name}发病原因{$name}是怎么引起的等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'prevent':
                $meta['title'] = "预防{$name}_如何预防{$name}_症状查询_久久健康网";
                $meta['keywords'] = "预防{$name},如何预防{$name}";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的预防{$name}、如何预防{$name}等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'examine':
                $meta['title'] = "{$name}临床检查,{$name}检查项目,{$name}检查费用_久久健康网";
                $meta['keywords'] = "{$name}的症状表现,{$name}的治疗方法,{$name}检查";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}的症状表现、{$name}的治疗方法、{$name}检查等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'food':
                $meta['title'] = "{$name}吃什么好_{$name}食疗方法_{$name}饮食食谱_症状查询_久久健康网";
                $meta['keywords'] = "{$name}吃什么好,{$name}食疗方法,{$name}饮食食谱";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}吃什么好、{$name}食疗方法、{$name}饮食食谱等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'article':
                $meta['title'] = "{$name}相关解答_{$name}相关文章_症状查询_久久健康网";
                $meta['keywords'] = "{$name}相关解答,{$name}相关文章";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}相关解答、{$name}相关文章等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'medicine':
                $meta['title'] = "{$name}吃什么药_{$name}用药_{$name}用药禁忌_症状查询_久久健康网";
                $meta['keywords'] = "{$name}吃什么药,{$name}用药,{$name}用药禁忌";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}吃什么药、{$name}用药、{$name}用药禁忌等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;

            case 'online':
                $meta['title'] = "{$name}在线咨询_{$name}在线预约、挂号_症状查询_久久健康网";
                $meta['keywords'] = "{$name}在线咨询,{$name}在线预约,{$name}在线挂号";
                $meta['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}在线咨询、{$name}在线预约、{$name}在线挂号等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
                break;
        }
        $this->getView()->title = $meta;
    }

    public function getOnlineDoctor() {
        return [
            [
                'uid' => 1440561,
                'nickname' => '陶丽萍',
                'zhicheng' => '',
                'best_dis' => '保健综合',
                'pic' => '201601/1440561_avatar_middle.jpg'
            ],
            [
                'uid' => 221102,
                'nickname' => '王庆松',
                'zhicheng' => '',
                'best_dis' => '上呼吸道综合',
                'pic' => '201601/221102_avatar_middle.jpg',
            ],
            [
                'uid' => 831181,
                'nickname' => '刘业生',
                'zhicheng' => '',
                'best_dis' => '常见病综合，呼吸道系统诊疗',
                'pic' => '201604/831181_avatar_middle.jpg'
            ],
        ];
    }

    /**
     * 获取相关问答数据
     * @param type $param
     */
    public function getRelAsks($keywords, $offset = 0, $limit = 5) {
        $asks = Search::search_ask($keywords, $offset, $limit); //相关问答
        $doc = new Doctor();
        foreach ($asks['list'] as $k => $v) {
            if(isset($v['answer'])){
                $v['userid'] = '';
                $res = $doc->getDoctorById($v['answer']['userid']);
                $doctor = array_shift($res);
                $asks['list'][$k]['answer']['truename'] = $doctor['truename'] ? : $doctor['nickname'];
                $asks['list'][$k]['answer']['doc_keshi'] = $doctor['doc_keshi'];
                $asks['list'][$k]['answer']['pic'] = $doctor['pic'] ? : 'default.jpg';
                unset($res);
                unset($doctor);
            }
        }
        return $asks;
    }

    /**
     * 适应宽度数据
     * @param type $data
     * @param type $max_dis_lenth
     * @return type
     */
    private function fitwidthdata($data, $max_dis_lenth) {
        $return_arr = array();
        $tmp_str = '';
        foreach ($data as $v) {
            $v = is_array($v) ? $v['name'] : $v;
            $pinyin = is_array($v) ? $v['pinyin_initial'] : $v;
            $tmp_str.=$v;
            $str_len = mb_strlen($tmp_str, 'utf8');
            if ($str_len >= $max_dis_lenth) {
                $cut_len = $max_dis_lenth - ($str_len - mb_strlen($v, 'utf8'));
                $cur_str = Utils::String()->mbSubstr($v, $cut_len, 0);
                $return_arr[] = $cur_str;
                break;
            } else {
                $return_arr[] = $v;
            }
        }
        return $return_arr;
    }

}
