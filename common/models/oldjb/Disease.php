<?php

namespace common\models\oldjb;

use librarys\models\BaseModel;

class Disease extends BaseModel {

    public static function getDB() {
        return \Yii::$app->db_dzjb;
    }

    public function getDiseaseByContentid($contentid) {
        $connection = $this->getDB();
        $sql = "select * from 9939_dzjb where contentid=:contentid";
        return $connection->createCommand($sql)
                        ->bindValue(":contentid", $contentid)
                        ->queryOne();
    }

}
