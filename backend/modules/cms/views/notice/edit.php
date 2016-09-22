<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;
$this->title = '修改公告';
?>
    <div class="dis-bread"><a href="/">首页</a>><a href="/cms/default/index">内容管理</a>><a href="/cms/notice/index" class="bolde">公告管理</a></div>
    <div class="dis-main dis-mainnr" style="height:900px;">
           <div class="d-titr"><a href="/cms/notice/index">返回</a><h3>公告管理 -- 添加公告</h3></div>

           <form class="edito clinic" id="from1" name="from1" action="/cms/notice/edit" method="post">
                <div>
                    <label><span>*</span>客户端：</label>
                    <select class="level levc" id="client" name="client">
                        <option value="" name="client" >选择客户端</option>
                        <option value="0" name="client" <?php if($data['client'] =='0'){echo'selected';}?>>所有客户端</option>
                        <option value="1" name="client" <?php if($data['client'] =='1'){echo'selected';}?>>医生端</option>
                        <option value="2" name="client" <?php if($data['client'] =='2'){echo'selected';}?>>客户端</option>
                    </select>
                </div>
                <div>
                    <label><span>*</span>公告名称：</label>
                    <input type="text" class="txco" id="title" name="title" placeholder="" value="<?php echo $data['title'];?>" style="width:640px;">
                </div>
                <div>
                    <label>公告摘要：</label>
                    <textarea class="woro" style="height:70px;width: 770px;" id="description" name="description" value=""><?php echo $data['description'];?></textarea>
                </div>
                <div>
                    <label>公告内容：</label>
                    <script id="content" name="content" id="content" type="text/plain"><?php echo $data['content'];?></script>
                </div>

                <div class="d-heir"></div>
                <input type="hidden" value="<?php echo $data['id'];?>" name="id">
                <div class="savew"><a href="javascript:void(0);" id="submit">保存</a></div>
           </form> 
       </div>
<style>
    .edui-editor { margin-left: 12px;}/*对齐*/
    .edui-default div { margin-bottom: 0px !important;}/*主样式与编辑器样式冲突*/
</style>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.all.min.js')?>"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/lang/zh-cn/zh-cn.js')?>"></script>
<script type="text/javascript">
    editors = ["content"];
    for(i=0;i<editors.length;i++){
//        console.log(editors[i]);
        var ue = UE.getEditor(editors[i],{
//            toolbars: [
//                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
//                    ],
            initialFrameWidth   : 770,
            initialFrameHeight  : 300,
        });
    }
img_upload_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/index/','category'=>'article']);?>';    
img_delete_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/delete/','category'=>'article']);?>';  
form_ajaxUrl = '<?php echo Url::to(['/basedata/symptom/ajax-part']);?>';
</script>
<script>
    $("#submit").click(function(){
        var title = $("#title").val();
        var client = $("#client").val();
        if(client==''){
            alert('系统提示:\n请选择客户端！');
            return false;
        }
        if(title==''){
            alert('系统提示:\n标题不能为空！');
            return false;
        }
        $('#from1').submit();
    });
</script>