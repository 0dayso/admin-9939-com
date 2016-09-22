<?php
$ads = new \common\models\ads\Ads();
$content = $ads->ads(4559);
if (isset($content) && !empty($content)){
echo $content;
}