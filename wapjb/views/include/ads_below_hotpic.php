<?php

/**
 *  热图推荐下方广告
 *  通用
 */
if ($this->beginCache('wapjb_below_hotpic', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4576);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
