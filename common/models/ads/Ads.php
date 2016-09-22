<?php

namespace common\models\ads;

use librarys\models\BaseModel;

class Ads extends BaseModel {
    
    const PCDOMAIN = 'http://www.9939.com/'; //uploadfile/
    
    public static function getDb() {
        return \Yii::$app->db_v2;
    }

    public static function tableName() {
        return 'ads';
    }

    public function ads($id = 0, $num = 1, $ofset = 0, $class_name = '') {
        $data = $this->ads_content($id, $num);
        $arr_method_ref = array(
            '1' => 'default_ads_text',
            '2' => 'default_ads_pic',
            '3' => 'default_ads_ref',
            '4' => 'default_ads_flash'
        );
        $arr_ret = array();
        foreach ($data as $k => $v) {
            $type = $v['type'];
            $ret = $this->{$arr_method_ref[$type]}($v);
            array_push($arr_ret, $ret);
        }
        if (count($arr_ret) > 0) {
            return implode('', $arr_ret);
        }
        return '';
    }

    //默认的文字链广告
    //广告类型type为1
    private function default_ads_text($ads) {
        extract($ads);
        $ret = '';
        $ret.='<a href="' . $linkurl . '" target="_blank" title ="' . $adsname . '">';
        $ret.= $adsname;
        $ret.='</a>';
        return $ret;
    }

    /*
     * 默认的图片广告
     * 广告类型type为2
     */

    private function default_ads_pic($ads) {
        extract($ads);
        $ret = '';
        $ret.='<a href="' . $linkurl . '" target="_blank">';
        $ret.='    <img src="' . $imageurl . '" alt="' . $adsname . '" title="' . $adsname . '"/>';
        $ret.='</a>';
        return $ret;
    }

    /*
     * 默认的外部调用广告
     * 广告类型type为3
     */

    private function default_ads_ref($ads) {
        extract($ads);
        return $text;
    }

    /*
     * 默认的flash广告
     * 广告类型type为3
     */

    private function default_ads_flash($ads) {
        return '';
    }

    // 获取 广告内容
    public function ads_content($id = 0, $num = 1) {
        return $this->getAdsList($id, $num);
    }
    
    //获取处理后的的ads
    public function getAdsHandle($placeid, $item) {
        $res = $this->getAdsList($placeid, $item);
        foreach ($res as $k => $v) {
            $res[$k]['imageurl'] = self::PCDOMAIN . 'uploadfile/' . $res[$k]['imageurl'];
        }
        return $res;
    }
    
    //获取原生的ads
    public function getAdsList($placeid, $item) {
        
        $limit = "  ";
        if (isset($item) && !empty($item)) {
            $limit .= " LIMIT 0,{$item}";
        }
        $sql = "select adsid,adsname,introduce,placeid,width,height,type,linkurl,imageurl,text,sortid from ads where placeid='{$placeid}' order by adsid desc " . $limit;
        
        $return_ad_list = static::getDb()->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        foreach ($return_ad_list as &$val) {
            $val['text'] = str_replace(array('\"', "\'"), array('"', "'"), $val['text']);
        }
        return $return_ad_list;
    }

}
