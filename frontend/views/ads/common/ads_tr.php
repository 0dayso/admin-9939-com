<?php

if ($this->beginCache('jb_ads_common_right_bottom', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $ads_tr = $ads->ads(4544);
    //右上角广告
    if (isset($ads_tr) && !empty($ads_tr)) {
        echo $ads_tr;
    }
    $this->endCache();
}
?>