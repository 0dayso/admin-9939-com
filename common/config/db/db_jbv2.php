<?php
return [
    'components' => [
        'db_jbv2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.220.185;dbname=9939_com_v2jb',
            'username' => '9939_com_v2jb',
            'password' => 'wiiC4U04bNM6kn5k',
            'charset' => 'utf8',
            'tablePrefix' => '9939_',
            // 配置从服务器
            'slaveConfig' => [
                'username' => '9939_com_v2jb',
                'password' => 'wiiC4U04bNM6kn5k',
                'charset' => 'utf8',
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],

            // 配置从服务器组
            'slaves' => [
                ['dsn' => 'mysql:host=192.168.220.168;dbname=9939_com_v2jb']
            ],
        ]
    ],
];
