<?php
namespace common\models;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

/**
 * 操作所有关联中间表类
 * 2016-1-20
 * licheng
 */
class Relate extends BaseModel{
    
    private $query;
    private static $_sftablename ='';

    /**
     * 从 【部位疾病】关系数据集中，得到所有的部位 id 集
     * @author gaoqing
     * @date 2016-03-23
     * @param array $partDiseases 【部位疾病】关系数据集
     * @return array 部位 id 集
     */
    private static function getPartIDsFromPDR($partDiseases)
    {
        $partids = [];
        if (isset($partDiseases['list']) && !empty($partDiseases['list'])) {
            foreach ($partDiseases['list'] as $partDisease) {
                if (!in_array($partDisease['partid'], $partids)) {
                    $partids[] = $partDisease['partid'];
                }
            }
        }
        return $partids;
    }

    public static function getDb() {
        return \Yii::$app->db_jbv2;
    }
    
    public static function tableName()
    {
        return self::$_sftablename;
    }

    /**
     * 根据部位id集，查询 9939_symptom_part_rel 数据集
     * @author gaoqing
     * @date 2016-04-08
     * @param array $partids 部位id集
     * @return array 9939_symptom_part_rel表中的数据集
     */
    public static function getSymptomRelPart($partids){
        $symptomRelPart = array();

        self::$_sftablename = '9939_symptom_part_rel';
        self::tableName();
        $condition = ['partid' => $partids];
        $temp = self::search($condition);
        if (isset($temp['list']) && !empty($temp['list'])){
            $symptomRelPart = $temp['list'];
        }
        self::$_sftablename = '';
        return $symptomRelPart;
    }
    
    /**
     * get datas from 9939_disease_department_rel table
     * @param array $departmentids department id array 
     * @return array datas
     */
    public static function getDisRelDeps($departmentids){
    	$disRelDep = array();
    	
    	self::$_sftablename = '9939_disease_department_rel';
    	self::tableName();
    	$condition = ['departmentid' => $departmentids];
    	$temp = self::search($condition);
    	if (isset($temp['list']) && !empty($temp['list'])){
    		$disRelDep = $temp['list'];
    	}
    	self::$_sftablename = '';
    	
    	return $disRelDep;
    }

    /**
     * 根据疾病文章id, 得到疾病文章和疾病的相关信息
     * @author gaoqing
     * @date 2016-04-01
     * @param int $articleid 疾病文章id
     * @return array 疾病文章和疾病的相关信息
     */
    public static function getArtDisRel($articleid){
        $artDisRel = [];

        $condition = ['articleid' => $articleid];
        Relate::$_sftablename = '9939_article_disease_rel';
        $artDisRels = Relate::search($condition, 0, 1);
        if (!empty($artDisRels['list'])){
            $artDisRel = $artDisRels['list'];
        }
        return $artDisRel;
    }

    /**
     * 根据疾病id, 得到其相关文章的文章id集
     * @author gaoqing
     * @date 2016-07-13
     * @param int $diseaseid 疾病id
     * @return array 相关文章的文章id集
     */
    public static function getRelArticlesByDisid($diseaseid,$offset=0,$size=0,$orderby=array()){
        $relArticles = [];

        if (isset($diseaseid) && !empty($diseaseid)){
            self::$_sftablename = '9939_article_disease_rel';
            $relArticles = self::search(['diseaseid' => $diseaseid],$offset,$size,$orderby);
            if (!empty($relArticles['list'])){
                $relArticles = $relArticles['list'];
            }
            self::$_sftablename = '';
        }
        return $relArticles;
    }

    /**
     * 根据疾病id, 获取所属的部位信息
     * @author gaoqing
     * @date 2016-03-23
     * @param int $diseaseid 疾病id
     * @return array 所属的部位信息
     */
    public static function getPartsByDisid($diseaseid){
        $parts = [];

        //得到 9939_part_disease_rel 的 part id
        $partDiseases = [];
        $db = \Yii::$app->db_jbv2;
        $sql = "  SELECT DISTINCT partid FROM 9939_part_disease_rel WHERE diseaseid = '". $diseaseid ."' ORDER BY partid DESC ";
        $partDiseases['list'] = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);

