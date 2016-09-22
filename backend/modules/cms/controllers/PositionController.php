<?php
/**
 * @version 0.0.0.1
 */

namespace backend\modules\cms\controllers;


use common\models\position\Position;
use librarys\controllers\backend\BackController;
use yii\web\Response;

class PositionController extends BackController
{
    public function init()
    {
        parent::init();
    }

    public function actionDelete(){
        \Yii::$app->response->format=Response::FORMAT_JSON;

        $id = $this->helpGquery('id', '0');
        $msg = ['msg' => 0];
        if (!empty($id)){
            $position = new Position();
            $deleteFlag = $position->deletePosition(['id' => $id]);
            if ($deleteFlag){
                $msg = ['msg' => 1];
            }
        }
        return $msg;
    }

    public function actionEdit(){
        $id = $this->helpGquery('id', '0');

        if (!empty($id)){
            $position = new Position();
            $pos = $position->getPosition(['id' => $id]);

            return $this->render('edit', ['position' => $pos]);
        }
    }

    public function actionDetail(){
        $id = $this->helpGquery('id', '0');
        if (!empty($id)){
            $position = new Position();
            $pos = $position->getPosition(['id' => $id]);

            return $this->render('detail', ['position' => $pos]);
        }
    }

    public function actionUpdate(){
        $params = $this->getParams();
        $id = $params['id'];
        if (!empty($id)){

            $updateDatas = array_filter($params, function ($val){
                if (empty($val)){
                    return false;
                }
                return true;
            });
            unset($updateDatas['id']);

            $position = new Position();
            $updateFlag = $position->updatePosition(['id' => $id], $updateDatas);
            if ($updateFlag){
                $this->redirect('/cms/position/index');
            }
        }
    }

    /**
     * 新增广告位信息
     * @author gaoqing
     * @date 2016-08-10
     * @return
     */
    public function actionInsert(){
        $params = $this->getParams();
        $values = array_filter($params, function ($val){
            if (empty($val)){
                return false;
            }
            return true;
        });
        //设置默认值
        $default = [
            'uid' => $this->user->id,
            'uname' => $this->user->login_name,
            'createtime' => time(),
            'updatetime' => time(),
            'status' => '0',
        ];
        $inserDatas = array_merge($values, $default);
        $position = new Position();
        $insertFlag = $position->insertPosition($inserDatas);
        if ($insertFlag){
            $this->redirect('/cms/position/index');
        }
    }

    /**
     * 添加广告位
     * @author gaoqing
     * @date 2016-08-09
     * @return String 视图
     */
    public function actionAdd(){
        return $this->render('add');
    }

    /**
     * 广告位首页
     * @author gaoqing
     * @date 2016-08-08
     * @return String 视图
     */
    public function actionIndex(){
        return $this->render('index');
    }

    public function actionSearch(){
        \Yii::$app->response->format=Response::FORMAT_JSON;

        $id = $this->helpGpost('id', '0');
        $name = $this->helpGpost('name', '');
        $page = $this->helpGpost('page', 1);
        $page = empty($page) ? 1 : $page;

        $conditions = [];
        if (!empty($id)){
            $conditions['id'] = $id;
        }
        if (!empty($name)){
            $conditions['name'] = $name;
        }
        $size = 9;
        $offset = ($page - 1) * $size;
        $orderby = 'id ASC';

        if (!empty($conditions) && isset($conditions['name']) && !empty($conditions['name'])){
            $archive_name_arr = ['LIKE', 'name', $conditions['name']];
            unset($conditions['name']);
            $conditions[] = $archive_name_arr;
        }

        $position = new Position();
        $values = $position->getPositions($conditions, $offset, $size, $orderby);
        $pageHTML = $this->getPageHTML($page, $size, $values['total']);

        return [
            'positions' => $values['list'],
            'pageHTML' => $pageHTML
        ];
    }

    /**
     * 得到分页
     * @author gaoqing
     * 2016-08-09
     * @param int $page 当前页数
     * @param int $size 每页显示条数
     * @param int $count 总记录数
     * @return string 分页的 html
     */
    public function getPageHTML($page, $size, $count){
        $pageHTML = '<a href="javascript:;" class="hko kos" data-id = "pre">&lt;&lt;</a>';
        $first = 1;
        $paging = ($size + 1) / 2;
        $floor = ($size - 1) / 2;
        $total = ceil($count / $size);
        if($page > $paging){
            $first = $page - $floor;
        }
        for($i = 0; $i < $size; $i++){
            $currNum = $first + $i;
            if($currNum > $total){
                break;
            }
            $style = $page == $currNum ? "class='curt'" : "";
            $dataValue = $currNum == $total ? 'data-value = "end"' : '';
            $pageHTML .= '<a href="javascript:;" '. $style .' data-id = "page" '. $dataValue .' >'. $currNum .'</a>';
        }
        if($size < $total){
            $pageHTML .= '<span>...</span>';
            $pageHTML .= '<a href="javascript:;" data-id = "page" data-value = "end">'. $total .'</a>';
        }
        $pageHTML .= '<a href="javascript:;" class="hko" data-id = "next">&gt;&gt;</a>';
        return $pageHTML;
    }


}