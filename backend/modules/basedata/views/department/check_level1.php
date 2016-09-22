<?php

use yii\helpers\Url;

$this->title = '查看一级科室';
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain'); ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata'); ?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/department/index'); ?>" class="bolde"> 科室管理</a>
</div>
<div class="dis-main">
    <div class="d-titr d-manar clearfix">
        <h3>科室管理列表—查看</h3>
    </div>
    <div class="amout">
        <p>
            <span><b>科室名称：</b><?php echo $department['name'] ?></span>
            <input type="hidden" id="class_level1_id" value="<?php echo $department['id']; ?>"/>
            <span><b>科室等级：</b>一级科室</span></p>
        <p><b>科室简介：</b><?php echo $department['description'] ?></p>
    </div>

    <!--二级科室列表 start-->
    <?php
    echo $this->render('check_level1_search', [
        'class_level2' => $class_level2,
        'page_html' => $page_html,
    ]);
    ?>
    <!--二级科室列表 end-->

</div>

<!--添加疾病弹出层 start-->
<?php
echo $this->render('popup', [
    'class_level1' => $class_level1,
]);
?>
<!--添加疾病弹出层 end-->

<!--提示框部分 start-->
<div id="dialog"></div>
<!--提示框部分 end-->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css'); ?>"/>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery.dialogBox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/check_level1.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/add_disease.js'); ?>"></script>