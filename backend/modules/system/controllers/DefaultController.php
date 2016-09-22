<?php

namespace backend\modules\system\controllers;

use Yii;
use librarys\controllers\backend\BackController;

class DefaultController extends BackController
{
    public function init(){
        parent::init();
        $this->setLayout('//bootstrapmaster');
	}
    public function actionIndex()
    {
//        $path  = \Yii::getAlias('@backend/modules');
//        $arr_file = array();
//        if(is_dir($path)){
//            $this->scan($path,$arr_file);
//        }
//        foreach($arr_file as $k=>$v){
//            $file_abs_path  = str_replace($path, '', $v);
//            $file_abs_path = str_replace('/', '\\', $file_abs_path);
//            $file_abs_path = str_replace('.php', '', $file_abs_path);
//            $file_abs_path = '\\backend\modules'.$file_abs_path;
//            $class_methods = get_class_methods($file_abs_path);
//            foreach($class_methods as $kk=>$vv){
//                if(stripos($vv, 'action')===0){
//                    echo $vv.'<br />';
//                }
//            }
//            $path_parts = pathinfo($v);
//        }
        return $this->render('index');
    }
    private function scan($path,&$ret_file_list = array()) {
        $arr_path = scandir($path);
        foreach ($arr_path as $v) {
            if (!in_array($v, array(".", ".."))) {
                $r_real_path = realpath($path . '/' . $v);
                if(is_dir($r_real_path)){
                    $this->scan($r_real_path,$ret_file_list);
                }else if (is_file($r_real_path)&& stripos($v, 'controller')!==false) {
                    $ret_file_list[] = $r_real_path;
                }
            }
        }
    }
}
