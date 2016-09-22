<?php
/**
 * 疾病wap端内容页疾病相关下  ID：4586
 */
if ($this->beginCache('wapjb_symptom_hot_search', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4586);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
?>