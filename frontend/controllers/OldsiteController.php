<?php

/**
 * @version 0.0.0.1
 */

namespace frontend\controllers;

use yii;
use librarys\controllers\BaseController;
use common\models\Disease;
use common\models\oldjb\Disease as oldDisease;

class OldsiteController extends BaseController {

    public function init() {
        parent::init();
        $this->disableLayout();
    }

    public function behaviors() {
        return [
            [
                'class' => '\librarys\actions\filters\PageCacheFilter',
                'cache' => 'cache_file',
                'enabled' => true,
                //'only' => ['*'], //需要添加缓存的方法列表
//                'duration' => 24 * 60 * 60, //默认一天
                'variations' => [
                    $_SERVER['REQUEST_URI']
                ],
            ],
        ];
    }

    public function actionDispatch() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $querystr = '';
        if (stripos($uri, "?") !== false) {
            $uri_arr = explode('?', $uri);
            $uri = $uri_arr[0];
            if (empty($uri_arr[1])) {
                $querystr = '?' . $uri_arr[1];
            }
        }
        if ($uri == 'map') {
            $uri = 'map.php';
        }
        $curl_url = sprintf('%s/%s%s', Yii::getAlias('@oldjb'), $uri, $querystr);
        $context = @file_get_contents($curl_url);
        return $context;
    }

    public function actionRedirect() {
        $diseaseid = $this->helpGquery('disid',0);
        if($diseaseid>0){
            $oldDisease = new oldDisease();
            $disInfo = $oldDisease->getDiseaseByContentid($diseaseid);
            $url = \Yii::getAlias("@jb_domain");
    //        var_dump($url);exit;
            if ($disInfo) {
                $disname = $disInfo['title'];
                $newDisInfo = Disease::find()->where('name=:name', [':name' => $disname])->one();
                $pinyin_initial = $newDisInfo ? $newDisInfo->pinyin_initial : '';
                $url .= '/' . $pinyin_initial . '/';

                header("Location:$url", true, 301);
                exit;
            }else{
                $this->actionDispatch();
            }
        }
    }

}
