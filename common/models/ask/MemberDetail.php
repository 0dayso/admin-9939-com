<?php

namespace common\models\ask;

use librarys\models\BaseModel;

class MemberDetail extends BaseModel {

    public static function tableName() {
        return 'member_detail_1';
    }

    public static function getDb() {
        return \Yii::$app->db_v2sns;
    }

    public function add_one($info) {
        $db = static::getDb();
        $res = $db->createCommand()->insert(self::tableName(), $info)->execute();
        return $res;
    }

}
