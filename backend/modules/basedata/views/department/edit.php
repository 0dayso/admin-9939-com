<?php

use yii\helpers\Url;

$this->title = '编辑科室';
?>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata');?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/department/index'); ?>" class="bolde">科室管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/department/index'); ?>">返回</a>
        <h3>科室管理 -- 编辑科室</h3>
    </div>

    <form class="edito clinic" id="form" action="<?php echo Url::to('/basedata/department/edit?id=' . $id, true); ?>" method="post">
        <div><label><span>*</span>科室名称：</label>
            <input type="text" class="txco" id="form_name" name="param[name]" value="<?php echo $department['name']; ?>">
            <input type="hidden" name="param[id]" value='<?php echo $id; ?>' />
        </div>
        <?php
        if (isset($class_level1)) {
            ?>
            <div><label><span>*</span>所属科室：</label>
                <select name="param[pid]" class="level infose">
                    <?php
                    foreach ($class_level1 as $key => $val) {
                        $select = ($selected == $val['id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $val['id']; ?>" <?php echo $select; ?>><?php echo $val['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <?php
        }
        ?>
        <div><label>科室关键词：</label>
            <input type="text" class="txco" id="form_keywords" name="param[keywords]" value="<?php echo $department['keywords']; ?>">
        </div>
        <div><label>科室简介：</label>
            <textarea class="woro" id="form_description" name="param[description]" style="resize: none;" ><?php echo $department['description']; ?></textarea>
        </div>
    </form> 

    <div class="d-heir"></div>
    <div class="savew">
        <a href="javascript:;" id="depsave">保存</a>
    </div>

</div>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/department/form_submit.js'); ?>"></script>



