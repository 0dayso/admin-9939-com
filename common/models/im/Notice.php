<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 相关资讯
 */

class Notice extends BaseModel{
    

    public static function tableName(){
        return '{{%notice}}';
    }
    
    public static function getDb(){
        return Yii::$app->db_jbv2;
    }
    
    /**
     * 获取公告列表
     * @param type $client
     * @param type $orderBy
     * @param type $offise
     * @param type $size
     * @return type
     */
    public static function getList($client=0,$orderBy='id desc',$offise=0,$size=10){
        $sql = "select id,client,description,content,createtime from 9939_notice where client =$client and status = 1 order by $orderBy limit $offise,$size";
        return static::getDb()->createCommand($sql)->queryAll();
    }
    
    /**
     * 获取公告详情
     * @param type $noticeid
     * @return type
     */
    public static function noticeDetail($noticeid=0){
        $sql = "select * from 9939_notice where id = $noticeid";
        return static::getDb()->createCommand($sql)->queryOne();
    }
}
