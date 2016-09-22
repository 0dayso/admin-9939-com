<?php
return [
    'components' => [
        'db_service' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.28.50;dbname=9939_com_service',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => '',
            // 配置从服务器
            'slaveConfig' => [
                'username' => 'root',
                'password' => '123456',
                'charset' => 'utf8',
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],

            // 配置从服务器组
            'slaves' => [
                ['dsn' => 'mysql:host=192.168.28.50;dbname=9939_com_service']
            ],
        ]
    ],
];
