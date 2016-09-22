<?php
/**
 * 疾病文章页第三个个广告
 */

if ($this->beginCache('wapjb_article_disease_third_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4586);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
