<?php

namespace backend\models\part;

use Yii;
use librarys\models\BaseModel;
use yii\db\Query;

/**
 * 部位 model 类
 */

class Part extends BaseModel{
    
    const STATUS_ACTIVE = 1;
    const STATUS_DIE = 0; 

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Part}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_jbv2;
    }

    public function rules() {
        return [
            [['id'],'integer'],
            ['name','unique','message'=>'<{value}>已经存在！'],
            [['name','keywords','description'],'required','message'=>'{attribute}不能为空！'],
            [['name','keywords','description','pid','part_level1','part_level2','level','child','userid','username','createtime','updatetime'],'safe'],
        ];
    }
    /*
     * 查询所有一级部位
     * @return 所有数据集合
     */
    public function getList(){
            return part::find()->select('id,name,description,child,level')->where(array('level'=>'1'))->orderBy('id asc')->asArray()->all();
    }
    
    public static function search($condition=[],$offset=0, $size=0,$orderby = array(),$return_count_flag=false,$index_by='') {
        $query = static::find();
        if(count($condition)>0){
            $query = $query->where($condition);
        }
        $total = 0;
        if($return_count_flag===true){
            $total = $query->count('*');
        }
        
        if(!empty($index_by)){
            $query = $query->indexBy($index_by);
        }
        
        if(count($orderby)>0){
            $query = $query->orderBy($orderby);
        }
        
        if($size>0){
            $query = $query->limit($size)->offset($offset);
        }
        
        $list = $query->asArray(true)->all();
        return ['list'=>$list,'total'=>$total];
    }

   /*
    * 统计数据条数
    */
    public function getListCount(){
        return part::find()->where(array('level'=>'1'))->count('id');
    }
    /**
     * 一级部位下的子部位的数目
     * @param type $id
     * @return array 返回该一级部位下的子部位的数目
     */
    public function getLevel1ChildNum($id) {
        return part::find()
                ->select("count(id) as count")
                ->where('pid=:pid',[':pid'=>$id])
                ->asArray()
                ->one();
    }
    
    /*
     * 统计各级部位数量
     */
    public function getNum(){
        return part::find()
            ->select("count(case when level=1 then level end) as part_level1,count(case when level=2 then level end ) as part_level2")
            ->asArray()
            ->one();
    }

    /*
     * 查询一级部位数据
     */
    public function getPartLevel(){
        $where= array(
            'level'=>1
        );
        return part::find()->select('*')->where($where)->asarray()->all();
    }

    /**
    * 按条件查询部位的记录条数
    */
   public function getPartCount($param = []) {
       $array = array_intersect_key($param , $this->attributes);
       $where = '';
       $bound = [];
       foreach ($array as $k => $v) {
           if(!empty($v)){
                   $where .= ' and ' . $k . ' = :' . $k;
                   $bound[':' . $k] = $v;
           }
       }
       $where = substr($where, 5);
       $where = (!empty($where)) ? $where : 'pid = 0' ;
       return part::find()
               ->where($where,$bound)
               ->count('id');
   }
   
    /**
     * 根据条件查询部位
     * @param array $param 为空时查询返回一级部位
     * @param integer $offset
     * @param integer $length
     * @return array
     */
    public function getSearchPart($param = [],$offset = 0,$length = 10) {
        $array = array_intersect_key($param , $this->attributes);
        $where = '';
        $bound = [];
        foreach ($array as $k => $v) {
            if(!empty($v)){
                    $where .= ' and ' . $k . ' = :' . $k;
                    $bound[':' . $k] = $v;
            }
        }
        $where = substr($where, 5);
        $where = (!empty($where)) ? $where : 'pid = 0' ;
        return part::find()
                ->select("id,name,description,child,level")
                ->where($where,$bound)
                ->offset($offset)
                ->limit($length)
                ->asArray()
                ->all();
    }

   /*
    * ajax删除指定部位
    */
   public function partDel($id){
      return static::getDb()->createCommand()->delete('9939_part',array('id'=>$id))->execute();
   }
       
    /**
     * 添加部位
     * @param array $param 包含部位信息的数组
     */
    public function partAdd1($param) {

        //整理数据
        $this->attributes = $param;
        if ($this->save()) {
            $id = $this->Attributes['id'];
            $part_level = ($param['level'] == 1) ? 'part_level1' : 'part_level2';
            $this->updateAll([$part_level => $id], 'id = :id', [':id' => $id]);
            if ($param['level'] == 2) {
                $this->updateAll(['child' => '1'], 'id = :id', [':id' => $param['pid']]);
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 查询单一部位     
     *  条件：部位id
     * @param integer $id 部位ID
     * @param integer $contain 默认为0，结果为id,pid,class_level1,class_level2,name,listorder,level；值为1，则为所有字段
     */
    public function getPartById($id , $contain = 0) {
        $select = 'id,pid,part_level1,part_level2,name,listorder,level,keywords,description';
        $select = ($contain == 1) ? "*" : $select;
        $res = part::find()
                ->select($select)
                ->where('id =:id', [':id' => $id])
                ->asArray()
                ->one();
        return $res;
    }
    
    /**
     * 编辑部位
     * @param array $param 包含部位信息的数组
     */
    public function partEdit($param) {
        //判断用户名是否存在
        $name = part::findBySql("select * from `9939_part` where id != '". $param['id'] ."' and name = '".$param['name']."'")->one();
        if(empty($name)){
            $array = array(
                'name'=>$param['name'],
                'keywords'=>$param['keywords'],
                'description'=>$param['description'],
                'username'=>$param['username'],
                'userid'=>$param['userid'],
                'updatetime'=>$param['updatetime'], 
            );
            unset($array['id']);
            $where = array(
                'id'=>$param['id']
            );
           $db1 = static::getDb()->createCommand()->update("9939_part", $array, $where)->execute();
           if($db1){
               return '0';
           }else{
               return '1';
           }
        }else{
			return '2';
		}
        
    }
    /*
     * 查询一级部位下的子部位
     * @param integer $id 部位ID(默认为0，所有部位列表，若不为0，返回子部位信息 )
     * @param integer $offset
     * @param integer $length 0=>所有数据
     * @param integer $contain  默认为0=>主要字段;值为1=>全部字段
     * return 部位集合
     */
    public function getPartListLevel2($id = 0, $offset = 0, $length = 0, $contain = 0){
        $where = ($id > 0) ? 'pid = ' . $id : '';
        $select = 'id,pid,part_level1,part_level2,name,listorder,level,description';
        $select = ($contain == 1) ? '*' : $select;

        $dep = part::find()
                ->select($select)
                ->where($where);
        if ($length == 0) {
            $res = $dep
                    ->asArray()
                    ->all();
        } else {
            $res = $dep
                    ->offset($offset)
                    ->limit($length)
                    ->asArray()
                    ->all();
        }

        return $res;
    }
    
   /*
    *修改二级部位数据
    * @param param要修改的数据值 
    */
    public function editLevel2($param = 0,$id = 0){
        //判断当前用户修改后，是否需要修改
        $level1 = part::findOne(array('id'=>$id));
        $flag = 0;
         if (array_key_exists('pid', $param)) {
             if($level1->attributes['pid'] != $param['pid']){
                 $count = $this->getLevel1Count($level1->attributes['pid']);
                 $forepid = $level1->attributes['pid'];
                 $flag = 1;
             }
         }
        $level1->attributes = $param;
        
        if ($level1->save()) {
            if ($flag) {//所属部位更改，将新的所属部位child->1
                $this->updateAll(['child' => '1'], 'id = :id', [':id' => $param['pid']]);
                    $this->editPartDisease($level1->attributes['pid'], $level1->attributes['id']);
                if ($count['count'] == 1) {//若为原属一级部位的唯一子部位，将原属部位的child->0
                    $this->updateAll(['child' => '0'], 'id = :id', [':id' => $forepid]);
                }
            }
            return true;
        } else {
            return false;
        }
        //print_r($level1);exit;
    }
    
    public function getLevel1Count($id){
        return part::find()
                ->select("count(id) as count")
                ->where('pid=:pid',[':pid'=>$id])
                ->asArray()
                ->one();
    }
    public function editPartDisease($pid = 0,$id = 0){
       if($pid && $id){
            return part::getDb()->createCommand()->update('9939_part',array('part_level1'=>$pid),array('id'=>$id))->execute();
        }
    }
    /**
     * 查询部位下子部位列表
     * @param integer $id 部位ID(默认为0，所有部位列表，若不为0，返回子部位信息 )
     * @param integer $offset
     * @param integer $length 0=>所有数据
     * @param integer $contain  默认为0=>主要字段;值为1=>全部字段
     * @return array 部位集
     */
    public function getPartListById($id = 0, $offset = 0, $length = 0, $contain = 0) {
       
        $where = ($id > 0) ? 'pid = ' . $id : '';
        $select = 'id,pid,part_level1,part_level2,name,listorder,level,description,pinyin';
        $select = ($contain == 1) ? '*' : $select;

        $dep = Part::find()
                ->select($select)
                ->where($where);
        if ($length == 0) {
            $res = $dep
                    ->asArray()
                    ->all();
        } else {
            $res = $dep
                    ->offset($offset)
                    ->limit($length)
                    ->asArray()
                    ->all();
        }

        return $res;
    }
    
    /**
	 *得到疾病总数
	 * @param array $diseaseQuery 查询条件数据集
	 * @return int 疾病总数
	 */
	public function getCounts($diseaseQuery){
		$queryObj = new Query();
		$queryObj
				->select(["de.id", "de.name", "de.typical_symptom", "de.inputtime"])
				->from("9939_disease de");
		$queryObj = $this->getQueryCondition($diseaseQuery, $queryObj);
		return $queryObj->count('de.id',static::getDb());
	}
        
        /**
	 * 得到查询条件的字符串值
	 * @param array $diseaseQuery 查询条件
	 * @param Query $queryObj Query 查询对象
	 * @return string 查询条件的字符串值
	 */
	 private function getQueryCondition($diseaseQuery, $queryObj) {
	 	//判断是否有部位方面的查询条件
	 	if (isset($diseaseQuery['part']) && !empty($diseaseQuery['part'])) {
	 		$part = $diseaseQuery['part'];
                        //print_r($part);exit;
	 		$queryObj->innerJoin("9939_part_disease_rel ddr", "de.id = ddr.diseaseid");
	 		$queryObj->andWhere($part);
	 	}
	 	//判断是否有疾病表中的查询条件
	 	elseif (isset($diseaseQuery['disease']) && !empty($diseaseQuery['disease'])) {
	 		$disease = $diseaseQuery['disease'];
	 		$queryObj->andWhere($disease);
	 	}
	 	//判断是否根据疾病名称，模糊查询
	 	elseif (isset($diseaseQuery['name'])) {
	 		$name = $diseaseQuery['name'];
	 		$queryObj->andWhere(["like", "de.name", $name]);
	 	}
	 	//判断是否根据症状信息，模糊查询
	 	elseif (isset($diseaseQuery['typical_symptom'])) {
	 		$symptom = $diseaseQuery['typical_symptom'];
	 		$queryObj->andWhere(["like", "de.typical_symptom", $symptom]);
	 	}
	 	return $queryObj;
	}
        
       /**
        * 根据条件，查询疾病信息
        * @param array $diseaseQuery 查询条件
        * @param int $start 开始值
        * @param int $size 每次查询的条数
        * @return array 疾病信息集
        */
       public function getDiseasesByCondition($diseaseQuery, $start = 0, $size = 10) {
           $diseaseArr = [];

           //组装查询对象
           $queryObj = new Query();
           $queryObj
                           ->select(["de.id", "de.name", "de.typical_symptom", "de.inputtime"])
                           ->from("9939_disease de");
           $queryObj = $this->getQueryCondition($diseaseQuery, $queryObj);
           $queryObj->offset($start);
           $queryObj->limit($size);

           $command = $queryObj->createCommand(static::getDb());
           $diseaseArr = $command->queryAll(\PDO::FETCH_ASSOC);

           return $diseaseArr;
       }
       
    /**
     * 添加 部位 <=> 疾病
     * @param type $department ['class_level1'=>$class_level1 , 'class_level2'=>$class_level2]
     * @param type $arrdisease [diseaseid1,...]
     * @return boolean
     */
    public function addDiseaseRel($department, $arrdisease) {
        $db = \Yii::$app->db_jbv2;
        $rows = [];
        foreach ($arrdisease as $key => $val) {
            $rows[] = [$val, $department['part_level2'], $department['part_level1'], $department['part_level2']];
        }
        $create = $db->createCommand()
                ->batchInsert('9939_part_disease_rel', ['diseaseid', 'partid', 'part_level1', 'part_level2'], $rows)
                ->execute();
        if ($create) {
            return true;
        }
    }
    
    /**
     * 
     * @param int $partid 部位id
     * @param int $arrdiseaseid
     * @return boolean
     */
    public function deleteDiseasePart($partid, $arrdiseaseid) {
        $db = \Yii::$app->db_jbv2;
        $mes = $db->createCommand()->delete('9939_part_disease_rel',array('partid'=>$partid,'diseaseid'=>$arrdiseaseid))->execute();
        if($mes){
            return 1;
        }else{
            return 0; 
        }
    }
}
