<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2>疾病专区</h2>
<ul class="rade inpu">
    <?php
    if (isset($diseaseZone) && !empty($diseaseZone)) {
        foreach ($diseaseZone as $k => $v) {
            ?>
            <li><a href="<?php echo $v; ?>"><?php echo $k; ?></a></li>
            <?php
        }
    }
    ?>
</ul>

