<?php

namespace common\models;

use Yii;
use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

/**
 * Department 科室操作 model
 */

class Department extends BaseModel{
    
//    public $login_id;
//    public $login_name;
//    
//    public function __construct($userid = '', $username = '') {
//        parent::__construct();
//        $this->login_id = $userid;
//        $this->login_name = $username;
//    }

    public static function tableName()
    {
        return '{{%department}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_jbv2;
    }
    
    public function rules() {
        return [
            [['id'],'integer'],
            ['name','unique','message'=>'<{value}>已经存在！'],
            [['name'],'required','message'=>'{attribute}不能为空！'],
            [['name','keywords','description','pid','class_level1','class_level2','level','child','userid','username'],'safe'],
        ];
    }
     public function attributeLabels()
    {
        return [
            'id' => '科室ID',
            'pid' => '科室pID',
            'name' => '科室名称',
            'keywords' => '科室关键词',
            'description' => '科室描述',
        ];
    }

    /**
     * 根据科室名称，获取 9939_com_v2sns wd_keshi 表中的 科室 信息
     * @author gaoqing
     * @date 2018-04-01
     * @param string $name 科室名称
     * @return array wd_keshi 表中的 科室 信息
     */
    public function getOldDepsByName($name){
        $department = [];

        $db = Yii::$app->db_v2sns;
        $sql = " SELECT * FROM wd_keshi WHERE name = '" . $name . "'";
        $department = $db->createCommand($sql)->queryOne(PDO::FETCH_ASSOC);
        return $department;
    }

    public function getDepsByName($names){
        return Department::find()->asArray()->where(["name" => $names])->all();
    }
    
    /**
     * 根据科室名称，获取科室的id
     * @author gaoqing
     * 2016年1月21日
     * @param string $departmentName 科室名
     * @return int 科室id
     */
    public function getDepIDByName($departmentName) {
    	$departmentid = 0;
    	
    	if (isset($departmentName) && !empty($departmentName)) {
    		$department = $this->getDepsByName($departmentName);
    		if (isset($department) && !empty($department)) {
    			$departmentid = $department[0]['id'];
    		}
    	}
    	return $departmentid;
    }
    
    /**
     * 根据疾病id，查询其对应的科室信息
     * @author gaoqing
     * 2016年1月19日
     * @param int $diseaseid 疾病id
     * @return array 科室信息集
     */
    public function getDepartmentsByDisid($diseaseid) {
    	$diseaseDepartment = [];
    	$connection = $this->getDb();

        //1、根据疾病id, 查询其 科室id departmentid,
        $sql = " SELECT ddr.departmentid from `9939_disease_department_rel` ddr WHERE ddr.diseaseid = ${diseaseid}";
        $departmentidObj = $connection->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);

