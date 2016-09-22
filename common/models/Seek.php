<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\db\Query;
use common\models\Part;

class Seek extends BaseModel {
    private $department;
    private $part;


    public static function tableName() {
        return '{{%disease}}';
    }

    public static function getDb() {
        return \Yii::$app->db_jbv2;
    }
    
    public function init(){
    	parent::init();
    	
    	$this->department = new Department();
        $this->part = new Part();
    }
    /**
     * 查询所有的一级二级部位
     * @param string $select 要查询的字段
     * @param array $where 条件
     * @param array $orderBy 排序
     * @return array level1 一级二级部位数据集合
     */
    public function partList($select='',$where=array(),$orderBy=array()){
        $level1 = $this->part->getPartByPinyinList($select,$where,$orderBy);
        foreach($level1 as $k =>$val){
            $level2 = $this->part->getPartByPinyinList($select,['and','part_level1='.$val['id'],'level=2']);
            $level1[$k]['level2'] = $level2;
        }
        return $level1;
    }
    
    /**
     * 根据科室，查询当前所有和科室相关联的部位
     * @param array $where 查询条件
     * @return  array 部位数据集合
     */
    public function partDepartmentRel($where=''){
        $sql = 'select part.id,part.name,part.pinyin,part.child from `9939_disease_department_rel` diseaseDepartment ,`9939_part_disease_rel` partDisease , `9939_part` part where diseaseDepartment.diseaseid = partDisease.diseaseid and partDisease.partid = part.id '.$where.' group by part.name order by part.listorder asc';
        return static::findBySql($sql)->asArray(true)->all();
    }
    
    /**
     * 查询所有的一级二级科室
     * @param string $select 要查询的字段
     * @param array $where 条件
     * @param array $orderBy 排序
     * @return array department 一级二级部位科室集合
     */
    public function departmentList($select='',$where=array(),$orderBy=array()){
        $department = $this->department->getDepartmentByPinyinList($select,$where,$orderBy);
        foreach($department as $k=>$val){
            $level2 = $this->department->getDepartmentByPinyinList($select,['and','class_level1='.$val['id'],'level=2'],$orderBy);
            $department[$k]['level2'] = $level2;
        }
        return $department;
    }
    /**
     * 根据部位，查询所有部位有关联的科室数据
     * @param array $where 查询条件
     * @return 科室的数据集合
     */
    public function departmentPartRel($where =''){
        $sql =  'select department.id,department.name,department.pinyin,department.child from `9939_part_disease_rel` partDisease ,`9939_disease_department_rel` deseaseDepartment ,`9939_department` department where partDisease.diseaseid = deseaseDepartment.diseaseid and deseaseDepartment.departmentid = department.id '.$where.' group by department.name order by department.listorder asc ';
        return static::findBySql($sql)->orderBy('id')->asArray(true)->all();
    }

    /**
     * 查询症状相关联的疾病
     * @param int $id 疾病id
     * @return array 疾病列表
     */
    public function relevanceDisease($id=0){
        $sql = "select disease.id,disease.name,disease.pinyin_initial from `9939_disease_symptom_rel` disease_symptom ,`9939_disease` disease where disease_symptom.diseaseid =  disease.id  and disease_symptom.symptomid = ".$id." limit 0,5" ;
        return static::findBySql($sql)->asArray(true)->all();
    }
    
    /**
     * 查询疾病相关联的症状
     * @param int $id 症状id
     * @return array 疾病列表
     */
    public function relevanceSymptom($id=0){
       $sql = "select symptom.id,symptom.name,symptom.pinyin_initial from `9939_disease_symptom_rel` disease_symptom ,`9939_symptom` symptom where disease_symptom.symptomid =  symptom.id and disease_symptom.diseaseid = ".$id." limit 0,5" ;
       return static::findBySql($sql)->asArray(true)->all();
    }

