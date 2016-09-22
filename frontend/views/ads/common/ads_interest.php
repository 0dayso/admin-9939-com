<?php

if ($this->beginCache('jb_ads_common_left_bottom', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $ads_interest = $ads->ads(4543);
    if (isset($ads_interest) && !empty($ads_interest)) {
        echo $ads_interest;
    }
    $this->endCache();
}
?>
