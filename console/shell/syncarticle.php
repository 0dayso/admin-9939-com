#!/usr/bin/php
#/usr/bin/php /data/www/develop/code/trunk/admin-9939-com/console/shell/syncarticle.php >/dev/null 2>&1 
<?php
$app_path = dirname(__DIR__) ;
require $app_path.'/config/init.php';
$articleObj = new \common\models\disease\Article();
$maxid = $articleObj::find()->max('id');//获取最大文章id
$sql = "insert into 9939_com_v2jb.9939_disease_article(id,title,keywords,description,content,inputtime,click,status,username,copyfrom,fjc,url,source,type,updatetime,userid,author,diseaseid )
select id,title,keywords,description,content,UNIX_TIMESTAMP() as inputtime,click,status,username,copyfrom,fjc,url,source,type,UNIX_TIMESTAMP() as updatetime,0 as userid,'' as author,0 as diseaseid 
from 9939_com_dzjb.9939_disease_article where id>{$maxid} order by id asc limit 20000;";
$result = \Yii::$app->db_all->createCommand($sql)->execute();
echo "成功导入了{$result}条文章.";