<!-- 文章内容上面部分的广告 -->

<!--<script type="text/javascript">
    /*久久疾病库内容页广告位二左侧文章摘要下方*/
    var cpro_id = "u2302983";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>-->

<?php
if ($this->beginCache('frontend_article_detail_contentupperad', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4549);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}
