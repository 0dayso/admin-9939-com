<?php

use yii\helpers\Url;

$this->title = '添加二级科室';
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata');?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/department/index') ?>" class="bolde">科室管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/department/index') ?>">返回</a>
        <h3>科室管理 — 添加二级科室</h3>
    </div>

    <form class="edito clinic canco" id="form" action="<?php echo Url::to(['/basedata/department/add-second']); ?>" method="post">
        <div><label><span>*</span>二级科室：</label>
            <input type="text" class="txco" id="form_name" name="param[name]" value="">
        </div>
        <div><label><span>*</span>所属科室：</label>
            <select class="level infose" name="param[pid]">
                <?php
                if ($class_level1) {

                    foreach ($class_level1 as $k => $v) {
                        $select = (!empty($selected) && $selected == $v['id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $v['id']; ?>" <?php echo $select; ?>><?php echo $v['name']; ?></option>

                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="scawi"><label>科室关键词：</label>
            <input type="text" id="form_keywords" name="param[keywords]">
        </div>
        <div><label>科室简介：</label>
            <textarea class="woro" id="form_description" name="param[description]"></textarea>
        </div>
    </form> 
    <div class="d-heir"></div>
    <div class="savew"><a href="javascript:;" id="depsave">保存</a></div>

</div>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/form_submit.js') ?>"></script>




