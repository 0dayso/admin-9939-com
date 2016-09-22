<!-- 第一个广告位 -->
<?php
if ($this->beginCache('frontend_disease_index_ads01', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4546);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
