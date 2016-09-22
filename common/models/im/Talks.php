<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 部位 model 类
 */
class Talks extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'im_talks';
    }

    public static function getDb() {
        return Yii::$app->db_service;
    }

    public function rules() {
        return [
            ['state', 'default', 'value' => 0],
            ['state', 'in', 'range' => [0, 1, 2]],
        ];
    }

    /**
     * 
     * @param type $subject
     * @param type $sender_uid
     * @param type $sender_name
     * @param array $extend_info 扩展字段
     * @return int
     */
    public static function addTasks($subject, $sender_uid, $sender_name, $extend_info = array()) {
        $createtime = time();
        $params = array(
            'subject' => $subject,
            'sender_uid' => $sender_uid,
            'sender_name' => $sender_name,
            'begintime' => $createtime * 1000,
            'createtime' => $createtime,
            'updatetime' => $createtime
        );
        $params = array_merge($params,$extend_info);
        if (isset($params['team_id'])) {
            $params['flag'] = 2;
        }

        $db = static::getDb();
        $db->createCommand()->insert(self::tableName(), $params)->execute();
        return $db->getLastInsertID();
    }

    /**
     * 
     * @param type $id
     * @param type $params
     * $params = array(
      'receiver_id' => $receiver_id,
      'receiver_name' => $receiver_name,
      'endtime' => $endtime,
      'state'=>$state,
      'last_reply'=>$last_reply
      );
     * @return type
     */
    public static function updateTalks($id, $params = array()) {
        if (count($params) > 0) {
            $condition = ['id' => $id];
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
        return static::findOne(['id' => $id]);
    }

}
