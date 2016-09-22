<?php

namespace backend\modules\basedata\controllers;

use Yii;
use yii\helpers\Json;
use common\models\Department;
use common\models\Disease;
//use librarys\helpers\plugin\Paging;
use librarys\controllers\backend\BackController;

/**
 * Department controller
 * 
 */
class DepartmentController extends BackController {

    public $department;
    public $disease;
//    public $paging;
    public $enableCsrfValidation = false;

    public function init() {
        parent::init();
        $this->department = new Department();
        $this->disease = new Disease();
    }

    /**
     * 科室管理 首页
     * @param array $param 默认选择一级科室
     */
    public function actionIndex() {
        $data = [];

        $param = [];
        $length = 10;
        $offset = 0;
        
        $total = $this->department->getSearchCount($param); //总数
        $res = $this->department->getSearch($param, $offset, $length); //查询结果
        $num = $this->department->getDepartmentNumber(); //各级科室数目
        $class_level1 = $this->department->getDepartmentLevel1(); //所有一级科室
        
        $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
        $paging->setTotal($total);
//        $paging = new Paging($total, $length, 1);
//        $page_html = $paging->pageToHtml(); //页码条

        $data["search"] = $res;
        $data['num'] = $num;
        $data['class_level1'] = $class_level1;
        $data['page_html'] = $paging;//$page_html;

        return $this->render('index', $data);
    }

//    private function initSearchCondition(){
//        return array('id'=>'',
//            'name'=>'',
//                'level'=>''
//            );
//    }
    /**
     * 科室首页 ajax请求 返回查询结果
     * @return HTML 
     */
    public function actionIndexSearch() {
        $data = [];
        $request = Yii::$app->request;
        if ($request->isPost) {
            $param = [
                'id' => $request->post("id"),
                'name' => $request->post("name"),
                'level' => $request->post("level"),
                'page' => $request->post('page', 1),
            ];
            $length = 10;
            $total = $this->department->getSearchCount($param); //总记录数
            
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
//            $paging = new Paging($total, $length, $param['page']);
//            $page_html = $paging->pageToHtml(); //页码条
//            $page = $paging->pageNo;
//            $offset = ($page - 1) * $length;

            $res = $this->department->getSearch($param, $offset, $length); //查询结果
            // $num = $this->department->getDepartmentNumber(); //各级科室数目
 
            $data["search"] = $res;
            $data["page_html"] = $paging;//$page_html;

            return $this->renderPartial('index_search', $data);
        }
    }

    /**
     * Add action 添加一级科室
     */
    public function actionAdd() {

        $data = [];
        $request = Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post("param");
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $param['level'] = 1;
            $param['pid'] = 0;
            $res = $this->department->add($param);

            if ($res) {
                return $this->redirect(['index']);
            }else{
                
                $this->helpJsRedirect('操作失败！');
            }
            $data['message'] = $res;
        }

        return $this->render('add', $data);
    }

    /**
     * Edit action 编辑科室 信息
     * @param integer $id 科室ID
     */
    public function actionEdit($id) {

        $data = [];
        $data['id'] = $id;
        $request = Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post("param");
            if (array_key_exists('pid', $param)) {
                $param['class_level1'] = $param['pid'];
            }
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $res = $this->department->edit($param);
            if ($res) {
                return $this->redirect(['index']);
            }else{
                $this->helpJsRedirect('操作失败！');
            }
        }
        $department = $this->department->getDepartmentById($id);
        if ($department['level'] == 2) {
            $class_level1 = $this->department->getDepartmentLevel1();
            $data['class_level1'] = $class_level1;
            $data['selected'] = $department['pid'];
        }
        $data['department'] = $department;
        return $this->render("edit", $data);
    }

    /**
     * 添加二级科室
     */
    public function actionAddSecond() {

        $data = [];

        $request = Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post("param");
            $param['class_level1'] = $param['pid'];
            $param['level'] = 2;
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $res = $this->department->add($param);
//            $data['message'] = $res;
            if ($res) {
                return $this->redirect(['index']);
            }
        } elseif ($request->isGet) {
            $data['selected'] = $request->get('id');
        }

        $res = $this->department->getDepartmentLevel1();
        $data['class_level1'] = $res;