    /**
     * 根据部位，关联查询所有数据疾病，症状数据
     * @param string $col_name 等级字段 part_level1/part_level2
     * @param int $partid 部位id
     * @param string $typeId t1 疾病 t2症状 为空查询，疾病和症状综合
     * @param int $offset 第几条开始
     * @param int $size 每页显示条数
     * @param array $orderby 排序
     * @param $return_count_flag 是否查询总条数
     * @return res array 查询的部位数据集合  total int 总条数
     */
    public function partSearchSynthesize($col_name='',$partid=0,$typeId='',$offset=0,$size=10,$return_count_flag=false,$orderBy=[]){
        $query = new Query(); 
        $relateTable = '{{%disease_symptom_merge}}';
        //根据typeid判断要查询时需要的条件
        if($typeId=='t1'){
            $where[$relateTable.'.source_flag']=1;
        }elseif($typeId=='t2'){
            $where[$relateTable.'.source_flag']=2;
        }
        $where['9939_part_rel_merge.'.$col_name]=$partid;
        $res =  $query->select("{$relateTable}.id,{$relateTable}.name,{$relateTable}.description,{$relateTable}.pinyin,{$relateTable}.pinyin_initial,{$relateTable}.source_flag,{$relateTable}.alias")
                ->from('9939_part_rel_merge')
                ->where($where)
                ->leftJoin($relateTable, "9939_part_rel_merge.unique_key = {$relateTable}.unique_key");
                $total = 0;
                if($return_count_flag===true){
                    $total = $res->count("9939_part_rel_merge.unique_key",static::getDb());
                }
                if($size>0){
                    $res = $res ->limit($size)->offset($offset);
                }
                $res = $res->all(static::getDb());
        return array('total'=>$total,'res'=>$res);
    }
   
    /**
     * 根据科室查询所有相关的疾病和症状集合
     * @param string $col_name 等级字段 class_level1/class_level2
     * @param int $departid 科室id
     * @param string $typeId t1 疾病 t2症状 为空查询，疾病和症状综合
     * @param int $offset 第几条开始
     * @param int $size 每页显示条数
     * @param array $orderby 排序
     * @param $return_count_flag 是否查询总条数
     * @return res array 查询的部位数据集合  total int 总条数
     */
    public function departSearchSynthesize($col_name='',$departid=0,$typeId='',$offset=0,$size=10,$return_count_flag=false,$orderBy=[]){
        $query = new Query(); 
        $relateTable = '{{%disease_symptom_merge}}';
        //根据typeid判断要查询时需要的条件
        if($typeId=='t1'){
            $where[$relateTable.'.source_flag'] = 1;
        }elseif($typeId=='t2'){
            $where[$relateTable.'.source_flag'] = 2;
        }
        $where['9939_depart_rel_merge.'.$col_name]=$departid;
        $res =  $query->select("{$relateTable}.id,{$relateTable}.name,{$relateTable}.description,{$relateTable}.pinyin,{$relateTable}.pinyin_initial,{$relateTable}.source_flag,{$relateTable}.alias")
                ->from('9939_depart_rel_merge')
                ->where($where)
                ->leftJoin($relateTable, "9939_depart_rel_merge.unique_key = {$relateTable}.unique_key");
        $total = 0;
        if($return_count_flag===true){
            $total = $res->count("9939_depart_rel_merge.unique_key",static::getDb());
        }
        if(!empty($orderBy)){
            $res = $res->orderBy($orderBy);
        }
        if($size>0){
            $res = $res ->limit($size)->offset($offset);
        }
        $res = $res->all(static::getDb());
        return array('total'=>$total,'res'=>$res);
    }
    
