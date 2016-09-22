<?php

namespace common\models\disease;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;
use yii\db\Query;

class Article extends BaseModel {
    use ArticlelinkTrait;
    private $query;

    public static function tableName() {
        return '{{%disease_article}}';
    }

    public static function getDB() {
        return \Yii::$app->db_jbv2;
    }

    public function init() {
        parent::init();
        $this->query = new Query();
    }

    public function getLatestArticle($count = '5', $offset = '0') {
        $sql = "select title,url, id, inputtime from 9939_disease_article where status=99 order by id desc limit " . $offset . "," . $count;
        $db = self::getDB();
        $result = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    /**
     * 获取最新的与疾病关联的文章
     */
    public function getLatestDiseaseArticle($offset = 0, $length = 10) {
//        $sql = 'SELECT
//                r.articleid,r.diseaseid,a.title,a.inputtime,d.`name`,d.pinyin_initial
//                FROM
//                9939_article_disease_rel r
//                LEFT JOIN 9939_disease d ON r.diseaseid = d.id
//                LEFT JOIN 9939_disease_article a ON r.articleid = a.id
//                ORDER BY
//                r.articleid DESC
//                LIMIT '.$offset.','.$length;
        
        $sql = "select 
                a.id as articleid,a.diseaseid,a.title,a.inputtime,b.name,b.pinyin_initial 
                from 9939_disease_article a 
                inner join 9939_disease b on a.diseaseid=b.id 
                where a.status=99 order by a.id desc 
                limit $offset,$length";
        $db = self::getDB();
        $result = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function List_DiseaseArticleByIds($articleids = array()) {
        if (count($articleids) == 0) {
            return false;
        }
        $ids = implode(',', $articleids);
        $sql = "select id,title,url,description,inputtime from 9939_disease_article where id in ($ids) order by id desc";
        $result = self::getDB()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 根据条件查询文章列表
     * @param type $condition 查询条件数组
     * @param type $orderBy 排序
     * @return type
     */
    public function listByCondition($condition = [], $limit = 10, $offset = 0, $orderBy = 'id DESC') {
        $res = $this->query->select("{$this->tableName()}.*");
        $res = $res->from($this->tableName());
        foreach ($condition as $v) {
            $res = $res->andWhere($v);
        }
        $res = $res->limit($limit);
        $res = $res->offset($offset);
        $res = $res->orderBy($orderBy);
//        
//        $commandQuery = clone $res;
//        print_r($commandQuery->createCommand()->getRawSql());
//        exit;

        $res = $res->all(self::getDb());

        return $res;
    }
    
    
    public function getRecords($condition = []) {
        $res = $this->query->select("{$this->tableName()}.id");
        $res = $res->from($this->tableName());
        foreach ($condition as $v) {
            $res = $res->andWhere($v);
        }
        $res = $res->count('id', static::getDb());
        return $res;
    }
    
    
    /**
     * 
     * @param type $dis_str
     * @param type $limit
     * @param type $offset
     * @param type $orderBy
     * @return type
     */
    public function listBySqlCondition($dis_str = '', $limit = 10, $offset = 0, $orderBy = 'id desc') {
        $orderBy = ltrim($orderBy);
        $orderBy = strtolower($orderBy);
        $sql = 'SELECT dis_article.id FROM 9939_disease_article dis_article INNER JOIN (SELECT distinct articleid FROM 9939_article_disease_rel WHERE diseaseid IN(' . $dis_str . ')) dis_article_rel ON dis_article.id=dis_article_rel.articleid ORDER BY '.$orderBy.' LIMIT '.$offset.','.$limit.'';
        if(stripos('id', $orderBy)===0){
            $sql = 'SELECT dis_article.id FROM 9939_disease_article dis_article INNER JOIN (SELECT distinct articleid FROM 9939_article_disease_rel WHERE diseaseid IN(' . $dis_str . ') order by articleid desc) dis_article_rel ON dis_article.id=dis_article_rel.articleid LIMIT '.$offset.','.$limit.'';
        }
        
        $sql_format = 'select * from 9939_disease_article cc inner join (%s) c on cc.id = c.id;';
        $sql = sprintf($sql_format,$sql);
        $result = self::getDB()->createCommand($sql)->queryAll();
        return $result;
    }
    
    public function getRecordsBySql($dis_str = '') {
        $sql = 'SELECT count(1) as num FROM 9939_disease_article dis_article INNER JOIN (SELECT distinct articleid FROM 9939_article_disease_rel WHERE diseaseid IN(' . $dis_str . ')) dis_article_rel ON dis_article.id=dis_article_rel.articleid';
        $result = self::getDB()->createCommand($sql)->queryAll();
        return $result;
    }


    /**
     * 
     * @param type $condition 
     *       [
     *           'diseaseid'=>1,
     *           'type'=>[$type1,$type2...],//[''],['0'],或不传时均为：所有分类
     *           ...
     *       ]
     * @param type $offset
     * @param type $limit
     * @param type $orderBy
     * @return type
     */
    public function getListByDiseaseid($condition = [], $offset = 0, $limit = 10, $orderBy = 'id DESC') {
       
        if(!isset($condition['diseaseid'])){
            return array();
        }
        $strsql = $this->build_big_query_string($condition, $offset, $limit, $orderBy);
        $ret = self::getDB()->createCommand($strsql)->queryAll();
        return $ret;
    }
    
    private function build_big_query_string($condition = [], $offset = 0, $limit = 10, $orderBy = 'id DESC'){
        $tmp_diseaseid = $condition['diseaseid'];
        
        $strsql = '';
        if($offset>=0){
            $strsql =" SELECT  art.id
                FROM 9939_disease_article art
                INNER JOIN 9939_article_disease_rel rel ON art.id = rel.articleid and rel.diseaseid='$tmp_diseaseid' 
                WHERE art.status =99 ";
        }else{
            $strsql =" SELECT  *
                FROM 9939_disease_article art
                INNER JOIN 9939_article_disease_rel rel ON art.id = rel.articleid and rel.diseaseid='$tmp_diseaseid' 
                WHERE art.status =99 ";
        }

        if(isset($condition['type']) && !empty($condition['type'])){
            if(count($condition['type'])>1){
                $typeids = implode(',', $condition['type']);
                $strsql.=" and art.type in ($typeids) ";
            }else{
                $typeids = $condition['type'][0];
                if(!empty($typeids)){
                    $strsql.=" and art.type='$typeids' ";
                }
            }
        }
        $strsql.=" ORDER BY art.id DESC limit $offset,$limit ";
        
        if($offset>=0){
           $sql_format = 'select * from 9939_disease_article cc inner join (%s) c on cc.id = c.id;';
           $strsql = sprintf($sql_format,$strsql);
        }
        
        return $strsql;
    }

    
    /**
     * 疾病下文章的条数
     * @param array $condition  同 getListByDiseaseid()
     * @return array
     */
    public function getCountByDiseaseid($condition = []) {
        if(!isset($condition['diseaseid'])){
           return 0;
        }
        $tmp_diseaseid = $condition['diseaseid'];
        $strsql =" SELECT  count(1)
                FROM 9939_disease_article art
                INNER JOIN 9939_article_disease_rel rel ON art.id = rel.articleid and rel.diseaseid='$tmp_diseaseid' 
                WHERE art.status =99 ";
       
        if(isset($condition['type']) && !empty($condition['type'])){
            if(count($condition['type'])>1){
                $typeids = implode(',', $condition['type']);
                $strsql.=" and art.type in ($typeids) ";
            }else{
                $typeids = $condition['type'][0];
                if(!empty($typeids)){
                    $strsql.=" and art.type='$typeids' ";
                }
            }
        }
        
        $ret = self::getDB()->createCommand($strsql)->queryScalar();
        return $ret;
    }
    
    /**
     * 每个疾病获取一条数据
     * @param type $dis_str
     * @return string
     */
    public function getListByGroup($dis_str) {
        $sql = "select  r.diseaseid,a.title,a.inputtime,a.id from 9939_disease_article a 
            inner join (
                select diseaseid,max(articleid) max_articleid from 9939_article_disease_rel where diseaseid in ($dis_str) group by diseaseid
            ) r on r.max_articleid=a.id 
            order by a.id desc;";
        $result = self::getDB()->createCommand($sql)->queryAll();
        return $result;
    }

    

    /**
     * 添加文章
     * @param type $data
     * @return type false|true
     */
    public function addArticle($data = []) {
        $q = $this->query->createCommand(self::getDB());
        $q = $q->insert($this->tableName(), $data);
        $q = $q->execute();
        if ($q) {
            return self::getDB()->getLastInsertID();
        } else {
            return $q;
        }
    }

    /**
     * 删除文章，单条多条均可
     * @param type $condtion
     * @return type
     */
    public function delArticle($condtion) {
        $result = Article::deleteAll($condtion);
        return $result;
    }

    /**
     * 设置文章字段属性值
     * @param type $attribute
     * @param type $condtion
     * @return type
     */
    public function editArticle($attribute, $condtion) {
        $result = Article::updateAll($attribute, $condtion);
        return $result;
    }

    /**
     * 获取单条文章信息
     * @param type $articleid
     * @return type
     */
    public function getSimpleArticle($articleid) {
        //文章信息
        $artcile['info'] = $this->query
                ->select('id,title,keywords,description,content,status,username,copyfrom,fjc,url,type,author')
                ->from(self::tableName())
                ->where(['id' => [$articleid]])
                ->one(static::getDb());

        //文章所属疾病信息
        $diseaseRelArticle = '9939_article_disease_rel';
        $disease = '9939_disease';
        $condition = ['articleid' => [$articleid]];
        $artcile['disease'] = $this->query
                ->select("{$diseaseRelArticle}.diseaseid,{$diseaseRelArticle}.articleid,{$disease}.id,{$disease}.name")
                ->from("{$diseaseRelArticle}")
                ->leftJoin($disease, "{$disease}.id = {$diseaseRelArticle}.diseaseid")
                ->where($condition)
                ->all(static::getDb());

        return $artcile;
    }

    public function getAllArticle() {
        $sql = "SELECT id,title,keywords,url from 9939_disease_article";
        $result = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}
