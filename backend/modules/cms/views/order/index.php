<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '订单管理';
?>
<div class="dis-bread"><a href="">首页</a>><a href="">内容管理</a>><a href="">订单管理</a></div>
     <div class="dis-main">
           <div class="d-titr d-manar"><!--<a href="/cms/push/add">添加</a>--><h3>订单管理</h3></div>
   <form class="disin" action="" method="post"><p>
       <label>订单ID：</label><input type="text" value="" name="tradeid" id ='tradeid'>
       <label>支付宝订单ID：</label><input type="text" value="" name="paytradeno" id ='paytradeno'>
       <select class="level" name="paystatus" id="paystatus">
           <option value="">支付状态</option>
           <option value="0">未支付</option>
           <option value="1">已支付</option>
       </select>
       <select class="level" name="shipstatus" id="shipstatus">
           <option value="">发货状态</option>
           <option value="0">未发货</option>
           <option value="1">待发货</option>
           <option value="2">已发货</option>
       </select>
       <label>手机号：</label><input type="text" value="" name="phone" id ='phone'>
       <!--<label>发布时间：</label><input type="text" value="" name="inputtime" id="inputtime" class="mh_date">-->
       <a href="javascript:void(0);" class="resres" id="search" >搜索</a></p>
   </form>
<div class="confi">
    <div class="discov fl">
        <a class="cusde" onclick="changeTab(this);" data-status="0" data-type="all">全部订单</a>
        <!--<a class="mo" onclick="changeTab(this);" data-status="1" data-type="are">已发布</a>-->
    </div>
    <div class="totde fr"><!--<a href="javascript:void(0);" id="batDelete" data-type>批量删除</a>--></div></div>
		<div class="isshi"  id="all_result">
            <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                         <th class="til_01">全部<input  class="d-asrl" id="check_all" type="checkbox" value="0"/></th>
                         <th class="til_02" style="width:12%">订单ID</th>
                         <th class="til_02" style="width:12%">支付订单ID</th>
                         <th class="" style="width:16%">商品名称 </th> 
                         <th class="til_04" style="width:7%">商品价格</th>
                         <th class="til_04" style="width:7%">购买人</th>
                         <th class="til_04" style="width:7%">手机号</th>
                         <th class="til_04" style="width:7%">支付状态</th>
                         <th class="til_04" style="width:7%">发货状态</th>
                         <th class="til_07" >购买时间</th>
                         <th class="til_09" style="width:12.4%">操 作</th>                             
                    </tr>
                 </thead>
                <tbody class="ddf" id="all_result_tbody">
                
                </tbody>
            </table>
        </div>
            </div>
    <!--弹出层 开始-->
    <div class="qbwrt qbwrt_shn" style=" display:none;">
        <div class="d-list-form" style="width: 600px;margin: -305px 0 0 -350px;height:520px;">
            <div class="d-titr  d-grew">
                <a href="javascript:void(0)" class="d-errtu">
                    <img  src="<?php echo Url::to('/images/d-wor.png'); ?>"/>
                </a>
                <h3>订单信息详情</h3>
            </div>
            <!--表格 开始-->
            <div style="height:400px; overflow-X:scroll;">
            <table width="500" cellspacing="0" id="table1" style="margin-top:0px;border-left:0 solid #fff;"> 
                <tbody class="ddf">
                    <tr>
                        <td>
                            加载中...
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="d-kodrl">
                <a class="d-save-elec d-errtu" href="javascript:void(0)">确定</a>
                <a class="d-sr-elec d-errtu" href="javascript:void(0)">取消</a>
            </div>
            <!--表格 结束-->
        </div>
    </div>
    <!--弹出层 end-->
<!--时间日期控件-->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.css')?>" />
<script src="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script src="<?php echo Url::to('@domain/js/cms/order/manage.js?201608240111')?>"></script>
<!--时间日期控件-->
<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->
<script>
    $(".discov .cusde").click();
</script>