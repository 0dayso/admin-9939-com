<?php
use yii\helpers\Html;
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}图片_${diseaseName}症状图片_${diseaseName}图片大全_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName}图片,${diseaseName}症状图片,${diseaseName}图片大全",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}图片、${diseaseName}症状图片、${diseaseName}图片大全等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo $this->title; ?></title>
    <meta name="keywords" content="<?= Html::encode($this->metaTags['keywords']); ?>" />
    <meta name="description" content="<?= Html::encode($this->metaTags['description']); ?>" />
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="applicable-device"content="mobile">
    <meta name="format-detection" content="telephone=no">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-retina.png">

    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>

    <!--slide滚动-->
    <script type="text/javascript" src="/imjs/zepto.min.js"></script>
    <script type="text/javascript" src="/imjs/swipe.min.js"></script>
    <script src="/imjs/gundong.js"></script>
    <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
    <script type="text/javascript" src="/js/slide.js"></script>
    <!--ends-->
</head>
<body class="clor-2">
<div class="oubra disn"></div>

<!-- 分享部分 Start -->
<div class="sio fred disn">
    <div class="cdoer">
        <!-- 分享部分 Start -->
        <?php echo $this->render('share', ['title' => $disease['name']]); ?>
        <!-- 分享部分 End -->
    </div>
    <p class="cairet">取消</p>
</div>
<!-- 分享部分 Start -->

<?php
$absolutePath = \Yii::$app->params['uploadPath']['disease']['path'];
$path = '/' . strstr($absolutePath, 'uploads');
$domain = \Yii::$app->params['uploadPath']['disease']['domain'];
?>

<article id="slider2" class="swipe">
    <ul class="revri clearfix">
        <?php
        $diseaseName =  $disease['name'];
        if (isset($imagesList) && !empty($imagesList)) {
            $total = count($imagesList);
            foreach ($imagesList as $key => $image){
                $imageURL = $domain . $path . $image['name'];
        ?>
                <li class="iask_day" data-index="<?php echo $key + 1; ?>">
                    <article class="head imsy">
                        <a href="/<?php echo $disease['pinyin_initial']; ?>/"></a>
                        <span><?php echo $diseaseName; ?>图集</span>
                        <a class="lstrc"></a>
                    </article>

                    <div class="l-heroud">
                        <img src="<?php echo $imageURL; ?>" alt="<?php echo $diseaseName; ?>" tltle="<?php echo $diseaseName; ?>">
                    </div>
                    <section class="str-tit clearfix">
                        <div class="surnum">
                            <i class="bodro"><?php echo $key + 1; ?></i>
                            /
                            <i class="allnum"><?php echo $total; ?></i>
                        </div>
                    </section>
                </li>
        <?php
            }
        }
        ?>

        <!-- 相关文章部分 Start -->
        <li class="iask_day" data-index="5">
            <article class="head imsy disin">
                <a href="/<?php echo $disease['pinyin_initial']; ?>/"></a>
                <span></span>
                <a href="/">疾病库首页</a>
            </article>
            <article class="slout">
                <ul class="comruh clearfix">

                    <?php
                    if (isset($relDiseaseImages) && !empty($relDiseaseImages)) {
                        foreach ($relDiseaseImages as $relDiseaseImage){
                            $relImageURL = '/images/ache.jpg';
                            if (isset($relDiseaseImage['images']) && !empty($relDiseaseImage['images'])){
                                $relImageURL = $domain . $path . $relDiseaseImage['images']['name'];
                            }
                    ?>
                            <li>
                                <a href="/<?php echo $relDiseaseImage['disease']['pinyin_initial']; ?>/tuji/">
                                    <div class="">
                                        <img src="<?php echo $relImageURL; ?>"
                                             alt="<?php echo $relDiseaseImage['disease']['name']; ?>"
                                             title="<?php echo $relDiseaseImage['disease']['name']; ?>"/>
                                    </div>
                                    <span><?php echo $relDiseaseImage['disease']['name']; ?></span>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <!-- 百度广告位 Start -->
                    <?php echo $this->render('disease_images_ads_ending'); ?>
                    <!-- 百度广告位 End -->
                </ul>
            </article>

        </li>
        <!-- 相关文章部分 End -->
    </ul>
</article>

<script type="text/javascript">
    $(function(){
        $('.revri').css({'font-size':'100%','height':'420px'});

        $('.revri>li').height(440);

        $('.revri').find('>li:last').css('vertical-align','top');

        /*var heis=$(window).height();
         var heir=heis-88;*/
        var rheight=0;//记录原来图片域的高度

        /*获取图片路径*/
        var ind=$('.swipe li').find(':first img').attr('src');
        $('.doar').css('background-image','url('+ind+')');

        $('.doarr').click(function(){
            var intervalID=0;
            rheight=400;//获取原div高度，用于还原
            $(this).removeClass('shol').addClass('dino');

            $('.lispa,.rehea,.nfa').removeClass('dino').addClass('shol');
            $('.nfa').removeClass('disn').addClass('shay');
            $('.reagin').removeClass('shol').addClass('dino');
            $('.imsy' ).height(0).removeClass('shol').addClass('dino');

            $('.resy').addClass('nres').appendTo($('.apeand'));

            var fundisp=function(){
                var hei=$(".swipe").height();
                var heisa=hei/10;
                //保留80px高度，使标题栏出现
                if(hei>0){

                    $(".swipe").height(hei-heisa);//逐渐减小高度
                }else{
                    clearInterval(intervalID);
                }
            }
            intervalID=setInterval(fundisp,0.1);
        });
        $('.doar').click(function(){
            var intervalID2=0;
            //var wheight=$(window).height()-80;
            $('.lispa,.rehea').removeClass('shol').addClass('dino');
            $('.doarr,.reagin').removeClass('dino').addClass('shol');
            $('.nfa').removeClass('shay').addClass('disn');
            $('.imsy' ).height('44px').removeClass('dino').addClass('shol');
            var fundisp2=function(){
                var hei=$(".swipe").height();

                if(hei<heir-33){
                    $(".swipe").height(hei+heir/10);
                }else{
                    clearInterval(intervalID2);
                }
            }
            intervalID2=setInterval(fundisp2,2);
        });
    });
</script>
<script type="text/javascript">

    /*2.2*/
    window.mySwipe = new Swipe(document.getElementById('slider2'), {
        startSlide: 0,
        speed:0,
        auto:0,
        continuous: false,
        disableScroll: false,
        stopPropagation: false,
        callback: function(index,elm) {
            var i = bullets.length;
            while (i--) {
                bullets[i].className = ' ';
            }
            bullets[index].className = 'current';
        },
        transitionEnd: function(index, elem) {
            var cuva=$(elem).find("img").attr("src");
            $('.doar').css('background-image','url('+cuva+')');

        }
    });
    var bullets = document.getElementById('curren_bar').getElementsByTagName('span');

</script>

<!-- 通用部分 -->
<?php echo $this->render('/include/ads_common_all'); ?>

</body>
</html>