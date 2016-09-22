<?php
/**
 * @version 0.0.0.1
 */

namespace common\models\ask;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use common\models\doctor\Doctor;

/**
 * 问答回复
 * @author gaoqing
 */
class Answer extends BaseModel
{
    private static $tableName = 'wd_answer';

    public static function getDb()
    {
        return \Yii::$app->db_v2sns;
    }

    public static function tableName()
    {
        return self::$tableName;
    }
    
    public function getbyaskid($ask_id){
        $ask_id = intval($ask_id);
        $where = ['askid' => $ask_id];
        $order = ' addtime asc';
        $this->settbname($ask_id);
        $tmp_answer_array = $this->getList($where, $order);
        return $tmp_answer_array;
    }
    
    /*
     * lc 2016-4-15
     * $in 是否使用in查询，默认不使用
     * $order 默认无排序
     * $count 默认调出所有
     */
    public function batgetbyaskid($ask_id, $in=0, $order=0, $count=0){
        $doctor = new Doctor();
        $ask_id = intval($ask_id);
        $where = $in?['askid' => $ask_id]:['in', 'askid', $ask_id];
        $order = ' addtime asc';
        $this->settbname($ask_id);
        $tmp_answer_array = $this->getList($where, $order, $count);
//        print_r($tmp_answer_array);
//        exit;
        return [
            'answer' => $tmp_answer_array,
            'doctor' => $doctor->getDoctorById($tmp_answer_array[0]['userid']),
        ];
    }

    public function settbname($ask_id) {
        $ask_id = intval($ask_id);
        $sqltable = 'select * from wd_ask_tablespace where minid <= ' . $ask_id . ' and maxid >= ' . $ask_id;
        $tableinfo = self::getDb()->createCommand($sqltable)->queryOne(PDO::FETCH_ASSOC);
        if ($tableinfo) {
            self::$tableName = $tableinfo['tablename_answer'];
            self::tableName();
        }else {
            self::$tableName = "wd_answer";
            self::tableName();
        }
    }

    public function getList($where = '1', $order = '', $count = '', $offset = '') {
        $result = self::search($where, $offset, $count, $order);
        return $result['list'];
    }
    
    /**
     * 通过医生id获取医生回答及回答的问题
     * @param type $docid
     */
    public function getAskAnswerByDoctorid($docid){
        $sql = 'SELECT ask.id,ask.title as ask,answer.content as answer,answer.addtime
                FROM wd_answer as answer 
                LEFT JOIN wd_ask as ask 
                ON answer.askid=ask.id 
                WHERE answer.userid = '.$docid.' 
                ORDER BY askid DESC
                LIMIT 0,1;';
        $result = self::getDb()->createCommand($sql)->queryAll();
        return $result;
    }
    
    /**
     * 获取医生的最新回答
     */
    public function getLatestByDoctorid($docid, $offset = 0, $size = 1) {
        $sql = "SELECT id,askid,content,addtime 
                FROM wd_answer 
                WHERE userid = {$docid}
                ORDER BY id DESC
                LIMIT {$offset},{$size};";
        $result = self::getDb()->createCommand($sql)->queryAll();
        return $result;
    }

}