        if (isset($departmentidObj) && !empty($departmentidObj)){
            $departmentids = "";
            foreach ($departmentidObj as $departmentid){
                $departmentids[] = $departmentid['departmentid'];
            }
            //2、根据 departmentid, 得到其对应的科室信息集
            $ids = implode(',', $departmentids);
            $dsql = " select * from `9939_department` WHERE id IN (${ids})";
            $diseaseDepartment = $connection->createCommand($dsql)->queryAll(PDO::FETCH_ASSOC);
        }
    	return $diseaseDepartment;
    }

     
    /**
     * 根据疾病id，查询其对应的科室信息
     * lc 2016-3-30
     * @param int $diseaseid 疾病id
     * @return array 科室信息集
     */
    public function batchGetDepartmentsByDisid($diseaseId) {
    	$diseaseDepartment = [];
    	$connection = $this->getDb();
    	 
    	$sql = "  SELECT dt.id, dt.class_level1, dt.class_level2, dt.name, dt.pinyin FROM 9939_disease_department_rel ddr, 9939_department dt "
                . "WHERE (ddr.departmentid = dt.id or ddr.class_level1 = dt.id)";
    	$where = " AND ddr.diseaseid in ({$diseaseId})";
        $sql .=$where;
    	$diseaseDepartment = $connection->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
    	 
    	return $diseaseDepartment;
    }
    
    
  public function beforeSave($insert) {
        $time = time();
        
        if ($this->isNewRecord) {
            $this->createtime = $time;
            $this->child = 0;
        }
            $this->updatetime = $time;

        return parent::beforeSave($insert);
    }

    /**
     * 添加科室
     * @param array $param 包含科室信息的数组
     * @return mixed 成功返回true,失败返回错误信息
     */
    public function add($param) {

        //整理数据
        $this->attributes = $param;

        if ($this->save()) {
            $id = $this->Attributes['id'];
            $class_level = ($param['level'] == 1) ? 'class_level1' : 'class_level2';
            $this->updateAll([$class_level => $id], 'id = :id', [':id' => $id]);
            if ($param['level'] == 2) {
                $this->updateAll(['child' => '1'], 'id = :id', [':id' => $param['pid']]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 编辑科室
     * @param array $param 包含科室信息的数组
     */
    public function edit($param) {

        $model = Department::findOne($param['id']);
        unset($param['id']);

        $flag = 0; //所属一级科室是否修改
        if (array_key_exists('pid', $param)) {
            if ($model->attributes['pid'] != $param['pid']) {
                $count = $this->getLevel1ChildNum($model->attributes['pid']);
                $forepid = $model->attributes['pid'];
                $flag = 1;
            }
        }

        $model->attributes = $param;

        if ($model->save()) {
            if ($flag) {//所属科室更改，将新的所属科室child->1
                $this->updateAll(['child' => '1'], 'id = :id', [':id' => $param['pid']]);
                    $this->editDepartmentDisease($model->attributes['class_level2'], $model->attributes['class_level1']);
                if ($count['count'] == 1) {//若为原属一级科室的唯一子科室，将原属科室的child->0
                    $this->updateAll(['child' => '0'], 'id = :id', [':id' => $forepid]);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除科室 
     * @param integer $id 要删除科室的id
     * @return integer 成功返回1；失败返回0；
     */
    public function del($id) {
        $flag = 0;
        $model = self::getDB();
        $transaction = $model->beginTransaction();
        try {
            $cur_depart = $this->getDepartmentById($id);
            if ($cur_depart['level'] == 2) {
                $class_level1 = $cur_depart['class_level1'];
                $search = $this->getSearch(['pid' => $class_level1]);
                $count = count($search);
                //若为二级科室，判断是否为所属一级科室下的最后一个子科室
                if ($count == 1) {
                    $userid = '008';
                    $username = '666';
                    $updatetime = time();
                    $model->createCommand()->update('9939_department', ['child' => '0', 'userid' => $userid, 'username' => $username, 'updatetime' => $updatetime], 'id = :id', [':id' => $class_level1])->execute();
                }
            }
            $model->createCommand()->delete('9939_department', 'id=:id', [':id' => $id])->execute();
            $model->createCommand()->delete('9939_disease_department_rel', 'departmentid=:id', [':id' => $id])->execute();

            $transaction->commit();
            $flag = 1;
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $flag;
    }

    /**
     * 查询单一科室     
     *  条件：科室ID
     * @param integer $id 科室ID
     * @param integer $contain 默认为0，结果为id,pid,class_level1,class_level2,name,listorder,level；值为1，则为所有字段
     */
    public function getDepartmentById($id , $contain = 0) {
        $select = 'id,pid,class_level1,class_level2,name,listorder,level,keywords,description';
        $select = ($contain == 1) ? "*" : $select;
        $res = Department::find()
                ->select($select)
                ->where('id =:id', [':id' => $id])
                ->asArray()
                ->one();
        return $res;
    }
    
    /**
     * 查询科室下子科室列表
     * @param integer $id 科室ID(默认为0，所有科室列表，若不为0，返回子科室信息 )
     * @param integer $offset
     * @param integer $length 0=>所有数据
     * @param integer $contain  默认为0=>主要字段;值为1=>全部字段
     * @return array 科室集
     */
    public function getDepartmentListById($id = 0, $offset = 0, $length = 0, $contain = 0) {
       
        $where = ($id > 0) ? 'pid = ' . $id : '';
        $select = 'id,pid,class_level1,class_level2,name,listorder,level,description,pinyin';
        $select = ($contain == 1) ? '*' : $select;

        $dep = Department::find()
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
     * 一级科室列表
     * @param integer $contain 默认为0=>主要字段；1=>全部字段
     */
    public function getDepartmentLevel1($contain = 0, $order = "listorder asc") {
        $select = 'id,name,listorder,pinyin';
        $select = ($contain == 1) ? '*' : $select;
        return Department::find()
                ->select($select)
                ->where('pid = 0')
                ->orderBy($order)
                ->asArray()
                ->all();
    }
    

    
    
    /**
     * 根据条件查询科室
     * @param array $param 为空时查询返回一级科室
     * @param integer $offset
     * @param integer $length
     * @return array
     */
    public function getSearch($param = [],$offset = 0,$length = 10) {
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
        return Department::find()
                ->select("id,name,description,child,level")
                ->where($where,$bound)
                ->offset($offset)
                ->limit($length)
                ->asArray()
                ->all();
        
    }
    /**
     * 按条件查询科室的记录条数
     */
    public function getSearchCount($param = []) {
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
        return Department::find()
                ->where($where,$bound)
                ->count('id');
        
    }
    /**
     * 查询一级、二级科室的数量
     * @return array 返回数组:['class_level1'=>$num1,'class_level2'=>$num2];
     */
    
    public function getDepartmentNumber() {
        return Department::find()
                ->select("count(case when level=1 then level end) as class_level1,count(case when level=2 then level end ) as class_level2")
                ->asArray()
                ->one();
    }
    
    /**
     * 一级科室下的子科室的数目
     * @param type $id
     * @return array 返回该一级科室下的子科室的数目
     */
    public function getLevel1ChildNum($id) {
        return Department::find()
                ->select("count(id) as count")
                ->where('pid=:pid',[':pid'=>$id])
                ->asArray()
                ->one();
    }
    /**
     * 科室归属改变 => 科室-疾病 改变
     * @param integer $class_level2 二级科室
     * @param integer $new 新归属的一级科室
     */
    public function editDepartmentDisease($class_level2,$new_level1) {
        if($class_level2 && $new_level1){
            return Department::updateAll(['class_level2'=>':level2'], 'class_level1=:level1', [':level2'=>$new_level1,'level1'=>$class_level2]);
        }
    }
    
    /**
     * 
     * @param integer $departmentid 科室id
     * @param integer $flag  0=>删除指定疾病  1=>删除该科室下所有疾病
     * @param array $arrdiseaseid 一维数组 [$diseaseid,...]
     * @return boolean
     */
    public function deleteDiseaseDepartment($departmentid, $flag , $arrdiseaseid = []) {

        $db = Yii::$app->db_jbv2;
        if ($flag == 0 && count($arrdiseaseid) > 0) {
            foreach ($arrdiseaseid as $key => $val) {
                $sql = 'delete 
                        from 9939_disease_department_rel 
                        where diseaseid = :diseaseid and departmentid = :departmentid';
                $bound = [':diseaseid' => $val, ':departmentid' => $departmentid];
                $mes = $db->createCommand($sql, $bound)->execute();
            }
        } elseif ($flag == 1) {
            $sql = 'delete 
                    from 9939_disease_department_rel 
                    where departmentid = :departmentid';
            $bound = [':departmentid' => $departmentid];
            $mes = $db->createCommand($sql, $bound)->execute();
        }
        return true;
    }

    /**
     * 添加 科室 <=> 疾病
     * @param type $department ['class_level1'=>$class_level1 , 'class_level2'=>$class_level2]
     * @param type $arrdisease [diseaseid1,...]
     * @return boolean
     */
    public function addDiseaseRel($department, $arrdisease) {
        $db = Yii::$app->db_jbv2;
        $rows = [];
        foreach ($arrdisease as $key => $val) {
            $rows[] = [$val, $department['class_level2'], $department['class_level1'], $department['class_level2']];
        }
        $create = $db->createCommand()
                ->batchInsert('9939_disease_department_rel', ['diseaseid', 'departmentid', 'class_level1', 'class_level2'], $rows)
                ->execute();
        if ($create) {
            return true;
        }
    }
    
    /**
     * 所有科室名称对应的拼音
     * lc 2016-4-7
     * @return type
     */
    public function getDepartmentPinyin(){
        $department = new Department();
        $tmp = $department->getDepartmentListById(0);
        foreach($tmp as $k=>$v){
            $ret[$v['name']] = $v['pinyin'];
        }
        return $ret;
    }
    
    /**
     * 根据科室pinyin查询单条科室数据
     * @param string $select 需要查询的字段
     * @param array $where 条件
     * @return array res 科室数据集合
     */
    public function getDepartmentByPinyin($select='',$where=array()){
        $select = empty($select) ? '*' : $select;
        $res = static::find()
                ->select($select)
                ->where($where)
                ->asArray()
                ->one();
        return $res;
    }
    
    /**
     * 根据条件查询出当前科室下的所有科室数据
     * @param string $select 需要查询的字段
     * @param array $where 条件
     * @param array $orderBy 排序
     * @param $size $offset 分页
     * @return array 数据集合
     */
    public function getDepartmentByPinyinList($select='',$where=[],$orderBy=[]){
        $select = empty($select) ? '*' : $select;
        $query = static::find()
                ->select($select)
                ->where($where)
                ->orderBy($orderBy)
                ->asArray(true)
                ->all();
        return $query;
    }

}
