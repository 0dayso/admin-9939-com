<?php
use yii\helpers\Url;
$this->title = '添加公告';
?>
    <div class="dis-bread"><a href="/">首页</a>><a href="/cms/default/index">内容管理</a>><a href="/cms/push/index" class="bolde">资讯推送管理</a></div>
    <div class="dis-main dis-mainnr" style="height:900px;">
           <div class="d-titr"><a href="/cms/push/index">返回</a><h3>资讯推送管理 -- 添加资讯</h3></div>

           <form class="edito clinic" id="from1" name="from1" action="/cms/push/add" method="post">
                <div>
                    <label><span>*</span>客户端：</label>
                    <select class="level levc" id="client" name="client">
                        <option value="" name="client">选择客户端</option>
                        <option value="0" name="client">所有客户端</option>
                        <option value="1" name="client">医生端</option>
                        <option value="2" name="client">客户端</option>
                    </select>
                </div>
                <div>
                    <label><span>*</span>推送内容：</label>
                    <textarea class="woro" style="height:70px;width: 770px;" id="body" name="body" value=""></textarea>
                </div>
               <div>
                    <label><span>*</span>资讯地址：</label>
                    <input type="text" class="txco" id="url" name="url" placeholder="" value="http://" style="width:640px;">
               </div>
               <div>
                    <label><span>*</span>定时发送：</label>
                    <input type="text" name="pushtime" id="pushtime" class="mh_date" value="<?php echo date('Y-m-d H:i:s',time())?>" style="width:180px;">
               </div>
                <div class="d-heir"></div>
                <div class="savew"><a href="javascript:void(0);" id="submit">保存</a></div>
           </form> 
       </div>
       </div>
<script>
    $("#submit").click(function(){
        var client = $("#client").val();
        var body = $("#body").val();
        var url = $("#url").val();
        if(client==''){
            alert('系统提示:\n请选择客户端！');
            return false;
        }
        if(body==''){
            alert('系统提示:\n推送内容不能为空！');
            return false;
        }
        if(url==''){
            alert('系统提示:\请输入链接地址！');
            return false;
        }
        $('#from1').submit();
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.css')?>" />
<script src="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script>
$(function(){
    /**时间控件**/
    $('#pushtime').datetimepicker({
	lang:'ch',
	format:'Y-m-d H:i:s',
    });
});
</script>