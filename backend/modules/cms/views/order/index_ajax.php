<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(count($model['pushlist']) > 0){
?>
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
                <tbody class="ddf" id="">
                <?php
                    foreach ($model['pushlist'] as $k=>$list){
                ?>
                 <tr id="line<?php echo $list['id']?>"> 
                    <td><input type="checkbox" name="articleid[]" id = "articleid" value="<?php echo $list['id']?>"/></td>
                    <td><?php echo $list['tradeid'];?></td> 
                    <td><?php echo $list['paytradeno'];?></td> 
                    <td><?php echo $list['productname'];?></td>
                    <td><?php echo $list['price'];?></td>
                    <td><?php echo $list['username'];?></td>
                    <td><?php echo $list['phone'];?></td>
                    <td><?php if($list['paystatus']=='0'){echo'未支付';}else{echo'<span style="color:#009967;">已支付</span>';};?></td>
                    <td><?php if($list['shipstatus']=='0'){echo'未发货';}elseif($list['shipstatus']=='1'){echo'<span style="color:#F9355B;">待发货</span>';}else{echo'<span style="color:#009967;">已发货</span>';};?></td>
                    <td><?php echo date('Y-m-d H:i:s',$list['createtime']);?></td>
                    <td>
                        &nbsp;<a href="javascript:void(0);" class="d-editor d-pop-dow" onclick="detail_click(<?php echo $list['id'];?>);" depid="<?php echo $list['id']; ?>">详情</a>
                        &nbsp;<?php if($list['shipstatus']=='0'){echo'<a href="javascript:void(0);" onclick="order_queren('.$list['id'].');"  class="d-find">确认订单</a>';}elseif($list['shipstatus']=='1'){echo'<a href="/cms/order/order-edit?id='.$list['id'].'" class="d-scee">确认发货</a>';}else{echo'<a href="javascript:void(0);" class="d-delet">已经发货</a>';}?>
                        &nbsp;<a href="javascript:void(0);" onclick="deletes(<?php echo $list['id']?>);" class="d-delet">删除</a>
                        
                    </td>
                </tr> 
               <?php
                    }
               ?>
                </tbody>
            </table>
            <div class="paget">
                 <?php echo $model['paging'] ->view(); ?>
            </div>
<?php
}else{
?>
        <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                         <th class="til_01">全部<input  class="d-asrl" type="checkbox"/></th> 
                         <th class="til_02">ID</th>
                         <th class="til_03">推送内容 </th> 
                         <th class="til_04">所属客户端</th>
                         <th class="til_05">发布状态</th>  
                         <th class="til_06">发布者</th>
                         <th class="til_07">发布时间</th>
                         <th class="til_09">操 作</th>                                 
                    </tr>
                 </thead>
                <tbody class="ddf" id="all_result_tbody">
                    <tr><td colspan="9" align="center">根据条件暂时还查不到数据...</td></tr>
                </tbody>
            </table>
<?php 
}
?>