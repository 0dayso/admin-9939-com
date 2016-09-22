<?php

namespace backend\modules\cms\controllers;

use librarys\controllers\backend\BackController;
use librarys\helpers\plugin\Paging;
use common\models\Order;

/**
 * 订单管理
 */
class OrderController extends BackController
{
    private $order;
    
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
        $tradeid = intval($request->get('tradeid'));
        $paytradeno= $request->get('paytradeno');
        $paystatus = $request->get('paystatus');
        $shipstatus = $request->get('shipstatus');
        $phone = $request->get('phone');
        if(!empty($tradeid)){
            $where['tradeid'] = ['tradeid'=>$tradeid];
        }
        if(!empty($paytradeno)){
            $where['paytradeno'] = array('paytradeno'=>$paytradeno);
        }
        if($paystatus!=''){
            $where['paystatus'] = array('paystatus'=>$paystatus);
        }
        if($shipstatus!=''){
            $where['shipstatus'] = array('shipstatus'=>$shipstatus);
        }
        if(!empty($phone)){
            $where['phone'] = array('phone'=>$phone);
        }
        
        $size = 10;
        $this->order = new Order();
        $paging = $this->helpPaging('pagerjs_3')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $pushList = $this->order->search($where, $offset, $size, array('id' => SORT_DESC), true); //查询结果
        $paging->setTotal($pushList['total'])->setCurrent($page);
        $num = $this->order->getNum($where); //统计公告条数
        $page = ($size <= ($num / $page)) ? $size : ($num / $page);
        $model['pushlist'] = $pushList['list'];
        $model['paging'] = $paging;
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
        $this->order = new Order;
        if(!empty($id)){
           $id = $this->order->orderDel($id);
           return $id;
        }
    }
    
    /**
     * 订单详情
     * @return type
     */
    public function actionOrderDetail(){
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $this->order = new Order;
        if(!empty($id)){
           $detail = $this->order->orderDetail($id);
           $msg['content'] = $this->renderPartial('order_detail',[
                'detail' => $detail,
            ]);
           return json_encode($msg);
        }
        
    }
    
    /**
     * 修改订单状态
     * @return type
     */
    public function actionOrderQueren(){
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $remark = $this->helpGparam('remark');
        if(!empty($id)){
            $data = array(
                'shipstatus'=>1,
                'remark'=>$remark
            );
            $this->order = new Order;
            $id = $this->order->orderQueren($data,$id);
            return $id;
        }
    }
    
    /**
     * 修改订单号信息
     * @return type
     */
    public function actionOrderEdit(){
        $request = \Yii::$app->request;
        if($request->isPost){
            $id = $request->post('id');
            $express_company = $request->post('express_company');
            $express_number = $request->post('express_number');
            $data = array(
                'express_company'=>$express_company,
                'express_number'=>$express_number,
                'shipstatus'=>2,
            );
            $this->order = new Order;
            $id = $this->order->orderQueren($data,$id);
            if($id){
                $this->helpGo('/cms/order/index');
            }else{
                $this->helpGo('/cms/order/index','修改失败,返回重试');
            }
        }else{
           $id = $request->get('id');
           return $this->render('order_express',[
                'id' => $id,  
            ]);
        }
    }
}
