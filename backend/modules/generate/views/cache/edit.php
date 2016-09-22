<?php

use yii\helpers\Url;

$this->title = '编辑缓存';
?>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain') ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/generate') ?>">生成管理</a>>
    <a href="<?php echo Url::to('@domain/generate/cache/index') ?>" class="bolde">缓存管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/generate/cache/index'); ?>">返回</a>
        <h3>缓存管理 -- 编辑缓存</h3>
    </div>

    <form class="edito clinic" id="form" action="<?php echo Url::to('/generate/cache/save', true); ?>" method="post">
        <div><label><span>*</span>缓存名称：</label>
            <input type="text" class="txco" id="form_name" name="param[name]" value="<?php echo $name; ?>">
            <input type="hidden" name="param[id]" value='<?php echo $id; ?>' />
        </div>
        <div><label>缓存前缀KEY：</label>
            <input type="text" class="txco" id="form_key_prefix" name="param[key_prefix]" value="<?php echo $key_prefix; ?>">
        </div>
        <div><label>方法名称：</label>
            <input class="txco" id="form_function" type="text" name="param[function]" value="<?php echo $function; ?>"/>
        </div>
        <div><label>数据表来源：</label>
            <input type="text" class="txco" id="form_source" name="param[source]" value="<?php echo $source; ?>">
        </div>
        <div><label>缓存简介：</label>
            <textarea class="woro" id="form_description" name="param[description]" style="resize: none;" ><?php echo $description; ?></textarea>
        </div>
    </form> 

    <div class="d-heir"></div>
    <div class="savew">
        <a href="javascript:;" id="save">保存</a>
    </div>

</div>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/generate/cache/form_submit.js') ?>"></script>
