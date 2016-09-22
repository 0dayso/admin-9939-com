<?php
use yii\helpers\Url;
if(!empty($detail)){
?>
<style>
    #ddf11 tr td span{float:left;width:380px; text-align: left;}
    #ddf11 tr td b{font-size: 16px;width:150px;}
</style>
    <!--表格 开始-->
    <table width="600"  style="margin-top:0px;"> 
        <tbody class="ddf" id='ddf11'>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">订单ID：</b> 
                    <span><?php echo $detail['tradeid'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">支付宝订单号：</b> 
                    <span><?php echo $detail['paytradeno'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">商品ID：</b> 
                    <span><?php echo $detail['productid'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">商品名称：</b> 
                    <span><?php echo $detail['productname'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">商品价格：</b> 
                    <span><?php echo $detail['price'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">支付状态：</b> 
                    <span><?php if($detail['paystatus']=='0'){echo'未支付';}else{echo'已支付';}?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">支付方式：</b> 
                    <span><?php if($detail['paytype']=='1'){echo'支付宝';}else{echo'微信';}?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">发货状态：</b> 
                    <span><?php if($detail['shipstatus']=='0'){echo'未发货';}elseif($detail['shipstatus']=='1'){echo'待发货';}else{echo'已发货';}?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">姓名：</b> 
                    <span><?php echo $detail['username'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">手机号：</b> 
                    <span><?php echo $detail['phone'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">收货地址：</b> 
                    <span><?php echo $detail['city'];?>-<?php echo $detail['area'];?>-<?php echo $detail['address'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">用户留言：</b> 
                    <span><?php echo $detail['message'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">快递公司：</b> 
                    <span><?php echo $detail['express_company'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">快递单号：</b> 
                    <span><?php echo $detail['express_number'];?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">购买时间：</b> 
                    <span><?php echo date('Y-m-d H:i:s',$detail['createtime']);?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <b style="font-size: 16px;float: left;margin-left: 50px; width:150px;">备注：</b> 
                    <span><?php echo $detail['remark'];?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    }
    ?>