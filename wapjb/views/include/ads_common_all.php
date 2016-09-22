<?php

/**
 * 整站 通用
 */
//疾病wap端整站图+   ID：4583
if ($this->beginCache('wapjb_station_map', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4583);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
//疾病wap端整站智能场景  ID：4584
if ($this->beginCache('wapjb_intelligent_scene', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4584);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
//疾病wap端整站搜索推荐  ID：4585
if ($this->beginCache('wapjb_search_recommendation', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4585);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}

//疾病wap端整站统计  ID：4588
if ($this->beginCache('wapjb_search_statistic', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4588);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
