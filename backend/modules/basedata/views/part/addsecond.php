<?php

use yii\helpers\Url;

$this->title = '添加二级部位';
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata');?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/part/index') ?>" class="bolde">部位管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/part/index') ?>">返回</a>
        <h3>部位管理 — 添加二级部位</h3>
    </div>

    <form class="edito clinic canco" id="form" action="<?php echo Url::to(['/basedata/part/second-part-add']); ?>" method="post">
        <div><label><span>*</span>二级部位：</label>
            <input type="text" class="txco" id="form_name" name="name" value="">
        </div>
        <div><label><span>*</span>所属部位：</label>
            <select class="level infose" name="pid">
                <?php
                if ($part_level1) {

                    foreach ($part_level1 as $k => $v) {
                        $select = (!empty($selected) && $selected == $v['id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $v['id']; ?>" <?php echo $select; ?>><?php echo $v['name']; ?></option>

                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="scawi"><label>部位关键词：</label>
            <input type="text" id="form_keywords" name="keywords">
        </div>
        <div><label>部位简介：</label>
            <textarea class="woro" id="form_description" name="description"></textarea>
        </div>
    </form> 
    <div class="d-heir"></div>
    <div class="savew"><a href="javascript:;" id="depsave">保存</a></div>

</div>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/part/form_submit.js') ?>"></script>




