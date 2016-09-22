<?php

namespace backend\modules\system\controllers;


use yii\helpers\Url;
use yii\helpers\Json;
use librarys\controllers\backend\BackController;
use backend\models\funcs\Func;

class FuncController extends BackController
{
	public function init(){
        parent::init();
        $this->setLayout('//bootstrapmaster');
	}

	public function actionIndex(){
		$funcList = Func::getByParentId(0);
		foreach($funcList as $k => $func) {
			$funcList[$k]['child'] = Func::getByParentId($func['id']);
		}
        $params = array('funcList'=>$funcList);
        return $this->render('index',$params);
	}
	
	/**
	 * 添加功能
	 */
	public function actionAdd() {
		$funcList = Func::getByParentId(0);
        $params = array('funcList'=>$funcList);
        return $this->render('add',$params);
	}
	
	/**
	 * 编辑
	 */
	public function actionEdit() {
		$id = $this->helpGparam('id');
		$funcInfo = Func::getById($id);
		$funcList = Func::getByParentId(0);
        $params = array('funcList'=>$funcList,'funcInfo'=>$funcInfo);
        return $this->render('edit',$params);
		
	}
	
	/**
	 * 保存
	 */
	public function actionSave() {
        $postdata = $this->helpGpost('func');
        extract($postdata);
		if(empty($caption)) {
			$this->helpJsRedirect('功能名称不能为空');
		}
        $parent_id = $parent_id==-1?0:$parent_id;
//        if(empty($moduleid)){
//           $this->helpJsRedirect('模块ID不能为空'); 
//        }
//        if(empty($controlid)){
//           $this->helpJsRedirect('控制器ID不能为空'); 
//        }
		if(intval($id) > 0) {
			//编辑保存
			$ret = Func::updateFunc($id, $caption,$moduleid,$controllerid,$url, $parent_id, $show_style, $remark, $order_by, $status);
		} else {
			//新建保存
			$ret = Func::addFunc($caption, $moduleid,$controllerid,$url, $parent_id, $show_style, $remark, $order_by, $status);
		}
        if((intval($ret)>=0)){
            $url = Url::toRoute('func/');
			$this->helpRefresh($url);
        }else{
            $this->helpJsRedirect('操作失败');
        }
	}
	
	public function actionDel(){
		$id = $this->helpGparam('id');
		$ret = Func::deleteFuncById($id);
        if($ret>0){
            echo Json::encode ( array (
                    'code' => 200,
                    'message' => '权限项已删除',
                    'data'=>$ret
            ) );
        }else{
            echo Json::encode ( array (
                    'code' => 500,
                    'message' => '权限项删除失败',
                    'data'=>$ret
            ) );
        }
	}
}
