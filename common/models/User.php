<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\funcs\Func;
use backend\models\roles\Role_Purview;
use backend\models\users\User_Purview;
use backend\models\users\User_Role_Relate;

/**
 * User model
 *
 * @property integer $id
 * @property string $login_name
 * @property string $email
 * @property string $real_name
 * @property string $phone
 * @property integer $user_group_id
 * @property integer $status
 * @property string $auth_key
 * @property string $password write-only password
 * @property integer $created_time
 * @property integer $updated_time
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DIE = 2;

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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED,self::STATUS_DIE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['login_name' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $password_valid_str = $password.$this->getAuthKey();
        return md5($password_valid_str) === $this->password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $password_valid_str = $password.$this->getAuthKey();
        $this->password = md5($password_valid_str);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = time();
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
                $curr_time = time();
                $this->created_time =$curr_time;
                $this->updated_time =$curr_time;
            }
            return true;
        }
        return false;
    }
    /**
     * 
     * @return string
     */
    public function getDisplayName(){
        return sprintf('%s,%s',$this->real_name,'高级管理员');
    }
    
    public function getMyFunc(){
        $user_id = $this->getId();
        $myFunc = array();
		//获取角色权限
		
        $func_ids = [];
        $myRoles = User_Role_Relate::getByUid($user_id);
		if(!empty($myRoles)) {
			foreach ($myRoles as $role) {
				$rolePurviews = Role_Purview::getByRoleId($role['role_id']);
				foreach ($rolePurviews as $rolePurview) {
                    $func_ids[] =$rolePurview['func_id'];
				}
			}
		}
		//获取用户权限
		$userPurviews = User_Purview::getByUid($user_id);
		if(!empty($userPurviews)){
			foreach ($userPurviews as $purview) {
                $func_ids[] =$purview['func_id'];
			}
		}
        $condition = ['id'=>$func_ids];
        $myFunc = Func::search($condition,0,0,array('id'=>SORT_ASC),false,'id');
		return $myFunc['list'];
    }


    
}
