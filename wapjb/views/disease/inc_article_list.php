<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<?php
if (!empty($article)) {
    foreach ($article as $k => $v) {
        $url = '/article/' . date("Y/md", $v["inputtime"]) . '/' . $v['id'] . '.shtml';
        ?>
        <a href="<?php echo Url::to($url); ?>">
            <h3><?php echo String::cutString($v['title'], 22) ?></h3>
            <p><?php echo!empty($v['description']) ? String::cutString($v['description'], 42) : String::cutString(strip_tags($v['content']), 42); ?></p>
        </a>
        <?php
    }
}
?>

