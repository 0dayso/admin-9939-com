<!-- 第一个广告位 -->
<?php
$ads = new \common\models\ads\Ads();
$content = $ads->ads(4556);
if (isset($content) && !empty($content)){
echo $content;
}