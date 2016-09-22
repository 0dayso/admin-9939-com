<?php
namespace common\models\ask;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

class Department extends BaseModel{
    private static $tableName = 'wd_keshi';
    
    public static function tableName() {
        return self::$tableName;
    }

    public static function getDB() {
        return \Yii::$app->db_v2sns;
    }
    
    //问答库 一级科室
    public function getlevel1() {
        $db = $this->getDB();
        $sql = 'select id,class_level1,class_level2,name from wd_keshi where pID=0';
        $mes = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $mes;
    }
    
    public function getLevel2ByLevel1($level1) {
        $db = $this->getDB();
        $sql = 'select id,class_level1,class_level2,name from wd_keshi where pID=:pID';
        $bound = ['pID'=>$level1];
        $mes = $db->createCommand($sql,$bound)->queryAll(PDO::FETCH_ASSOC);
        return $mes;
    }
    

}