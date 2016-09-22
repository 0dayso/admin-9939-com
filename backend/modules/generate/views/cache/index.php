<?php

use yii\helpers\Url;

$this->title = '缓存管理';
?>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain') ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/generate') ?>">生成管理</a>>
    <a href="<?php echo Url::to('@domain/generate/cache/index') ?>" class="bolde">缓存管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar">
        <a href="<?php echo Url::to('@domain/generate/cache/add'); ?>">添加缓存</a>
        <h3>缓存列表</h3>
    </div>

    <table border="1" cellspacing="0" class="tablay"> 
    <thead>
        <tr style="border-left: 1px solid #ececec;"> 
            <th class="chelay">全部<input  type="checkbox"   class="d-asrl"/></th> 
            <th class="idlay">ID</th> 
            <th class="clabe">缓存名称</th>
            <th class="creti">缓存KEY</th>  
            <th class="creor">方法名称</th>
            <th class="cret">操 作</th>                                  
        </tr> 
    </thead>
    <tbody class="ddf">
        <?php
        if (!empty($cache)) {
            foreach ($cache as $k => $v) {
                ?>
                <tr> 
                    <td><input type="checkbox"/></td>
                    <td><?php echo $v['id']; ?></td> 
                    <td><?php echo $v['name']; ?></td> 
                    <td><?php echo $v['key_prefix']; ?></td> 
                    <td><?php echo $v['function']; ?></td> 
                    <td><a href="javascript:;" cacheid="<?php echo $v['id']; ?>" class="d-editor generate_cache">生成缓存</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Url::to('@domain/generate/cache/edit?id=') . $v['id']; ?>" class="d-editor">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" cacheid ="<?php echo $v['id']; ?>" class="d-delet">删除</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6" style="text-align: center;">无内容，请添加！</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<div class="paget">
    <?php //echo $page_html->view(); ?>
</div>
</div>
<!--<form action="/generate/cache/generate-cache" method="post">
    <input type="hidden" name='id' value="5"/>
    <input type="submit" name='sub' value="tjiao"/>
</form>-->
<!--提示框部分 start-->
<div id="dialog"></div>
<!--提示框部分 end-->
<?php
echo $this->render('mask');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css'); ?>"/>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery.dialogBox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/generate/cache/index.js') ?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/generate/cache/alert.js') ?>"></script>
