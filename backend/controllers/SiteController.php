<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use librarys\controllers\backend\BackController;

use librarys\helpers\utils\SearchHelper;
/**
 * Site controller
 */
class SiteController extends BackController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }
    
    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //验证码
            'captcha' => [
                    'class' => 'librarys\actions\VerifycodeAction',
                    'fixedVerifyCode'=>null,
                    'width'=>80,
                    'height'=>35,
                    'backColor' => 0xFFFFFF,
                    'minLength' => 4,
                    'maxLength' => 4,
                    'offset' => 5,
                    'foreColor' => 'Ox000000',
                    'transparent' => false,
                    'testLimit'=>1
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
//        $ret =SearchHelper::Search('糖尿病', 'index_9939_com_dzjb_art', 0, 100);
//        var_dump($ret);exit;
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
