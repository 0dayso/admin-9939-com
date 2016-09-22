<?php

use yii\helpers\Url;

$this->title = '疾病分类';
?>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain'); ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata/'); ?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/category/index'); ?>" class="bolde"> 疾病分类管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar">
        <a href="<?php echo Url::to('@domain/basedata/category/add'); ?>">添加分类</a>
        <h3>疾病分类</h3>
    </div>

    <?php 
        echo $this->render('index_search',[
            'category'=>$category,
            'page_html'=>$page_html,
        ]);
    ?>

</div>

<!--提示框部分 start-->
<div id="dialog"></div>
<!--提示框部分 end-->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css'); ?>"/>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery.dialogBox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/category/index.js') ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/category/alert.js') ?>"></script>
