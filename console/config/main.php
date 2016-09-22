<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/params'.YII_DB_ENV.'.php')
);

return [
    'id' => 'app-console',
    'vendorPath' => YII_LIB_PATH,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'search'=>[
            'class'=>'librarys\extensions\search\Sphinx',
            'servers'=>[
                [
                    'host'=>'192.168.220.195',
                    'port'=>'9312',
                ]
            ]
        ],
        'redis'=>[
            'class'=>'librarys\extensions\caching\RedisCache',
            'servers'=>[
                [
                    'host'=>'192.168.220.196',
                    'port'=>'6379',
                ]
            ]
        ],
        'cache_file' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix'=>'jb-9939-com-filecache_'
        ],
        'cache_data_file' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix'=>'jb-9939-com-cachedatafile_',
            'cachePath' => '@frontend/runtime/cache/datacache'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];

