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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="applicable-device"content="mobile">
        <link rel="canonical" href="<?php echo $pcUrl;?>">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script src="/js/jquery-1.11.2.min.js"></script>
        <script src="/js/detail.js"></script>
        <?php $this->head(); ?>
    </head>
    <body ontouchstart="">
        <?php $this->beginBody() ?>
        <article class="head"><a href="/"></a><span>症状自查</span><a href="/jbzz/" class="setn"></a><a class="clna"></a></article>
        <!--导航栏展开 start-->
        <?php echo $this->render('/include/navigation');?>
        <!--导航栏展开 ends-->
        
        <?= $content ?>
        
        
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage()?>