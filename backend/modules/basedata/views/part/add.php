<?php

use yii\helpers\Url;

$this->title = "添加部位";
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain')?>">首页</a>>
    <a href="<?php echo Url::to('@domain/basedata')?>">基础数据</a>>
    <a href="<?php echo Url::to('@domain/basedata/part/index')?>" class="bolde">部位管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/basedata/part/index')?>">返回</a>
        <h3>部位管理 -- 添加部位</h3>
    </div>

    <form class="edito clinic" id='form' action="/basedata/part/add" method="post">
        <div><label><span>*</span>部位名称：</label>
            <input class="txco" id="form_name" type="text" name="param[name]" value=""/>
        </div>
        <div><label><span>*</span>关键词：</label>
            <input class="txco" id="form_keywords" type="text" name="param[keywords]" value=""/>
        </div>
        <div><label><span>*</span>部位简介：</label>
            <textarea id="form_description" class="woro" name="param[description]"></textarea>
        </div>
    </form> 

    <div class="d-heir"></div>
    <div class="savew"><a href="javascript:;" id='depsave'>保存</a></div>

    <script type="text/javascript" src="<?php echo Url::to('@domain/js/part/form_submit.js') ?>"></script>