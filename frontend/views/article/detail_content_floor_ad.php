
<!-- 文章下面部分的广告位 -->

<?php
if ($this->beginCache('frontend_article_detail_contentfloorad', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4550);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
?>

<!--<script type="text/javascript">
    var cpro_id="u2305398";
    (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"670",rsi1:"120",pat:"3",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"0",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#006600",titSU:"0",tft:"0",tlt:"0"}
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>-->