        //根据 part id 得到所有的部位信息
        $partids = self::getPartIDsFromPDR($partDiseases);
        if (!empty($partids)){
            $parts = Part::find()->where(['id' => $partids])->orderBy('id DESC')->asArray()->all();
        }
        self::$_sftablename = "";
        return $parts;
    }
    
    public function init() {
        parent::init();
        $this->query = new Query();
    }
    
    public function addRelDiseaseArticle($arr){
        self::getDb()->createCommand()->insert('9939_category_disease_rel', $arr)->execute();
    }
    
   
    /**
     * 【症状-相关症状关联表】根据当前症状id获取当前症状对应的所有相关症状id及名称
     * @param type $symptomId
     */
    public function getRelateSymptoms($symptomId){
        $primytableName = '9939_symptom';
        $tableName = '9939_symptom_symptom_rel';
//        $sql = "SELECT `symptomid`,`rel_symptomid` FROM {$tableName} WHERE `symptomid`={$symptomId}";
//        $sql = "SELECT `a.symptomid`,`a.rel_symptomid`,`b.title` FROM {$tableName} AS a INNER JOIN {$primytableName} AS b ON `a.symptomid`={$symptomId} and a.rel_symptomid=b.id and b.id in (4,2,1);";
        $sql = "SELECT a.`id`,a.`symptomid`,a.`rel_symptomid`,b.`name`,b.`pinyin_initial` FROM {$tableName} a INNER JOIN {$primytableName} b ON a.`symptomid`={$symptomId} AND a.`rel_symptomid`<>{$symptomId} AND a.`rel_symptomid`=b.`id` ORDER BY a.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
        return $results;
    }
    
    /**
     * 返回【症状-相关症状关联表】中当前症状id对应的总记录数
     * @param type $symptomId
     * @return type
     */
    public function getRelateSymptomsCount($symptomId){
        $tableName = '9939_symptom_symptom_rel';
        $model = self::getDb()->createCommand("SELECT count(symptomid) FROM {$tableName} WHERE `symptomid`={$symptomId}")->queryScalar();
//        exit($model);
        return $model;
    }
    
    
    /**
     * 【症状-相关症状关联表】批量插入当前症状的相关症状
     * @param type $symptomId 当前症状的id 
     * @param type $columns Array 当前表中的字段
     * @param type $datas Array 字段对应的值
     * @return boolean
     */
    public function addRelateSymptom($symptomId, $columns, $datas){
        if($this->deleteRelateSymptom($symptomId)){
            $tableName = '9939_symptom_symptom_rel';
            $model = self::getDb()->createCommand()->batchInsert($tableName, $columns, $datas)->execute();
            return $model;
        }else{
            return false;
        }
    }
    
    /**
     * 删除【症状-相关症状关联表】中所有与当前症状对应的所有相关症状
     * @param type $symptomId 当前症状的id 
     * @return type boolen
     */
    public function deleteRelateSymptom($symptomId){
        $tableName = '9939_symptom_symptom_rel';
        if($this->getRelateSymptomsCount($symptomId) > 0){
            $model = self::getDb()->createCommand()->delete($tableName, "symptomid=".$symptomId)->execute();
            return $model;
        }else{
            return true;
        }
    }
    
    
    /**
     * 【症状-疾病关联表】根据当前症状id获取相关症状id及名称
     * @param type $symptomId 当前症状的id 
     * @return type
     */
    public function getRelateDiseases($symptomId, $getImg=false){
        $tableNameA = '9939_disease_symptom_rel';
        $tableNameB = '9939_disease';
//        $sql = "SELECT `symptomid`,`rel_symptomid` FROM {$tableName} WHERE `symptomid`={$symptomId}";
//        $sql = "SELECT `a.symptomid`,`a.rel_symptomid`,`b.title` FROM {$tableName} AS a INNER JOIN {$primytableName} AS b ON `a.symptomid`={$symptomId} and a.rel_symptomid=b.id and b.id in (4,2,1);";
        $sql = "SELECT a.`id` AS symptomid,a.`symptomid`,a.`diseaseid`,b.`id`,b.`name`,b.`alias`,b.`pinyin_initial`,b.`description` FROM {$tableNameA} AS a INNER JOIN {$tableNameB} AS b ON a.`symptomid`={$symptomId} AND a.`diseaseid`=b.`id` ORDER BY a.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
        foreach($results as $k=>$v){
            $imgCondition = [
                                'flag' => 2,
                                'relid' => $v['diseaseid']
                            ];
            foreach($v as $kk=>$vv){
                $tmp[$k][$kk] = $vv;
            }
            $img = $this->getImage($imgCondition);
            if(isset($img[0])){
                $tmp[$k]['img'] = $img[0];
            }else{
                $tmp[$k]['img'] = [];
            }
        }
        return $results;
    }
    
    /**
     * 【症状-疾病关联表】根据当前症状id获取相关症状id及名称
     * @param type $symptomId 当前症状的id 
     * @return type
     */
    public function batchGetSymptomsByDisid($diseaseId){
        $tableNameA = '9939_disease_symptom_rel';
        $tableNameB = '9939_symptom';
        $query = new Query();
        $query = $query->select("{$tableNameB}.id,{$tableNameB}.name,{$tableNameB}.pinyin_initial,{$tableNameA}.diseaseid,{$tableNameA}.symptomid")
                ->from($tableNameB)
                ->where(['in', 'diseaseid', $diseaseId])
                ->leftJoin($tableNameA, "{$tableNameA}.symptomid = {$tableNameB}.id")
                ->all(self::getDb());
        return $query;
    }
    
    
    /**
     * 返回【症状-疾病关联表】中当前症状id对应的总记录数
     * @param type $symptomId 当前症状的id 
     * @return type
     */
    public function getRelateDiseasesCount($symptomId){
        $tableName = '9939_disease_symptom_rel';
        $model = self::getDb()->createCommand("SELECT count(symptomid) FROM {$tableName} WHERE `symptomid`={$symptomId}")->queryScalar();
//        exit($model);
        return $model;
    }
    
    
    /**
     * 【症状-疾病关联表】批量插入当前症状的相关疾病
     * @param type $symptomId 当前症状的id 
     * @param type $columns Array 当前表中的字段
     * @param type $datas Array 字段对应的值
     * @return boolean
     */
    public function addRelateDisease($symptomId, $columns, $datas){
        if($this->deleteRelateDisease($symptomId)){
            $tableName = '9939_disease_symptom_rel';
            $model = self::getDb()->createCommand()->batchInsert($tableName, $columns, $datas)->execute();
            return $model;
        }else{
            return false;
        }
    }
    
    /**
     * 删除【症状-疾病关联表】中所有与当前症状对应的所有疾病
     * @param type $symptomId 当前症状的id 
     * @return type boolen
     */
    public function deleteRelateDisease($symptomId){
        $tableName = '9939_disease_symptom_rel';
//        echo $this->getRelateDiseasesCount($symptomId);
//        exit;
        if($this->getRelateDiseasesCount($symptomId) > 0){
            $model = self::getDb()->createCommand()->delete($tableName, "symptomid=".$symptomId)->execute();
            return $model;
        }else{
            return true;
        }
    }
    
    public function getRelatePartsCount($symptomId){
        $tableName = '9939_symptom_part_rel';
        $sql = "SELECT count(symptomid) FROM {$tableName} WHERE `symptomid`=:symptomId";
        $where = ['symptomId'=>$symptomId];
        $model = self::getDb()->createCommand($sql, $where)->queryScalar();
//        exit($model);
        return $model;
    }
    
    public function deleteRelatePart($symptomId){
        $tableName = '9939_symptom_part_rel';
//        echo $this->getRelateDiseasesCount($symptomId);
//        exit;
        if($this->getRelatePartsCount($symptomId) > 0){
            $model = self::getDb()->createCommand()->delete($tableName, "symptomid=".$symptomId)->execute();
            return $model;
        }else{
            return true;
        }
    }
    
    public function addRelPart($symptomId, $datas){
        if($this->deleteRelatePart($symptomId)){
            $tableName = '9939_symptom_part_rel';
            $model = self::getDb()->createCommand()->insert($tableName, $datas)->execute();
            return $model;
        }else{
            return false;
        }
    }
    
    
    public function getAllPartArr(){
        $tableName = '9939_part';
        $sql = "SELECT * FROM {$tableName}";
        $results = self::getDb()->createCommand($sql)->queryAll();
        $res = array();
        foreach($results as $arr){
            $res[$arr['id']] = $arr;
        }
//        print_r($res);
//        exit;
        return $res;
    }
    
    
    public function getAllPart($level=1){
        $tableName = '9939_part';
        $sql = "SELECT a.* FROM {$tableName} AS a WHERE `level`=:level ORDER BY a.`id` ASC";
        $where = ['level'=>$level];
        $results = self::getDb()->createCommand($sql, $where)->queryAll();
        return $results;
    }
    
    public function getPartByCondition($condition){
        $tableName = '9939_part';
        $res = $this->query->select("*");
        $res = $res->from($tableName);
        $res = $res->where($condition);
        $res = $res->all(self::getDb());
        return $res;
    }
    
    
    public function getPartById($id = 0) {
        $tableName = '9939_part';
        $where = ($id > 0) ? 'pid = '.$id : '';     
        $sql = "SELECT a.* FROM {$tableName} AS a WHERE {$where} ORDER BY a.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
        return $results;
    }
    
   
    /**
     * 【症状-相关症状关联表】根据当前症状id获取当前症状对应的所有相关症状id及名称
     * @param type $symptomId
     */
    public function getRelatePart($symptomId){
        $tableNameA = '9939_symptom_part_rel';
        $tableNameB = '9939_part';
        $sql = "SELECT b.`id`,a.`symptomid`,a.`partid`,a.`part_level1`,a.`part_level2`,b.`name` FROM {$tableNameA} AS a INNER JOIN {$tableNameB} AS b ON a.`symptomid`={$symptomId} AND b.`id` IN (a.`part_level1`, a.`part_level2`) ORDER BY b.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
//        print_r($results);exit;
        return $results;
    }
    
    public function insertImage($data){
        $tableName = '9939_image';
//        print_r($data);exit;
        if(count($data) > 0){
            $res = $this->delImage($data[0]['relid']);
            $columns = ['name', 'flag', 'weight', 'createtime', 'updatetime', 'relid'];
            $results = self::getDb()->createCommand()->batchInsert($tableName, $columns, $data)->execute();
            return $results;
        }else{
            return false;
        }
    }
    
    public function delImage($symptomId, $flag='2'){
        $tableName = '9939_image';
        $results = self::getDb()->createCommand()->delete($tableName, "relid = :symptomId", [":symptomId" => $symptomId])->execute();
    }
    
    public function getImage($condition){
        $tableName = '9939_image';
        $res = $this->query->select("*");
        $res = $res->from($tableName);
        $res = $res->where($condition);
        $res = $res->all(self::getDb());
        return $res;
    }
    
    /**
     * 根据文章id删除相关疾病
     * @param type $articleid
     * @return boolean
     */
    public function delArticleRelDiseaseById($articleid){
        $tableName = '9939_article_disease_rel';
        $condition = ['articleid' => $articleid];
        $flag = $this->getArticleRelDiseaseByIds($articleid);//根据文章id查找是否有对应的疾病，如果有删除
        if(count($flag) > 0){
            $q = self::getDb()->createCommand();
            $q = $q->delete($tableName, $condition);
            $q = $q->execute();
            return $q;
        }else{
            return true;
        }
    }
    
    /**
     * 根据文章id删除相关图片
     * @param type $articleid
     * @return boolean
     */
    public function delArticleImageById($articleid){
        $tableName = '9939_artile_image';
        $condition = ['articleid' => $articleid];
        $flag = $this->getArticleImage($articleid);//根据文章id查找是否有对应的疾病，如果有删除
        if(count($flag) > 0){
            $q = self::getDb()->createCommand();
            $q = $q->delete($tableName, $condition);
            $q = $q->execute();
            return $q;
        }else{
            return true;
        } 
    }
    
    /**
     * 根据文章id获取文章关联疾病id
     * backend\modules\cms\controllers\ArticleController
     * @param type $articleids
     * @return type
     */
    public function getArticleRelDiseaseByIds($articleids){
        $tableNameA = '9939_disease';
        $tableNameB = '9939_article_disease_rel';
        $sql = "SELECT a.name,b.articleid,b.diseaseid FROM {$tableNameA} AS a,{$tableNameB} AS b WHERE b.`articleid` IN ({$articleids}) AND b.`diseaseid`= a.`id` ORDER BY a.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
//        print_r($results);
//        exit;
        return $results; 
    }
    
    /**
     * 根据条件删除文章对应的疾病
     * backend\modules\cms\controllers\ArticleController
     * @param type $tableName
     * @param type $attribute
     * @param type $dataArr
     * @return boolean
     */
    public function delArticleRelDisease($tableName, $attribute=[], $dataArr=[]){
        $condition = [$attribute['0'] => $dataArr['disease'][0][0]];
        $flag = $this->getArticleRelDiseaseByIds($dataArr['articleid']);//根据文章id查找是否有对应的疾病，如果有删除
        if(count($flag) > 0){
            $q = self::getDb()->createCommand();
            $q = $q->delete($tableName, $condition);
            $q = $q->execute();
            return $q;
        }else{
            return true;
        }
    }
    
    /**
     * 为了确保不重复添加，再添加之前需要先查找出已存在记录然后删除
     * backend\modules\cms\controllers\ArticleController
     * @param type $attribute
     * @param type $dataArr
     * @return type
     */
    public function addArticleRelDisease($attribute=[], $dataArr=[]){
        $tableName = '9939_article_disease_rel';
        $flag = $this->delArticleRelDisease($tableName, $attribute, $dataArr);//根据条件删除对应文章id的疾病
        if($flag){
            $q = self::getDb()->createCommand();
            $q = $q->batchInsert($tableName, $attribute, $dataArr['disease']);
            $q = $q->execute();
            return $q;
        }else{
            return false;
        }
    }
    
    /**
     * 根据文章id获取文章关联图片id
     * backend\modules\cms\controllers\ArticleController
     * @param type $articleids
     * @return type
     */
    public function getArticleImage($articleids){
        $tableNameA = '9939_disease_article';
        $tableNameB = '9939_artile_image';
        $sql = "SELECT a.id as articleid,b.* FROM {$tableNameA} AS a,{$tableNameB} AS b WHERE b.`articleid` IN ({$articleids}) AND b.`articleid`= a.`id` ORDER BY a.`id` ASC";
        $results = self::getDb()->createCommand($sql)->queryAll();
//        print_r(($results));
//        exit;
        return $results; 
    }
    
    /**
     * 根据条件删除文章对应的图片
     * backend\modules\cms\controllers\ArticleController
     * @param type $tableName
     * @param type $attribute
     * @param type $dataArr
     * @return boolean
     */
    public function delArticleImage($tableName, $attribute=[], $dataArr=[]){
        $articleid = $attribute['2'];
        $articleidData = $dataArr['img'][0]['2'];
        $condition = [$articleid => $articleidData];
        $flag = $this->getArticleImage($dataArr['articleid']);//根据文章id查找是否有对应的疾病，如果有删除
        if(count($flag) > 0){
            $q = self::getDb()->createCommand();
            $q = $q->delete($tableName, $condition);
            $q = $q->execute();
            return $q;
        }else{
            return true;
        }
    }
    
    /**
     * 为了确保不重复添加，再添加之前需要先查找出已存在记录然后删除
     * backend\modules\cms\controllers\ArticleController
     * @param type $attribute
     * @param type $dataArr
     * @return type
     */
    public function addArticleImage($attribute=[], $dataArr=[]){
        $tableName = '9939_artile_image';
        $flag = $this->delArticleImage($tableName, $attribute, $dataArr);//根据条件删除对应文章id的疾病
        if($flag){
            $q = self::getDb()->createCommand();
            $q = $q->batchInsert($tableName, $attribute, $dataArr['img']);
            $q = $q->execute();
            return $q;
        }else{
            return false;
        }
    }

    
    
    
    /**
     * 根据条件查询疾病文章列表 可模糊查询 可根据id精确查询
     * 根据疾病名称模糊查询得到疾病文章id
     * @param type $diseaseName 疾病名称 比如：感
     * @return type
     */
    public function getDiseaseByCondition($condition){
        $q = new Query();
        $primaryTable = '{{%disease}}';
        $relTable = '{{%article_disease_rel}}';
        $q = $q->select("{$primaryTable}.id,{$primaryTable}.name,{$relTable}.articleid,{$relTable}.diseaseid");
        $q = $q->from($primaryTable);
        if(is_array($condition)){
            foreach ($condition as $v){
                $q = $q->andWhere($v);
            }
        }else{
            $q = $q->andWhere($condition);
        }
        $q = $q->leftJoin("{$relTable}", "{$primaryTable}.id = {$relTable}.diseaseid");
        $q = $q->all(static::getDb());
        return $q;
    }
    
    
    public function getSymptomByRelCondition($condition, $limit=10, $offset=0, $orderBy='capital ASC'){
        $q = new Query();
        $primaryTable = '{{%symptom}}';
        $relTable = '{{%symptom_part_rel}}';
        $q = $q->select("{$primaryTable}.id,{$primaryTable}.name,{$primaryTable}.pinyin,{$primaryTable}.capital,{$relTable}.partid,{$relTable}.symptomid");
        $q = $q->from($primaryTable);
        if(is_array($condition)){
            foreach ($condition as $v){
                $q = $q->andWhere($v);
            }
        }else{
            $q = $q->andWhere($condition);
        }
        $q = $q->leftJoin("{$relTable}", "{$primaryTable}.id = {$relTable}.symptomid");
        $q = $q->orderBy($orderBy);
//        $q = $q->offset($offset)->limit($limit);
        $q = $q->all(static::getDb());
        return $q;
    }
    
    /**
     * 【症状-部位关联表】根据当前部位id获取当前症状对应的所有相关症状id及名称
     * lc 2016-4-11
     * @param type $partid
     */
    public function getSymptomByPartid($partid, $limit=10, $offset=0, $orderBy='id ASC'){
        $query = new Query();
        $tableNameA = '9939_symptom_part_rel';
        $tableNameB = '9939_symptom';
        $query = $query->select("{$tableNameB}.id,{$tableNameB}.name,{$tableNameB}.pinyin_initial,{$tableNameA}.partid,{$tableNameA}.symptomid");
        $query = $query->from($tableNameB);
        $query = $query->andWhere("{$tableNameA}.partid = :partid",['partid'=>$partid]);
        $query = $query->leftJoin("{$tableNameA}", "{$tableNameB}.id = {$tableNameA}.symptomid");
        $query = $query->offset($offset)->limit($limit);
        $query = $query->orderBy($orderBy);
        $query = $query->all(static::getDb());
        return $query;
    }
    
    /**
     * 【疾病-部位关联表】根据当前部位id获取当前症状对应的所有相关症状id及名称
     * lc 2016-4-11
     * @param type $partid
     */
    public function getDiseaseByPartid($partid, $flag=2, $limit=10, $offset=0, $orderBy='id ASC'){
        $tableNameA = '9939_part';
        $tableNameB = '9939_part_rel_merge';
        $tableNameC = $flag==1 ? '9939_disease' : '9939_symptom';
        
        $query = new Query();
        $query = $query->select(['id','name','level'])->from($tableNameA)->where('id=:id', [':id' => $partid])->one(self::getDb());
        $part_level = 'part_level'.$query['level'];
        $part_id = $query['id'];
        
        
        $query2 = new Query();
        $query2 = $query2->select(['id'])
                ->from($tableNameB)
                ->where("$part_level=:part_level", [':part_level' => $part_id])
                ->andWhere("source_flag=:source_flag", [':source_flag' => $flag])
                ->offset($offset)
                ->limit($limit)
                ->orderBy($orderBy)
                ->all(static::getDb());
        
        $diseaseId = [];
        foreach($query2 as $v){
            $diseaseId[] = $v['id'];
        }
        
        $query3 = new Query();
        $query3 = $query3->select(['id','name','pinyin_initial'])->from($tableNameC)->where(['in', 'id', $diseaseId])->all(static::getDb());
        return $query3;
    }
    
    /**
     * 根据疾病id查找出最新的一条
     * lc@2016-7-8
     * @param type $diseaseid
     * @return type
     */
    public function getOneArticleByDiseaseId($diseaseid){
        $sql = "SELECT a.* FROM 9939_disease_article AS a,9939_article_disease_rel AS b WHERE b.`articleid` = a.`id` AND b.`diseaseid`= {$diseaseid} ORDER BY a.`id` DESC LIMIT 0,1";
        $results = self::getDb()->createCommand($sql)->queryAll();
        return $results;
    }
    
    /**
     * 根据多个疾病id通过GROUP BY方式查出每个疾病对应的最新疾病资讯
     * lc@2016-7-8
     * @param type $diseaseids
     * @return type
     */
    public function getArticlesGroupBy($diseaseids){
        $sql = "select art.*,tmp.diseaseid as tmp_diseaseid from 9939_disease_article art inner join (
                    select diseaseid,max(articleid) as max_articleid from 9939_article_disease_rel 
                    where diseaseid in ({$diseaseids}) group by diseaseid
                ) tmp on art.id=tmp.max_articleid";
        $results = self::getDb()->createCommand($sql)->queryAll();
        return $results;
    }
    
}
