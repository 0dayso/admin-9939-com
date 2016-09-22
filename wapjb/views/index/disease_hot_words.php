<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2>疾病热词</h2>
<ul class="rade inpu">
    <?php
    if (isset($disease_hot_words) && !empty($disease_hot_words)) {
        $hot_words = array_shift($disease_hot_words);
        foreach ($hot_words['disease'] as $k => $v) {
            $url = Url::to('/' . $v['pinyin_initial'] . '/');
            ?>
            <li><a href="<?php echo $url; ?>"><?php echo $v['name']; ?></a></li>
            <?php
        }
    }
    ?>

</ul>
