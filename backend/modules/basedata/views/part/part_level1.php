<?php

use yii\helpers\Url;

?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain'); ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata'); ?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/part/index'); ?>" class="bolde"> 部位管理</a>
</div>
<div class="dis-main">
    <div class="d-titr d-manar clearfix"><a href="<?php echo Url::to('@domain/basedata/part/second-part-add?id=' . $pid, true) ?>">添加部位</a>
        <h3>部位管理列表—查看</h3>
    </div>
    <div class="amout">
        <p>
            <span><b>部位名称：</b><?php echo $part['name']; ?></span>
            <input type="hidden" id="class_level1_id" value="<?php echo $part['id']; ?>"/>
            <span><b>部位等级：</b>一级部位</span></p>
        <p><b>部位简介：</b><?php echo $part['description'] ?></p>
    </div>

    <!--二级部位列表 start-->
    <?php
    echo $this->render('part_level1_search', [
        'class_level2' => $class_level2,
        'page_html' => $page_html,
    ]);
    ?>
    <!--二级部位列表 end-->

</div>

<!--添加疾病弹出层 start-->
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
<script type="text/javascript" src="<?php echo Url::to('@domain/js/part/index.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/part/alert.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/part/add_disease.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/check_level1.js'); ?>"></script>