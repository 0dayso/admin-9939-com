<?php
namespace frontend\controllers;

use Yii;
use common\models\Seek;
use librarys\controllers\frontend\FrontController;
use common\models\Part;
use common\models\Department;
use common\models\Search;
use yii\db\Query;
use common\models\DiseaseSymptomMerge;

class SeekController extends FrontController
{
    private $seek;
    private $department;
    private $part;

    public function init(){
        parent::init();
        $this->setLayout('seek');
        $this->seek = new Seek();
        $this->department = new Department();
        $this->part = new Part();
    }
    /**
     * 症状疾病列表页
     * @author caoxingdi
     * @date 2016-4-13
     * @return array 疾病症状列表数据集合
     */
    public function actionIndex(){
        $key = '';
        $partKey = '';
        $partKeyName ='';
        $departmentKeyName='';
        $size = 10;
        $typeId='';
        $request = \Yii::$app->request;
        if($request->isGet){
            //接收所需要的参数
            $key = $request->get('key');//搜索的关键词
            $key1 = $request->get('key1');//科室或者部位的拼音
            $partKey = $request->get('part');
            $departmentKey = $request->get('department');
            $typeId=$request->get('tab');
            $paging = $this->helpPaging('qt.pager')->setSize($size)->setPageSetSize(7);
            $offset = $paging->getOffset();
            if(!empty($key)){
                /**
                 * 关键词搜索
                 * @param string $key 关键词
                 * @param string $typeId 标识 t1疾病 t2症状
                 * @return array keyList 疾病症状列表 array part 部位列表 array department 科室列表 
                 */
                $keyList = $this->keywordSearch($key,$typeId,$offset,$size,array('name'=>SORT_ASC), true);
                //关键词数据为空，跳转全站检索
                if(empty($keyList['list'])){
                    return $this->redirect('http://zhannei.baidu.com/cse/search?s=11191038390795407073&entry=1&q='.$key);
                }
                $part = $this->seek->partList('id,name,child,pinyin',array('level'=>'1')); //前台部位列表
                $department = $this->seek->departmentList('id,name,child,pinyin',array('level'=>'1')); //科室列表
                $paging->setTotal($keyList['total']);
            }else{
                if(!empty($key1)){
                    /**
                     * 根据key1关键词，查询出相应的科室或部位相关联的症状，疾病数据
                     * @param string $key1 科室或部位关键词
                     * @param string $typeId 标识 t1疾病 t2症状
                     * @return array keyList 疾病症状列表 string partKeyName 部位关键词名称 string departmentKeyName 科室关键词名称 array part array 部位列表 array department array 科室列表 
                     */
                    $keyList = $this->conditionSearch($key1,$offset,$size,array('9939_disease_symptom_merge.id'=>SORT_ASC), true,$typeId);
                    $paging->setTotal($keyList['total']);
                    if($keyList['flag']=='1'){
                       $partKey = $key1;
                       $partKeyName = $keyList['keyName'];
                    }else if($keyList['flag']=='2'){
                        $departmentKey = $key1;
                        $departmentKeyName = $keyList['keyName'];
                    }
                    $part = $keyList['part'];
                    $department = $keyList['department'];
                    //重新赋值
                    $keyList=array(
                        'list'=>$keyList['list'], //疾病症状列表
                        'partLevelList'=>$keyList['partLevelList'],  //二级部位列表
                        'partlevel1Id'=>$keyList['partlevel1Id'],//如果选择的是二级部位，需要查询出一级部位的name匹配显示
                        'departementLevelList'=>$keyList['departementLevelList'],
                        'firstClassData'=>$keyList['firstClassData']
                    );
                }else{
                    /**
                     * 根据部位和科室，查询出相关疾病症状
                     * @param string epartmentKey 科室关键词（拼音） 
                     * @param string partKey 部位关键词（拼音）
                     * @return keyList array 疾病症状列表  string partKeyName 部位关键词名称  string departmentKeyName 科室关键词名称 array part 部位列表 array department 科室列表
                     */
                    if(!empty($departmentKey) && !empty($partKey)){
                        $keyList = $this->conditionSearch2($partKey,$departmentKey,$offset,$size,array('9939_disease_symptom_merge.id'=>SORT_ASC), true,$typeId);
                        $paging->setTotal($keyList['total']);
                        $partKeyName = $keyList['partKeyName'];
                        $departmentKeyName = $keyList['departmentKeyName'];
                        $part = $keyList['part'];
                        $department = $keyList['department'];
                    }else{
                        /**
                         * 无条件下查询相关的疾病症状集合
                         * @param string $typeId 标识 t1疾病 t2症状
                         * @return array keyList 数据列表 array part 部位列表 array department 科室列表
                         */
                        $typeId = $request->get('tab');
                        $keyList = $this->queryAllList('id,name,description,pinyin,pinyin_initial',$typeId,$offset,$size,array('id'=>SORT_ASC));
                        $paging->setTotal($keyList['total']);
                        $part = $this->seek->partList('id,name,child,pinyin,listorder',array('level'=>'1'),array('listorder'=>SORT_ASC));
                        $department = $this->seek->departmentList('id,name,child,pinyin',array('level'=>'1'),array('listorder'=>SORT_ASC));
                    }
                }
            }
        }
        //右侧热门关注
        $latestFucus = $this->latestFucus();
        //病列表页标题判断
        $top = $this->tops($key,$partKeyName,$departmentKeyName);
        $data = array(
            'part'=>$part,
            'department'=>$department,
            'key'=>$key,//关键词
            'partKey'=>$partKey,//部位关键词
            'partKeyName'=>$partKeyName,//部位名称
            'departmentKeyName'=>$departmentKeyName,//科室名称
            'departmentKey'=>$departmentKey,//科室关键词
            'paging'=>$paging,
            'typeId'=>$typeId,
            'keyList'=>$keyList,
            'latestFucus'=>$latestFucus,
            'top'=>$top
        );
        return $this->render('index',$data);
    }
    /**
     * 关键词搜索操作
     * @param string keyword 关键词名称
     * @param string typeId 标识 t1疾病 t2症状
     * @param int offset 分页 开始条数
     * @param int size 每页显示的条数 
     * @param array orderBy 排序
     * @param return_count_flag  是否统计总条数 false不统计
     * @return array res视图数据集合 int total 数据总条数
     */
    public function keywordSearch($keyword = '',$typeId,$offset=0, $size=0,$orderBy = array(),$return_count_flag=false){
        $select='id,name,description,pinyin_initial';
        $where=array();
        if(!empty($typeId)){
            if($typeId=='t1'){
               $where = array('tmp_source_id'=>array(1));
            }else if($typeId=='t2'){
                $where = array('tmp_source_id'=>array(2));
            }
        }
        $res = Search::search_disease_symptom_merge($keyword, $offset, $size , 0 ,$where);
        //$res = DiseaseSymptomMerge::search($where,$offset,$size,$orderBy,true);
        foreach($res['list'] as $k=>$val){
            $sql = "select symptom.id,symptom.name,symptom.pinyin_initial from `9939_disease_symptom_rel` disease_symptom ,`9939_symptom` symptom where disease_symptom.symptomid =  symptom.id and disease_symptom.diseaseid = ".$val['id']." limit 0,5" ;
            $res['list'][$k]['relevance'] = Seek::findBySql($sql)->asArray(true)->all();
        }
        return array('list'=>$res['list'],'total'=>$res['total'],'explain_words'=>$res['explain_words']);
    }
    
