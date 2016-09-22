<?php
/**
 * 症状首页第二个广告
 */

if ($this->beginCache('wapjb_symptom_index_second_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4575);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
