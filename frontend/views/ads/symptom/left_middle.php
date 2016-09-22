<?php

//症状首页左侧广告
if ($this->beginCache('jb_ads_symptom_left_middle', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $ads_lm = $ads->ads(4554);
    if (isset($ads_lm) && !empty($ads_lm)) {
        echo $ads_lm;
    }
    $this->endCache();
}
?>

