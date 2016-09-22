<?php
/**
 * 疾病wap端相关热搜通发 ID：4575
 */
if ($this->beginCache('wapjb_symptom_hot_search', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4575);
    if (isset($content) && !empty($content)) {
        echo $content;
    }
    $this->endCache();
}
?>