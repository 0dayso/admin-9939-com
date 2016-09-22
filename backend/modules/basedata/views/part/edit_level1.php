<?php

use yii\helpers\Url;

$this->title = '编辑部位';
?>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata');?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/part/index'); ?>" class="bolde">部位管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/part/index'); ?>">返回</a>
        <h3>部位管理 -- 编辑部位</h3>
    </div>

    <form class="edito clinic" id="form" action="<?php echo Url::to('/basedata/part/edit-level2?id=' . $id, true); ?>" method="post">
        <div><label><span>*</span>部位名称：</label>
            <input type="text" class="txco" id="form_name" name="name" value="<?php echo $part['name']; ?>">
            <input type="hidden" name="id" value='<?php echo $id; ?>' />
        </div>
            <div><label><span>*</span>所属部位：</label>
                <select name="pid" class="level infose">
                    <?php
                    foreach ($part_level1 as $key => $val) {
                        $select = ($part['pid'] == $val['id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $val['id']; ?>" <?php echo $select; ?>><?php echo $val['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        <div><label>部位关键词：</label>
            <input type="text" class="txco" id="form_keywords" name="keywords" value="<?php echo $part['keywords']; ?>">
        </div>
        <div><label>部位简介：</label>
            <textarea class="woro" id="form_description" name="description" style="resize: none;" ><?php echo $part['description']; ?></textarea>
        </div>
    </form> 

    <div class="d-heir"></div>
    <div class="savew">
        <a href="javascript:;" id="depsave">保存</a>
    </div>

</div>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/part/form_submit.js'); ?>"></script>



