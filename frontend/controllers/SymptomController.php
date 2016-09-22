<?php

namespace frontend\controllers;

use yii\helpers\Url;
use common\models\Symptom;
use common\models\SymptomContent;
use common\models\Relate;
use common\models\Disease;
use common\models\Department;
use common\models\ask\Answer;
use common\models\disease\Article;
use common\models\doctor\Doctor;
use librarys\controllers\frontend\FrontController;
use librarys\helpers\utils\Utils;
use common\models\FSearchTrait as SearchTrait;
use yii\web\NotFoundHttpException;
use common\models\CacheHelper;

class SymptomController extends FrontController {

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
                'class' =>'\librarys\actions\filters\PageCacheFilter',
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

        //默认图片
        $defaultThumb = \yii\helpers\Url::to("@domain") . '/images/dise_02.jpg';

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['info']['description'];
        $model['pinyin_initial'] = $pinyin;
        $model['thumbnail'] =$result['info']['thumbnail'];
        $model['imgPath'] = '/images/';

        //设置title,keywords,description
        $this->setMeta($name, 'index');


        $model['thumb']['src']=empty($model['thumbnail'])?$defaultThumb: \librarys\helpers\utils\Url::getuploadfileUrl(2,$model['thumbnail']);

        //相关问答 15条sql语句
//        $questions = Search::search_ask($name, 0, 5);
        $cacheKey = 'frontend_symptom_index_xgwd';
        $parms = [
            'id' => $symptomid,
            'name' => $name,
        ];
        $questions = $this->cacheHelper->getCache($cacheKey, $parms);
        $model['questions'] = $questions['list'];

        //左侧四个医生随机
        $leftQuankeDoctorIds = array_rand($this->quankeDoctors, 4);
        $leftQuankeDoctors = [];
        $ids = $this->quankeDoctors;
        foreach ($leftQuankeDoctorIds as $v) {
            $docIds[] = $ids[$v];
        }
        $tmp = implode(',', $docIds);
        $leftQuankeDoctors = $this->doctor->getDoctorById(implode(',', $docIds));
        $model['leftQuankeDoctors'] = $leftQuankeDoctors;

        //症状自查下方4个文章模块
        $model['symptomContent'] = $result;
        $model['prevent'] = $relieve;

        //底部随机词
        $randWords = $this->letterHotWordsBatch($name);
        $model['randWords'] = $randWords;

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid);
//        print_r($rightTmp);
//        exit;
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        //伴随症状 省略号显示
        if (isset($model['disease'])) {
            $relDisease = $model['disease']['relDisease'];
            $relSymptom = $model['disease']['relSymptom'];
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

            $model['diseaseSymptomCustom'] = $diseaseSymptomCustom;
            $model['diseaseDepartmentCustom'] = $diseaseDepartmentCustom;
        }
//        print_r($diseaseDepartmentCustom);
//        exit;
        //$this->fitwidthdata();

        return $this->render('index', [
                    'model' => $model
        ]);
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

        //设置title,keywords,description
        $this->setMeta($name, 'online');

//        //相关问答
//        $questions = Search::search_ask($name, 0, 6);
//        $model['questions'] = $questions['list'];
//        
        //相关问答 15条sql语句
