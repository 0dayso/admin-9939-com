<!-- 疾病文章页：右侧第二个广告位 -->
<!--<script type="text/javascript">
    var cpro_id="u2303355";
    (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"300",rsi1:"250",pat:"3",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"0",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",tft:"0",tlt:"1"}
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
-->

<?php
if ($this->beginCache('frontend_article_detail_rightad02', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4553);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
