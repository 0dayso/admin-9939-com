<?php

use yii\helpers\Url;

$this->title = '编辑分类';
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain'); ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata'); ?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/category'); ?>">疾病分类管理</a>>
    <a href="javascript:;" class="bolde">编辑分类</a>
</div>

<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/category'); ?>">返回</a>
        <h3>疾病分类管理 — 编辑分类</h3>
    </div>
    <ul class="d-clas-add">
        <li>
            <b>疾病分类：</b>
            <input type="text" id="catename" cateid="<?php echo $category['id'];?>" value="<?php echo $category['name'];?>"/>
            <input type="hidden" id="oldname" value="<?php echo $category['name'];?>"/>
        </li>
        <li>
            <b>选择疾病：</b>
            <button class="d-pop-up d-pop-dow">添加</button>
        </li>
    </ul>

    <!--弹出 开始-->
    <?php
    echo $this->render('popup', [
        'class_level1' => $class_level1,
    ]);
    ?>
    <!--弹出 结束-->

    <!--选中显示疾病 start-->
    <div class="d-pop-cidr clearfix">
        <ul class="d-symp-m">
            <?php 
                foreach ($disease as $k => $v) {
                    ?>
                    <li class=""
                        disid="<?php echo $v['id'];?>"
                        class_level1="<?php echo $v['class_level1'];?>"
                        class_level2="<?php echo $v['class_level2'];?>"
                        name="<?php echo $v['name'];?>"><?php echo $v['name'];?><i></i></li>
            <?php
                }
            ?>
        </ul>
    </div>
    <!--选中显示疾病 end-->
    <div class="d-heir"></div>
    <div class="savew save-edit"><a href="javascript:;">保存</a></div>
</div>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/category/add.js') ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/category/alert.js') ?>"></script>