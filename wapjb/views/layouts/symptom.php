<?php

use yii\helpers\Html;
use yii\helpers\Url;

$URI = $_SERVER['REQUEST_URI'];
$URIArr = explode("?", $URI);
$url = $URIArr[0];
$pcUrl = Url::to("@jb_domain".$url);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= Html::encode($this->title['title'])?></title>
        <meta name="keywords" content="<?= Html::encode($this->title['keywords'])?>" />
        <meta name="description" content="<?= Html::encode($this->title['description'])?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="applicable-device"content="mobile">
        <link rel="canonical" href="<?php echo $pcUrl;?>">
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
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <article class="head"><a href="<?php echo Url::home(true); ?>"></a><span><?php echo $this->params['name'];?></span><a href="/jbzz/" class="setn"></a><a class="clna"></a></article>
        <!--导航栏展开 start-->
        <?php echo $this->render('/include/navigation'); ?>
        <!--导航栏展开 ends-->

        <?= $content ?>
        
        <?php echo$this->render('/include/hot_pic'); ?>

        <!--广告位-->
        <div class="adv">
            <?php echo $this->render('/include/ads_below_hotpic'); ?>
        </div>
        <div class="thre"></div>
        <?php echo $this->render('/include/health_assistant'); ?>
        <?php echo $this->render('/include/footer'); ?>
        <!--整站通发代码 start -->
        <?php echo $this->render('/include/ads_common_all'); ?>
        <!--整站通发代码 end -->

        <?php $this->endBody() ?>
    </body>
</html>

