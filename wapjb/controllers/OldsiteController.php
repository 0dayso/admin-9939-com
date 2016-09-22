<?php

/**
 * @version 0.0.0.1
 */

namespace wapjb\controllers;

use yii;
use librarys\controllers\wapjb\WapController;

class OldsiteController extends WapController {

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

    /**
     *         http://m.jb.9939.com/dis/140926/
     * 跳转到   http://m.9939.com/jb/140926.shtml
     * @return type
     */
    public function actionDispatch() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        $redirect_url = Yii::getAlias('@wap');
        $existence = strpos($uri, 'dis');
        if ($existence !== false) {
            $arr = explode('/', $uri);
            $num = array_pop($arr);
            $tail = 'jb/' . $num . '.shtml';
            $redirect_url = sprintf('%s/%s', Yii::getAlias('@wap'), $tail);
        }

        return $this->redirect($redirect_url, '302');
    }

}
