<?php
namespace common\models\doctor;

use librarys\models\BaseModel;
use yii\db\Query;

class Doctor extends BaseModel {
    
    public static function tableName() {
        return 'member_detail_2';
    }

    public static function getDB() {
        return \Yii::$app->db_v2sns;
    }

    public function init() {
        parent::init();
    }
    
    /**
     * 根据科室名称获取医生列表
     * @param type $departmentname
     */
    public function getDoctorByDepartment($departmentname, $offset = 0, $limit = 5) {
        $connection = $this->getDB();
        $sql = "  SELECT doc.uid,doc.truename,doc.doc_keshi,doc.doc_hos,doc.zhicheng,doc.dis,doc.best_dis,doc.description,mem.pic
                 FROM member_detail_2 doc, member mem 
                 WHERE doc.uid = mem.uid ";
        $where = " AND doc_keshi like :departmentname AND doc.truename  != '' ";
        $limit = " limit {$offset},{$limit}";
        $result = $connection->createCommand($sql . $where . $limit, [':departmentname' => $departmentname])->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     * 根据 uid 获取医生的详细信息
     * @param type $uid
     */
    public function getDoctorById($uid = '') {
        $connection = $this->getDB();
        $sql = "  SELECT doc.uid,doc.truename,doc.doc_keshi,doc.doc_hos,doc.zhicheng,doc.dis,doc.best_dis,doc.description,doc.doc_hos,mem.pic,mem.totalanswer,mem.nickname
                 FROM member_detail_2 doc, member mem 
                 WHERE doc.uid = mem.uid ";
        $where = " AND doc.uid in ({$uid}) ";
        $result = $connection->createCommand($sql . $where )->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}
