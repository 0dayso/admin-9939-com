<?php
/**
 * @version 0.0.0.1
 */

namespace backend\modules\cms\controllers;

use common\models\disease\Article;
use common\models\position\Advertisement;
use common\models\position\Position;
use librarys\controllers\backend\BackController;
use yii\web\Response;

/**
 * 广告内容管理
 * @author gaoqing
 */
class AdmanageController extends BackController
{
    public function init()
    {
        parent::init();
    }

    public function actionSearchart(){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $article = [];

        $articleid = $this->helpGquery('articleid', '0');
        $type = $this->helpGquery('type', '1');

        if (!empty($articleid)){
            if ($type == 2){
                $articleObj = new \common\models\Article();
                $temp = $articleObj->List_ArticleByIds([$articleid]);
                if (!empty($temp)){
                    $article = $temp[0];
                }
            }elseif ($type == 1){
                $temp = Article::find()->where(['id' => $articleid])->asArray()->one();
                if (!empty($temp)){
                    $temp['url'] = \Yii::getAlias("@domain") . '/article/' . date('Y/md', $temp['inputtime']) . '/' . $temp['id'] . '.shtml';
                    $article = $temp;
                }
            }
        }
        return $article;
    }

    public function actionAddart(){
        $position = new Position();
        $positions = $position->getPositions(null, null, null, null, false);
        $positions = $positions['list'];

        $params = ['positions' => $positions];
        return $this->render('addart', $params);
    }

    public function actionStat(){
        $adid = $this->helpGquery('id', '0');

        //查询广告内容
        $advertisement = new Advertisement();
        $ad = $advertisement->getAdr(['id' => $adid]);

        //查询统计信息
        $stat = $advertisement->getStat(['adsid' => $adid]);

        return $this->render('stat', ['ad' => $ad, 'stat' => $stat]);
    }

    public function actionUpdateart(){
        $params = $this->getParams();
        $condition = $params['condition'];
        unset($params['condition']);
        $insertValues = $this->filterUpdateDatas($params);

        $advertisement = new Advertisement();
        $updateFlag = $advertisement->updateArt($insertValues, $condition);
        if ($updateFlag > 0){
            $this->redirect('/cms/admanage/index');
        }
    }

    public function actionUpdate(){
        $params = $this->getParams();
        $condition = $params['condition'];
        unset($params['condition']);
        $insertValues = $this->filterUpdateDatas($params);

        $advertisement = new Advertisement();
        $updateFlag = $advertisement->updateAd($insertValues, $condition);
        if ($updateFlag > 0){
            $this->redirect('/cms/admanage/index');
        }
    }

    public function actionEdit(){
        $id = $this->helpGquery('id', '0');
        $category = $this->helpGquery('category', '1');

        if (!empty($id)){
            if ($category > 2){
                return $this->editCode($id);
            }else {
                return $this->editArt($id);
            }
        }
    }

    public function editArt($id){
        $advertisement = new Advertisement();
        $adr = $advertisement->getAdr(['id' => $id]);

        $position = new Position();
        $positions = $position->getPositions(null, null, null, null, false);
        $positions = $positions['list'];

        return $this->render('editart', ['adr' => $adr, 'positions' => $positions]);
    }

    public function editCode($id){
        $advertisement = new Advertisement();
        $adr = $advertisement->getAdr(['id' => $id]);
        $adc = [];
        $adi = [];

        //查询广告内容
        if (!empty($adr)){
            $adc = $advertisement->getAdc(['id' => $adr['archive_id']]);
            if (!empty($adc)){
                $adi = $advertisement->getAdi(['relid' => $adc['id']]);
            }
        }
        $position = new Position();
        $positions = $position->getPositions(null, null, null, null, false);
        $positions = $positions['list'];

        return $this->render('edit', ['adr' => $adr, 'adc' => $adc, 'adi' => $adi, 'positions' => $positions]);
    }

    public function actionDelete(){
        \Yii::$app->response->format=Response::FORMAT_JSON;

        $id = $this->helpGquery('id', '0');
        $msg = ['msg' => 0];
        if (!empty($id)){
            $advertisement = new Advertisement();
            $deleteFlag = $advertisement->deleteAd(['id' => $id]);
            if ($deleteFlag){
                $msg = ['msg' => 1];
            }
        }
        return $msg;
    }

