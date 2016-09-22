<?php
namespace common\models\ask;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

class Keywords extends BaseModel{
    private static $tableName = 'wd_keywords';
    
    public static function tableName() {
        return self::$tableName;
    }

    public static function getDB() {
        return \Yii::$app->db_v2sns;
    }
    

    public function add($params) {
        $time = time();
        $params['inputtime'] = $time;
        $params['updatetime'] = $time;
        $params['beizhu'] = '';
        $params = array_intersect_key($params , $this->attributes);
        $connetion = $this->getDB();
        $res = $connetion
                ->createCommand()
                ->insert('wd_keywords', $params)
                ->execute();
        $id = $connetion->getLastInsertID();
        $res = $connetion->createCommand()->update('wd_keywords', ['pinyin_initial' => $params['pinyin_initial'] . $id], 'id = ' . $id)->execute();
        return $res ? true : false;
    }

    public function edit($id,$params) {
        $update = [];
        foreach ($params as $k => $v) {
            $update[$k] = $v;
        }
        $update['updatetime'] = time();
        $connetion = $this->getDB();
        $res = $connetion
                ->createCommand()
                ->update('wd_keywords', $update, 'id = '.$id)
                ->execute();
        return $res ? true : false;
    }
    
    public function getSearch($param = [], $offset = 0, $length = 10) {
        $where = '';
        $bound = [];
        foreach ($param as $k => $v) {
            if (!empty($v)) {
                $where .= ' and ' . $k . ' = "' . $v . '"';
            }
        }
        $where = substr($where, 5);
        $where = (!empty($where)) ? ' where ' . $where : '';
        $sql = 'select k.id,k.name,k.pinyin_initial,k.disease_id,d.name as diseasename from wd_keywords as k left join wd_disease d on k.disease_id=d.id ' . $where . ' limit ' . $offset . ',' . $length;
        return $this->getDB()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
    }

    /**
     * 按条件记录条数
     */
    public function getSearchCount($param = []) {
        $where = '';
        $bound = [];
        foreach ($param as $k => $v) {
            if (!empty($v)) {
                $where .= ' and ' . $k . ' = "' . $v.'"';
            }
        }
        $where = substr($where, 5);
        $where = (!empty($where)) ? ' where '.$where : '';

        $sql = 'select count(k.id) as count from wd_keywords as k left join wd_disease d on k.disease_id=d.id ' . $where;
        $res = $this->getDB()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $res ? $res['0']['count'] : false;
    }

}
