<?php

namespace backend\models\users;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class User_Role_Relate extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_role_relate}}';
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
	 * @param integer $role_id
	 * @param integer $user_id
	 */
	public static function addRelate($role_id, $user_id) {
		$params = array(
			'role_id' => $role_id,
			'user_id' => $user_id		
		);
		$db = static::getDb();
		$db->createCommand()->insert('user_role_relate', $params)->execute();
        return $db->getLastInsertID();
	}
	
	/**
	 * 删除
	 * @param integer $user_id
	 */
	public static function delByUid($user_id) {
        $condition = array('user_id'=>$user_id);
		return static::getDb()->createCommand()->delete('user_role_relate', $condition)->execute();
	}
	
	/**
	 * 
	 * @param integer $user_id
	 */
	public static function getByUid($user_id,$index_by='role_id') {
		$condition = array(
				'user_id' => $user_id
		);
        return static::find()->where($condition)->indexBy($index_by)->asArray(true)->all();
	}
    
    /**
	 * 
	 * @param integer $user_id
	 */
	public static function getByRoleid($role_id) {
		$condition = array(
				'role_id' => $role_id
		);
        return static::find()->where($condition)->asArray(true)->all();
	}

}
