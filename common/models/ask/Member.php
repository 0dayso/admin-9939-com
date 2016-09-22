<?php
namespace common\models\ask;
use librarys\models\BaseModel;

class Member extends BaseModel
{
    
    public static function tableName()
    {
        return 'member';
    }
    
    public static function getDb()
    {
        return \Yii::$app->db_v2sns;
    }
    
    /**
     * 添加用户信息
     * @param type $info array
     * @return type
     */
    public static function add_one($info)
    {
        $db = static::getDb();
        $db->createCommand()->insert(self::tableName(), $info)->execute();
        $last_insert_id = $db->getLastInsertID();
        return $last_insert_id;
    }

    /**
     * 查询单条会员记录信息
     * @param type $where
     * @return type
     */
    public function get_one($where)
    {
        $res = self::find()->where($where)->one();
        return $res;
    }
    
    
    /**
    * 验证用户名密码是否正确
    * @param type $username
    * @param type $password
    */
   public function checkLogin($username, $password){
       $condition = [
           'username' => $username
       ];
       $user_pwd = md5($password);
       $res = static::find()->where($condition)->one();
       if(isset($res) && $res->password == $user_pwd){
           return $res->uid;
       }
       return false;
   }

    /**
     * 更新个人信息
     * @param $userid
     * @param array $info
     * @return int
     */
   public static function updateInfo($userid,$info = array()){
       $res = 0;
       if($userid && !empty($info)){
           $connection = static::getDb();
           $res = $connection->createCommand()
               ->update(static::tableName(),$info,'uid = :uid')
               ->bindValue(':uid',$userid)
               ->execute();
       }
       return $res;
   }

}
