<?php
return [
    'vendorPath' => TEMP_PATH . '/data/lib/lib-yii2-framework',
//    'vendorPath' => 'E:/web/php/develop/code/trunk/lib-yii2-framework/',
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
        'request'=>[
            'enableCsrfValidation' => false,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