    /**
     * 根据拼音查询出部位或科室数据，查询和科室或部位关联的数据集合
     * @param string key 关键词拼音 
     * @param int offset 第几条开始
     * @param int size 每页显示条数
     * @param array orderBy 排序
     * @param return_count_flag 是否分页 false 不分页
     * @param string typeId 类型 t1查询疾病数据 t2查询科室数据
     * return array res视图数据集合 int total 数据总条数  int is科室部位标识 1部位 2科室 string keyName  关键词名称 array partLevelList 部位的二级数据 
     *        array departementLevelList 科室的二级数据列表 int level1 当前条件属于几级部位 array part 部位列表 array department 科室列表 
     *        array firstClassData 如何为二级部位,需要查询出一级部位的名称
     */
    public function conditionSearch($key='',$offset=0, $size=0,$orderBy = array(),$return_count_flag=false,$typeId){
        $flag='0'; //标示，1部位 2科室
        $partLevelList=array();
        $departementLevelList=array();
        $firstClassData=array();
        $res = array('res'=>'','total'=>'');
        $level1='';
        $part= array();
        $department =array();
        //判断当前关键词属于科室还是部位
        $data = $this->part->getPartByPinyin('id,name,level,child,part_level1',['pinyin'=>$key]);
        if(!empty($data)){
            $flag='1';
            if($data['level']=='2'){
                 $partLevelList = $this->part->getPartByPinyinList('id,name,pinyin',['and','part_level1 = '.$data['part_level1'] ,'level=2'],array('listorder'=>SORT_ASC));
                 //根据当前部位的id，查询出他的一级的数据
                 $firstClassData = $this->part->getPartByPinyin('id,name,pinyin',['and','part_level1 = '.$data['part_level1'] ,'level=1']);
            }else if($data['level']=='1'){
                 //当前部位id为一级部位，查询出她所有的二级部位
                 $partLevelList = $this->part->getPartByPinyinList('id,name,pinyin',['and','part_level1='.$data['id'],'pid != 0 '],array('listorder'=>SORT_ASC));
            }
            $col_name = 'part_level'.$data['level'];
            $disease_where = " and partDisease.".$col_name." = ".$data['id']."";
            $department = $this->seek->departmentPartRel($disease_where);
            //获取所有的一级二级部位
            $part = $this->seek->partList('id,name,child,pinyin',array('level'=>'1'),array('listorder'=>SORT_ASC));
        }else{
            //如果查询不到部位，执行else，查询科室
            $data = $this->department->getDepartmentByPinyin('',array('pinyin'=>$key));
            if($data){
                 $flag = '2';
                //如何科室是一级id，需要查询出一级id下的所有的二级id，组合，查询出关联部位或科室
                if($data['level']=='1'){
                    $departementLevelList = $this->department->getDepartmentByPinyinList('id,name,pinyin',['and','class_level1='.$data['id'],'pid!=0']);
                }else{
                    $departementLevelList = $this->department->getDepartmentByPinyinList('id,name,pinyin',['and','class_level1='.$data['class_level1'],'level=2']);
                    $firstClassData = $this->department->getDepartmentByPinyin('id,name',['and','class_level1='.$data['class_level1'],'level=1']);  
                }
                //根据科室，查询所有和科室相关联的部位 不分等级
                $col_name = 'class_level'.$data['level'];
                $part_where = ' and diseaseDepartment.'.$col_name.'='.$data["id"];
                $part = $this->seek->partDepartmentRel($part_where);
                //查询当前所有的科室数据
                $department = $this->seek->departmentList('id,name,child,pinyin',array('level'=>'1'),array('listorder'=>SORT_ASC));
            }
        }
        //根据科室查询出相应的部位数据，根据部位查询出相应的科室数据
        if($flag=='1'){
            $level1 = $data['part_level1'];
            $col_name = 'part_level'.$data['level'];
            $partid = $data['id'];
            if(!empty($col_name)){
                $res = $this->seek->partSearchSynthesize($col_name,$partid,$typeId,$offset,$size,true,$orderBy);
                foreach($res['res'] as $k=>$val){
                    if($val['source_flag']=='1'){
                        $res['res'][$k]['relevance'] = $this->seek->relevanceSymptom($val['id']);
                    }else{
                        $res['res'][$k]['relevance'] = $this->seek->relevanceDisease($val['id']);
                    }
                }
            }
        }else if($flag=='2'){
            $level1 = $data['class_level1'];
            $col_name = 'class_level'.$data['level'];
            $departid = $data['id'];
            if(!empty($col_name)){
                $res = $this->seek->departSearchSynthesize($col_name,$departid,$typeId,$offset,$size,true,$orderBy);
                 foreach($res['res'] as $k=>$val){
                    if($val['source_flag']=='1'){
                        $res['res'][$k]['relevance'] = $this->seek->relevanceSymptom($val['id']);
                    }else{
                        $res['res'][$k]['relevance'] = $this->seek->relevanceDisease($val['id']);
                    }
                }
            }
        }
       return array('list'=>$res['res'],'flag'=>$flag,'keyName' =>$data['name'],'partLevelList' =>$partLevelList,'departementLevelList'=>$departementLevelList,'partlevel1Id'=>$level1,'total'=>$res['total'],'part'=>$part,'department'=>$department,'firstClassData'=>$firstClassData);
    }
    
