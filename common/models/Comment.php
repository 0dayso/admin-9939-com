<?php
/**
 * @version 0.0.0.1
 */

namespace common\models;


use librarys\models\BaseModel;

class Comment extends BaseModel
{
    public static function tableName(){
        return '9939_comment';
    }

    public function updateComm($values, $condition){
        $connection = self::getDb();
        return $connection->createCommand()->update(self::tableName(), $values, $condition)->execute();
    }

    public function getComment($conditions){
        return Comment::find()->asArray()->where($conditions)->one();
    }

    public static function getDb(){
        return \Yii::$app->db_jbv2;
    }

    public function insertComm($values){
        $connection = self::getDb();
        return $connection->createCommand()->insert(self::tableName(), $values)->execute();
    }

    public function getComments($condition, $offset, $size, $orderby){
        return self::search($condition, $offset, $size, $orderby, true);
    }

}