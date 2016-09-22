<?php
use yii\helpers\Url;
$this->title = '修改快递信息';
?>
    <div class="dis-bread"><a href="/">首页</a>><a href="/cms/default/index">内容管理</a>><a href="/cms/push/index" class="bolde">订单管理</a></div>
    <div class="dis-main dis-mainnr" style="height:900px;">
           <div class="d-titr"><a href="/cms/order/index">返回</a><h3>订单管理 -- 修改信息</h3></div>

           <form class="edito clinic" id="from1" name="from1" action="/cms/order/order-edit" method="post">

               <div>
                    <label><span>*</span>快递公司：</label>
                    <input type="text" class="txco" id="express_company" name="express_company" placeholder="" value="" style="width:640px;">
               </div>
               <div>
                    <label><span>*</span>快递单号：</label>
                    <input type="text" class="txco" id="express_number" name="express_number" placeholder="" value="" style="width:640px;">
               </div>
               <input type="hidden" value="<?php echo $id?>" name="id">
                <div class="d-heir"></div>
                <div class="savew"><a href="javascript:void(0);" id="submit">保存</a></div>
           </form> 
       </div>
       </div>
<script>
    $("#submit").click(function(){
        var express_company = $("#express_company").val();
        var express_number = $("#express_number").val();
        if(express_company ==''){
            alert('系统提示:\n\n请输入快递公司');
            return false;
        }
        if(express_number==''){
            alert('系统提示:\n\n请输入快递单号');
            return false;
        }
        $('#from1').submit();
    });
</script>