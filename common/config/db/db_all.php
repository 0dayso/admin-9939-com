<?php
return [
    'components' => [
        'db_all' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.220.185;dbname=9939_com_v2jb',
            'username' => 'indata',
            'password' => '1qazxsw2',
            'charset' => 'utf8',
            'tablePrefix' => '9939_',
            // 配置从服务器
            'slaveConfig' => [
                'username' => 'indata',
                'password' => '1qazxsw2',
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
