<?php
namespace api\controllers;

use librarys\controllers\api\ApiController;

class IndexController extends ApiController {
    
    public function init()
    {
        parent::init();
    }
    public function actionIndex(){
        header('Access-Control-Allow-Origin:http://h5.9939.com');
        $function = $this->function;
        $method_name = $this->class_name;
        $params = $this->getParams();
        unset($params['method']);
        $ret = $method_name::$function($params);
        $this->helpResult($ret);
    }
}
