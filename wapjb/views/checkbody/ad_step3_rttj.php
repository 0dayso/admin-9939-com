<?php
if ($this->beginCache('wapjb_zicha_step3_xgrs', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4582);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
?>