//       $data['csrf'] = $request->getCsrfToken();
        return $this->render('addsecond', $data);
    }

    /**
     * 删除科室 ajax请求
     * @param array 二维数组 [[id=>id,level=>level],...]
     */
    public function actionDelete() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post('param');
            $message = '';
            if (is_array($param)) {
                foreach ($param as $k => $v) {
                    $message = $this->del((int) $v['id'], (int) $v['level']);
                    if (!$message) {
                        break;
                    }
                }
            }
            return Json::encode($message);
        }
    }

    private function del($departmentid, $level) {

        $res = '';
        if ($level == 2) {
            $res = $this->department->deleteDiseaseDepartment($departmentid, 1);
        }
        if ($res || $level == 1) {
            return $this->department->del($departmentid);
        }
    }

    /**
     * 查看一级科室
     * 
     */
    public function actionCheckLevel1() {
        $data = [];
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');


            $total = $this->department->getSearchCount(['pid' => $id]); //子科室的总数
            $length = 10;
            $page = 1;
            $offset = 0;

            $department = $this->department->getDepartmentById($id);
            $class_level2 = $this->department->getDepartmentListById($id, $offset, $length); //
            $class_level1 = $this->department->getDepartmentLevel1(); //所有一级科室

//            $paging = new Paging($total, $length, $page);
//            $page_html = $paging->pageToHtml();
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $paging->setTotal($total);
            
            $data['department'] = $department;
            $data['class_level2'] = $class_level2;
            $data['class_level1'] = $class_level1;
            $data['page_html'] = $paging;
        }
        return $this->render('check_level1', $data);
    }

    /**
     * 查看一级科室  二级科室列表分页  ajax
     * 
     */
    public function actionCheckLevel1Search() {
        $data = [];
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            $page = $request->post('page', 1);

            $total = $this->department->getSearchCount(['pid' => $id]); //子科室的总数
            $length = 10;
//            $paging = new Paging($total, $length, $page);
//            $page_html = $paging->pageToHtml();
//            $page = $paging->pageNo;
//            $offset = ($page - 1) * $length;
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
            
            $class_level2 = $this->department->getDepartmentListById($id, $offset, $length); //

            $data['class_level2'] = $class_level2;
            $data['page_html'] = $paging;

            return $this->renderPartial('check_level1_search', $data);
        }
    }
    
    /**
     * 查看二级科室
     * 
     */
    public function actionCheckLevel2() {
        $data = [];
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id'); //二级科室ID
            $total = $this->disease->getCounts(['department' => ['departmentid' => $id]]);

            $length = 10;
            $page = 0;
            $offset = 0;

            $class_level2 = $this->department->getDepartmentById($id); //当前科室信息
            $dis = $this->disease->getDiseasesByCondition(['department'=>['class_level2' => $id]], $offset, $length);
            
//            $page = new Paging($total, $length, $page);
//            $page_html = $page->pageToHtml();
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $paging->setTotal($total);
            
            $data['class_level2'] = $class_level2;
            $data['disease'] = $dis;
            $data['page_html'] = $paging;
        }

        return $this->render('check_level2', $data);
    }

    public function actionCheckLevel2Search() {
        $data = [];
        $request = Yii::$app->request;
        if ($request->isPost) {
            $name = $request->post("name", '');
            $departmentid = $request->post("departmentid");
            $page = $request->post("page");
            $like = 1;
            $total = $this->disease->getDiseaseCountByName($name, $departmentid, $like); //记录总数
            $length = 10;
//            $paging = new Paging($total, $length, $page);
//            $page_html = $paging->pageToHtml();
//            $page = $paging->pageNo;
//            $offset = ($page - 1) * $length;
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
            
            $res = $this->disease->getDiseaseByName($name, $departmentid, $like, $offset, $length);

            $data['disease'] = $res;
            $data['page_html'] = $paging;
            return $this->renderPartial('check_level2_search', $data);
        }
    }

    /**
     * 一级科室获取二级科室 联动 ajax请求
     * @return type
     */
    public function actionGetLevel2() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $class_level1 = $request->post('class_level1');
            $res = $this->department->getDepartmentListById($class_level1);
            return Json::encode($res);
        }
    }

    public function actionGetDisease() {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $class_level1 = $request->post('class_level1');
            $class_level2 = $request->post('class_level2');
            $name = $request->post('name');     //疾病名称
            $page = $request->post('page', 1);   //页码

            $condition = [];
            if ($class_level1 != 0 && $class_level2 != 0) {
                $condition['department'] = ['class_level2' => $class_level2];
            } elseif ($class_level1 != 0 && $class_level2 == 0) {
                $condition['department'] = ['class_level1' => $class_level1];
            }
            if (!empty($name)) {
                $condition['disease'] = ['name' => $name];
            }

            $total = $this->disease->getCounts($condition);
            $length = 10;

//            $paging = new Paging($total, $length, $page);
//            $page_html = $paging->pageToHtml(); //页码条
//            $page = $paging->pageNo; //页码
//            $offset = ($page - 1) * $length;
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
            
            $res = $this->disease->getDiseasesByCondition($condition, $offset, $length);
            $data = [];
            $data['disease'] = $res;
            $data['page_html'] = $paging;
            $data['page'] = $page;

            return $this->renderPartial('add_disease_search', $data);
        }
    }

    /**
     * 保存 科室 <=> 疾病 
     * ajax请求
     * @return
     */
    public function actionAddDiseaseRel() {
        $request = Yii::$app->request;
        if ($request->isPost) {
//            $class_level1 = $request->post('class_level1');
            $class_level2 = $request->post('class_level2');
            $arrdisease = $request->post('arrdisease');
            $class_level1 = $this->department->getDepartmentById($class_level2);
            $department = ['class_level1' => $class_level1['pid'], 'class_level2' => $class_level2];
            $res = $this->department->addDiseaseRel($department, $arrdisease);

            return Json::encode($res);
        }
    }

    /**
     * 二级科室详情 搜索   ajax请求
     * @return 返回查询结果
     */
    public function actionLevel2Search() {

        $request = Yii::$app->request;
        if ($request->isPost) {
            $name = $request->post("name");
            $departmentid = $request->post("departmentid");
            $res = $this->disease->getDiseaseByName($name, $departmentid, 1);
            return Json::encode($res);
        }
    }

    /**
     * 二级科室删除疾病  ajax请求
     * @return 返回删除情况
     */
    public function actionDeleteDiseaseDepartment() {

        $request = Yii::$app->request;
        if ($request->isPost) {
            $arrdiseaseid = $request->post("arrdiseaseid");
            $departmentid = $request->post("departmentid");
            $res = $this->department->deleteDiseaseDepartment($departmentid, 0, $arrdiseaseid);

            return Json::encode($res);
        }
    }

}