    /**
     * 根据拼音查询出部位和科室条件，查询和科室，部位关联的数据集合
     * @param string part 部位拼音
     * @param string department 科室拼音
     * @param int offset 第几条开始
     * @param int size 每页显示条数
     * @param array orderBy 排序
     * @param return_count_flag 是否分页 false 不分页
     * @param string typeId 类型 t1查询疾病数据 t2查询科室数据
     * return array res视图数据集合 int total 数据总条数 array part 部位列表 array department 科室列表 string departmentKeyName 科室名称  string partKeyName 部位名称 string partlevel1id 一级部位id
     */
    public function conditionSearch2($part='',$department='',$offset=0, $size=0,$orderBy = array(),$return_count_flag=false,$typeId){
        $res = array('res'=>'','total'=>'');
        //上部分，部位科室列表 开始
        $part = $this->part->getPartByPinyin('id,name,level,child,part_level1',['pinyin'=> $part]);
        if($part){
            $part_name = 'part_level'.$part['level'];
            $partid = $part['id'];
            $disease_where = " and partDisease.".$part_name." = ".$part['id']."";
            $departmentList = $this->seek->departmentPartRel($disease_where);
        }
        $department = $this->department->getDepartmentByPinyin('id,name,level,child,class_level1',['pinyin'=> $department],'','','',1);
        if($department){
            $department_name = 'class_level'.$department['level'];
            $departmentid =$department["id"];
            $part_where = ' and diseaseDepartment.'.$department_name.'='.$department["id"];
            $partList = $this->seek->partDepartmentRel($part_where);
        }
        $res = $this->seek->partDepartSearchSynthesize($part_name,$department_name,$partid,$departmentid,$typeId,$offset,$size,true,array('9939_disease_symptom_merge.id'=>SORT_ASC));
        foreach($res['res'] as $k=>$val){
            if($val['source_flag']=='1'){
                $res['res'][$k]['relevance'] = $this->seek->relevanceSymptom($val['id']);
            }else{
                $res['res'][$k]['relevance'] = $this->seek->relevanceDisease($val['id']);
            }
        }
        return array('list'=>$res['res'],'departmentKeyName'=>$department['name'],'partKeyName'=>$part['name'],'total'=>$res['total'],'part'=>$partList,'department'=>$departmentList);
    }
   /**
    * 首页右侧热门关注
    * sphinx调用疾病文章查询
    * @return array latestFucus 对应的数据集合
    */
    public function latestFucus(){
        $cache = \Yii::$app->cache_file;
        $cache_key = 'frontend_seek_right_rmgz';//疾病搜索页面_右侧_热门关注
        $data = $cache->get($cache_key);
        if(!empty($data)){
            return $data;
        }else{
            $queries = array(
                array('word'=>'高血压','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'心脏病','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'包皮过长','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'乳腺增生','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'胃溃疡','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'宫颈癌','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'癫痫病','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'阳痿','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'哮喘','indexer'=>'index_9939_com_jb_art'),
                array('word'=>'龋齿','indexer'=>'index_9939_com_jb_art'),
            );
            $result = [];
            $ret = \librarys\helpers\utils\SearchHelper::batchSearch($queries);
            foreach($ret as $kk=>$ret){
                $indexer_name = $ret['indexer'];
                $sphinx_result = Search::parse_search_data($ret,$indexer_name);
                $ret_list = $sphinx_result['list'];
                $kw = $queries[$kk]['word'];
                $result[$kw]=$ret_list;
            }
            $cache->set($cache_key,$result,24*3600);
            return $result;
            
        }
    }
    
