<?php

namespace common\models;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class Part extends BaseModel{
    
            
    public static function tableName()
    {
        return '{{%part}}';
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
            [['name','keywords','description','pid','class_level1','class_level2','level','child'],'safe'],
        ];
    }
    
    /**
     * 根据部位名称，获取部位的id
     * @author gaoqing
     * 2016年1月21日
     * @param string $partName 部位名
     * @return int 部位id
     */
    public function getPartIDByName($partName) {
    	$partid = 0;
    	
    	if (isset($partName) && !empty($partName)) {
    		$part = Part::find()->select("id")->where(["name" => $partName])->one();
    		if (isset($part) && !empty($part)) {
    			$partid = $part->id;
    		}
    	}
    	return $partid;
    }


    /**
     * 查询单一部位     
     *  条件：部位ID
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
     * 查询科室下子部位列表
     * @param integer $id 部位ID(默认为0，所有部位列表，若不为0，返回子部位信息 )
     * @param integer $contain  默认为0=>主要字段;值为1=>全部字段
     */
    public function getPartListById($id = 0, $contain = 0,$orderBy=array()) {
       
        $where = ($id > 0) ? 'pid = '.$id : '';       
        $select = 'id,pid,part_level1,part_level2,name,listorder,level,description,pinyin';
        $select = ($contain == 1) ? '*' : $select;
        
        $res = part::find()
                ->select($select)
                ->where($where)
                ->orderBy($orderBy)
                ->asArray()
                ->all();
        
        return $res;
    }
    
    /**
     * 一级部位列表
     * @param integer $contain 默认为0=>主要字段；1=>全部字段
     */
    public function getPartLevel1($contain = 0, $order = "listorder asc") {
        $select = 'id,name,listorder,pinyin';
        $select = ($contain == 1) ? '*' : $select;
        return part::find()
                ->select($select)
                ->where('pid = 0')
                ->orderBy($order)
                ->asArray()
                ->all();
    }
    

    
    
    /**
     * 根据条件查询部位
     * @param array $param
     * @return type
     */
    public function getSearch($param) {
        
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
        
        return part::find()
                ->select("id,name,description,child,level")
                ->where($where,$bound)
                ->asArray()
                ->all();
        
    }
    /**
     * 查询一级、二级部位的数量
     * @return array 返回数组:['part_level1'=>$num1,'part_level2'=>$num2];
     */
    
    public function getPartNumber() {
        return Part::find()
                ->select("count(case when level=1 then level end) as part_level1,count(case when level=2 then level end ) as part_level2")
                ->asArray()
                ->one();
    }
    
    /**
     * 一级部位下的子部位的数目
     * @param type $id
     * @return array 返回该一级部位下的子部位的数目
     */
    public function getLevel1ChildNum($id) {
        return Part::find()
                ->select("count(id) as count")
                ->where('pid=:pid',[':pid'=>$id])
                ->asArray()
                ->one();
    }
    
    /**
     * 根据部位拼音查询当前部位数据
     * @param string $select 需要查询的字段
     * @param array $where 查询条件
     */
    public function getPartByPinyin($select='',$where=array()){
        $select = empty($select) ? '*' : $select;
        $res = static::find()
                ->select($select)
                ->where($where)
                ->asArray()
                ->one();
        return $res;
    }
    
    /**
     * 根据条件查询出当前部位下的所有部位数据
     * @param string $select 查询的字段
     * @param array $where 查询条件
     * @param array $orderBy 排序
     * @param int $size 分页
     * @param int $offset
     * @return array
     */
    public function getPartByPinyinList($select='',$where=[],$orderBy='',$size=0,$offset=0){
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
