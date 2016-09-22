<?php
/**
 * 疾病首页第一个广告
 */

if ($this->beginCache('wapjb_disease_index_first', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4587);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
