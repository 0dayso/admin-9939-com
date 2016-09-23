<?php

namespace common\models\im;

use Yii;
use librarys\models\BaseModel;

/**
 * 相关资讯
 */

class Articles extends BaseModel{
    

    public static function tableName(){
        return 'article';
    }
    
    public static function getDb(){
        return Yii::$app->db_v2;
    }
    
    /**
     * 根据分类id，获取相关资讯
     * @param type $catid 咨询分类id
     * @param type $offset
     * @param type $size
     * @return type
     */
    public static function getList($catid='',$offset,$size){
        $where = '';
        if(!empty($catid)){
            $where = ' and catid = '.$catid;
        }
        $list=array();
        $sql ="select articleid,catid,title,description,inputtime from article where status =20 $where order by articleid desc limit $offset,$size";
        $list = static::getDb()->createCommand($sql)->queryAll();
        foreach($list as $k=>$val){
            //查询当前分类名称
            $sql ="select catname from category where catid = ".$val['catid'];
            $catgory = static::getDb()->createCommand($sql)->queryOne();
            $list[$k]['category'] = $catgory['catname'];
            //查询当前咨询图片
            $sql = "select thumb from article_position where articleid = ".$val['articleid'];
            $position = static::getDb()->createCommand($sql)->queryOne();
            if(empty($position)){
                $position['thumb'] = '/patients/styles/images/inf.jpg';
            }
            $list[$k]['thumb'] = $position['thumb'];
        }
        return $list;
    }
    
    /**
     * 获取文章页所有的一级栏目
     * @return type
     */
    public static function getCategory(){
        $sql ="select catid,catname from category where catid in(9456,1979,1976,11470,1836,2094,1947,2711,11152) ";
        return static::getDb()->createCommand($sql)->queryAll();
    }
    
    /**
     * 根据当前articleid获取详细信息
     * @param type $id
     * @return type
     */
    public static function getArtInfo($id){
        $sql = "select a.articleid,a.catid,a.title,a.inputtime,d.copyfrom,d.content from article a,article_detail d where a.articleid = d.articleid and a.articleid=$id and a.`status`=20";
        return static::getDb()->createCommand($sql)->queryOne();
    }
    
    public static function getRelatedContent($catid,$offset,$size){
        $sql="select articleid,title from article where catid = $catid and `status`=20 ORDER BY articleid desc limit $offset,$size";
        return static::getDb()->createCommand($sql)->queryAll();
    }
}
