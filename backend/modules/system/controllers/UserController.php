<?php
namespace backend\modules\system\controllers;

use yii\helpers\Url;
use librarys\controllers\backend\BackController;
use backend\models\funcs\Func;
use backend\models\roles\Roles;
use backend\models\roles\Role_Purview;
use backend\models\users\Users;
use backend\models\users\User_Role_Relate;
use backend\models\users\User_Purview;

class UserController extends BackController
{
	public function init(){
        parent::init();
        $this->setLayout('//bootstrapmaster');
	}

	/**
	 * 用户列表
	 */
	public function actionIndex() {
        $size = 10;
        $paging = $this->helpPaging('pager')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $records = Users::search(['user_group_id'=>$this->user_group_id],$offset,$size,array('id'=>SORT_ASC), true);
		$userList = $records['list'];
        $paging->setTotal($records['total']);
        $data = array('userList'=>$userList,'paging'=>$paging);
        return $this->render('index',$data);
	}
	
	public function actionAdd() {
        //加载所有角色
		$roleList = Roles::getByUsergroupId($this->user_group_id);
        $data = [
            'roleList'=>$roleList
        ];
        return $this->render('add',$data);
	}
    
    /**
	 * 编辑用户
	 */
	public function actionEdit() {
		$uid = $uid = $this->helpGparam('uid');
        
        $userinfo = Users::getById($uid);
		//加载所有角色
		$roleList = Roles::getByUsergroupId($this->user_group_id);
		$user_role_ids = User_Role_Relate::getByUid($uid);
		
		//加载所有功能
		$funcList = Func::getByParentId(0);
		$funcData = array();
		foreach($funcList as $k => $func) {
			$data = array(
					'id' => $func['id'],
					'name' => $func['caption'],
					'isParent' => true,
					'open' => true
			);
			$childList = Func::getByParentId($func['id']);
			$data['children'] = array();
			foreach($childList as $cf) {
				$data['children'][] = array(
						'id' => $cf['id'],
						'name' => $cf['caption'],
						'pId' => $func['id'],
						'isParent' => false
				);
			}
			$funcData[] = $data;
		}
		
		$data = [
            'userinfo'=>$userinfo,
            'funcData'=>$funcData,
            'uid'=>$uid,
            'roleList'=>$roleList,
            'user_role_ids'=>$user_role_ids
        ];
        return $this->render('edit',$data);
	}
	/**
	 * 保存
	 */
	public function actionSave() {
        $data = $this->helpGpost('users');
        extract($data);
        if(empty($login_name)) {
			$this->helpJsRedirect('请输入登录名');
		}
        $role_id = $this->helpGpost('role_id',0);
        $user_id = 0;
		if(($id=intval($id)) > 0) {
            $ret = Users::updateUser($id,$login_name,$real_name, $email, $this->user_group_id, $phone);
            $user_id = $id;
		}else{
            if(empty($password)) {
                $this->helpJsRedirect('请输入初始密码');
            }
            $password2 = $this->helpGpost('password2');
            if($password != $password2) {
                $this->helpJsRedirect('两次密码输入不一致');
            }
			//新增
			$ret = Users::addUser($login_name, $password, $real_name, $email, $this->user_group_id, $phone);
            $user_id = $ret;
        }
        
		if(empty($ret)) {
			$this->helpJsRedirect('操作失败');
		}
        
        if($role_id && $user_id){
            //保存用户角色关联
            User_Role_Relate::delByUid($user_id);
            User_Role_Relate::addRelate($role_id, $user_id);
            
            //删除用户所有权限
            User_Purview::delByUid($user_id);
            $role_purview = Role_Purview::getByRoleId($role_id);
            if(count($role_purview)>0){
                $rows = [];
                foreach ($role_purview as $k=>$v) {
                    $func_id = $v['func_id'];
                    $rows[]=[$user_id,$func_id];
                }
                User_Purview::batchAddPurview(['user_id','func_id'], $rows);
            }
        }
        $url = Url::toRoute('user/index');
		$this->redirect($url);
	}
	
	
	/**
	 * 停用
	 */
	public function actionDisable() {
		$user_id = $this->helpGparam('uid');
		$target_status = 2;//停用状态
		$ret = Users::updateUserStatusById($user_id, $target_status);
        $url = Url::toRoute('user/index');
        $this->helpGo($url);
	}
	
	/**
	 * 启用
	 */
	public function actionEnable() {
		$user_id = $this->helpGparam('uid');
		$target_status = 1;//启用状态
		$ret = Users::updateUserStatusById($user_id, $target_status);
        $url = Url::toRoute('user/index');
        $this->helpGo($url);
	}
	
	/**
	 * 修改密码
	 */
	public function actionModpassword(){
		$password = $this->helpGpost('password');
		$password2 = $this->helpGpost('password2');
        $uid = $this->helpGpost('uid');
		if($password != $password2) {
			$this->helpJsRedirect('两次密码输入不一致');
		}
        $ret = -1;
        if(intval($uid)>0){
            $ret = Users::modPwdById($password,$uid);
        }
        
        if($ret>=0){
            $url = Url::toRoute('user/index');
            $this->helpGo($url);
        }else{
             $this->helpJsRedirect('密码重置失败');
        }
        
	}
	
	public function actionEditpassword(){
        $uid = $this->helpGparam('uid');
        $data = [
            'uid'=>$uid
        ];
        return $this->render('editpassword',$data);
	}
}
