<?php

namespace backend\modules\cms\controllers;

use librarys\controllers\backend\BackController;
use librarys\helpers\plugin\Paging;
use common\models\Notice;

/**
 * 公告管理
 */
class NoticeController extends BackController
{
    private $notice;
    
    /**
     * 首页
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 首页ajax请求
     * @return type
     */
    public function actionIndexAjaxSeach(){
        $request = \Yii::$app->request;
        $page = intval($request->get('page')) ? $request->get('page') : 1;
        $where = array();
        $id = intval($request->get('id'));
        $title = $request->get('title');
        $client = $request->get('client');
        $inputtime = $request->get('inputtime');
        $status = $request->get('status');
        
        if(!empty($status)){
            $where['status'] = ['status'=>$status];
        }
        if(!empty($id)){
            $where['id'] = ['id'=>$id];
        }
        if(!empty($client)){
            if($client =='3'){
                $client=0;
            }
            $where['client'] = array('client'=>$client);
        }
        if(!empty($inputtime)){
            $time = strtotime($inputtime);
            $where['creaetime']= array('>=', 'createtime', $time);
        }
        if(!empty($title)){
            $where['title'] = ['like','title',$title] ;
        }
        
        $size = 10;
        $this->notice = new Notice();
        $paging = $this->helpPaging('pagerjs_3')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $noticeList = $this->notice->search($where, $offset, $size, array('id' => SORT_DESC), true); //查询结果
        $paging->setTotal($noticeList['total'])->setCurrent($page);
        $num = $this->notice->getNum($where); //统计公告条数
        $page = ($size <= ($num / $page)) ? $size : ($num / $page);
        $model['noticelist'] = $noticeList['list'];
        $model['paging'] = $paging;
        if($status=='' || $status=='0'){
            $model['status']='all_result_tbody';
        }else if($status=='1'){
            $model['status']='are_result_tbody';
        }else{
            $model['status']='nre_result_tbody';
        }
        $msg['content'] = $this->renderPartial('index_ajax',[
            'model' => $model,
        ]);
        return json_encode($msg);
    }
    
    /**
     * 根据id，删除数据 ,ajax请求
     * @return type
     */
    public function actionDelete(){
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $this->notice = new Notice;
        if(!empty($id)){
           $id = $this->notice->noticeDel($id);
           return $id;
        }
    }
    
    /**
     * 添加公告信息
     * @return type
     */
    public function actionAdd(){
        $request = \Yii::$app->request;
        if(!empty($request->isPost)){
            $this->notice = new Notice();
            $param['client'] = $request->post('client');
            $param['title'] = $request->post('title');
            $param['description'] = $request->post('description');
            $param['content'] = $request->post('content');
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $param['createtime'] = time();
            if(!$this->notice->getNoticeOne(['title'=>$param['title']])){
                if($this->notice->add($param)){
                    $this->helpGo('/cms/notice/index');
                }else{
                    $this->helpGo('/cms/notice/add','添加失败，返回重试');
                }
            }else{
                $this->helpGo('/cms/notice/add','标题已经存在,返回重试');
            }
        }else{
            return $this->render('add');
        }
    }
    
    /**
     * 修改公告信息
     * @return type
     */
    public function actionEdit(){
        $this->notice = new Notice();
        $request = \Yii::$app->request;
        if($request->isPost){
            $id = $request->post('id');
            $param['client'] = $request->post('client');
            $param['title'] = $request->post('title');
            $param['description'] = $request->post('description');
            $param['content'] = $request->post('content');
            $param['updatetime'] = time();
            $id = $this->notice->noticeUpdate($param,$id);
            if($id){
                $this->helpGo('/cms/notice/index');
            }else{
                $this->helpGo('/cms/notice/index','修改失败,返回重试');
            }
        }else{
            $id = $request->get('nid');
            $data = $this->notice->getNoticeOne(['id'=>$id]);
            if($data){
                return $this->render('edit',[
                'data' => $data,
            ]);
            }else{
                 $this->helpGo('/cms/notice/index','数据不存在,返回重试');
            }
        }
    }

    public function actionScreen(){
        $this->notice = new Notice();
        $request = \Yii::$app->request;
        if($request->isGet){
            $id = $request->get('id');
            $id = $this->notice->screens($id);
            if($id){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
    }
}
