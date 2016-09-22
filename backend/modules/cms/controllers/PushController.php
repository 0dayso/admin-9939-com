<?php

namespace backend\modules\cms\controllers;

use librarys\controllers\backend\BackController;
use librarys\helpers\plugin\Paging;
use common\models\Push;

/**
 * 资讯推送
 */
class PushController extends BackController
{
    private $push;
    
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
        $this->push = new Push();
        $paging = $this->helpPaging('pagerjs_3')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $pushList = $this->push->search($where, $offset, $size, array('id' => SORT_DESC), true); //查询结果
        $paging->setTotal($pushList['total'])->setCurrent($page);
        $num = $this->push->getNum($where); //统计公告条数
        $page = ($size <= ($num / $page)) ? $size : ($num / $page);
        $model['pushlist'] = $pushList['list'];
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
        $this->push = new Push;
        if(!empty($id)){
           $id = $this->push->pushDel($id);
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
            $this->push = new Push;
            $param['client'] = $request->post('client');
            $param['body'] = $request->post('body');
            $param['url'] = $request->post('url');
            $param['pushtime'] = strtotime($request->post('pushtime'));
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $param['createtime'] = time();
            if(!$this->push->getPushOne(['body'=>$param['body']])){
                if($this->push->add($param)){
                    $this->helpGo('/cms/push/index');
                }else{
                    $this->helpGo('/cms/push/add','添加失败，返回重试');
                }
            }else{
                $this->helpGo('/cms/push/add','标题已经存在,返回重试');
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
        $this->push = new Push;
        $request = \Yii::$app->request;
        if($request->isPost){
            $id = $request->post('id');
            $param['client'] = $request->post('client');
            $param['body'] = $request->post('body');
            $param['url'] = $request->post('url');
            $param['pushtime'] = strtotime($request->post('pushtime'));
            $param['updatetime'] = time();
            $id = $this->push->pushUpdate($param,$id);
            if($id){
                $this->helpGo('/cms/push/index');
            }else{
                $this->helpGo('/cms/push/index','修改失败,返回重试');
            }
        }else{
            $id = $request->get('nid');
            $data = $this->push->getPushOne(['id'=>$id]);
            if($data){
                return $this->render('edit',[
                'data' => $data,
            ]);
            }else{
                 $this->helpGo('/cms/push/index','数据不存在,返回重试');
            }
        }
    }

}