    /**
     * 首页title标题显示
     * @param string key 关键词
     * @param string partKeyName 部位名称
     * @param string departmentKeyName 科室名称
     */
    public function tops($key='',$partKeyName='',$departmentKeyName=''){
        if($key!=""){
            $top['title']=$key.'相关症状查询_'.$key.'相关疾病查询_疾病百科_久久健康网';
            $top['keywords'] = $key.'相关疾病,'.$key.'相关症状';
            $top['description'] = '久久健康网-疾病百科频道提供专业、全面的部位'.$key.'相关疾病、'.$key.'相关症状等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
        }else if(!empty($partKeyName) && empty($departmentKeyName)){
            $top['title']=$partKeyName.'相关症状查询_'.$partKeyName.'相关疾病查询_疾病百科_久久健康网';
            $top['keywords'] = $partKeyName.'相关症状查询,'.$partKeyName.'相关疾病查询';
            $top['description'] = '久久健康网-疾病百科频道提供专业、全面的部位相关症状查询、部位相关疾病查询等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
        }else if(!empty($departmentKeyName) && empty($partKeyName)){
            $top['title']=$departmentKeyName.'疾病查询_'.$departmentKeyName.'治疗哪些病_'.$departmentKeyName.'疾病、症状大全_疾病百科_久久健康网';
            $top['keywords']=$departmentKeyName.'疾病查询科室治疗哪些病,'.$departmentKeyName.'疾病';
            $top['description']='久久健康网-疾病百科频道提供专业、全面的科室疾病查询科室治疗哪些病、科室疾病等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
        }else if(!empty($departmentKeyName) && !empty($partKeyName)){
            $top['title'] = $partKeyName.'-'.$departmentKeyName.'相关疾病查询_'.$partKeyName.'-'.$departmentKeyName.'相关症状查询_疾病百科_久久健康网';
            $top['keywords']=$partKeyName.'-'.$departmentKeyName.'相关疾病查询,'.$partKeyName.'-'.$departmentKeyName.'相关症状查询';
            $top['description']='久久健康网-疾病百科频道提供专业、全面的部位-科室相关疾病查询、部位-科室相关症状查询等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
        }else{
            $top['title']='疾病查询_症状查询_疾病百科_久久健康网';
            $top['keywords']='疾病查询,症状查询';
            $top['description']='久久健康网-疾病百科频道提供专业、全面的部位相关疾病查询、症状查询等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
        }
        return $top;
    }
    /**
     *查询所有症状或疾病数据
     * @param string select 查询的数据字段
     * @param string typeId 标识 t1疾病 t2症状
     * @param int offset 第几条开始
     * @param int size 每页显示条数
     * @param array orderBy 排序
     * return array res 相关的疾病症状集合
     */
    public function queryAllList($select='',$typeId='',$offset=0,$size=10,$orderBy=[]){
        if($typeId=='t1'){
            //查询疾病
           $res = DiseaseSymptomMerge::search(array('source_flag'=>1),$offset,$size,$orderBy,true);
           //根据疾病，查询相关症状
        }elseif($typeId=='t2'){
            //查询症状
           $res = DiseaseSymptomMerge::search(array('source_flag'=>2),$offset,$size,$orderBy,true);
           //根据症状查询相关疾病
        }else{
            //关键词搜索，综合
            $res = DiseaseSymptomMerge::search([],$offset,$size,$orderBy,true);
            //判断疾病，查询相关症状，症状，查询相关疾病
        }
        foreach($res['list'] as $k=>$val){
            if($val['source_flag']=='1'){
                $res['list'][$k]['relevance'] = $this->seek->relevanceSymptom($val['id']);
            }else{
                 $res['list'][$k]['relevance'] = $this->seek->relevanceDisease($val['id']);
            }
        }
        return $res;
    }
}