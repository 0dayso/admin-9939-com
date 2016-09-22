<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 相关资讯
 */

class AdsPos extends BaseModel{
    

    public static function tableName(){
        return '{{%ads_pos}}';
    }
    
    public static function getDb(){
        return Yii::$app->db_jbv2;
    }
    
    public static function adsList($orderBy='a.id desc',$office=0,$size=10){
        $sql ="select * from 9939_ads_pos a ,archive_position_relate p where a.id = p.position_id order by $orderBy limit $office,$size";
        return self::getDb()->createCommand($sql)->queryAll();
    }
}
