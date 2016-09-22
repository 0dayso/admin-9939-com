<?php
/**
 * 疾病文章中间----广告
 */

if ($this->beginCache('frontend_article_detail_middle_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4574);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}

