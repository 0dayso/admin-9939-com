<?php
namespace common\models\disease;
use librarys\models\BaseModel;

class Doctor extends BaseModel
{
    public static function tableName()
    {
        return 'doctor';
    }
    
    public static function getDb()
    {
        return \Yii::$app->db_dzjb;
    }
    
    /**
     * 获取医生信息
     * @param type $where
     * @return type
     */
    public function get_doctor($where) {
        return self::find()->where($where)->one();
    }
    
    /**
     * 添加医生信息
     * @param type $info
     * @return type
     */
    function add_one($info) {
        try {
            $db = static::getDb();
            $db->createCommand()->insert(self::tableName(), $info)->execute();
            $last_insert_id = $db->getLastInsertID();
            return $last_insert_id;
        }catch(Exception $e) {
            echo $e;
        }
    }
}
?>