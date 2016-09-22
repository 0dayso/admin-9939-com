<?php
namespace librarys\controllers\api;

use librarys\controllers\BaseController;

/**
 * 只有jb.9939.com的前台用这个controller
 * Site controller
 */
class ApiController extends BaseController
{
    
    protected $api_key;
	
	protected $class_name;
	
	protected $function;
    
    public function init(){
        parent::init();
        $this->initVariables();
    }
    
    public function initVariables(){
        $this->disableLayout();
        $this->api_key = trim($this->helpGparam('api_key'));//用于验证是否有效的数据请求
		$method = trim($this->helpGparam('method'));
		$method_arr = explode('.', $method);
		if (count($method_arr) !== 2) {
			$this->helpJsonResult(500, ' Error\'s Method Value. ');
            exit;
		}
		list($model_name, $this->function) = $method_arr;
		$this->class_name = '\api\models'.'\\'.ucfirst($model_name);
		if (class_exists($this->class_name) === false || method_exists($this->class_name, $this->function) === false) {
			$this->helpJsonResult(500, ' Error\'s Api Method.');
            exit;
		}
    }
    
    /**
     * 当同步接口访问的时候,添加用户验证逻辑
     * @param type $action
     * @return boolean
     */
    public function beforeAction($action) {
        parent::beforeAction($action);
        //如果是授权请求,返回true;否则false
        $this->hasAuthorize();
        return true;
    }
    
    private function hasAuthorize(){
        return true;
    }
    /**
     * 当访问结束时，清除回话信息
     * @param type $action
     * @param type $result
     * @return type
     */
//    public function afterAction($action, $result) {
//        $this->clearAuthorize();
//        //清除回话信息
//        $result = parent::afterAction($action, $result);
//        return $result;
//    }
    
    private function clearAuthorize(){
        return true;
    }
    
}
