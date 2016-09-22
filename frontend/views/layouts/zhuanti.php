<?php
use yii\helpers\Url;
use yii\helpers\Html;

$URI = $_SERVER['REQUEST_URI'];
$URIArr = explode("?", $URI);
$url = $URIArr[0];
$wapUrl = Url::to("@mjb_domain".$url);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= Html::encode($this->title['title'])?></title>
    <meta name="keywords" content="<?= Html::encode($this->title['keywords'])?>" />
    <meta name="description" content="<?= Html::encode($this->title['description'])?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias("@jb_domain"); ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias("@jb_domain"); ?>/css/body.css"/>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@jb_domain"); ?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@jb_domain"); ?>/js/scrollbar.js"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@jb_domain"); ?>/js/gundong.js"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@jb_domain"); ?>/js/detail.js"></script>
    <script type="text/javascript" src="http://cbjs.baidu.com/js/m.js"></script>
    <base target="_blank">
    <?php $this->head(); ?>
</head>
<?=$this->beginBody()?>
<body>

    <?php
        //主导航上方
        echo $this->render("/include/header");
    ?>
    <?php echo $content;?>
    
    
<?=$this->endBody()?>
</body>
</html>       
