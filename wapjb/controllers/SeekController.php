<?php
namespace wapjb\controllers;

use Yii;
use librarys\controllers\wapjb\WapController;
use common\models\Part;
use common\models\Seek;
use common\models\Department;
use common\models\DiseaseSymptomMerge;
use common\models\Search;

/**
 * Seek controller
 */
class SeekController extends WapController{
    
    private $part;
    private $seek;
    private $department;


    public function init(){
        parent::init();
        $this->setLayout("seek");
        $this->part = new Part();
        $this->seek = new Seek();
        $this->department = new Department();
    }
    
    /**
     * wap站搜索
     * @return array
     */
    public function actionIndex(){
        $size=10;
        $request = \Yii::$app->request;
        if($request->isGet){
            $key = $request->get('key');
            $tab = $request->get('tab');
            if(!empty($key)){ //关键词搜索
                $select='id,name,description,pinyin_initial';
                $where=array();
                if(!empty($tab)){//根据tab，判断搜索条件
                    if($tab=='t1'){
                       $where = array('tmp_source_id'=>array(1)); //只搜索疾病
                    }else if($tab=='t2'){
                        $where = array('tmp_source_id'=>array(2));//只搜索症状
                    }
                }
                $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
                $offset = $paging->getOffset();
                $res = Search::search_disease_symptom_merge($key, $offset, $size , 0 ,$where); //数据集合
                $paging->setTotal($res['total']);
                if(empty($res['list'])){//判断条件为空，转为站内搜索
                    return $this->redirect('http://sousuo.9939.com/cse/search?s=2200337477999120096&isNeedCheckDomain=1&jump=1&q='.$key);
                }
                $data = array(
                    'res'=>$res['list'],  //查询数据结果
                    'paging'=>$paging,  //分页
                    'tab'=>$tab,    //标识 t1疾病 t2症状
                    'key'=>$key, //关键词
                    'explain_words'=>$res['explain_words']
                );
                return $this->render('keyword_index',$data);
            }else{
                $commonDisease = $this->seek->getCommonDisease();//查询相关疾病数据
                $departmentLevel1 = $this->department->getDepartmentLevel1();//获取页面的一级科室
                $partlevel1 = $this->part->getPartLevel1();//获取页面的一级部位
                $data = array(
                    'DepartmentLevel1'=>$departmentLevel1, //一级科室列表
                    'partlevel1'=>$partlevel1,  //一级部位列表
                    'commonDisease'=>$commonDisease
                );
                return $this->render('index',$data);
            }
        }
    }
    
    /**
     * 部位搜索页
     * @return array res 数据集合 paging fenye partlevel1 一级部位列表
     */
    public function actionPartSearch(){
        $size=10;
        $request = \Yii::$app->request;
        $tab = $request->get('tab');
        $partlevel1 = $this->part->getPartLevel1();//获取页面的一级部位
        $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        //根据tab标识，查询不同的数据 t1查询疾病数据 t2查询症状数据
        if($tab=="t1"){
            $res = DiseaseSymptomMerge::search(array('source_flag'=>1),$offset,$size,array('id'=>SORT_ASC),true);
        }else if($tab=="t2"){
            $res = DiseaseSymptomMerge::search(array('source_flag'=>2),$offset,$size,array('id'=>SORT_ASC),true);
        }else{//tab='',默认查询所有疾病或症状
            $res = DiseaseSymptomMerge::search([],$offset,$size,array('id'=>SORT_ASC),true);
        }
        $paging->setTotal($res['total']);
        $data = array(
            'res'=>$res['list'], //数据列表
            'paging'=>$paging,
            'partlevel1'=>$partlevel1,//一级部位列表
            'tab'=>$tab
        );
        return $this->render('part_search_index',$data);
    }
    
