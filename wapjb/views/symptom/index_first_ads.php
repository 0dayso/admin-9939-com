<?php
/**
 * 症状首页第一个广告
 */

if ($this->beginCache('wapjb_symptom_index_first_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4586);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
