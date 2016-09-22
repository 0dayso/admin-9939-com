<?php
/**
 * 猜你感兴趣----广告
 */

if ($this->beginCache('frontend_disease_common_cnxh', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4543);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}

