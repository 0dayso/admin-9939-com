<!-- 疾病文章页 -->

<?php
use yii\helpers\Html;
$this->title =  $article['title'] . "_久久健康网";
$this->metaTags = [
    'keywords' => "",
    'description' => "",
];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $this->title; ?></title>
    <meta name="keywords" content="<?= Html::encode($this->metaTags['keywords']); ?>" />
    <meta name="description" content="<?= Html::encode($this->metaTags['description']); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>

    <!--slide滚动-->
    <script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
    <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
    <script src="/js/slide.js"></script>
    <!--ends-->
</head>
<body>
<article class="head">
    <a href=""></a>
    <span>
        <?php
        if (isset($disease['name']) && !empty($disease['name'])) {
            echo $disease['name'];
        }else{
            echo '正文';
        }
        ?>
    </span>
    <a href="" class="setn"></a>
    <a class="clna"></a>
</article>

<!--导航栏展开-->
<?php echo $this->render('/include/navigation'); ?>
<!--ends-->

<article class="breas">
    <a href="http://m.9939.com">首页</a><span>></span>
    <a href="/">疾病百科</a><span>></span>
    <?php
    if (isset($disease['name']) && !empty($disease['name'])) {
        ?>
        <a href="/<?php echo $disease['pinyin_initial']; ?>/"><?php echo $disease['name']; ?></a>
    <?php
    }else{
        ?>
        <a href="javascript:;">正文</a>
    <?php
    }
    ?>
</article>

<h1 class="autu"><?php echo $article['title']; ?></h1>
<article class="sourc">
    <span><?php echo date('Y-m-d', $article['inputtime']); ?></span>
    <span><?php echo $article['copyfrom']; ?></span>
    <a> A <sup>+</sup></a>
</article>

<!-- 第一个广告 Start -->
<div class="adv">
    <?php echo $this->render('detail_first_ads'); ?>
</div>
<!-- 第一个广告 End -->

<article class="bocon artpa auwin">
    <!--<img src="images/imdes.jpg" alt="">-->
    <p class="inde">
        <?php echo strip_tags($article['content'],  '<a>' ); ?>
    </p>
</article>
<a class="loama">点击查看更多</a>

<!-- 分享部分 Start -->
<?php echo $this->render('share', ['title' => $article['title']]); ?>
<!-- 分享部分 End -->

<ul class="patran">
    <li>
        <span>上一篇：</span>
        <a href="<?php echo '/article/' . date('Y/md', $preArticle['inputtime']) . '/' . $preArticle['id'] . '.shtml'; ?>">
            <?php echo \librarys\helpers\utils\String::cutString($preArticle['title'], 17); ?>
        </a>
    </li>
    <li>
        <span>下一篇：</span>
        <a href="<?php echo '/article/' . date('Y/md', $nextArticle['inputtime']) . '/' . $nextArticle['id'] . '.shtml'; ?>">
            <?php echo \librarys\helpers\utils\String::cutString($nextArticle['title'], 17); ?>
        </a>
    </li>
</ul>

<div class="main_i capture">
    <ul>
        <!-- 第二个广告位 Start -->
        <?php echo $this->render('detail_second_ads'); ?>
        <!-- 第二个广告位 End -->
    </ul>
</div>
<div class="thre"></div>

<?php
if (isset($disease['name']) && !empty($disease['name'])) {
    ?>
    <h2>疾病相关</h2>
    <div class="redis clearfix">
        <?php echo $this->render('detail_disease_related', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>
    </div>
    <?php
}
?>

<!-- 第三个广告位 Start -->
<div class="apal insad" style="margin-top:-.2rem;">
    <?php echo $this->render('detail_third_ads'); ?>
</div>
<!-- 第三个广告位 End -->

<!-- 第四个广告位 Start -->
<div class="apal insad">
    <?php echo $this->render('detail_fourth_ads'); ?>
</div>
<!-- 第四个广告位 End -->

<div class="thre"></div>
<h2>相关文章</h2>
<article class="raatu">
    <?php
    if (isset($relArticles) && !empty($relArticles)) {
        foreach ($relArticles as $key => $relArticle){
            if (!isset($relArticle['wap_url'])){
                $relArticle['wap_url'] = '/article/' . date('Y/md', $relArticle['inputtime']) . '/' . $relArticle['id'] . '.shtml';
            }
            if ($key == 4){
                break;
            }
        ?>
            <a href="<?php echo $relArticle['wap_url']; ?>"
                title="<?php echo $relArticle['title']; ?>">
                <h3><?php echo \librarys\helpers\utils\String::cutString($relArticle['title'], 14); ?></h3>
                <p><?php echo \librarys\helpers\utils\String::cutString($relArticle['description'], 48); ?></p>
            </a>
    <?php
        }
    }
    ?>
</article>

<!-- 第五个广告位 Start -->
<div class="main_i capture">
    <ul>
        <?php echo $this->render('detail_fifth_ads'); ?>
    </ul>
</div>
<!-- 第五个广告位 End -->

<a href="/article_list.shtml" class="fimor">
    点击查看更多
    <span>&gt;</span>
</a>

<div class="thre"></div>

<h2>疾病问答</h2>
<ul class="upda">
    <?php
    if (isset($asks) && !empty($asks)) {
        foreach ($asks as $askKey => $ask){
            if ($askKey == 4){
                break;
            }
        ?>
            <li>
                <h3>
                    <span>Q</span>
                    <a href="http://wapask.9939.com/id/<?php echo $ask['ask']['id']; ?>.html" title="<?php echo $ask['ask']['title']; ?>">
                        <?php echo $ask['ask']['title']; ?>
                    </a>
                </h3>
                <p>
                    <span>A</span>
                    <?php
                    if (isset($ask['answer']) && !empty($ask['answer'])) {
                        if (!empty($ask['answer']['content'])){
                        ?>
                            <?php echo \librarys\helpers\utils\String::cutString($ask['answer']['content'], 92); ?>
                    <?php
                        }else{
                        ?>
                            <?php echo \librarys\helpers\utils\String::cutString($ask['answer']['suggest'], 92); ?>
                    <?php
                        }
                    }
                    ?>
                </p>
                <div></div>
            </li>
    <?php
        }
    }
    ?>
</ul>
<div class="main_i capture">
    <ul>
        <?php echo $this->render('detail_sixth_ads'); ?>
    </ul>
</div>
<a href="http://wapask.9939.com" class="fimor">
    点击查看更多
    <span>></span>
</a>
<div class="thre"></div>

<!-- 推荐专家部分 Start -->
<?php
$diseasePinYin_initial = '';
if (isset($disease['pinyin_initial']) && !empty($disease['pinyin_initial'])) {
    $diseasePinYin_initial = $disease['pinyin_initial'];
}
?>
<?php echo $this->render('detail_bottom_doctor', ['pinyin_initial' => $diseasePinYin_initial, 'doctors' => $doctors]); ?>
<!-- 推荐专家部分 End -->

<div class="thre"></div>

<!-- 底部通用部分 Start -->
<?php echo $this->render('article_common_footer'); ?>
<!-- 底部通用部分 End -->

<!-- 通用部分 -->
<?php echo $this->render('/include/ads_common_all'); ?>

</body>
</html>