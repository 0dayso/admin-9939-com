<?php

namespace common\models;

use librarys\models\BaseModel;
use yii\db\Query;
use common\models\disease\Article;

class Symptom extends BaseModel {

    public static function tableName() {
        return '{{%symptom}}';
    }

    public static function getDb() {
        return \Yii::$app->db_jbv2;
    }

    public function rules() {
        return [
            [['id', 'status', 'userid', 'createtime', 'updatetime', 'capital_sn'], 'integer'],
            [['name', 'keywords', 'thumbnail', 'description', 'username', 'pinyin', 'pinyin_initial', 'capital', 'source_pinyin'], 'safe'],
            [['name'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => '症状id',
            'status' => '',
            'userid' => '',
            'thumbnail' => '缩略图',
            'createtime' => '',
            'updatetime' => '',
            'name' => '症状名称',
            'keywords' => '关键词',
            'description' => '',
            'pinyin' => '',
            'pinyin_initial' => '',
            'capital' => '',
        ];
    }

/*       function beforeSave() {
        $this['userid'] = 8888;
        $this->username = 'lc';
        $this->createtime = time();
        $this->updatetime = time();
        return true;
    } */

    /**
     * 根据部位id 集，得到症状集
     * @author gaoqing
     * @date 2016-04-08
     * @param array $partid 部位id
     * @param string $part_level the part level
     * @return array 症状集
     */
    public function getSymptomsByPartid($partid, $part_level, $offset = 0, $size = 8){
        $symptoms = array();

        $db = \Yii::$app->db_jbv2;
        $sql = " SELECT dsm.id, dsm.name, dsm.pinyin, dsm.pinyin_initial ";
        $sql .= " FROM `9939_part_rel_merge` prm, `9939_disease_symptom_merge` dsm";
        $sql .= " WHERE prm.unique_key = dsm.unique_key AND prm.source_flag = 2 AND prm.${part_level} = ${partid} LIMIT ${offset}, ${size}";
        $symptoms = $db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);

        return $symptoms;
    }

    /**
     * 根据症状名称获取症状信息
     * @author gaoqing
     * @date 2016-03-24
     * @param array $symptomNames 症状名称
     * @return array 症状信息
     */
    public function getSymptomsByName($symptomNames){
        if (!isset($symptomNames) || empty($symptomNames)){
            return [];
        }
        return $this->getSymptom(['name' => $symptomNames]);
    }
    
    /**
     * 根据疾病id, 查询其相关症状信息
     * @author gaoqing
     * 2016年1月19日
     * @param int $diseaseid 疾病id 
     * @return array 症状信息
     */
    public function getSymptomsByDisid($diseaseid) {
    	$diseaseSymptom = [];
    	
    	$connection = $this->getDb();
    	$sql = "  SELECT sm.id, sm.name ,sm.pinyin_initial, sm.description FROM 9939_disease_symptom_rel dsr, 9939_symptom sm WHERE dsr.symptomid = sm.id ";
    	$where = " AND dsr.diseaseid = :diseaseid ";
    	$diseaseSymptom = $connection->createCommand($sql . $where, [":diseaseid" => $diseaseid])->queryAll(\PDO::FETCH_ASSOC);
    	
    	return $diseaseSymptom;
    }
    
    /**
     * 根据部位信息，查询相关症状
     * @author gaoqing
     * 2016年1月19日
     * @param array $queryConditions 查询条件（指定部位）
     * @param int $start 分页的开始值
     * @param int $size 每页显示的条数
     * @return array 症状集
     */
    public function getSymptomsByPart($queryConditions, $start, $size) {
    	$symptomArr = [];
    	 
    	if (isset($queryConditions) && !empty($queryConditions)) {
            $query = $this->pakingQueryByPart($queryConditions);
    		$query->offset($start)->limit($size);
    		$symptomArr = $query->createCommand()->queryAll(\PDO::FETCH_ASSOC);
    	}
    	return $symptomArr;
    }

    /**
     * 得到相关症状的总数
     * @author gaoqing
     * 2016年1月19日
     * @param array $queryConditions 查询条件（指定部位）
     * @return array 症状集
     */
    public function getSymByPartCount($queryConditions) {
    	$count = 0;

    	if (isset($queryConditions) && !empty($queryConditions)) {
            $query = $this->pakingQueryByPart($queryConditions);
            $count = $query->count();
    	}
    	return $count;
    }

    /**
     * 获取所有疾病症状
     * $orderby是数据排序条件
     * @return type array
     */
    public function getSymptom($where = [], $orderBy='id DESC') {
        return Symptom::find()
                        ->where($where)
                        ->orderBy($orderBy)
                        ->asArray()
                        ->all();
    }
    

    public function getSymptomByCondition($where = [], $whereLike = [], $limit=10, $offset=0, $orderBy='id DESC') {
        $query = new Query(); 
        $relateTable = '{{%symptom_part_rel}}';
//        print_r($where);
//        exit;
        
        $res = $query
                ->select("{$this->tableName()}.*,{$relateTable}.part_level1,{$relateTable}.part_level2")
                ->from($this->tableName())
                ->where($where)
                ->andWhere($whereLike)
                ->leftJoin($relateTable, "{$this->tableName()}.id = {$relateTable}.symptomid")
                ->limit($limit)
                ->offset($offset)
                ->orderBy($orderBy)
                ->all(static::getDb());
                
//                ->count();
//        $q = clone $res;
//        print_r($q->createCommand()->getRawSql());
//        exit;
        return $res;
    }
    
    
    
    public function getRecords($where = [], $whereLike = [], $limit=10, $offset=0, $orderBy='id DESC') {
        $query = new Query(); 
        $relateTable = '{{%symptom_part_rel}}';
//        print_r($where);
//        exit;
        
        $res = $query
                ->select("{$this->tableName()}.*,{$relateTable}.part_level1,{$relateTable}.part_level2")
                ->from($this->tableName())
                ->where($where)
                ->andWhere($whereLike)
                ->leftJoin($relateTable, "{$this->tableName()}.id = {$relateTable}.symptomid")
                ->count('*',static::getDb());
        return $res;
    }
    
    /**
     * 通过SymptomContent的id（前）与Symptom的id（后）关联起来
     * controller里使用的时候需要先查询find()->one() 或者find()->all()
     * @return type
     */
    public function getContent() {
        return $this->hasOne(SymptomContent::className(), ['id' => 'id']);
    }
    
    /**
     * 根据id获取某条疾病症状内容
     * 包括字表content里的内容
     * 通过hasOne来关联查询
     * @return type array
     */
    public function getOneSymptom($id = NULL) {
        return Symptom::find()
                        ->where('id=:id', ['id' => $id])
                        ->one();
    }

    /**
     * 添加症状
     */
    public function addSymptom($data) {
        $this->isNewRecord = true;//新纪录标记
        $this->attributes = $data;
//        return true;
        if ($this->validate($this->attributes) && $this->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改症状
     */
    public function editSymptom($data) {
        $model = self::findOne($data['id']);
        $model->attributes = $data;
        if ($model->validate($model->attributes) && $model->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 根据id删除症状信息，包括字表
     * 返回多表删除结果的数组
     * 根据数组判断删除操作结果是否成功
     * @param type $id
     * @return type array
     */
    public function deleteSymptom($id = NULL) {
        $flag[] = Symptom::deleteAll('id = :id', ['id' => $id]);
        $flag[] = SymptomContent::deleteAll('id = :id', ['id' => $id]);
        $num = count($flag);//当前删除记录操作的总个数
        $n = 0;
        foreach($flag as $v){//循环出所有的值，值分为0 1 ，成功是1，失败是0
            $n = $v + $n;
        }
        if($n < $num){//如果结果小于总个数，说明有失败
            return false;
        }
        return true;
        
        
    }

    /**
     *根据部分信息，封装症状的查询条件
     * @author gaoqing
     * 2016-02-18
     * @param array $queryConditions 查询条件（指定部位）
     * @return Query 封装条件后的查询对象
     */
    private function pakingQueryByPart($queryConditions)
    {
        $query = new Query();
        $query->select("sm.id, sm.name")->from("9939_symptom sm");

        if (isset($queryConditions['symptomName']) && !empty($queryConditions['symptomName'])) {
            $query->andWhere(['LIKE', "sm.name", $queryConditions['symptomName']]);
        }
        $hasSubQuery = false;
        $subQuery = new Query();
        if (isset($queryConditions['part_level1']) && !empty($queryConditions['part_level1'])) {
            $subQuery->select("spr.symptomid")->from("9939_symptom_part_rel spr");
            $subQuery->andWhere(["spr.part_level1" => $queryConditions['part_level1']]);
            $hasSubQuery = true;
        }
        if (isset($queryConditions['part_level2']) && !empty($queryConditions['part_level2'])) {
            if (!isset($queryConditions['part_level1'])) {
                $subQuery->select("spr.symptomid")->from("9939_symptom_part_rel spr");
            }
            $subQuery->andWhere(["spr.part_level2" => $queryConditions['part_level2']]);
            $hasSubQuery = true;
        }
        if($hasSubQuery){
            $query->andWhere(["in", "sm.id", $subQuery]);
        }
        return $query;
    }
    
    public static function List_ByIds($symids = array()) {
        if (count($symids) == 0) {
            return false;
        }
        $ids = implode(',', $symids);
        $sql = "select * from 9939_symptom where id in ($ids) order by field(id,$ids)";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAllSymptom() {
        $sql = "select id,name,keywords,pinyin_initial from 9939_symptom";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    /**
     * 获取所有疾病症状条数
     * @return type array
     */
    public function getCount() {
        return Symptom::find()
                        ->count();
    }
    
    public function getSymptomLimit($where = [], $offset = 0, $length = 10, $orderBy = 'id DESC') {
        return Symptom::find()
                        ->where($where)
                        ->orderBy($orderBy)
                        ->offset($offset)
                        ->limit($length)
                        ->asArray()
                        ->all();
    }
    /**
     * 症状id 获取症状信息
     * @param type $symid
     * @param type $content false 不获取content部分
     * @return type
     */
    public static function getSymptomByid($symid, $content = false) {
        if ($content) {
            $sql = 'SELECT s.* ,c.* FROM 9939_symptom s LEFT JOIN 9939_symptom_content c  ON s.id=c.id WHERE s.id = :id';
        } else {
            $sql = 'select * from 9939_symptom where id = :id';
        }
        $result = static::getDb()->createCommand($sql)->bindValue(':id', $symid)->queryOne(\PDO::FETCH_ASSOC);
        return $result;
    }
}
