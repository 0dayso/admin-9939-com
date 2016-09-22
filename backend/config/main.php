<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/params'.YII_DB_ENV.'.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'basedata' => [
            'class' => 'backend\modules\basedata\module',
        ],
        'system' => [
            'class' => 'backend\modules\system\module',
        ],
        'cms' => [
            'class' => 'backend\modules\cms\module',
        ],
        'generate' => [
            'class' => 'backend\modules\generate\module',
        ],
        'ask' => [
            'class' => 'backend\modules\ask\module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'M4opabTo_bJ3kJb9Lrih4Qbbgkwot8qZ',
        ],
        //url路由美化，伪静态
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,//隐藏index.php
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
