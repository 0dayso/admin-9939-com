<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2>当季多发疾病</h2>
<article class="keyw">
    <?php
    if (isset($seasonal_disease) && !empty($seasonal_disease)) {
        $disease = array_shift($seasonal_disease);
        foreach ($disease['disease'] as $k => $v) {
        $url = Url::to('/' . $v['pinyin_initial'] . '/');
        if ($k == 0 || $k == 3 || $k == 7) {
            echo '<p>';
        }
        echo '<a href="' . $url . '">' . $v['name'] . '</a>';
        if ($k == 2 || $k == 6 || $k == 7) {
            echo '</p>';
        }
    }
    }
    ?>
</article>

