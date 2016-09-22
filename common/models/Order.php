<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\db\Query;

class Order extends BaseModel {

    public static function tableName() {
        return '{{%order}}';
    }

    public static function getDb() {
        return \Yii::$app->db_jbv2;
    }
    
    public function init(){
    	parent::init();
    }
    
    /**
     * 查询数据
     * @param type $conditions
     * @param type $offset
     * @param type $size
     * @param type $orderby
     * @param type $return_count_flag
     * @param type $index_by
     * @return type
     */
    public static function search($conditions=[],$offset=0, $size=0,$orderby = array(),$return_count_flag=false,$index_by='') {
        $query = static::find();
        if(count($conditions)>0){
            foreach ($conditions as $con){
                $query = $query->andWhere($con);
            }
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
        return array('list'=>$list,'total'=>$total);
    }
    
    /**
     * 获取数据最大值
     * @param type $where
     * @return type
     */
    public function getNum($where=array()){
        $query = static::find();
                foreach($where as $wd){
                   $query = $query->andWhere($wd);
                }
//                $query =$query->createCommand()->getRawSql();
               return $query->count();
    }
    
    /**
     * 根据id，删除相关数据
     * @param type $id
     * @return type
     */
    public function orderDel($id=0){
        return static::findOne($id)->delete();
    }
    
    /**
     * 根据id获取当前数据详情
     * @param type $id
     */
    public function orderDetail($id=0){
        return static::find()->where(['id'=>$id])->asArray(TRUE)->one();
    }
    
    public function orderQueren($data=array(),$id=0){
        if(!empty($data)){
            $where =array(
                'id'=>$id,
            );
            return static::getDb()->createCommand()->update("9939_order", $data, $where)->execute();
        }
    }
}
