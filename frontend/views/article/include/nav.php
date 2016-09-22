<?php

use yii\helpers\Url;
?>

<!--左侧右侧-->
<?php echo $this->render('/include/rightFloat'); ?>
<!--左侧右侧-->

<div class="content bocon">
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="<?php echo Url::home(true); ?>" target="_blank">疾病百科</a>>
        <a><b>文章列表</b></a>
    </div>
</div>
