<?php
namespace librarys\helpers\utils;

use Yii;
class Url {

    /**
     * 获取关键字的url
     * @param type $keyword
     * @return type
     */
    public static function getkeywordsUrl($keyword){
         $map_url = array(
            '0'=>'http://www.9939.com/zhuanti/',
            '2'=>'http://www.9939.com/zhuanti/',
            '3'=>'http://www.9939.com/zhuanti/',
            '4'=>'http://www.9939.com/zhuanti/',
            '5'=>'http://www.9939.com/zhuanti/',
            '6'=>'http://www.9939.com/zhuanti/',
            '7'=>'http://baby.9939.com/zhuanti/',
            '8'=>'http://www.9939.com/zhuanti/',
            '9'=>'http://www.9939.com/zhuanti/',
            '99'=>'http://jb.9939.com/so/'
        );
        $url = '';
        if(isset($map_url[$keyword['typeid']])){
            $url = sprintf('%s%s/',$map_url[$keyword['typeid']],  str_replace(' ', '', $keyword['pinyin']));
            
        }else{
            $url = sprintf('%s%s/','http://www.9939.com/zhuanti/',  str_replace(' ', '', $keyword['pinyin']));
        }
        return $url;
    }
    
    /**
     * 获取疾病文章的URL
     * @param type $article
     * @return type
     */
    public static function getdisarticleUrl($article){
        $date_path = date('Y/md',$article['inputtime']);
        $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$article['id']);
        $url  = sprintf('%s/%s', Yii::getAlias('@jb_domain'), $article_path);
        return $url;
    }
    
    
    public static function getuploadfileUrl($typeid,$filename){
        $url = $filename;
        switch ($typeid){
            case 1:{ //疾病图片
                    $url = Yii::$app->params['uploadPath']['disease']['file_base_path'].$filename;
                    break;
            }
            case 2:{
                    $url = Yii::$app->params['uploadPath']['symptom']['file_base_path'].$filename;
                    break;
            }
        }
        return $url;
    }

}
