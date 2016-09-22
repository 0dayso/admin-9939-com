<?php
use yii\helpers\Html;
use yii\helpers\Url;

$URI = $_SERVER['REQUEST_URI'];
$URIArr = explode("?", $URI);
$url = $URIArr[0];
$wapUrl = Url::to("@mjb_domain".$url);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset; ?>">
        <title><?= Html::encode($this->title); ?></title>
        <?php
        if (isset($this->metaTags['keywords']) && !empty($this->metaTags['keywords'])) {
            ?>
            <meta name="keywords" content="<?= Html::encode($this->metaTags['keywords']); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($this->metaTags['description']) && !empty($this->metaTags['description'])) {
            ?>
            <meta name="description" content="<?= Html::encode($this->metaTags['description']); ?>" />
            <?php
        }
        ?>
        <meta name="applicable-device"content="pc">
        <meta name="mobile-agent" content="format=html5;url=<?php echo $wapUrl;?>" />
        <link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo $wapUrl;?>" >
        <link rel="stylesheet" type="text/css" href="<?php echo Url::to('@jb_domain/css/main.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Url::to('@jb_domain/css/list.css') ?>"/>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/jquery-1.10.2.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/9939_uaredirect_source.js?123456') ?>"></script>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/scrollbar.js') ?>"></script>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/gundong.js') ?>"></script>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/detail.js') ?>"></script>
        <base target="_blank">
    <?php $this->head(); ?>
    </head>
    <?= $this->beginBody() ?>
    <body>

        <!-- 头部 导航部分 Start-->
        <?php echo $this->render('/include/header'); ?>

        <div class="nav">
            <div class="content">
                <ul class="tnav clind fl">
                    <li><a href="<?php echo Url::home(); ?>">首页</a></li>
                    <li class="licu"><a href="<?php echo Url::to('/jbzz/'); ?>">疾病症状</a></li>
                    <li><a href="<?php echo Url::toRoute('/zicha/jbzc') . '/'; ?>">症状自查</a></li>
                </ul>
                <ul class="fhost finho fl">
                    <li><a href="http://hospital.9939.com/">找医院</a></li>
                    <li><a href="http://yisheng.9939.com/">找医生</a></li>
                    <li><a href="http://yiyao.9939.com/">找药品</a></li>
                </ul>
                <div class="mobil fr"><span>移动端：</span><span class="sp_02"></span><a href="http://m.jb.9939.com/">手机站</a></div>
                <div class="clear"></div>
            </div>
        </div>

        <!-- 主体内容部分 Start -->
            <?= $content ?>
        <!-- 主体内容部分 End -->

        <?php echo $this->render("/include/footer"); ?>
    </body>
<?= $this->endBody() ?>

</html>