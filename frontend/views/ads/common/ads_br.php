<?php

//右下角广告
if ($this->beginCache('jb_ads_common_right_top', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4545);
    if (isset($ads_br) && !empty($ads_br)) {
        echo $ads_br;
    }
    $this->endCache();
}
?>

