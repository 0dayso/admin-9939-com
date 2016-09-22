<?php
namespace librarys\controllers\backend;

use yii\helpers\Url;
use librarys\controllers\BaseController;
use backend\models\funcs\Func;

/**
 * Site controller
 */
class BackController extends BaseController
{
    public $user;
    public $funclist = array();
    public $user_group_id = 1;
    public $login_id;
    public $login_name;
    public function init(){
        parent::init();
        $this->initVariables();
    }
    
    public function initVariables(){
        $this->setLayout();
        $this->initIdentity();
        $this->initFuncsData();
    }
    private function initFuncsData(){
        $funcList = Func::getByParentId(0,array(1),array('order_by'=>SORT_ASC));
        $iconList = $this->loadModuleIcon();
        foreach($funcList as $k => $func) {
            $func_id = $func['id'];
            $funcList[$k]['bigicon']=isset($iconList[$func_id]['big'])?$iconList[$func_id]['big']:'';
            $funcList[$k]['smallicon']=isset($iconList[$func_id]['small'])?$iconList[$func_id]['small']:'';
            $funcList[$k]['child'] = Func::getByParentId($func_id,array(1),array('order_by'=>SORT_ASC));
        }
        $this->funclist = $funcList;
    }
    
    private function initIdentity(){
        $this->user = \Yii::$app->user->identity;
        if(!empty($this->user)) {
           $this->uid = $this->user->id;
           $this->user_group_id = $this->user->user_group_id;
           $this->login_id = $this->user->id;
           $this->login_name = $this->user->login_name;
        }
    }
    
    /**
     * 加载模块的icon
     * @return type
     */
    private function loadModuleIcon(){
        return [
            '1'=>[
                'name'=>'系统管理',
                'big'=>'images/sta_10.png',
                'small'=>'images/wel_10.png'
            ],
            '5'=>[
                'name'=>'基础数据',
                'big'=>'images/sta_01.png',
                'small'=>'images/wel_01.png'
            ],
            '9'=>[
                'name'=>'内容管理',
                'big'=>'images/sta_02.png',
                'small'=>'images/wel_02.png'
            ],
            '10'=>[
                'name'=>'问答管理',
                'big'=>'images/sta_03.png',
                'small'=>'images/wel_03.png'
            ],
            '11'=>[
                'name'=>'统计管理',
                'big'=>'images/sta_04.png',
                'small'=>'images/wel_04.png'
            ],
            '12'=>[
                'name'=>'生成管理',
                'big'=>'images/sta_05.png',
                'small'=>'images/wel_05.png'
            ],
            '13'=>[
                'name'=>'采集管理',
                'big'=>'images/sta_06.png',
                'small'=>'images/wel_06.png'
            ],
            '14'=>[
                'name'=>'会员管理',
                'big'=>'images/sta_07.png',
                'small'=>'images/wel_07.png'
            ],
            '15'=>[
                'name'=>'医圈管理',
                'big'=>'images/sta_08.png',
                'small'=>'images/wel_08.png'
            ],
            '16'=>[
                'name'=>'病案管理',
                'big'=>'images/sta_09.png',
                'small'=>'images/wel_09.png'
            ]
        ];
    }
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        if(!in_array($action->id, ['login', 'error', 'captcha', 'upfile'])){
            $url = Url::toRoute('/site/login');
            if(empty($this->user)) {
                $this->helpGo($url);
            }
            $pass_flag = $this->hasSecurity();
            if(!$pass_flag && ($this->user->is_super!==1)){
                $this->helpRefresh($url,'请确认是否有权限访问');
            }
        }
        return true;
    }
    
    public function hasSecurity(){
        return true;
        $user_func_list = $this->user->getMyFunc();
        $mvc_info= $this->helpGetDispatchPath();
        if(strtolower($mvc_info['controller'])=='site'){
            return true;
        }
        $dispatch_path='/'.$mvc_info['module'].'/'.$mvc_info['controller'].'/'.$mvc_info['action'];
        $pass_flag = false;
        foreach($user_func_list as $k=>$v){
            $func_url = $v['url'];
            if(!empty($func_url)){
                if(Url::toRoute($dispatch_path)==Url::toRoute($func_url)){
                    $pass_flag = true;
                }
            }
        }
        return $pass_flag;
    }
}
