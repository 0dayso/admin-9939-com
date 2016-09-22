<?php

namespace backend\models\roles;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class Role_Purview extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role_purview}}';
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
	 * 设置角色权限
	 * @param integer $role_id
	 * @param integer $purview_id
	 */
	public static function addPurview($role_id, $purview_id) {
		$params = array(
			'role_id' => $role_id,
			'func_id' => $purview_id		
		);
        $db = static::getDb();
		return $db->createCommand()->insert('role_purview', $params)->execute();
	}
    
     /**
     * 
     * @param type $columns
     * @param type $rows
     * @return type
     */
    public static function batchAddPurview($columns,$rows){
        $db = static::getDb();
		$ret = $db->createCommand()->batchInsert('role_purview', $columns,$rows)->execute();
        return $ret;
    }
	
	/**
	 * 
	 * @param integer $role_id
	 */
	public static function getByRoleId($role_id) {
        $condition = array('role_id'=>$role_id);
        return static::find()->where($condition)->asArray(true)->all();
	}
	
	/**
	 * 删除
	 * @param integer $roleId
	 */
	public static function delByRoleId($roleId) {
        $condition = array('role_id'=>$roleId);
        $db = static::getDb();
        return $db->createCommand()->delete('role_purview', $condition)->execute();
	}

}
