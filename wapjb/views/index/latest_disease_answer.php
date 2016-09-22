<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2>最新疾病问答</h2>
<ul class="upda">
    <?php
    if (isset($latest_disease_answer) && !empty($latest_disease_answer)) {
        foreach ($latest_disease_answer as $k => $v) {
            $url = Url::to('@wapask/id/' . $v['id'] . '.html'); //'http://wapask.9939.com/id/3968375.html';
            ?>

            <li>
                <h3><span>Q</span><a href="<?php echo $url; ?>"><?php echo $v['title']; ?></a></h3>
                <p><span>A</span><?php echo $v['content']; ?></p><div></div>
            </li>
            <?php
        }
    }
    ?>
</ul>
<a href="<?php echo Url::to('@wapask'); ?>" class="fimor">点击查看更多<span>></span></a>

