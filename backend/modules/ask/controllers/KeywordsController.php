<?php

namespace backend\modules\ask\controllers;

use Yii;
use librarys\controllers\backend\BackController;
use common\models\ask\Department;
use common\models\ask\Keywords;
use common\models\ask\Disease;
use yii\helpers\Json;
use librarys\helpers\utils\Spell;

/**
 * Description of KeywordsController
 */
class KeywordsController extends BackController {

    /**
     * 疾病关键词列表
     */
    public function actionIndex() {
        $data = [];

        $param = [];
        $length = 10;
        $offset = 0;
        $obj_keywords = new Keywords();
        $total = $obj_keywords->getSearchCount($param); //总数
        $res = $obj_keywords->getSearch($param, $offset, $length); //查询结果
        
        $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
        $paging->setTotal($total);
        $data["keywords"] = $res;
        $data['page_html'] = $paging;
        return $this->render('index', $data);
    }
    
    public function actionIndexSearch() {
        $data = [];
        $param = [];
        $request = Yii::$app->request;
        if ($request->isPost) {
            $keywords = $this->helpGpost('keywords', '');
            $diseasename = $this->helpGpost('diseasename', '');
            if ($keywords) {
                $param['k.name'] = $keywords;
            }
            if ($diseasename) {
                $param['d.name'] = $diseasename;
            }
           
            $length = 10;
            $obj_keywords = new Keywords();
            $total = $obj_keywords->getSearchCount($param); //总记录数
            
            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);

            $res = $obj_keywords->getSearch($param, $offset, $length); //查询结果
 
            $data["keywords"] = $res;
            $data["page_html"] = $paging;//$page_html;

            return $this->renderPartial('index_search', $data);
        }
    }
    /**
     * 添加关键词
     */
    public function actionAdd() {
        $data = [];
        $department = new Department();
        $data['class_level1'] = $department->getlevel1();
        return $this->render('add', $data);
    }

    /**
     * 编辑关键词
     */
    public function actionEdit() {
        $id = $this->helpGquery('id', '');
        if (!$id) {
            return $this->redirect('index');
        }
        $department = new Department();
        $data['class_level1'] = $department->getlevel1();
        $keywords = Keywords::findOne($id);
        $disease = Disease::findOne($keywords['disease_id']);
        if($keywords){
            $keywords = $keywords->toArray();
        }
        if($disease){
            $disease = $disease->toArray();
        }
        $data['keywords'] = $keywords;
        $data['disease'] = $disease;
        return $this->render('edit', $data);
    }

    public function actionGenetePinyin() {
        $keywords = $this->helpGpost('keywords', '');
        $pinyin_initial = Spell::Pinyin($keywords, 'utf-8', true); //汉字->简拼

        $message = [
            'error' => 0,
            'pinyin' => $pinyin_initial
        ];
        return Json::encode($message);
    }

    /**
     * ajax 获取二级科室
     */
    public function actionGetLevel2() {
        $class_level1 = $this->helpGpost('class_level1', '');
        $department = new Department();
        $level2 = $department->getLevel2ByLevel1($class_level1);
        return Json::encode($level2);
    }

    /**
     * ajax 获取疾病
     */
    public function actionGetDisease() {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $class_level1 = $request->post('class_level1', '');
            $class_level2 = $request->post('class_level2', '');
            $name = $request->post('name', '');     //疾病名称
            $page = $request->post('page', 1);   //页码

            $condition = [];
            if (!empty($class_level1)) {
                $condition['class_level1'] = $class_level1;
            }
            if (!empty($class_level2)) {
                $condition['class_level2'] = $class_level2;
            }
            if (!empty($name)) {
                $condition['name'] = $name;
            }
            $obj_disease = new Disease();
            $total = $obj_disease->getCounts($condition);
            $length = 10;

            $paging = $this->helpPaging('pager_department')->setSize($length)->setPageSetSize(5);
            $offset = $paging->getOffset();
            $paging->setTotal($total);

            $res = $obj_disease->getDiseasesByCondition($condition, $offset, $length);
            $data = [];
            $data['disease'] = $res;
            $data['page_html'] = $paging;
            $data['page'] = $page;

            return $this->renderPartial('add_disease_search', $data);
        }
    }

    /**
     * 添加保存
     */
    public function actionAddSave() {
        $name = $this->helpGpost('name', '');
        $separator = ';'; //关键词之间的分隔符
        $name = trim($name, $separator);
        $name_arr = [$name];
        if (strpos($name, $separator)) {
            $name_arr = explode($separator, $name);
        }

        $disease = $this->helpGpost('disease', []);
        $diseaseid = $disease[0]['diseaseid'];
        $obj_keywords = new Keywords();
        $i = 0;
        foreach ($name_arr as $key => $name) {
            $pinyin_initial = Spell::Pinyin($name, 'utf-8', true); //简写
            $pinyin = Spell::Pinyin($name, 'utf-8', false); //全拼
            $params = [
                'name' => $name,
                'pinyin_initial' => $pinyin_initial,
                'pinyin' => $pinyin,
                'disease_id' => $diseaseid,
            ];
            $res = $obj_keywords->add($params);
            $res ? $i++ : '';
        }
        $message['error'] = $res ? 0 : 1;
        $message['num'] = $i;
        return Json::encode($message);
    }

    /**
     * 编辑保存
     */
    public function actionEditSave() {
        $id = $this->helpGpost('id', '');
        $name = $this->helpGpost('name', '');
        $disease = $this->helpGpost('disease', []);
        $diseaseid = $disease[0]['diseaseid'];
        $res = Keywords::findOne($id);
        if (!$res) {
            return Json::encode(['error' => 1]);
        }
        $pinyin_initial = Spell::Pinyin($name, 'utf-8', true) . $id;
        $params = [
            'name' => $name,
            'pinyin_initial' => $pinyin_initial,
            'disease_id' => $diseaseid,
        ];
        $obj_keywords = new Keywords();
        $res = $obj_keywords->edit($id, $params);
        $message['error'] = $res ? 0 : 1;
        return Json::encode($message);
    }
    
    /**
     * ajax 删除操作
     */
    public function actionDel() {
        $id = $this->helpGpost('id', '');
        if ($id) {
            $keywords = Keywords::findOne($id);
            $res = $keywords->delete();
            if ($res) {
                return Json::encode(['error' => 0]);
            }
        }
        return Json::encode(['error' => 1]);//删除失败
    }

}
