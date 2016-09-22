<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2>最新疾病文章</h2>
<div class="upest">
    <?php
    if (isset($latest_disease_article) && !empty($latest_disease_article)) {
        foreach ($latest_disease_article as $k => $v) {
            $url_article = '/article/' . date("Y/md", $v["inputtime"]) . '/' . $v['articleid'] . '.shtml';
            ?>
            <a href="<?php echo $url_article; ?>"><span><?php echo $v['name']; ?></span><p><?php echo $v['title']; ?></p></a>
            <?php
        }
    }
    ?>

</div>
<a href="<?php echo Url::to('/article_list.shtml'); ?>" class="fimor every"><mark>每日更新！！</mark>点击查看更多<span>></span></a>

