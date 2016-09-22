<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */
class TalksDetail extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'im_talks_detail';
    }

    public static function getDb() {
        return Yii::$app->db_service;
    }

    /**
     * 
     * @param type $body
     * @param type $flag
     * @param type $uid
     * @param type $username
     * @param type $talks_id
     * @param type $from_flag
     * @param type $extend_params
     * @return type
     */
    public static function addDetail($body, $flag, $uid, $username, $talks_id, $from_flag, $extend_params = array()) {
        $createtime = time();
        $params = array(
            'body' => $body,
            'flag' => $flag,
            'uid' => $uid,
            'username' => $username,
            'talks_id' => $talks_id,
            'from_flag' => $from_flag,
            'createtime' => $createtime
        );
        $params = array_merge($params, $extend_params);
        $db = static::getDb();
        $db->createCommand()->insert(self::tableName(), $params)->execute();
        return $db->getLastInsertID();
    }

    /**
     * 
     * @param type $id
     * @param type $params
     * $params = array(
      'body' => $body,
      'flag' => $flag,
      'accid' => $accid,
      'username'=>$username,
      'talks_id'=>$talks_id,
      'from_flag'=>$from_flag
      );
     * @return type
     */
    public static function updateDetail($id, $params = array()) {
        if (count($params) > 0) {
            $condition = ['id' => $id];
            return static::getDb()->createCommand()->update(self::tableName(), $params, $condition)->execute();
        }
        return false;
    }

    /**
     * 通过ID获取数据
     * @param integer $id
     */
    public static function getById($id) {
        return static::findOne(['id' => $id]);
    }

}