    /**
     * 根据科室，部位查询所有相关的疾病和症状集合
     * @param string $part_name 部位等级字段 part_level1/part_level2
     * @param string $department_name 科室等级字段 class_level1/class_level2
     * @param string $partid 部位id
     * @param string $departmentid 科室id
     * @param string $typeId t1 疾病 t2症状 为空查询，疾病和症状综合
     * @param int $offset 第几条开始
     * @param int $size 每页显示条数
     * @param array $orderby 排序
     * @param $return_count_flag 是否查询总条数
     * @return res array 查询的部位数据集合  total int 总条数
     */
    public function partDepartSearchSynthesize($part_name='',$department_name='',$partid=0,$departmentid=0,$typeId='',$offset=0,$size=10,$return_count_flag=false,$orderBy=[]){
        $query = new Query();
        $relateTable = '{{%depart_rel_merge}}';
        $relateTable2 = '{{%part_rel_merge}}';
        if($typeId=='t1'){
           $where['9939_disease_symptom_merge.source_flag']=1;

        }elseif($typeId=='t2'){
            $where['9939_disease_symptom_merge.source_flag']=2;
        }
        $where[$relateTable.'.'.$department_name]=$departmentid;
        $where[$relateTable2.'.'.$part_name]=$partid;

        $res =  $query->select('9939_disease_symptom_merge.id,9939_disease_symptom_merge.name,9939_disease_symptom_merge.description,9939_disease_symptom_merge.pinyin,9939_disease_symptom_merge.pinyin_initial,9939_disease_symptom_merge.source_flag')
                ->from('9939_disease_symptom_merge')
                ->where($where)
                ->leftJoin($relateTable, "9939_disease_symptom_merge.unique_key = {$relateTable}.unique_key")
                ->leftJoin($relateTable2, "9939_disease_symptom_merge.unique_key = {$relateTable2}.unique_key");
                $total = 0;
        if($return_count_flag===true){
            $total = $res->count("9939_disease_symptom_merge.unique_key",static::getDb());
        }
        if(!empty($orderBy)){
            $res = $res->orderBy($orderBy);
        }
        if($size>0){
            $res = $res ->limit($size)->offset($offset);
        }
        $res = $res->all(static::getDb());
         return array('total'=>$total,'res'=>$res);
    }
    
    /**
     * 查询常见疾病
     */
    public function getCommonDisease(){
        $sql = "select d.id,d.name,d.pinyin,d.pinyin_initial from 9939_category_disease_rel as c inner join 9939_disease as d on c.diseaseid = d.id where c.categoryid = 1 order by c.id asc limit 0,12" ;
       return static::findBySql($sql)->asArray(true)->all();
    }
    /**
     * 查询人群关联的疾病症状列表
     * @param int $creatureid 分类id
     * @param string $tab 标识 默认查找疾病  t2疾病查找
     * @param int $size
     * @param int $offset
     * @param $return_count_flag
     * @return array total 总共条数 array res 数据集合
     */
    public function getCreatureSearch($creatureid=array(),$tab=array(),$size=10,$offset=1,$return_count_flag=false){
        $where='';
        $where2='';
        if(!empty($creatureid)){
            $where = 'where a.categoryid = '.$creatureid;
            $where2 = 'and a.categoryid = '.$creatureid;
        }
        if($tab=='t2'){
            $source_flag = 'WHERE source_flag = 2';
            $sql = "select * FROM 9939_disease_symptom_merge ".$source_flag." AND id in(select b.departmentid from 9939_category_disease_rel a INNER JOIN 9939_disease_department_rel b on a.diseaseid = b.diseaseid ".$where.") order by id asc";
        }else{
            $sql = "select d.* from 9939_category_disease_rel a inner join 9939_disease_symptom_merge d on a.diseaseid = d.id where source_flag = 1 ".$where2." order by a.id asc ";
        }
        $total = 0;
        if($return_count_flag!=false){
            $total = static::findBySql($sql)->count();
        }
        $sql.=' limit '.$offset.','.$size;
        $res = static::findBySql($sql)->asArray(true)->all();
        return array('total'=>$total,'list'=>$res);
    }
}
