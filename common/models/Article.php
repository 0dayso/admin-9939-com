<?php
/**
 * @version 0.0.0.1
 */

namespace common\models;

use librarys\models\BaseModel;
use yii\db\mssql\PDO;

/**
 * 资讯文章
 * @author gaoqing
 */
class Article extends BaseModel
{
    public static function getDb()
    {
        return \Yii::$app->db_v2;
    }

    public static function tableName()
    {
        return 'article';
    }

    //============================ 2015-12-11: 新增 【热搜】、【专题】部分 Start ==========================//
    public function List_ArticleByIds($articleids=array()){
        if(count($articleids)==0){
            return false;
        }
        $ids = implode(',', $articleids);
        $sql = "select articleid as id,title,url,description,inputtime from article where articleid in ($ids) order by articleid desc";
        $result = self::getDb()->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function List_Articles($where = '1', $order = '', $count = '', $offset = '') {
        $sql = 'SELECT a.* FROM article a Left JOIN article_detail ad on a.articleid=ad.articleid where ' . $where ;
        $sql .= ' order by ' . $order;
        if(!empty($count)){
            $sql.= " limit ".$offset.",".$count;
        }
        $db = self::getDb();
        $result = $db->createCommand($sql)->queryAll(PDO::FETCH_ASSOC);
        return $result;
    }


}