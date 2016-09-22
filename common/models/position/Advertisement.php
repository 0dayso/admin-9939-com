<?php
/**
 * @version 0.0.0.1
 */

namespace common\models\position;


use common\models\Image;
use librarys\models\BaseModel;
use yii\base\Exception;
use yii\db\Query;

class Advertisement extends BaseModel
{

    public static function tableName(){
        return 'archive_position_relate';
    }

    public static function getDb(){
        return \Yii::$app->db_jbv2;
    }

    public function init(){
        parent::init();
    }

    public function getAdi($condition){
        return Image::find()->where($condition)->asArray()->one();
    }

    public function getAdr($condition){
        return Advertisement::find()->where($condition)->asArray()->one();
    }

    public function getStat($condition){
        $stat = ['pv' => 0, 'uv' => 0, 'ip' => 0, 'updatetime_str' => ''];

        $connection = self::getDb();
        $sql = ' SELECT * FROM 9939_ads_stat WHERE TRUE ';
        $where = '';
        if (!empty($condition)){
            foreach ($condition as $key => $value ){
                $where .= ' AND ' . $key . ' = \''. $value .'\' ';
            }
        }
        $value = $connection->createCommand($sql . $where)->queryOne(\PDO::FETCH_ASSOC);
        if (isset($value) && !empty($value)){
            $value['updatetime_str'] = date('Y-m-d', $value['updatetime']);
            $stat = $value;
        }
        return $stat;
    }

    public function getAdc($condition){
        $connection = self::getDb();
        $sql = ' SELECT * FROM 9939_ads_content WHERE TRUE ';
        $where = '';
        if (!empty($condition)){
            foreach ($condition as $key => $value ){
                $where .= ' AND ' . $key . ' = \''. $value .'\' ';
            }
        }
        return $connection->createCommand($sql . $where)->queryOne(\PDO::FETCH_ASSOC);
    }

    public function deleteAd($condition){
        $connection = self::getDb();
        return $connection->createCommand()->delete('archive_position_relate', $condition)->execute();
    }

    public function getAds($conditions, $offset, $size, $orderby){
        $ads = self::queryDatas('archive_position_relate', $conditions, $offset, $size, $orderby, true);

        if (!empty($ads['list'])){
            $category = [1 => '疾病文章', 2=> '资讯文章', 3 => '图片', 4 => '代码'];
            $position = [];
            foreach ($ads['list'] as &$ad){
                $position = Position::find()->asArray()->where(['id' => $ad['position_id']])->one();
                if (!empty($position)){
                    $ad['position_name'] = $position['name'];
                }
                $ad['category_name'] = $category[$ad['category']];
                $ad['createtime_str'] = date('Y-m-d H:i', $ad['createtime']);
            }
        }
        return $ads;
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

    public function updateArt($values, $condition){
        $updateFlag = 0;
        $connection = self::getDb();
        $updateFlag = $connection->createCommand()->update('archive_position_relate', $values['adr'], ['id' => $condition['adr_id']])->execute();
        return $updateFlag;
    }

    public function updateAd($values, $condition){
        $updateFlag = 0;
        if (!empty($values)){

            if (!empty($values['adc'])){
                $connection = self::getDb();
                $transaction = $connection->beginTransaction();
                try{
                    //1、更新广告内容 9939_ads_content
                    $connection->createCommand()->update('9939_ads_content', $values['adc'], ['id' => $condition['adc_id']])->execute();

                    //2、更新广告内容的图片 9939_image
                    if (isset($condition['adi_id']) && isset($values['adi']) && !empty($values['adi'])){
                        $connection->createCommand()->update('9939_image', $values['adi'], ['id' => $condition['adi_id']])->execute();
                    }

                    //3、更新广告位中间表 archive_position_relate
                    if (isset($values['adr']) && !empty($values['adr'])){
                        $connection->createCommand()->update('archive_position_relate', $values['adr'], ['id' => $condition['adr_id']])->execute();
                    }
                    $transaction->commit();
                    $updateFlag = 1;
                }catch (Exception $e){
                    $transaction->rollBack();
                }
            }
        }
        return $updateFlag;
    }

    public function insertArt($values){
        $insertFlag = 0;
        if (!empty($values) && isset($values['adr'])){
            $connection = self::getDb();
            $insertFlag = $connection->createCommand()->insert('archive_position_relate', $values['adr'])->execute();
        }
        return $insertFlag;
    }

    public function insertAd($values){
        $insertFlag = 0;
        if (!empty($values)){

            if (!empty($values['adc'])){
                $connection = self::getDb();
                $transaction = $connection->beginTransaction();
                try{
                    //1、插入广告内容 9939_ads_content
                    $adcCommand = $connection->createCommand()->insert('9939_ads_content', $values['adc']);
                    $adcCommand->execute();
                    $adcid = $adcCommand->db->getLastInsertID();

                    //2、插入广告内容的图片 9939_image
                    if ($adcid > 0 && isset($values['adi']) && !empty($values['adi'])){
                        $connection->createCommand()->insert('9939_image', array_merge($values['adi'], ['relid' => $adcid]))->execute();
                    }

                    //3、插入广告位中间表 archive_position_relate
                    if ($adcid > 0 && isset($values['adr']) && !empty($values['adr'])){
                        $connection->createCommand()->insert('archive_position_relate', array_merge($values['adr'], ['archive_id' => $adcid]))->execute();
                    }
                    $transaction->commit();
                    $insertFlag = 1;
                }catch (Exception $e){
                    $transaction->rollBack();
                }
            }
        }
        return $insertFlag;
    }



}