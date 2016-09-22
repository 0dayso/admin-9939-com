<?php

namespace backend\models\roles;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class Roles extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%roles}}';
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
	 * 添加角色
	 * @param string $role_name
	 * @param integer $user_group_id
	 * @param string $remark
	 */
	public static function addRole($role_name, $user_group_id, $remark="") {
		$params = array(
			'role_name' => $role_name,
			'user_group_id' => $user_group_id,
			'remark' => $remark	
		);
        $db =static::getDb(); 
		$db->createCommand()->insert('roles', $params)->execute();
        return $db->getLastInsertID();
	}
	
	/**
	 * 获取角色
	 * @param integer $user_group_id
	 */
	public static function getByUsergroupId($user_group_id) {
		$params = array(
			'user_group_id' => $user_group_id		
		);
        return static::findAll($params);
	}
	
	public static function getById($roleId) {
		$params = array(
				'id' => $roleId
		);
        return static::findOne($params);
	}
	
	/**
	 * 更新角色
	 * @param integer $id
	 * @param string $role_name
	 * @param integer $user_group_id
	 * @param string $remark
	 */
	public static function updateRole($id, $role_name, $user_group_id, $remark="") {
		$params = array(
				'role_name' => $role_name,
				'user_group_id' => $user_group_id,
				'remark' => $remark
		);
        $condition = ['id' => $id];
		return static::getDb()->createCommand()->update('roles', $params,$condition)->execute();
	}

}
