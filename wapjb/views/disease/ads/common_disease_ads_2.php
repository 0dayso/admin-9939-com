<?php
/**
 * 疾病页面 通用 第二个广告
 */

if ($this->beginCache('wapjb_disease_common_second', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4575);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}