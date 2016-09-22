<?php

use yii\helpers\Url;

$this->title = '关键词管理';
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain'); ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/ask'); ?>">问答管理</a>>
    <a href="<?php echo Url::to('@domain/ask/keywords'); ?>">关键词管理</a>>
</div>

<div class="dis-main">
    <div class="d-titr d-manar clearfix"><a href="<?php echo Url::to('@domain/ask/keywords/add') ?>">添加关键词</a></div>
    <form class="disin fosub canwi" action="" method="post"><p>
            <label>关键词：</label><input type="text" value="" name="keywords" id="keywords">
            <label>疾病：</label><input type="text" value="" name="diseasename" id="diseasename">
            <a href="javascript:;" id="search">搜索</a></p>
    </form>

    <!--搜索结果 start-->
    
    <?php
    echo $this->render('index_search', [
        'keywords' => $keywords,
        'page_html' => $page_html,
    ]);
    ?>
    <!--搜索结果 end-->

</div>

<!--提示框部分 start-->
<div id="dialog"></div>
<!--提示框部分 end-->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css'); ?>"/>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery.dialogBox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/ask/keywords/index.js') ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/ask/keywords/alert.js') ?>"></script>