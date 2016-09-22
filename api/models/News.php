<?php
namespace api\models;
use api\models\Common;
use common\models\im\AdsPos;
use common\models\im\Notice;
class News extends Common {
    
    public static function getNoticeList($params=0){
        $client = intval($params['client']) ? $params['client'] : '' ;
        $page = intval($params['page']) ? intval($params['page']) : 1;
        $offise = 10;
        $pager = ($page-1)*$offise;
        $list = Notice::getList($client,'id desc',$pager,$offise);
        if($list){
            $array = array(
                'list'=>$list,
                'page'=>$page
            );
            return self::result(200, '成功', $array);
        }else{
            return self::result(500, '数据不存在', 'null');
        }
    }
    
    public static function noticeDetail(){
        $noticeid = $_REQUEST['id'];
        if($noticeid>0){
            $notice_detail = Notice::noticeDetail($noticeid);
            if($notice_detail){
                return self::result(200, '成功', $notice_detail);
            }else{
                return self::result(500, '数据不存在', 'null');
            }
        }else{
            return self::result(500, '数据错', 'null');
        }
    }
    
    public static function adsPos($params=0){
        $list = AdsPos::adsList();
        if($list){
            return self::result(200, '成功', $list);
        }else{
            return self::result(500, '数据不存在', 'null');
        }
    }
}
