<?php
namespace librarys\controllers\wapjb;

use librarys\controllers\BaseController;

/**
 * Site controller
 */
class WapController extends BaseController
{
    public function init(){
        $this->fillSuffix();
        parent::init();
        $this->initVariables();
    }
    
    public function initVariables(){
        $this->setLayout();
    }
    
    private function fillSuffix(){
        header('Cache-Control:max-age=3600');
        $uristr = $_SERVER['REQUEST_URI'];
        $str_params ='';
        if ($pos = strpos($uristr, '?')) {
            $str_params=substr($uristr, $pos);
            $uristr = substr($uristr, 0, $pos);
        }
        if(($last_char =  substr($uristr, -1) )!='/' && (stripos($uristr,'.shtml')===false)){
            $redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$uristr.'/';
            $redirect_url.= $str_params;
            header("Location:$redirect_url", true, 301);
            exit;
        }
    }
    
}
