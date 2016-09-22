<?php
/**
 * 疾病图集最后位置----广告
 */

if ($this->beginCache('wapjb_article_disease_images_ending_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4577);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}

