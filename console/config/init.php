<?php
defined('APP_CACHE_PREFIX') or define('APP_CACHE_PREFIX','JB-9939-COM_');//缓存前缀
defined('CACHE_AD_TIME') or define('CACHE_AD_TIME', 24*3600);
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_ENV_DEV') or define('YII_ENV_DEV', YII_ENV === 'dev');
if(YII_ENV_DEV){
    defined('YII_DB_ENV') or define('YII_DB_ENV', '-local');
    defined('YII_LIB_PATH') or define('YII_LIB_PATH','/data/lib/lib-yii2-framework/');
    defined('PROJECT_PATH') or define('PROJECT_PATH', '/data/www/develop/code/trunk/admin-9939-com/frontend/web/');
    //defined('YII_LIB_PATH') or define('YII_LIB_PATH','E:/web/php/develop/code/trunk/lib-yii2-framework/');
    //defined('PROJECT_PATH') or define('PROJECT_PATH', 'E:/web/php/develop/code/trunk/admin-9939-com/frontend/web/');
}else{
    defined('YII_DB_ENV') or define('YII_DB_ENV', '');
    defined('YII_LIB_PATH') or define('YII_LIB_PATH','/data/web/framework/lib-yii2-framework/');
    defined('PROJECT_PATH') or define('PROJECT_PATH', '/data/web/jb-9939-com/frontend/web/');
}

require(YII_LIB_PATH. '/autoload.php');
require(YII_LIB_PATH. '/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/db/db_jbv2'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/../../common/config/db/db_portal'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/../../common/config/db/db_v2'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/../../common/config/db/db_v2sns'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/../../common/config/db/db_all'.YII_DB_ENV.'.php'),
    require(__DIR__ . '/../config/main'.YII_DB_ENV.'.php')
);

$application = new yii\console\Application($config);
$application->run();