//        $questions = Search::search_ask($name, 0, 5);
        $cacheKey = 'frontend_symptom_zixun_xgwd';
        $parms = [
            'id' => $symptomid,
            'name' => $name,
        ];
        $questions = $this->cacheHelper->getCache($cacheKey, $parms);
        $model['questions'] = $questions['list'];

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['leftDoctor','doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }


        return $this->render('online', [
                    'model' => $model
        ]);
    }

    /**
     * 疾病症状 常用药品
     */
    public function actionMedicine() {
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

        //相关问答
//        $questions = Search::search_ask($name, 0, 6);
//        $model['questions'] = $questions['list'];
        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        return $this->render('medicine', [
                    'model' => $model
        ]);
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
        $model['info'] = $result['info'];
        $model['content'] = $result['info']['description'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'cause');

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

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
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'cause');

        //右侧公用信息['disease','articles','doctorInfos','leftDoctor','medicalDepartment','relSymptom','departPinyin']
        $rightTmp = $this->getRightInfo($symptomid, ['doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        return $this->render('cause', [
                    'model' => $model
        ]);
    }

    /**
     * 疾病症状 预防
     * @return type
     */
    public function actionPrevent() {
        $pinyin = $this->helpGquery('pinyin');
        $result = $this->getColumn('relieve', $pinyin); //获取基本信息及字段对应信息
        $name = $result['info']['name'];
        $symptomid = $result['info']['id'];

        //症状基本信息
        $model['id'] = $symptomid;
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'prevent');

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        return $this->render('prevent', [
                    'model' => $model
        ]);
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
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'examine');

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['disease', 'doctorInfos', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

        //伴随症状 省略号显示
        if (isset($model['disease'])) {
            $relDisease = $model['disease']['relDisease'];
            $relSymptom = $model['disease']['relSymptom'];
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

            $model['diseaseSymptomCustom'] = $diseaseSymptomCustom;
            $model['diseaseDepartmentCustom'] = $diseaseDepartmentCustom;
        }

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
        $model['info'] = $result['info'];
        $model['content'] = $result['content'];
        $model['pinyin_initial'] = $pinyin;

        //设置title,keywords,description
        $this->setMeta($name, 'food');

        //右侧公用信息
        $rightTmp = $this->getRightInfo($symptomid, ['articles', 'doctorInfos', 'medicalDepartment', 'relSymptom']);
        foreach ($rightTmp as $k => $v) {
            $model[$k] = $v;
        }

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
        $article_count = Article::find()->andWhere('symptomid=:symptomid', [':symptomid'=>$symptomid])->count('id');
        if ($article_count > 0) {
            $perpage = 20;
            $pagenum = $this->helpGparam('page', 1);
            $total = $article_count;
            $page = ($pagenum <= ($total / $perpage)) ? $pagenum : ($total / $perpage);
            $paging = $this->helpPaging('pager_symptom_article')->setSize($perpage)->setPageSetSize(5);
            $paging->setUrlFormat(Url::to("@domain/zhengzhuang/{$pinyin}/article_list_%u.shtml"));
            $paging->setTotal($total)->setCurrent($page);
            $offset = $paging->getOffset();
            $articles = $this->article->listByCondition([['status'=>'99'],['symptomid' => $symptomid]], $perpage, $offset, 'id DESC'); //查询结果
            $model['articles'] = $articles;
            $model['paging'] = $paging;
        } else {
            if (isset($model['disid'])) {
                //通过疾病id查找【疾病与疾病文章关联表】得到疾病文章id
                $diseaseIdStr = implode(',', $model['disid']);

                $perpage = 20;
                $pagenum = $this->helpGparam('page', 1);
                $tmp = $this->article->getRecordsBySql($diseaseIdStr);
                $totalPage = $tmp[0]['num'];
                $page = ($pagenum <= ($totalPage / $perpage)) ? $pagenum : ($totalPage / $perpage);
                $paging = $this->helpPaging('pager_symptom_article')->setSize($perpage)->setPageSetSize(5);
                $paging->setUrlFormat(Url::to("@domain/zhengzhuang/{$pinyin}/article_list_%u.shtml"));
                $paging->setTotal($totalPage)->setCurrent($page);
                $offset = $paging->getOffset();
                $articles = $this->article->listBySqlCondition($diseaseIdStr, $perpage, $offset); //查询结果

                $model['articles'] = $articles;
                $model['paging'] = $paging;
            }
        }


        //底部随机词
        $randWords = $this->letterHotWordsBatch($name);
        $model['randWords'] = $randWords;

        return $this->render('article', [
                    'model' => $model
        ]);
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
        //右侧就诊科室
        if (in_array('medicalDepartment', $filter)) {
            if (!empty($diseaseCache)) {
                //在取到的所有科室数据合并去重
                $medicalDepartment = [];
                foreach ($diseaseCache['departmentMap'] as $vv) {
                    $Tmp['medicalDepartmentTmp'][] = $vv['id'];
                    $Tmp['medicalDepartmentTmpName'][] = $vv['name'];
                    $Tmp['medicalDepartmentTmpPinyin'][] = $vv['pinyin'];
                }
                $medicalDepartment['id'] = array_unique($Tmp['medicalDepartmentTmp']);
                $medicalDepartment['name'] = array_unique($Tmp['medicalDepartmentTmpName']);
                $medicalDepartment['pinyin'] = array_unique($Tmp['medicalDepartmentTmpPinyin']);
//                print_r($medicalDepartment);exit;
                $model['medicalDepartment'] = $medicalDepartment;
                //科室拼音
                $model['departPinyin'] = $this->department->getDepartmentPinyin();
            }
        }

        //右侧相关症状
        if (in_array('relSymptom', $filter)) {
            $model['relSymptom'] = $this->relate->getRelateSymptoms($symptomid);
        }

        //症状相关文章
        if (in_array('articles', $filter)) {
            $model['articles'] = [];
            $articles = $this->article->listByCondition([['status' => '99'], ['symptomid' => $symptomid]], 8, 0, 'id DESC');
            if (!empty($articles)) {
                $model['articles'] = $articles;
            } else {
                if (!empty($diseaseCache)) {
                    $diseaseId = $diseaseCache['diseaseId'];
                    $disease_ids = implode(',', $diseaseId);
                    $articles = $this->article->listBySqlCondition($disease_ids, 8, 0);
                    $model['articles'] = $articles;
                }
            }
        }
        
        //专家（左侧）
        if (in_array('doctorInfos', $filter)) {
            if (!empty($diseaseCache)) {
                //取所有相关疾病里第一个疾病id来查专家
                $diseaserandid = $diseaseCache['diseaseId']['0'];
                $doctors = $this->getDoctor($diseaserandid,0,6);
                
                //专家（右侧）
                $rightDoctor = array_slice($doctors, 3, 3);
                $model['doctorInfos'] = $rightDoctor;
                
                //在线咨询 左侧
                $leftDoctor = [
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
                $model['leftDoctor'] = $leftDoctor;
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
                $meta['title'] = "{$name}的症状表现_{$name}的治疗方法_{$name}检查_症状查询_久久健康网";
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
