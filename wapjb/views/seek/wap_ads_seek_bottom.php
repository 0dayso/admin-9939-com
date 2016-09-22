<?php

//疾病wap端热图推荐奇趣广告通发
//if ($this->beginCache('wapjb_below_hotpic', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4582);
    if (isset($ads_br) && !empty($ads_br)) {
        echo $ads_br;
    }
//    $this->endCache();
//}
