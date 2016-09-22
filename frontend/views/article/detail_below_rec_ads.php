<!--<script type="text/javascript">
var cpro_id="u2302991";
(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"660",rsi1:"60",pat:"3",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"1",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",tft:"0",tlt:"1"}
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>-->

<?php
if ($this->beginCache('frontend_article_detail_belowrecads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4551);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
