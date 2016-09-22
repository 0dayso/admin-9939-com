<?php
return [
    'components' => [
        'db_service' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.220.189;dbname=9939_com_service',
            'username' => '9939_com_v2sns',
            'password' => 'snsrewou#*&#inewk',
            'charset' => 'utf8',
            'tablePrefix' => '',
            // 配置从服务器
            'slaveConfig' => [
                'username' => '9939_com_v2sns',
                'password' => 'snsrewou#*&#inewk',
                'charset' => 'utf8',
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],

            // 配置从服务器组
            'slaves' => [
                ['dsn' => 'mysql:host=192.168.220.189;dbname=9939_com_service']
            ],
        ]
    ],
];
