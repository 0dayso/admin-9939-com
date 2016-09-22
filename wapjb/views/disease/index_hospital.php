<h2 class="syart"><?php echo $name; ?><span>医院</span></h2>
<ul class="recom">
    <?php
    require 'index_hospital_data.php';
    $randArr = [];
    $arr = range(0, 9);
    $arr_rand = array_rand($arr, 4);
    foreach ($arr_rand as $k => $v) {
        echo $hospitals[$v];
    }
    ?>
</ul>
<a href="<?php echo yii\helpers\Url::to('/'.$pinyin_initial.'/yy/');?>" class="fimor">点击查看更多<span>></span></a>


