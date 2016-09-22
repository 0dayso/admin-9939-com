<?php

use yii\helpers\Url;

$this->title = "添加缓存";
?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain')?>">首页</a>>
    <a href="<?php echo Url::to('@domain/generate')?>">生成管理</a>>
    <a href="<?php echo Url::to('@domain/generate/cache/index')?>" class="bolde">缓存管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::to('@domain/generate/cache/index')?>">返回</a>
        <h3>缓存管理 -- 添加缓存</h3>
    </div>
    <?php
        $message = isset($message) ? $message : '';
    ?>
    <script>
       $(function (){
           var mess = "<?php echo $message?>";
           if(mess){
           Alert(mess,2000);
           }
       });
    </script>
    <form class="edito clinic" id='form' action="/generate/cache/save" method="post">
        <div><label><span>*</span>缓存名称：</label>
            <input class="txco" id="form_name" type="text" name="param[name]" value=""/>
        </div>
        <div><label>缓存前缀KEY：</label>
            <input class="txco" id="form_key_prefix" type="text" name="param[key_prefix]" value=""/>
        </div>
        <div><label>方法名称：</label>
            <input class="txco" id="form_function" type="text" name="param[function]" value=""/>
        </div>
        <div><label>数据表来源：</label>
            <input class="txco" id="form_source" type="text" name="param[source]" value=""/>
        </div>
        <div><label>缓存简介：</label>
            <textarea id="form_description" class="woro" name="param[description]"></textarea>
        </div>
    </form> 

    <div class="d-heir"></div>
    <div class="savew"><a href="javascript:;" id='save'>保存</a></div>

    <script type="text/javascript" src="<?php echo Url::to('@domain/js/generate/cache/form_submit.js') ?>"></script>
    <script type="text/javascript" src="<?php echo Url::to('@domain/js/generate/cache/alert.js') ?>"></script>