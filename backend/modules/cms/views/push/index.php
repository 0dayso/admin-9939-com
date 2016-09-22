<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '资讯推送管理';
?>
<div class="dis-bread"><a href="">首页</a>><a href="">内容管理</a>><a href="">资讯推送管理</a></div>
     <div class="dis-main">
           <div class="d-titr d-manar"><a href="/cms/push/add">添加</a><h3>资讯推送管理</h3></div>
   <form class="disin" action="" method="post"><p>
       <label>ID：</label><input type="text" value="" name="id" id ='id'>
       <label>资讯名称：</label><input type="text" value="" name="title" id="title" class="txle">
       <select class="level" name="client" id="client">
           <option value="">发布客户端</option>
           <option value="3">所有客户端</option>
           <option value="2">客户端</option>
           <option value="1">医生端</option>
       </select>
       <label>发布时间：</label><input type="text" value="" name="inputtime" id="inputtime" class="mh_date">
       <a href="javascript:void(0);" class="resres" id="search" >搜索</a></p>
       <input type="hidden" value="all" name='type' id="type">
       <input type="hidden" value="0" name='status' id="status">
   </form>
<div class="confi">
    <div class="discov fl">
        <a class="cusde" onclick="changeTab(this);" data-status="0" data-type="all">全部公告</a>
        <a class="mo" onclick="changeTab(this);" data-status="1" data-type="are">已发布</a>
    </div>
    <div class="totde fr"><!--<a href="javascript:void(0);" id="batDelete" data-type>批量删除</a>--></div></div>
		<div class="isshi"  id="all_result">
            <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                        <th class="til_01">全部<input  class="d-asrl" type="checkbox" value="all_result_tbody"/></th> 
                         <th class="til_02">ID</th>
                         <th class="til_03">公告标题 </th> 
                         <th class="til_04">所属客户端</th>
                         <th class="til_05">推送状态</th>  
                         <th class="til_06">发布者</th>
                         <th class="til_07">发布时间</th>
                         <th class="til_09">操 作</th>                                 
                    </tr>
                 </thead>
                <tbody class="ddf" id="all_result_tbody">
                
                </tbody>
            </table>
        </div>
        <div class="isshi" style="display:none;" id="are_result">
            <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                        <th class="til_01">全部<input  class="d-asrl" type="checkbox" value="are_result_tbody" onclick="checkAll(this);"/></th> 
                         <th class="til_02">ID</th>
                         <th class="til_03">公告标题 </th> 
                         <th class="til_04">所属客户端</th>
                         <th class="til_05">推送状态</th>  
                         <th class="til_06">发布者</th>
                         <th class="til_07">发布时间</th>
                         <th class="til_09">操 作</th>                              
                    </tr>
                 </thead>
                <tbody class="ddf" id="are_result_tbody">
               
                </tbody>
            </table>
        </div>
            </div>
<!--时间日期控件-->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.css')?>" />
<script src="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script src="<?php echo Url::to('@domain/js/cms/push/manage.js')?>"></script>
<!--时间日期控件-->
<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->
<script>
    $(".discov .cusde").click();
</script>