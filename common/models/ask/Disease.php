<?php
namespace common\models\ask;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

class Disease extends BaseModel{
    private static $tableName = 'wd_disease';
    
    public static function tableName() {
        return self::$tableName;
    }

    public static function getDB() {
        return \Yii::$app->db_v2sns;
    }
    
    public function getDiseaseByName($name) {
        $connection = $this->getDB();
        $sql = 'SELECT * from wd_disease where name like "%'.$name.'%"';
        $res = $connection->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $res;
    }
    
    /**
     * 获取疾病条数
     * @param type $diseaseQuery
     * @return type
     */
    public function getCounts($param){
        $where = '';
        $bound = [];
        foreach ($param as $k => $v) {
            if(!empty($v)){
                    $where .= ' and ' . $k . ' = :' . $k;
                    $bound[':' . $k] = $v;
            }
        }
        $where = substr($where, 5);
        $where = (!empty($where)) ? $where : '' ;
        return Department::find()
                ->where($where,$bound)
                ->count('id');
    }
    
    public function getDiseasesByCondition($param = [], $offset = 0, $length = 10) {
        $where = '';
        $bound = [];
        foreach ($param as $k => $v) {
            if(!empty($v)){
                    $where .= ' and ' . $k . ' = :' . $k;
                    $bound[':' . $k] = $v;
            }
        }
        $where = substr($where, 5);
        $where = (!empty($where)) ? $where : '' ;
        return Disease::find()
                ->select("id,name,class_level1,class_level2,source")
                ->where($where,$bound)
                ->offset($offset)
                ->limit($length)
                ->asArray()
                ->all();
    }
}
