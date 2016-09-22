<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/params'.YII_DB_ENV.'.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
        //url路由美化，伪静态
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,//隐藏index.php
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            ],
        ],
        'im' => [
            'class' => 'librarys\extensions\message\Client',
            'config' => [
                'ClassPath' => '\librarys\extensions\message\rongcloud\Server',
                'AppKey' => 'n19jmcy59ndu9',
                'AppSecret' => '2N23h3Remd',
                'Format' => 'json'
            ]
        ],
//        'im'=>[
//            'class'=>'librarys\extensions\message\Client',
//            'config' => [
//                'ClassPath' => '\librarys\extensions\message\im\Server',
//                'AppKey'=>'54e43d5b013e65f64d78cc3d15dd9a4d',
//                'AppSecret'=>'31b8495fecac'
//            ]
//        ],
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
            'errorAction' => 'upload/error',
        ],
    ],
    'params' => $params,
];
