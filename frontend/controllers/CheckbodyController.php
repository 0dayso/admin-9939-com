<?php
namespace frontend\controllers;

use common\models\Symptom;
use common\models\SymptomContent;
use common\models\disease\Article;
use common\models\Relate;
use common\models\Disease;
use common\models\ask\Ask;
use librarys\controllers\frontend\FrontController;

class CheckbodyController extends FrontController
{
    private $symptom;
    private $symptomContent;
    private $article;
    private $relate;
    private $disease;
    private $ask;
    
    private $sexOptions = [
        '1' => '男',
        '0' => '女',
    ];
    
    private $ageOptions = [
        '0' => '一个月内',
        '1' => '2~11个月',
        '12' => '1~12岁',
        '13' => '13~18岁',
        '19' => '19~29岁',
        '30' => '30~39岁',
        '40' => '40~49岁',
        '50' => '50~64岁',
        '65' => '65岁以上',
    ];
    
    private $jobOptions = [
        '1' => '工人',
        '2' => '农民',
        '3' => '教师',
        '4' => '服务员',
        '5' => '司机',
        '6' => '厨师',
        '7' => '办公室/白领',
        '8' => '医师/护士',
        '9' => '公务员',
        '10' => '销售/采购',
        '11' => '其他',
    ];


    public function init(){
        parent::init();
        $this->setLayout('checkbody');
        $this->setMeta();
        $this->symptom = new Symptom();
        $this->symptomContent = new SymptomContent();
        $this->relate = new Relate();
    }
//    

