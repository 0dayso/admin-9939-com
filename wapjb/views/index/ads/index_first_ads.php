<?php

/**
 * 首页相关热搜位置的广告（热图推荐上方）
 */
if ($this->beginCache('wapjb_index_relate_hot_serarch', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4575);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}

