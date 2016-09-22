<?php
/**
 * 相关阅读 ------ 广告
 */
if ($this->beginCache('frontend_disease_common_xgrd', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4547);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
