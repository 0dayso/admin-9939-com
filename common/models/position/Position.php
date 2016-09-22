<?php
/**
 * @version 0.0.0.1
 */

namespace common\models\position;


use librarys\models\BaseModel;
use yii\db\Query;

class Position extends BaseModel
{

    public static function tableName(){
        return '{{%ads_pos}}';
    }

    public static function getDb(){
        return \Yii::$app->db_jbv2;
    }

    public function init(){
        parent::init();

    }

    public static function queryDatas($tableName, $conditions, $offset, $size, $orderby, $isGetTotal = false){
        $query = new Query();
        $query->select('*')->from($tableName);
        if (!empty($conditions)){
            foreach ($conditions as $name => $value){
                if (is_array($value)){
                    $query->andWhere($value);
                }else{
                    $query->andWhere([$name => $value]);
                }
            }
        }
        $total = 0;
        if ($isGetTotal){
            $total = $query->count('*');
        }
        $query->offset($offset)->limit($size)->orderBy($orderby);
        $list = $query->all();
        return ['list' => $list, 'total' => $total];
    }

    public function deletePosition($condition){
        $connection = self::getDb();
        return $connection->createCommand()->delete('9939_ads_pos', $condition)->execute();
    }

    public function updatePosition($condition, $values){
        $connection = self::getDb();
        return $connection->createCommand()->update('9939_ads_pos', $values, $condition)->execute();
    }

    public function getPosition($condition){
        return Position::find()->where($condition)->asArray()->one();
    }

    public function getPositions($condition, $offset, $size, $orderby, $isGetCount = true){
        return self::queryDatas(self::tableName(), $condition, $offset, $size, $orderby, $isGetCount);
    }

    public function insertPosition($values){
        $connection = self::getDb();
        return $connection->createCommand()->insert('9939_ads_pos', $values)->execute();
    }

}