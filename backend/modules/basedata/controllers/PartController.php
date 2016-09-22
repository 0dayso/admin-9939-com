<?php

namespace backend\modules\basedata\controllers;

use librarys\helpers\utils\Spell;
use backend\models\part\Part;
use librarys\controllers\backend\BackController;
use librarys\helpers\plugin\Paging;
use yii\helpers\Json;

/**
 * 身体部位的控制器类
 * @author caoxingdi
 * 2016年3月15日
 */
class PartController extends BackController {

    private $part;

    public function init() {
        parent::init();
        $this->part = new Part();
    }

    public function actionIndex() {
        $size = 10;
        $paging = $this->helpPaging('part_pager')->setSize($size)->setPageSetSize(7);
        $offset = $paging->getOffset();
        $partList = $this->part->search(array('level' => '1'), $offset, $size, array('id' => SORT_ASC), true); //查询结果
        $paging->setTotal($partList['total']);
        //print_r($paging->setTotal($partList['total']));exit;
        $num = $this->part->getNum(); //统计部位的数量
        $level1 = $this->part->getPartLevel();
        $data = array(
            'search' => $partList['list'],
            'num' => $num,
            'paging' => $paging,
            'class_level1' => $level1
        );
        return $this->render('index', $data);
    }

    /**
     * 部位搜索 ajax请求 返回查询结果
     * @return HTML 
     */
    public function actionIndexSearch() {
        $data = [];
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $param = [
                'id' => $request->post("id"),
                'name' => $request->post("name"),
                'level' => $request->post("level"),
                'page' => $request->post('page', 1),
            ];
            $length = 10;
            $total = $this->part->getPartCount($param); //总记录数
            $paging = $this->helpPaging('part_pager')->setSize($length)->setPageSetSize(7);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
            $res = $this->part->getSearchPart($param, $offset, $length); //查询结果

            $data["search"] = $res;
            $data["paging"] = $paging;

            return $this->renderPartial('index_search', $data);
        }
    }

    /**
     * 删除部位 ajax请求
     */
    public function actionDelete() {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post("id");
            $message = '';
            if (!empty($id)) {
                $message = $this->part->partDel($id);
            }
            return $message;
        }
    }

    /**
     * Add action 添加一级部位
     */
    public function actionAdd() {
        $data = [];
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post("param");
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $param['level'] = 1;
            $param['pid'] = 0;
            $param['createtime'] = time(); //创建时间
            $param['updatetime'] = time(); //更新时间

            $res = $this->part->partAdd1($param);

            if ($res) {
                return $this->redirect(['index']);
            } else {
                $this->helpJsRedirect('操作失败！');
            }
            //$data['message'] = $res;
        }
        return $this->render('add', $data);
    }

    /*
     * edit action 修改一级部位
     */

    public function actionEdit($id) {
        $data = array();
        $data['id'] = $id;
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $param = $request->post("param");
            if (array_key_exists('pid', $param)) {
                $param['part_level1'] = $param['pid'];
            }
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $param['updatetime'] = time();
            $res = $this->part->partEdit($param);
            if ($res == "0") {
                return $this->redirect(['index']);
            } else if ($res == "1") {
                $this->helpJsRedirect('操作失败！');
            } else {
                $this->helpJsRedirect('用户名已存在！');
            }
        }
        //单挑数据查询
        $data['part'] = $this->part->getPartById($id);
        return $this->render("edit", $data);
    }

    /*
     * 添加二级部位
     */

    public function actionSecondPartAdd() {
        $data = array();
        $param = array();
        //根据id查询出所有的一级部位
        $partList = $this->part->getPartLevel();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $param['name'] = $request->post("name");
            $param['pid'] = $request->post("pid");
            $param['keywords'] = $request->post("keywords");
            $param['description'] = $request->post("description");
            $param['level'] = '2';
            $param['child'] = '0';
            $param['part_level1'] = $request->post("pid");
            $param['createtime'] = time(); //创建时间
            $param['updatetime'] = time(); //更新时间
            $param['userid'] = $this->login_id;
            $param['username'] = $this->login_name;
            $res = $this->part->partAdd1($param);
            if ($res) {
                return $this->redirect(['index']);
            } else {

                $this->helpJsRedirect('操作失败！');
            }
        } elseif ($request->isGet) {
            $data['selected'] = $request->get('id');
        }
        $data['part_level1'] = $partList;
        return $this->render('addsecond', $data);
    }

    /*
     * 查看一级部位下的子部位 
     */

    public function actionPartLevel1() {
        $param = [];
        $length = 10;
        $offset = 0;
        $request = \Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            //查询一级部位数据
            $part = $this->part->getPartById($id);
            $partLevel1 = $this->part->getList();//获取所有一级数据
            $total = $this->part->getLevel1ChildNum($id); //统计条数
            
            $partList = $this->part->getPartListLevel2($id, $offset, $length); //查询结果
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $paging->setTotal($total['count']);
            $data = array(
                'class_level1' => $partLevel1,
                'class_level2' => $partList,
                'page_html' => $paging,
                'part' => $part,
                'pid' => $id
            );
            return $this->render('part_level1', $data);
        }
    }

    /**
     * 查看一级部位  二级部位列表分页  ajax
     * 
     */
    public function actionCheckLevel1Search() {
        $data = [];
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            $page = $request->post('page');

            $total = $this->part->getPartCount(['pid' => $id]); //子部位的总数
            $length = 10;
            $paging = new Paging($total, $length, $page);
            $page_html = $paging->pageToHtml();

            $page = $paging->pageNo;
            $offset = ($page - 1) * $length;

            $class_level2 = $this->part->getPartListLevel2($id, $offset, $length); //

            $data['class_level2'] = $class_level2;
            $data['page_html'] = $page_html;

            return $this->renderPartial('part_level1_search', $data);
        }
    }

    /*
     * 修改二级部位
     */

    public function actionEditLevel2($id = 0) {
        $data = array();
        $request = \Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            $part = $this->part->getPartById($id);
            $data['part'] = $part;
            $data['id'] = $id;
            //查询所有一级部位
            $part_level1 = $this->part->getPartLevel();
            $data['part_level1'] = $part_level1;
            return $this->render('edit_level1', $data);
        } else if ($request->isPost) {
            //接收所有的值
            $param = [];
            $id = $request->post('id');
            $param['name'] = $request->post('name');
            $param['pid'] = $request->post('pid');
            $param['keywords'] = $request->post('keywords');
            $param['description'] = $request->post('description');
            $param['updatetime'] = time();
            $part = $this->part->editLevel2($param, $id);
            if ($part) {
                return $this->redirect(['index']);
            } else {
                $this->helpJsRedirect('操作失败！');
            }
        }
    }

    /**
     * 一级部位获取二级部位 联动 ajax请求
     * @return type
     */
    public function actionGetLevel2() {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $part_level1 = $request->post('part_level1');
            $res = $this->part->getPartListById($part_level1);
            return Json::encode($res);
        }
    }

    public function actionGetDisease() {
        $request = \Yii::$app->request;

        if ($request->isPost) {
            $part_level1 = $request->post('part_level1');
            $part_level2 = $request->post('part_level2');
            $name = $request->post('name');     //部位名称
            $page = $request->post('page', 1);   //页码

            $condition = [];
            if ($part_level1 != 0 && $part_level2 != 0) {
                $condition['part'] = ['ddr.part_level2' => $part_level2];
            } elseif ($part_level1 != 0 && $part_level2 == 0) {
                $condition['part'] = ['ddr.part_level1' => $part_level1];
            }
            if (!empty($name)) {
                $condition['disease'] = ['name' => $name];
            }
            $total = $this->part->getCounts($condition);
            $length = 10;
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);

            $res = $this->part->getDiseasesByCondition($condition, $offset, $length);
            $data = [];
            $data['disease'] = $res;
            $data['page_html'] = $paging;
            $data['page'] = $page;
            return $this->renderPartial('add_disease_search', $data);
        }
    }

    /**
     * 保存 部位 <=> 疾病 
     * ajax请求
     * @return
     */
    public function actionAddDiseaseRel() {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $part_level2 = $request->post('part_level2');
            $arrdisease = $request->post('arrdisease');
            $part_level1 = $this->part->getPartById($part_level2);
            $department = ['part_level1' => $part_level1['pid'], 'part_level2' => $part_level2];
            $res = $this->part->addDiseaseRel($department, $arrdisease);

            return Json::encode($res);
        }
    }

    /**
     * 查看二级部位下的疾病列表
     * 
     */
    public function actionPartLevel2() {
        $data = [];
        $request = \Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id'); //二级部位ID
            $total = $this->part->getCounts(['part' => ['part_level2' => $id]]);
            $length = 10;

            $class_level2 = $this->part->getPartById($id); //当前部位信息
            $paging = $this->helpPaging('part_pager')->setSize($length)->setPageSetSize(7);
            $offset = $paging->getOffset();
            $paging->setTotal($total);
            $dis = $this->part->getDiseasesByCondition(['part' => ['part_level2' => $id]], $offset, $length);

            $data['class_level2'] = $class_level2;
            $data['disease'] = $dis;
            $data['page_html'] = $paging;
        }

        return $this->render('part_level2', $data);
    }
    /**
     * 删除疾病操作
     * @param $id int 疾病id
     * @return ture 
     */
    public function actionDeleteDiseasePart(){
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $arrdiseaseid = $request->post("arrdiseaseid");
            $partid = $request->post("departmentid");
            $res = $this->part->deleteDiseasePart($partid,$arrdiseaseid);
            return $res;
        }
    }
}
