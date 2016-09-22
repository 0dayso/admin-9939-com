<?php
/**
 * 疾病文章页第二个个广告
 */

if ($this->beginCache('wapjb_article_disease_second_ads', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
    $ads = new \common\models\ads\Ads();
    $content = $ads->ads(4579);
    if (isset($content) && !empty($content)){
        echo $content;
    }
    $this->endCache();
}

?>

<!--<li>
    <a href="">
        <img src="images/hot_01.jpg" alt="">
        <p>贝克汉姆登上杂志刊封面</p>
    </a>
    <a href="">
        <img src="images/hot_02.jpg" alt="">
        <p>李敏镐拍写真 卧床撒娇</p>
    </a>
</li>
<li>
    <a href="">
        <img src="images/hot_01.jpg" alt="">
        <p>贝克汉姆登上杂志刊封面</p>
    </a>
    <a href="">
        <img src="images/hot_02.jpg" alt="">
        <p>李敏镐拍写真 卧床撒娇</p>
    </a>
</li>-->

