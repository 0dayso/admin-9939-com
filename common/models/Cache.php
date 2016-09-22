<?php
namespace common\models;

use librarys\models\BaseModel;
class Cache extends BaseModel{
    public static function getDb()
    {
        return \Yii::$app->db_jbv2;
    }

    public static function tableName()
    {
        return '{{%cache}}';
    }
    
    /**
     * 获取缓存名称列表
     * @return type 
     */
    public static function getCacheList($offset = 0, $length = 10) {
        $connection = self::getDb();
        $res = $connection->createCommand("select * from 9939_cache  order by id asc limit {$offset} , {$length}")->queryAll();
        return $res;
    }

    /**
     * 获取单条缓存
     * @return type 
     */
    public static function getCacheById($id = '') {
        if (!empty($id)) {
            $connection = self::getDb();
            $res = $connection->createCommand('select * from 9939_cache where id = :id')->bindValues([':id' => $id])->queryOne();
            return $res;
        }
        return;
    }
    
    /**
     * 获取单条缓存
     * @return type 
     */
    public static function getCacheByKey($key_prefix = '') {
        if (!empty($key_prefix)) {
            $connection = self::getDb();
            $res = $connection->createCommand('select * from 9939_cache where key_prefix = :key_prefix')->bindValues([':key_prefix' => $key_prefix])->queryOne();
            return $res;
        }
        return;
    }

    /**
     * 添加缓存
     * @param type $param
     * @return type 
     */
    public static function add($param=[]) {
        $connection = self::getDb();
        $res = $connection->createCommand()->insert('9939_cache', $param)->execute();
        return $res;
    }
    
    /**
     * 编辑缓存
     * @param type $param
     */
    public static function edit($id, $param = []) {
        $connection = self::getDb();
        $res = $connection->createCommand()->update('9939_cache', $param, 'id = :id', [':id' => $id])->execute();
        return $res;
    }
    /**
     * 删除缓存
     * @param type $param
     */
    public static function del($id) {
        $connection = self::getDb();
        $res = $connection->createCommand()->delete('9939_cache', 'id = :id', [':id' => $id])->execute();
        return $res;
    }

}
