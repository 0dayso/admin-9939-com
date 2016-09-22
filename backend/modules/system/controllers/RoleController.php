<?php
namespace backend\modules\system\controllers;


use yii\helpers\Url;
use librarys\controllers\backend\BackController;
use backend\models\funcs\Func;
use backend\models\roles\Roles;
use backend\models\roles\Role_Purview;
use backend\models\users\User_Role_Relate;
use backend\models\users\User_Purview;

class RoleController extends BackController
{
	public function init(){
        parent::init();
        $this->setLayout('//bootstrapmaster');
	}
	
	public function actionIndex() {
		$roleList = Roles::getByUsergroupId($this->user_group_id);
        return $this->render('index',array('roleList'=>$roleList));
	}
	
	/**
	 * 新建角色
	 */
	public function actionAdd() {
		$funcData = $this->getFuncsData();
        return $this->render('add',array('funcData'=>$funcData));
	}
	
	/**
	 * 编辑角色
	 */
	public function actionEdit() {
		$funcData = $this->getFuncsData();
		$role_id = $this->helpGquery('role_id');
		$role = Roles::getById($role_id);
        $role_func_list = Role_Purview::getByRoleId($role_id);
        $role_func_data = [];
        foreach($role_func_list as $k=>$v){
            $func_id = $v['func_id'];
            $role_func_data[$func_id]=$v;
        }
        $data = array(
            'role'=>$role,
            'funcData'=>$funcData,
            'role_func_data'=>$role_func_data
        );
        return $this->render('edit',$data);
	}
    
	/**
	 * 删除角色
	 */
	public function actionDel() {
		
	}
	
	/**
	 * 保存角色
	 */
	public function actionSave() {
        $data = $this->helpGpost('role');
        extract($data);
		$purview_ids = $this->helpGpost('purview_ids');
		if(empty($role_name)) {
			$this->helpJsRedirect('请填写角色名称');
		}
		if(($role_id=intval($id))<1) {
			//新增角色
			$role_id = Roles::addRole($role_name, $this->user_group_id, $remark);
		} else {
			//更新角色
			Roles::updateRole($role_id, $role_name, $this->user_group_id,$remark);
		}
		//删除角色所有权限
		Role_Purview::delByRoleId($role_id);
        $func_ids = array();
        if(!empty($purview_ids)){
            $func_ids = explode(',', trim($purview_ids,','));
            if(count($func_ids)>0){
                $rows = [];
                foreach ($func_ids as $func_id) {
                    $func_id = $func_id;
                    $rows[]=[$role_id,$func_id];
                }
                if(count($rows)>0){
                    Role_Purview::batchAddPurview(['role_id','func_id'], $rows);
                }
            }
        }
        //更新角色对应的所有用户的权限
        $user_ids =  User_Role_Relate::getByRoleid($role_id);
        foreach($user_ids as $k=>$v){
            $uid = $v['user_id'];
            User_Purview::delByUid($uid);
            $user_purview_rows = [];
            foreach ($func_ids as $func_id) {
                $func_id = $func_id;
                $user_purview_rows[]=[$uid,$func_id];
            }
            if(count($user_purview_rows)>0){
                User_Purview::batchAddPurview(['user_id','func_id'], $user_purview_rows);
            }
        }
        
        $url = Url::toRoute('role/index');
        $this->helpRefresh($url,'保存成功');
	}
    
    private function getFuncsData(){
        $funcList = Func::getByParentId(0);
		$funcData = array();
		foreach($funcList as $k => $func) {
			$data = array(
					'id' => $func['id'],
					'name' => $func['caption'],
					'fatherid' => 0,
                    'isparent'=>true
			);
			$childList = Func::getByParentId($func['id']);
			$data['children'] = array();
			foreach($childList as $cf) {
				$data['children'][] = array(
						'id' => $cf['id'],
						'name' => $cf['caption'],
						'fatherid' => $func['id'],
						'isparent' => false
				);
			}
			$funcData[] = $data;
		}
        return $funcData;
    }
}