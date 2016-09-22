<?php
namespace librarys\controllers\frontend;

use librarys\controllers\BaseController;
use librarys\helpers\utils\Utils;

/**
 * 只有jb.9939.com的前台用这个controller
 * Site controller
 */
class FrontController extends BaseController
{
    public function init(){
        $this->mobile_redirect();
        parent::init();
        $this->initVariables();
    }
    
    public function initVariables(){
        $this->setLayout();
    }
    
    /**
     * 
     */
    private function mobile_redirect() {
        header('Cache-Control:max-age=3600');
//        header('Cache-Control:no-cache,no-store,max-age=0,must-revalidate');
//        header("Pragma: no-cache"); 
        $flag = Utils::ismobile();
        if ($flag === true) {
            $uri = $this->getRequestURIPath();
            if(stripos($uri,'.shtml')===false){
                $uri=str_replace('//', '/', $uri.'/');
            }
            $redirect_url =  sprintf('%s%s',\Yii::getAlias('@mjb_domain'),$uri);
            header("Location:$redirect_url", true, 302);
            exit;
        }
        $this->fillSuffix();
    }
    
    private function fillSuffix(){
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