    /**
     * 科室搜索页
     * @return array res 数据列表 paging 分页 deparmentlevel1 一级部位列表 tab 标识 t1疾病标识 t2 症状标识
     */
    public function actionDepartmentSearch(){
        $size=10;
        $request = \Yii::$app->request;
        $tab = $request->get('tab');
        $departmentLevel1 = $this->department->getDepartmentLevel1();//获取页面的一级科室
        $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        if($tab=="t1"){
            $res = DiseaseSymptomMerge::search(array('source_flag'=>1),$offset,$size,array('id'=>SORT_ASC),true);
        }else if($tab=="t2"){
            $res = DiseaseSymptomMerge::search(array('source_flag'=>2),$offset,$size,array('id'=>SORT_ASC),true);
        }else{//tab='',默认查询所有疾病或症状
            $res = DiseaseSymptomMerge::search([],$offset,$size,array('id'=>SORT_ASC),true);
        }
        $paging->setTotal($res['total']);
        $data = array(
            'res'=>$res['list'],
            'paging'=>$paging,
            'departmentLevel1'=>$departmentLevel1,
            'tab'=>$tab
        );
        return $this->render('department_search_index',$data);
    }
    
    /**
     * 人群搜索页
     * @return array res 数据列表 paging 分组  tab 标识 t2症状 creatureid id参数
     */
    public function actionCreatureSearch(){
        $size=10;
        $request = \Yii::$app->request;
        $tab = $request->get('tab'); //标识 t2 症状查找 
        $creatureid = $request->get('creatureid');//人群查找的分类id
        
        $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $res =  $this->seek->getCreatureSearch($creatureid,$tab,$size,$offset,true);
        $paging->setTotal($res['total']);
        $data = array(
            'res'=>$res['list'], //数据列表
            'paging'=>$paging, 
            'tab'=>$tab,//标识
            'creatureid'=>$creatureid //分类id
        );
        return $this->render('creature_search_index',$data);
    }
    
    /**
     * 根据相应的部位拼音或科室拼音，查询出相应的数据
     * @return array
     */
    public function actionPinyinSearch(){
        $size=10;
        $partlevel2=array('name'=>'');
        $departmentLevel2=array('name'=>'');
        $request = \Yii::$app->request;
        $pinyin = $request->get('pinyin');
        $typeId = $request->get('tab');
        $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        //根据不pinyin判断是否存在于科室或部位中
        $data = $this->part->getPartByPinyin('id,name,level,child,part_level1,pinyin',['pinyin'=>$pinyin]);
        if(!empty($data)){
            $partlevel1List = $this->part->getPartLevel1();//获取页面的一级部位
            //判断当前科室属于几级部位，根据不同部位，映射到不同的对应页。
            if($data['level']=='1'){
                $partlevel1 = $data;
                //根据一级部位，查询出二级部位数据
                $partlevel2List = $this->part->getPartListById($data['id'],'',array('listorder'=>SORT_ASC));
            }elseif($data['level']=='2'){
                 $partlevel2List = $this->part->getPartByPinyinList('id,name,pinyin',['and','part_level1 = '.$data['part_level1'] ,'level=2'],array('listorder'=>SORT_ASC));
                 $partlevel1 = $this->part->getPartByPinyin('id,name,pinyin',['and','part_level1 = '.$data['part_level1'] ,'level=1']); //根据当前id.查询出她的一级部位数据 
                 $partlevel2 = $data;
            }
            $col_name = 'part_level'.$data['level'];
            $partid = $data['id'];
            $res = $this->seek->partSearchSynthesize($col_name,$partid,$typeId,$offset,$size,true,[]);
            $paging->setTotal($res['total']);
            $array = array(
                'partlevel1List'=>$partlevel1List, //一级部位列表
                'partlevel2List'=>$partlevel2List, //二级部位列表
                'partlevel1'=>$partlevel1, //当前选中的一级部位数据
                'partlevel2'=>$partlevel2, //当前选中的二级部位数据
                'res'=>$res['res'],
                'paging'=>$paging,
                'tab'=>$typeId,
                'data'=>$data
            );
            return $this->render('part_search_level2_index',$array);
        }else{
            $data = $this->department->getDepartmentByPinyin('',array('pinyin'=>$pinyin));
            if(!empty($data)){
                $departmentLevel1List = $this->department->getDepartmentLevel1();//获取页面的一级科室
                if($data['level']=='1'){
                    $departmentLevel1 = $data;
                    $departmentLevel2List = $this->department->getDepartmentByPinyinList('id,name,pinyin',['and','class_level1='.$data['id'],'pid!=0']);
                }else{
                    $departmentLevel2List = $this->department->getDepartmentByPinyinList('id,name,pinyin',['and','class_level1='.$data['class_level1'],'level=2']);//查询出当前部位的同等级部位
                     $departmentLevel1 = $this->department->getDepartmentByPinyin('id,name',['and','class_level1='.$data['class_level1'],'level=1']);//查询当前部位的一级部位
                     $departmentLevel2 = $data;
                }
                $level1 = $data['class_level1'];
                $col_name = 'class_level'.$data['level'];
                $departid = $data['id'];
                $res = $this->seek->departSearchSynthesize($col_name,$departid,$typeId,$offset,$size,true,array('9939_disease_symptom_merge.id'=>SORT_ASC));
                $paging->setTotal($res['total']);
                $array = array(
                    'departmentLevel1List'=>$departmentLevel1List, //一级科室列表
                    'departmentLevel2List'=>$departmentLevel2List, //二级科室列表
                    'departmentLevel1'=>$departmentLevel1, //当前选中的一级科室数据
                    'departmentLevel2'=>$departmentLevel2, //当前选中的二级科室数据
                    'res'=>$res['res'],
                    'paging'=>$paging,
                    'tab'=>$typeId,
                    'data'=>$data
                );
                return $this->render('department_search_level2_index',$array);
            }
        }
    }
    
