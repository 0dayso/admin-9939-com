#!/usr/bin/php
#/usr/bin/php /data/www/develop/code/trunk/admin-9939-com/console/shell/test.php >/dev/null 2>&1 
<?php
$app_path = dirname(__DIR__) ;
require $app_path.'/config/init.php';

$ret = \common\models\Article::search(['articleid'=>434155]);
//
$ret11 = var_export($ret,true);
var_dump($ret11);exit;
$savepath = \Yii::getAlias('@frontend').'/runtime/1.txt';
file_put_contents($savepath,$ret11);