    public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => true,  //是否开启缓存
                'only' => ['check-body-step-one','check-body-step-two','check-body-step-three'], //需要添加缓存的方法列表
                'duration' => 24*60*60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }
    
    
    public function actionDispatch(){
        $routerMap = [
            'jbzc' => 'check-body-step-one',
            'jbzc_zz' => 'check-body-step-two',
            'jbzc_bw' => 'check-body-step-three',//该步取消
            'jbzc_jg' => 'check-body-step-three',
            'query' => 'query'
        ];
        $act = $this->helpGparam('act')==''?'jbzc':$this->helpGparam('act');//默认跳到首页
        $pinyin = $this->helpGparam('pinyin');
        
        $route = 'checkbody/'.$routerMap[$act];
        $params = ['pinyin'=>$pinyin];
        return $this->run($route, $params);
    }
    
    
    public function actionCheckBodyStepOne(){
        $model['option']['sex'] = $this->sexOptions;
        $model['option']['age'] = $this->ageOptions;
        $model['option']['job'] = $this->jobOptions;
        
        return $this->render('step1',[
            'model' => $model
        ]);
    }
    
    
    public function actionCheckBodyStepTwo(){
        $condition['age'] = $this->helpGparam('age', 1);
        $condition['sex'] = $this->helpGparam('sex', 1);
        $condition['job'] = $this->helpGparam('job', 1);
        
        $model['option']['sex'] = $this->sexOptions;
        $model['option']['age'] = $this->ageOptions;
        $model['option']['job'] = $this->jobOptions;
        
        $allPartLevel1 = $this->relate->getAllPart(1);//获取所有一级部位
//        print_r($allPartLevel2);
//        exit;
        $model['allPartLevel1'] = $allPartLevel1;
        
        $model['condition'] = $condition;
        return $this->render('step2',[
            'model' => $model
        ]);
    }
    
    
    public function actionCheckBodyStepThree(){
        $condition['age'] = $this->helpGparam('age', 1);
        $condition['sex'] = $this->helpGparam('sex', 1);
        $condition['job'] = $this->helpGparam('job', 1);
        
        $model['option']['sex'] = $this->sexOptions;
        $model['option']['age'] = $this->ageOptions;
        $model['option']['job'] = $this->jobOptions;
        
        //已选择症状
        $selectSymptomId = $this->helpGparam('symptomid');
        $selectSymptomInfo = $this->symptom->getOneSymptom($selectSymptomId);
        $model['selectSymptom'] = $selectSymptomInfo;
        
        //相关症状
        $relSymptom = $this->relate->getRelateSymptoms($selectSymptomId);
        $model['relSymptom'] = $relSymptom;
        
        //相关疾病
        $relDisease = $this->relate->getRelateDiseases($selectSymptomId);
        $model['relDisease'] = $relDisease;
        //获取所有一级部位
//          $allPartLevel1 = $this->relate->getAllPart(1);
//        print_r($allPartLevel2);
//        exit;
//        $model['allPartLevel1'] = $allPartLevel1;
        
        $model['condition'] = $condition;
        return $this->render('step3',[
            'model' => $model
        ]);
    }
    
    /**
     * 根据部位，关键词查询症状
     * @return type
     */
    public function actionQuery(){
        $type = $this->helpGparam('type');
        switch ($type){
            //根据图片部位查询
            case 1:
                $partid = $this->helpGparam('partid');
                $partname = $this->helpGparam('partname');
                $condition = [
                    ["{{%symptom_part_rel}}.partid" => $partid]
                ];


                $symptoms = $this->relate->getSymptomByRelCondition($condition, 50);
                $letterSymptoms = [];
                foreach($symptoms as $k=>$v){
                    if(preg_match('/^[a-zA-Z]+$/', $v['capital'])){//排除 首字母 不是字母的记录
                        $letterSymptoms[$v['capital']][$k] = $v;
                    }
                }
                $model['partname'] = $partname;
                $model['letterSymptoms'] = $letterSymptoms;

                $model['option']['sex'] = $this->sexOptions;
                return $this->renderPartial('query',[
                    'model' => $model
                ]);
            break;
            
            //根据全部症状查询
            case 2:
                $model['type'] = 'lv2Part'; //该参数用于views/part.php输出html结果

                $partid = $this->helpGparam('partid');
                $partname = $this->helpGparam('partname');

                $allPartLevel2 = [];
                $conditon = ['level'=>2, 'pid'=>$partid];
                $allPartLevel2 = $this->relate->getPartByCondition($conditon);
                if(count($allPartLevel2) > 0){
                    $model['allPartLevel2'] = $allPartLevel2;
                }else{//如果没有二级部位，则显示它本身
                    $model['allPartLevel2'] = [
                        ['id'=>$partid, 'name'=>$partname]
                    ];
                }

                return $this->renderPartial('part',[
                    'model' => $model
                ]);
            break;
            
            //根据二级部位展示症状
            case 3:
                $model['type'] = 'symptom';//该参数用于views/part.php输出html结果

                $partid = $this->helpGparam('partid');
                $partname = $this->helpGparam('partname');

                $allSymptoms = [];
                $conditon = ['partid'=>$partid];
                $allSymptoms = $this->symptom->getSymptomByCondition($conditon, [], 999, 0);
                if(count($allSymptoms) > 0){
                    $model['allSymptoms'] = $allSymptoms;
                }
                return $this->renderPartial('part',[
                    'model' => $model
                ]); 
            break;
            
            //根据选择的症状筛选出相关的疾病
            case 4:
                $model['type'] = 'disease';//该参数用于views/part.php输出html结果
                
                $tmpSymptomid = $this->helpGparam('symptomid');
                $relSymptomidArr = explode('|', $tmpSymptomid);
                $relSymptomidArr = array_filter($relSymptomidArr);
                
//                print_r($relSymptomidArr);
//                exit;
                
                /*
                $A = array('tt', 'cc', 'dd', 'mm');
                $B = array('ad', 'tt', 'cc', 'qq');
                $sameArr = array();
                for($i=0; $i < count($A); $i++) {
                    $pos = array_search($A[$i], $B);
                    if($pos>0){
                        $sameArr[] = $A[$i];
                    }
                }
                
                var_dump($sameArr);
                exit;
                 */
                $disease = $relDiseaseId = [];
                $arrNum = count($relSymptomidArr);
//                print_r($arrNum);
//                exit();
                if($arrNum > 1){
                    foreach($relSymptomidArr as $k=>$v){
                        $all[] = $tmpRelDis = $this->relate->getRelateDiseases($v);

                        foreach($tmpRelDis as $kk=>$vv){
                            $relDiseaseId[$k][] = $tmpRelDis;
                            ${'disease_'.$k}[] = $vv['diseaseid'];
                        }
                    }

                    /**
                     * 此处的逻辑是：
                     * 使用第一个数组与以后的数组逐一进行对比，取出相同的元素
                     * 如果与之后的任一数组无相同值，那所有的数组无共同元素
                     */
                    $sameArr = array();
                    for($n=1;$n<$arrNum;$n++){
                        for($i=0; $i < count($disease_0); $i++) {
                            $pos = array_search($disease_0[$i], ${'disease_'.$n});
                            if($pos>0){
                                $sameArr[] = $disease_0[$i];
                            }
                        }
                    }
                    if(count($sameArr) > 0){
                        $diseaseInfo = $all[0];//对比之后拿到的id直接在第一个数组取内容
                        foreach($diseaseInfo as $v){
                            $allInfo[$v['diseaseid']] = $v;
                        }
        //                
                        foreach($sameArr as $k=>$v){
                            $sameDisease[][$k] = $allInfo[$v];
                        }
                    }else{
                        $sameDisease[] = [0];
                    }
    //                print_r($sameDisease);
    //                exit;
                }else{
                    $sameDisease[] = $this->relate->getRelateDiseases($relSymptomidArr[0]);
                }
                
                $model['disease'] = $sameDisease;
                return $this->renderPartial('part',[
                    'model' => $model
                ]); 
                
            break;
        
            
            //模糊查询
            case 5:
                $model['type'] = 'suggest';//该参数用于views/part.php输出html结果
                $model['allSymptoms'] = [];
                
                $keywords = $this->helpGparam('keywords');
                $allSymptoms = [];
                $condition = [];

                if(preg_match('/^[a-zA-Z]+$/', $keywords)){//排除 首字母 不是字母的记录
                    $conditonLike = ['like', "{{%symptom}}.pinyin", $keywords];
                }else{
                    $conditonLike = ['like', "{{%symptom}}.name", $keywords];
                }
                $allSymptoms = $this->symptom->getSymptomByCondition($condition, $conditonLike, 6, 0);
                if(count($allSymptoms) > 0){
                    $model['allSymptoms'] = $allSymptoms;
                }
                return $this->renderPartial('part',[
                    'model' => $model
                ]); 
            break;
        
            
            //模糊查询
            case 6:
                $model['type'] = 'search';//该参数用于views/part.php输出html结果
                $model['allSymptoms'] = [];
                
                $keywords = $this->helpGparam('keywords');
                $allSymptoms = [];
                $condition = [];

                if(preg_match('/^[a-zA-Z]+$/', $keywords)){//排除 首字母 不是字母的记录
                    $conditonLike = ['like', "{{%symptom}}.pinyin", $keywords];
                }else{
                    $conditonLike = ['like', "{{%symptom}}.name", $keywords];
                }
                $allSymptoms = $this->symptom->getSymptomByCondition($condition, $conditonLike, 999, 0);
                if(count($allSymptoms) > 0){
                    $model['allSymptoms'] = $allSymptoms;
                }
                return $this->renderPartial('part',[
                    'model' => $model
                ]); 
            break;
        }
        
    }
    
    
    /**
     * 设置网站title,keywords,description
     * lc 2016-4-1
     * @param type $name
     * @param type $page
     */
    public function setMeta(){
        $meta = [];
        $meta['title'] = "疾病自查_症状自查_快速自测、诊断疾病、症状_疾病百科_久久健康网";
        $meta['keywords'] = "疾病自查,症状自查,快速自测、诊断疾病、症状";
        $meta['description'] = "久久健康网-疾病百科频道提供专业、全面的疾病自查、症状自查、快速自测、诊断疾病、症状等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
        $this->getView()->title = $meta;
    }
    
}