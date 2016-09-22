<?php

use yii\helpers\Url;
use yii\helpers\Html;

$URI = $_SERVER['REQUEST_URI'];
$URIArr = explode("?", $URI);
$url = $URIArr[0];
$pcUrl = Url::to("@jb_domain".$url);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="applicable-device"content="mobile">
        <link rel="canonical" href="<?php echo $pcUrl;?>">

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
        <?php echo $content; ?>
        <?php echo $this->render("/include/footer"); ?>
        <!--整站通发代码 start -->
        <?php echo $this->render('/include/ads_common_all'); ?>
        <!--整站通发代码 end -->
<?php $this->endBody() ?>
    </body>
</html>
