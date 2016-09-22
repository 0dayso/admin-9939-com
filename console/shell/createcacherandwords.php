#!/usr/bin/php
#/usr/bin/php /data/www/develop/code/trunk/admin-9939-com/console/shell/createcacherandwords.php >/dev/null 2>&1

<?php
$app_path = dirname(__DIR__) ;
require $app_path.'/config/init.php';

\common\models\KeyWords::createCacheRandWords(
        array(
                array(
                    'filter'=>'filter',
                    'args'=>array('typeid',array(99))
                )
        )
);
\common\models\KeyWords::createCacheRandWords(
        array(
                array(
                    'filter'=>'filter',
                    'args'=>array('typeid',array(0,2,3,4,5,6,7,8,9))
                )
        )
);

