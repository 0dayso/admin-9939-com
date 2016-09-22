<?php

namespace backend\models\users;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */

class Users extends BaseModel{
    
            
     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
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
	 * 添加用户
	 * @param string $login_name
	 * @param string $password
	 * @param string $real_name
	 * @param string $email
	 * @param integer $user_group_id
	 * @param string $phone
	 */
	public static function addUser($login_name, $password, $real_name, $email, $user_group_id, $phone){
        
        $auth_key =time();
        $password_valid_str = $password.$auth_key;
        $password =  md5($password_valid_str);
        $create_time = $update_time =$auth_key;
		$params = array(
			'login_name' => $login_name,
			'password' => $password,
			'real_name' => $real_name,
			'email' => $email,
			'user_group_id' => $user_group_id,
			'phone' => $phone,
            'create_time'=>$create_time,
            'update_time'=>$update_time,
            'auth_key'=>$auth_key
		);
		$db = static::getDb();
		$db->createCommand()->insert('users', $params)->execute();
        return $db->getLastInsertID();
	}
    
    /**
	 * 
	 * @param integer $id
	 * @param string $caption
	 * @param string $url
	 * @param integer $parent_id
	 * @param integer $show_style
	 * @param string $remark
	 * @param integer $order_by
	 * @param integer $status
	 * @param integer $is_super
	 */
	public static function updateUser($id, $login_name, $real_name, $email, $user_group_id, $phone) {
        $update_time =time();
        $params = array(
			'login_name' => $login_name,
			'real_name' => $real_name,
			'email' => $email,
			'user_group_id' => $user_group_id,
			'phone' => $phone,
            'update_time'=>$update_time
		);
        $condition =['id'=>$id];
        return static::getDb()->createCommand()->update('users',$params,$condition)->execute();
	}
	
	
	/**
	 * 获取用户数量
	 * @param integer $user_group_id
	 */
	public static function getUserCount($user_group_id) {
        $condition = array('user_group_id' => $user_group_id);
        $count = static::find()->where($condition)->count();
        return $count;
	}
	
	/**
	 * 
	 * @param integer $user_group_id
	 * @param integer $offset
	 * @param integer $size
	 */
	public static function getUserList($user_group_id, $offset, $size) {
		$params = array(
			'user_group_id' => $user_group_id
		);
        return static::find()->where($params)->limit($size)->offset($offset)->all();
	}
	
	/**
	 *
	 * @param integer $id
	 */
	public static function getById($id) {
        $condition =  array('id' => $id);
        return static::findOne($condition);
	}
	
	public static function updateUserStatusById( $id,$target_status ) {
		$params = array(
				'status' => $target_status,
                'update_time'=>time()
		);
        
        $condition = ['id' => $id];
		return static::getDb()->createCommand()->update('users', $params,$condition)->execute();
	}
	
	/**
	 *
	 * @param $password
	 * @param $id
	 */
	public static function modPwdById($password,$id){
        $condition = ['id' => $id];
        $userinfo = static::findOne($condition);
        $auth_key =$userinfo->auth_key;
        $password_valid_str = $password.$auth_key;
        $password =  md5($password_valid_str);
		$params = array(
				'password'=>$password,
                'update_time'=>time()
		);
        return static::getDb()->createCommand()->update('users', $params,$condition)->execute();
	}
    
    

}
