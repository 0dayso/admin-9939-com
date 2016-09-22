<?php

namespace backend\modules\basedata\controllers;

use librarys\controllers\backend\BackController;

class DefaultController extends BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
