<?php

namespace backend\models\users;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class User_Purview extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_purview}}';
    }
    
    public static function getDb()
    {
        return Yii::$app->db_portal;
    }

    
    public function rules() {
        return [
        ];
    }
    
    /**
	 * 
	 * @param integer $user_id
	 * @param integer $func_id
	 */
	public static function addPurview($user_id, $func_id) {
		$params = array(
			'user_id' => $user_id,
			'func_id' => $func_id		
		);
        $db = static::getDb();
		$db->createCommand()->insert('user_purview', $params)->execute();
        return $db->getLastInsertID();
	}
    /**
     * 
     * @param type $columns
     * @param type $rows
     * @return type
     */
    public static function batchAddPurview($columns,$rows){
        $db = static::getDb();
		$ret = $db->createCommand()->batchInsert('user_purview', $columns,$rows)->execute();
        return $ret;
    }
	
	
	/**
	 * 
	 * @param integer $user_id
	 */
	public static function getByUid($user_id) {
        $condition = array('user_id'=>$user_id);
		return static::find()->where($condition)->asArray(true)->all();
	}
	
	/**
	 * 
	 * @param integer $user_id
	 */
	public static function delByUid($user_id) {
        $condition = array('user_id'=>$user_id);
		return static::getDb()->createCommand()->delete('user_purview', $condition)->execute();
	}

}
