<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    
    'uploadPath' => [
                    'symptom' => [
                                    'path' => PROJECT_PATH.'uploads/symptom/',
                                    'domain' => \Yii::getAlias("@fileserver"),
                                    'file_base_path'=>\Yii::getAlias("@fileserver").'/uploads/symptom/',
                                    'api_id' => '123456',
                                    'api_key' => '',
                                ],
                    'article' => [
                        'path' => PROJECT_PATH.'uploads/cms/article/',
                        'domain' => \Yii::getAlias("@fileserver"),
                        'file_base_path'=>\Yii::getAlias("@fileserver").'/uploads/cms/article/',
                        'api_id' => '123456',
                        'api_key' => '',
                    ],
                    'disease' => [
                        'path' => PROJECT_PATH.'uploads/disease/',
                        'domain' => \Yii::getAlias("@fileserver"),
                        'file_base_path'=>\Yii::getAlias("@fileserver").'/uploads/disease/',
                        'api_id' => '123456',
                        'api_key' => '',
                    ],
                    'ad' => [
                        'path' => PROJECT_PATH.'uploads/ad/',
                        'domain' => \Yii::getAlias("@fileserver"),
                        'file_base_path'=>\Yii::getAlias("@fileserver").'/uploads/ad/',
                        'api_id' => '123456',
                        'api_key' => '',
                    ],
    ],
];
