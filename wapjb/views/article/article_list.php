<!-- 疾病文章列表页 -->

<?php
use yii\helpers\Html;
$this->title =  '疾病文章_久久健康网';
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
<header>
    <a href=""><h1></h1></a>
    <a class="clna"></a>
</header>

<!--导航栏展开-->
<?php echo $this->render('detail_right_more'); ?>
<!--ends-->

<article class="dare">
    <?php echo $this->render('/include/search', ['class' => 'finput']); ?>
</article>

<div class="thre"></div>
<article class="raatu dream">

    <?php
    if (isset($article) && !empty($article)) {
        foreach ($article as $art){
            $url = '/article/'. date('Y/md', $art['inputtime']) .'/'. $art['id'] .'.shtml';
    ?>
            <a href="<?php echo $url; ?>" title="<?php echo $art['title']; ?>">
                <h3><?php echo \librarys\helpers\utils\String::cutString($art['title'], 14); ?></h3>
                <p>
                    <?php echo \librarys\helpers\utils\String::cutString($art['description'], 45); ?>
                </p>
            </a>
    <?php
        }
    }
    ?>
</article>
<section class="sechoi">
    <div class="lasp">
        <?php echo $paging->view();?>
    </div>
</section>

<div class="redis clearfix"></div>

<div class="apal insad" style="margin-top:-.2rem;">
    <?php echo $this->render('article_list_first_ads'); ?>
</div>
<div class="apal insad">
    <?php echo $this->render('article_list_second_ads'); ?>
</div>

<div class="thre"></div>
<article class="dissy">
    <a href="/zicha/">
        <p>
            <img src="/images/disc.png"></p>
        <p>
            病急不再乱投医，
            <span>马上开始自查></span>
        </p>
    </a>
</article>

<div class="thre"></div>
<article class="exname">
    <div class="expin">
        <a href="http://wapask.9939.com/ask/goAskDoctor">
            <img src="/images/logre.png" alt=""></a>
        <p>专家与您一对一答疑</p>
        <p>
            <span>免费提问</span>
            及时解答
        </p>
    </div>
    <div class="eimg">
        <img src="/images/rexp_01.jpg" alt="">
        <img src="/images/rexp_02.jpg" alt="">
        <img src="/images/rexp_03.jpg" alt="">
        <img src="/images/rexp_04.jpg" alt="">
        <img src="/images/rexp_05.jpg" alt=""></div>
</article>

<div class="thre"></div>

<!-- 底部通用部分 Start -->
<?php echo $this->render('article_common_footer'); ?>
<!-- 底部通用部分 End -->

<!-- 通用部分 -->
<?php echo $this->render('/include/ads_common_all'); ?>

<script type="text/javascript">
    $(function(){
        //症状自查3，症状自查4头部浮动
        var defc=$('.dare').offset().top;
        $(window).scroll(function(){

            if($(window).scrollTop()>=defc){
                $('.dare').addClass('fifix');
            }
            else if($(window).scrollTop()<defc){
                $('.dare').removeClass('fifix');
            }
        });

    });
</script>
</body>
</html>