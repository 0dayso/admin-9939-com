<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */
class Users extends BaseModel {

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'im_users';
    }

    public static function getDb() {
        return Yii::$app->db_service;
    }

    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_CLOSE],
            ['status', 'in', 'range' => [self::STATUS_OPEN, self::STATUS_CLOSE]],
        ];
    }

    /**
     * 
     * @param int $uid
     * @param string $username
     * @param string $nickname
     * @param int $utype
     * @param string $avatar
     * @param int $status
     * @param array $extend_info 扩展信息
     * @return type
     */
    public static function addUsers($uid, $username, $nickname, $utype, $avatar, $status,$extend_info  = array()) {
        $createtime = time();
        $params = array(
            'uid' => $uid,
            'username' => $username,
            'nickname' => $nickname,
            'utype' => $utype,
            'avatar' => $avatar,
            'status' => $status,
            'createtime' => $createtime,
            'updatetime' => $createtime
        );
        $params = array_merge($params,$extend_info);
        $db = static::getDb();
        $db->createCommand()->insert(self::tableName(), $params)->execute();
        return $db->getLastInsertID();
    }

    
    /**
     * 
     * @param int $id
     * @param array $params
     * $params = array(
            'username' => $username,
            'nickname' => $nickname,
            'utype' => $utype,
            'avatar' => $avatar,
            'accid' => $accid,
            'token' => $token,
            'status' => $status,
            'updatetime' => time()
      );
     * @return type
     */
    public static function updateUsers($uid, $params = array()) {
        if (count($params) > 0) {
            $condition = ['uid' => $uid];
            $curr_time = time();
            $params['updatetime'] = $curr_time;
            return static::getDb()->createCommand()->update(self::tableName(), $params, $condition)->execute();
        }
        return false;
    }

    /**
     * 通过ID获取数据
     * @param integer $id
     */
    public static function getById($id) {
        return static::findOne(['uid' => $id]);
    }

    /**
     * 根据用户名获取用户信息
     * @param type $username
     * @return type
     */
    public static function getUserByName($username) {
        return static::findOne(['username' => $username]);
    }

}