    /**
     * 科室部位条件搜索功能
     * return array 
     */
    public function actionPartDepartmentSearch(){
        $size=10;
        $department = $this->helpGparam('dep'); //接收科室的值
        $part = $this->helpGparam('par');//接收部位的值
        $typeid = $this->helpGparam('tab');
        $paging = $this->helpPaging('wap_pager_search')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $res = $this->partDepartmentSearch($part,$department,$typeid,$size,$offset);
        $paging->setTotal($res['total']);
        $data = array(
            'res'=>$res['res'],  //查询数据结果
            'paging'=>$paging,  //分页
            'tab'=>$typeid,    //标识 t1疾病 t2症状
            'department'=>$department,
            'part'=>$part,
        );
        return $this->render('part_department_search_index',$data);
    }
    
    /**
     * @param string $part 部位拼音
     * @param string $department 科室拼音
     * @param string $typeid 类型id
     * @param int $size 每页显示的条数
     * @param int $offset 第几条开始
     * @return array total 总共查询多少条数据 res 数据列表
     */
    
    public function partDepartmentSearch($part='',$department='',$typeid='',$size=10,$offset=0){
        $partList = $this->part->getPartByPinyin('id,name,level,child,part_level1,pinyin',['pinyin'=>$part]);  //根据拼音查询部位数据
         
        $departmentList =  $this->department->getDepartmentByPinyin('id,name,level,child,class_level1,pinyin',array('pinyin'=>$department)); //根据拼音查询科室数据
        if(!empty($departmentList) && !empty($partList)){
            $part_level = 'part_level'.$partList['level'];
            $department_level = 'class_level'.$departmentList['level'];
            $res = $this->seek->partDepartSearchSynthesize($part_level,$department_level,$partList['id'],$departmentList['id'],$typeid,$offset,$size,true,array('9939_disease_symptom_merge.id'=>SORT_ASC));
        }
        return array('total'=>$res['total'],'res'=>$res['res']);
    }
}
