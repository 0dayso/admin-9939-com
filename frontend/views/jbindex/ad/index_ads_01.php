<?php
$ads = new \common\models\ads\Ads();
$content = $ads->ads(4557);
if (isset($content) && !empty($content)){
echo $content;
}