<?php
use yii\helpers\Html;
use yii\helpers\Url;
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

        <div class="ftnav colorline"> <a href="http://www.9939.com/" title="久久健康网">久久健康网</a>| <a href="/Company/wzjj.shtml" rel="nofollow">网站简介</a>| <a href=" http://www.9939.com/sitemap/" title="网站地图">网站地图</a>| <a href="http://ask.9939.com/map/">问答地图</a>| <a href="http://jb.9939.com/map.php">疾病地图</a>| <a href="/Company/careers.php" rel="nofollow">招聘信息</a>| <a href="/Company/zlhz.shtml" rel="nofollow">战略合作</a>| <a href="/Company/wzdt.php" rel="nofollow">媒体报道</a>| <a href="mailto:SERVICES@9939.COM" rel="nofollow">意见反馈</a>| <a href="/Company/lxwm.shtml" rel="nofollow">联系我们</a>|<a href="/Company/cpfw.shtml" rel="nofollow">服务条款</a> </div>
        <div class="ftbox">
            <div class="ftzq">
                <p><?php echo Yii::$app->params['copyright']; ?></p>
                <p><?php echo Yii::$app->params['declaration']; ?></p>
            </div>
        </div>
    </body>
<?= $this->endBody() ?>

</html>