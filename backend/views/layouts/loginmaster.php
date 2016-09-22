<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset; ?>">
        <title><?= Html::encode($this->title); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/body.css') ?>">
        <script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery-1.7.2.min.js') ?>"></script>
        <script type=text/javascript src="<?php echo Url::to('@domain/js/slides.jquery.js') ?>"></script>
        <script type=text/javascript src="<?php echo Url::to('@domain/js/detail.js') ?>"></script>
        <?php $this->head(); ?>
    </head>
    <body>
        <div class="naout">
            <div class="navlog">
                <a href="javascript:"><img src="<?php echo Url::to('@domain/images/logo.png') ?>" alt="久久健康网" title="久久健康网"></a>
                <img src="<?php echo Url::to('@domain/images/system.png') ?>" class="til">
            </div>
        </div>
        <div id="mainbody">
            <?= $content ?>
        </div>
        <div class="folog"><p><?php echo \Yii::$app->params['copyright']; ?></p></div>
    </body>
</html>