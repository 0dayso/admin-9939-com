<?php
/**
 * 疾病页面 通用 第一个广告
 */

if ($this->beginCache('wapjb_disease_common_first', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4586);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}