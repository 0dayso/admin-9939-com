<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

if (isset($articles) && !empty($articles)) {
    foreach ($articles as $k => $v) {
        $url = '/article/' . date("Y/md", $v["inputtime"]) . '/' . $v['id'] . '.shtml';
        $title = String::cutString($v['title'], 20);
        $content = !empty($v['description']) ? strip_tags($v['description']) : strip_tags($v['content']);
        ?>

        <a href="<?php echo $url; ?>"><h3><?php echo $title; ?></h3><p><?php echo $content; ?></p></a>
        <?php
    }
}
?>