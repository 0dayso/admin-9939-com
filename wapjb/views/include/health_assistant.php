<?php

use yii\helpers\Url;
use common\models\Disease;

$obj_disease = new Disease();
$catId = [25];
$res = $obj_disease->batGetDiseaseByCategoryId($catId);
$tmp = array_slice($res, 0, 8);
?>
<h2>健康助手</h2>
<nav class="asdc">
    <a href="http://wapask.9939.com/ask/goAskDoctor"><span></span><p>问医生</p></a><a href="http://m.jb.9939.com/"><span></span><p>查疾病</p></a><a href="javascript:;"><span></span><p>找医院</p></a><a href="http://m.9939.com/drug/"><span></span><p>找药品</p></a>
</nav>

<article class="prot">
    <?php
    if (!empty($tmp)) {
        foreach ($tmp as $k => $v) {
            $url = Url::to('/' . $v['pinyin_initial'] . '/');
            if ($k % 4 == 0) {
                echo '<p>';
            }
            echo '<a href="' . $url . '">' . $v['name'] . '</a>';
            if ($k % 4 == 3) {
                echo '</p>';
            }
        }
    }
    ?>
</article>

<?php
echo $this->render('/include/search');
?>