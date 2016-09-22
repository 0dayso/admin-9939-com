<?php

namespace backend\modules\basedata\controllers;

use Yii;
use librarys\controllers\backend\BackController;
use yii\helpers\Json;
use common\models\Department;
use common\models\Disease;
use common\models\CategoryDisease;
//use librarys\helpers\plugin\Paging;

/**
 * Description of CategoryController
 */
class CategoryController extends BackController {

    public $category;
    public $department;
    public $disease;

    public function init() {
        parent::init();
        $this->category = new CategoryDisease();
        $this->disease = new Disease();
        $this->department = new Department();
        
    }
    
    /**
     * 分类列表
     */
    public function actionIndex() {
        $page = 1;
        $data = $this->indexSearchData($page);
        
        return $this->render('index',$data);
    }
    /**
     * 分类列表 分页  ajax请求返回 html
     */
    public function actionIndexSearch() {
        $page = $this->helpGpost('page', 1);
        $data = $this->indexSearchData($page);
        
        return $this->renderPartial('index_search', $data);
    }
    //分类 分页+数据
    public function indexSearchData($page = 1) {
        $data = [];
        $total = $this->category->getCounts();
        $length = 10;
        
//        $paging = new Paging($total, $length, $page);
//        $page_html = $paging->pageToHtml();
//        $page = $paging->pageNo;
//        $offset = ($page - 1) * $length;
        $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
        $offset = $paging->getOffset();
        $paging->setTotal($total);

        $category = $this->category->getCategory([], $offset, $length);
        
        $data['category'] = $category;
        $data['page_html'] = $paging;
        
        return $data;
    }
    /**
     * 删除 分类
     * 传递的 ids 为id组成的索引数组 [$id1,$id2,……]
     */
    public function actionDelCategory() {
        
        $ids = $this->helpGpost('ids', []);

        $res = $this->category->deleteCategory($ids);

        $code = $res ? 'success' : 'error';
        $message = $res ? '删除成功！' : '删除失败！';

        return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
    }

    /**
     * 添加分类
     */
    public function actionAdd() {
        $data = [];
        $class_level1 = $this->department->getDepartmentLevel1();//所有一级科室
        
        $data['class_level1'] = $class_level1;
        return $this->render('add',$data);
    }
    
    /**
     * 编辑分类
     */
    public function actionEdit() {
        $data = [];
        $id = $this->helpGquery('id');
        if(empty($id)){
            return $this->redirect('index');
        }
        $category = $this->category->getCategoryById($id);
        
        $disease = $this->disease->getDiseaseByCategoryId($id);
        $class_level1 = $this->department->getDepartmentLevel1();//所有一级科室
        
        $data['category'] = $category;
        $data['disease'] = $disease;
        $data['class_level1'] = $class_level1;
        return $this->render('edit',$data);
    }
    /**
     * 获取疾病
     */
    public function actionGetDisease() {
        $data = [];
        $class_level1 = $this->helpGpost('class_level1', '162');
        $class_level2 = $this->helpGpost('class_level2', '');
        $name = $this->helpGpost('name', '');
        $page = $this->helpGpost('page', 1);
        $param = [
            'class_level1' => $class_level1,
            'class_level2' => $class_level2,
            'name' => $name
        ];
        $total = $this->disease->getDisCountsByDepAndName($param);
        
        $length = 10;
        
//        $paging = new Paging($total,$length,$page);
//        $page_html = $paging->pageToHtml();
//        $page = $paging->pageNo;
//        $offset = ($page - 1) * $length;
        $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
        $offset = $paging->getOffset();
        $paging->setTotal($total);
        $disease = $this->disease->getDiseaseByDepatmentAndName($param,$offset,$length);
        
        $data['disease'] = $disease;
        $data['page_html'] = $paging;
        return $this->renderPartial('search_disease', $data);
    }

    /**
     * 新增保存分类
     */
    public function actionAddSave() {
        $flag = '';
        $name = $this->helpGpost('name');
        $data = $this->helpGpost('data', []);

        if (empty($name)) {
            $flag = true;
            $code = 'error';
            $message = '缺少分类名称！';
        }
        $search = $this->category->getCategory(['name' => $name]);
        if (!empty($search)) {
            $flag = true;
            $code = 'error';
            $message = '分类名称已存在！';
        }
        if ($flag) {
            return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
        }

        $time = time();
        $param = [
            'name' => $name,
            'createtime' => $time,
            'updatetime' => $time,
            'userid' => $this->user->id,
            'username' => $this->user->login_name,
        ];
        $id = $this->category->addCategory($param); //成功返回id
        $code = 'success';
        $message = '添加成功！';
        if ($id) {
            if (!empty($data)) {
                $ret = $this->category->addCategoryDiseaseRel($id, $data);
            }
        } else {
            $code = 'error';
            $message = '添加失败！';
        }
        return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
    }
    
    /**
     * 编辑保存分类
     */
    public function actionEditSave() {
        $flag = '';
        $name = $this->helpGpost('name','');
        $oldname = $this->helpGpost('oldname');
        $id = $this->helpGpost('id');
        $data = $this->helpGpost('data', []);
        
        if (empty($name)) {
            $flag = true;
            $code = 'error';
            $message = '缺少分类名称！';
        }
        if ($name != $oldname) {
            $search = $this->category->getCategory(['name' => $name]);
            if (!empty($search) && $search['0']['id'] != $id && $search['0']['name'] == $name) {
                $flag = true;
                $code = 'error';
                $message = '分类名称已存在！';
            }
        }
        if ($flag) {
            return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
        }
        
        $edit = $this->editCategory($id, $name);
        
        $code = 'error';
        $message = '编辑失败！';
        if ($edit) {
            $res = $this->addCategoryDiseaseRel($id, $data);
            if (!$res) {
                $code = 'error';
                $message = '编辑失败！';
            }
            $code = 'success';
            $message = '编辑成功！';
        }
        return $this->helpResult(['code' => $code, 'message' => $message, 'data' => '']);
    }
    
    public function editCategory($id,$name) {
        $time = time();
        $param = [
            'id' => $id,
            'name' => $name,
            'createtime' => $time,
            'updatetime' => $time,
            'userid' => $this->user->id,
            'username' => $this->user->login_name,
        ];
        return $this->category->editCategory($param);
    }
    public function addCategoryDiseaseRel($categoryId, $data) {
        if(empty($data)){
            return true;
        }
        $del = $this->category->deleteCategoryDiseaseRel($categoryId);
        if (is_numeric($del)) {
            return $this->category->addCategoryDiseaseRel($categoryId, $data);
        }
    }

}
