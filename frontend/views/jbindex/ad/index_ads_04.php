<?php
$ads = new \common\models\ads\Ads();
$content = $ads->ads(4560);
if (isset($content) && !empty($content)){
echo $content;
}