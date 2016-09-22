<?php
use yii\helpers\Url;
$this->title = "评价编辑";
?>

<div class="dis-bread">
    <a href="/">首页</a>>
    <a href="/basedata/default/index">基础数据</a>>
    <a href="/basedata/comment/index">评价管理</a>>
    <a href="javascript:;" class="bolde">评价设置</a>
</div>

<div class="dis-main  dis-mainnr">
    <div class="d-titr">
        <a href="/basedata/comment/index">返回</a>
        <h3>评价设置 — 编辑等级</h3>
    </div>
    <form class="edito clinic" action="/basedata/comment/update" method="post" id="form">
        <div class="visla clearfix">
            <label class="cib"><span>*</span>评价等级：</label>
            <input type="text" class="txco" name="name" id="name" value="<?php echo $comment['name']; ?>" >
            <input type="hidden" name="id" value="<?php echo $comment['id']; ?>" >
        </div>
        <div>
            <label class="cib"><span>*</span>评价内容：</label>
            <input type="text" class="txco" placeholder="请填写评价内容" id="content">
            <a class="add" id="content_add" style="cursor: pointer;">添加</a>
            <input type="hidden" name="content" id="content_val" value="">
        </div>
    </form>

    <div class="d-pop-cidr clearfix" id="contents">
        <ul class="d-symp-m">
            <?php
            foreach ($comment['content_arr'] as $content){
                ?>
                <li><?php echo $content; ?><i></i></li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="d-heir"></div>
    <div class="savew">
        <a class="sav" id="comment_save" style="cursor: pointer;">保存</a>
    </div>
</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    $("#content_add").on('click', document, function () {
        var content = $("#content").val();
        if (content.length > 0){
            $("#contents ul").append('<li>'+ content +'<i></i></li>');
            $(".d-symp-m li").hover(function() {
                $(this).addClass("hover");
            }, function() {
                $(this).removeClass("hover");
            });
            $(".d-symp-m li i").click(function(){
                $(this).parent().eq(0).remove();
            });
            $("#content").val('');
        }
    });

    $("#comment_save").on('click', function () {

        //check out name value
        var name = $("#name").val();
        if (name.length == 0){
            tip_box('correct', '确定', null, '提示信息', '请填写评价等级！', null);
            return false;
        }

        //check out content values
        var contents = $("#contents ul li");
        if (contents.size() == 0){
            tip_box('correct', '确定', null, '提示信息', '请填写评价内容！', null);
            return false;
        }

        //set the content_val's value
        var content_values = '';
        $("#contents ul li").each(function () {
            content_values += $(this).text() + ',';
        });
        $("#content_val").val(content_values);
        $("#form").submit();
    });


    function tip_box(type, confirmValue, cancelValue, title, content, confirm_func) {
        $('#dialog').dialogBox({
            width:400,
            hasClose: false,
            effect: 'fade',
            hasBtn: true,
            type: type,
            confirmValue: confirmValue,  //确定按钮文字内容
            cancelValue: cancelValue,  //取消按钮文字内容
            confirm: confirm_func,
            title: title,
            content: content
        });
    }

</script>
