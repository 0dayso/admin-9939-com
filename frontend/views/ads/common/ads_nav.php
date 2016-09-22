<?php

if ($this->beginCache('jb_ads_common_header_nav', ['cache' => 'cache_file', 'duration' => 24*3600])) {
    $ads = new \common\models\ads\Ads();
    $ads_tr = $ads->ads(4556);
    //头部通栏广告
    if (isset($ads_tr) && !empty($ads_tr)) {
        echo $ads_tr;
    }
    $this->endCache();
}
?>