
<!-- 广告位管理 首页 -->
<?php
use yii\helpers\Url;

$this->title = "添加广告位";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/position/index'); ?>" class="bolde">广告位管理</a>
</div>

<div class="dis-main">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('/cms/position/index'); ?>">返回</a>
        <h3>添加广告位</h3>
    </div>

    <form class="edito" action="<?php echo Url::toRoute('/cms/position/insert'); ?>" method="post" id="form">
        <div>
            <label>
                <span>*</span>
                广告位名称：
            </label>
            <input type="text" class="txco" id="name" name="name">
        </div>
        <div>
            <label>
                <span>*</span>
                标识代码&nbsp;：
            </label>
            <input type="text" class="txco" id="code" name="code">
        </div>
        <div>
            <label>
                <span>*</span>
                宽&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <input type="text" class="txco" id="width" name="width">
        </div>
        <div>
            <label>
                <span>*</span>
                高&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <input type="text" class="txco" id="height" name="height">
        </div>
        <div>
            <label>
                <span>*</span>
                广告数量&nbsp;：
            </label>
            <input type="text" class="txco" id="items" name="items">
        </div>
        <div>
            <label>
                备注&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <textarea class="txtar" id="remark" name="remark"></textarea>
        </div>
    </form>

    <div class="savea">
        <a href="javascript:;" id="save">保存</a>
    </div>

</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    $("#save").on('click', function () {
        /*
            1、验证必填项
            2、提交 form 数据
         */

        var ischecked = check();
        if (ischecked){
            $("#form").submit();
        }
    });
    
    function check() {
        var ischeck = true;

        var name = $("#name").val();
        if (name.length < 1){
            ischeck = false;
            alert("广告位名称不能为空！");
        }
        var code = $("#code").val();
        if (code.length < 1){
            ischeck = false;
            alert("标识代码不能为空！");
        }
        var numRex = /^\d{1,4}$/;
        var width = $("#width").val();
        if (!numRex.test(width)){
            ischeck = false;
            alert("广告位宽度为数字！");
        }
        var height = $("#height").val();
        if (!numRex.test(height)){
            ischeck = false;
            alert("广告位高度为数字！");
        }
        var items = $("#items").val();
        if (!numRex.test(items)){
            ischeck = false;
            alert("广告数量为数字！");
        }
        return ischeck;
    }

    /**
     * 弹出框
     * @param alertMsg 弹出框的提示信息
     */
    function alert(alertMsg){
        $('#dialog').dialogBox({
            width:400,
            hasClose: false,
            effect: 'fade',
            hasBtn: true,
            type: 'correct',
            confirmValue: "确定",  //确定按钮文字内容
            cancelValue: null,  //取消按钮文字内容
            confirm: function(){},
            title: '更新提示',
            content: alertMsg
        });
    }
    
</script>

