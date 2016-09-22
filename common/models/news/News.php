<?php
namespace common\models\news;

use librarys\models\BaseModel;
use yii\db\Query;

class News extends BaseModel {
    private $query;

    public static function getDB() {
        return \Yii::$app->db_v2;
    }

    public function init() {
        parent::init();
        $this->query = new Query();
    }
    
    public function getTopArticle($limit){
        $res = $this->query->select("articleid,title,url,updatetime");
        $res = $res->from('article');
        $res = $res->where(['status'=> 20]);//20表示已经生成了
        $res = $res->offset(0);
        $res = $res->limit($limit);
        $res = $res->orderBy('articleid DESC ');
        
        $commandQuery = clone $res;
        $result = $commandQuery->createCommand(self::getDB())->queryAll();
        return $result;
    }

}
