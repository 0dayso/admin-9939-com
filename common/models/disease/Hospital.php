<?php
namespace common\models\disease;
use librarys\models\BaseModel;

class Hospital extends BaseModel
{
    public static function tableName()
    {
        return 'hospital';
    }
    
    public static function getDb()
    {
        return \Yii::$app->db_dzjb;
    }
        
    /**
     * 
     * @param type $where
     * @return type
     */
    function get_one_get($where){
        return self::find()->where($where)->one();
    }
	
}
?>