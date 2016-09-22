<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>提建议_疾病百科_久久健康网</title>
        <meta name="keywords" content="提建议_疾病百科_久久健康网" />
        <meta name="description" content="提建议_疾病百科_久久健康网" />
        <link rel="stylesheet" type="text/css" href="<?php echo Url::to("@jb_domain");?>/css/main.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Url::to("@jb_domain");?>/css/list.css"/>
        <script type="text/javascript" src="<?php echo Url::to("@jb_domain");?>/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/9939_uaredirect_source.js?123456') ?>"></script>
        <script type="text/javascript" src="<?php echo Url::to("@jb_domain");?>/js/detail.js"></script>
        <script type="text/javascript" src="<?php echo Url::to("@jb_domain");?>/js/scrollbar.js"></script>
        <base target="_blank"/>
    </head>
    <body>
        <?php
        echo $this->render("/include/header");
        ?>
        <?php echo $content;?>

        <?php
        echo $this->render("/include/footer");
        ?>
    </body>
</html>