    public function actionInsertart(){
        $params = $this->getParams();
        $insertValues = $this->filterInsertDatas($params);

        $advertisement = new Advertisement();
        $insertFlag = $advertisement->insertArt($insertValues);
        if ($insertFlag > 0){
            $this->redirect('/cms/admanage/index');
        }
    }

    public function actionInsert(){
        $params = $this->getParams();
        $insertValues = $this->filterInsertDatas($params);

        $advertisement = new Advertisement();
        $insertFlag = $advertisement->insertAd($insertValues);
        if ($insertFlag > 0){
            $this->redirect('/cms/admanage/index');
        }
    }

    private function filterUpdateDatas($params){
        $insertValues = [];
        if (isset($params) && !empty($params) && is_array($params)){
            $adcAppendValues = ['updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adc', $adcAppendValues);
            $adrAppendValues = ['create_uid' => $this->user->id, 'create_name' => $this->user->login_name, 'updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adr', $adrAppendValues);
            $adiAppendValues = ['updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adi', $adiAppendValues);
        }
        return $insertValues;
    }

    private function filterInsertDatas($params){
        $insertValues = [];
        if (isset($params) && !empty($params) && is_array($params)){
            $adcAppendValues = ['createtime' => time(), 'updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adc', $adcAppendValues);
            $adrAppendValues = ['create_uid' => $this->user->id, 'create_name' => $this->user->login_name, 'createtime' => time(), 'updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adr', $adrAppendValues);
            $adiAppendValues = ['flag' => '3', 'createtime' => time(), 'updatetime' => time()];
            $insertValues = $this->filterNull($params, $insertValues, 'adi', $adiAppendValues);
        }
        return $insertValues;
    }

    /**
     * 过滤空的值
     * @author gaoqing
     * @date 2016-08-22
     * @param array $params $_POST 值
     * @param array $insertValues 过滤后的数组集
     * @param string $partKey 标识名称
     * @param array $appendValues 追加的数据
     * @return array 过滤后的数组集
     */
    private function filterNull($params, $insertValues, $partKey, $appendValues)
    {
        if (isset($params[$partKey]) && !empty($params[$partKey])) {
            $adTmp = $params[$partKey];
            $ad = array_filter($adTmp, function ($val) {
                if (empty($val)) {
                    return false;
                }
                return true;
            });
            $insertValues[$partKey] = array_merge($ad, $appendValues);
            return $insertValues;
        }
        return $insertValues;
    }

    public function actionAdd(){

        $position = new Position();
        $positions = $position->getPositions(null, null, null, null, false);
        $positions = $positions['list'];

        $params = ['positions' => $positions];
        return $this->render('add', $params);
    }

    public function actionSearch(){
        \Yii::$app->response->format=Response::FORMAT_JSON;

        $params = $this->getParams();
        $page = isset($params['page']) ? $params['page'] : 1;
        $page = empty($page) ? 1 : $page;
        unset($params['page']);

        $conditions = array_filter($params, function ($val){
            if (empty($val)){
                return false;
            }
            return true;
        });
        $size = 9;
        $offset = ($page - 1) * $size;
        $orderby = " id DESC";

        if (!empty($conditions) && isset($conditions['archive_name']) && !empty($conditions['archive_name'])){
            $archive_name_arr = ['LIKE', 'archive_name', $conditions['archive_name']];
            unset($conditions['archive_name']);
            $conditions[] = $archive_name_arr;
        }

        $advertisement = new Advertisement();
        $returns = $advertisement->getAds($conditions, $offset, $size, $orderby);
        $advertisements = empty($returns['list']) ? [] : $returns['list'];
        $total = $returns['total'];
        $pageHTML = $this->getPageHTML($page, $size, $total);
        return [
            'advertisements' => $advertisements,
            'pageHTML' => $pageHTML
        ];
    }

    public function actionIndex(){
        return $this->render('index');
    }

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