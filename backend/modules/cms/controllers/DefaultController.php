<?php

namespace backend\modules\cms\controllers;

use librarys\controllers\backend\BackController;

class DefaultController extends BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
