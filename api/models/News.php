<?php
namespace api\models;
use api\models\Common;
use common\models\im\AdsPos;
use common\models\im\Notice;
use common\models\im\Articles;
class News extends Common {
    
    public static function index(){
        //获取未读公告数量
        
        //获取未读推荐数量
    }

    public static function getNoticeList($params=0){
        $client = intval($params['client']) ? $params['client'] : '1' ;
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
    
    /**
     * 资讯列表页api接口
     * @return type
     */
    public static function getArticleList($array =array()){
        $catid = $_REQUEST['catid'] ? $_REQUEST['catid'] : 0;
        //查询所有的一级栏目
        $category = array(
            
            '0' => Array(
                        'catid' => '1836',
                        'catname' => '美容'
                    ),
            '1' => Array(
                        'catid' => '1947',
                        'catname' => '心理'
                    ),
            '2' => Array(
                        'catid' => '1976',
                        'catname' => '两性'
                    ),
            '3' => Array(
                        'catid' => '1979',
                        'catname' => '母婴'
                    ),
            '4' => Array(
                        'catid' => '2094',
                        'catname' => '减肥'
                    ),
            '5' => Array(
                        'catid' => '2711',
                        'catname' => '保健'
                    ),
            '6' => Array(
                        'catid' => '9456',
                        'catname' => '新闻'
                    ),
            '7' => Array(
                        'catid' => '11152',
                        'catname' => '疾病'
                    ),
            '8' => Array(
                        'catid' => '11470',
                        'catname' => '女性'
                    )
        );
        $article_list1 = Articles::getList($catid,0,4); //咨询文章
        $article_list2 = Articles::getList($catid,4,4);

        $data = array('article_list1' => $article_list1,'article_list2' => $article_list2,'article_category'=>$category);
        return self::result(200, '成功', $data);
    }
    
    public static function getArticleDetail(){
        $id = $_REQUEST['id'];
        if(!empty($id)){
            //详细内容
            $ret = Articles::getArtInfo($id);
            if(!$ret){
                return self::result(500, '失败', 'null');exit;
            }
            //获取相关文章
            $correlation = Articles::getRelatedContent($ret['catid'],0,6);
            $data = array(
                'detail'=>$ret,
                'related'=>$correlation,
            );
            return self::result(200, '成功', $data);
        }else{
            return self::result(500, '失败', 'null');
        }
    }
}
