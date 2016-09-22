<?php
return [
    'components' => [
        'db_dzjb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.220.185;dbname=9939_com_dzjb',
            'username' => '9939_com_dzjb',
            'password' => 'dzjb!(&20101008new$%^',
            'charset' => 'utf8',
            'tablePrefix' => '',
            // 配置从服务器
            'slaveConfig' => [
                'username' => '9939_com_dzjb',
                'password' => 'dzjb!(&20101008new$%^',
                'charset' => 'utf8',
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],

            // 配置从服务器组
            'slaves' => [
                ['dsn' => 'mysql:host=192.168.220.168;dbname=9939_com_dzjb']
            ],
        ]
    ],
];
