$(function(){
    initSearch();//条件筛选
    batchAction();//批量删除
    checkAll();//全选
});

/**
 * 查询数据集合
 * @param {type} action 触发方式
 * @param {type} pagenum 页码
 * @returns {Boolean}
 */
function search(action, pagenum){
   var tradeid = $("#tradeid").val() ? $("#tradeid").val() : '';
   var paytradeno = $("#paytradeno").val() ? $("#paytradeno").val() : '';
   var paystatus = $("#paystatus").val() ? $("#paystatus").val() : '';
   var shipstatus = $("#shipstatus").val() ? $("#shipstatus").val() : '';
   var phone = $("#phone").val() ? $("#phone").val() : '';
   if(action=='froms'){
        if(tradeid=='' && paytradeno=='' && paystatus=='' && shipstatus=='' && phone==''){
            alert('系统提示:\n\n请输入至少一个条件！');
            return false;
        }
    }
   console.log(pagenum);
   $.ajax({
        type: 'get',
        url:'/cms/order/index-ajax-seach',
        data:{tradeid: tradeid,paytradeno: paytradeno,paystatus: paystatus,shipstatus: shipstatus,phone:phone,page:pagenum},
        dataType: 'html',
        beforeSend:function(){
            $("#all_result_tbody").html('<tr><td colspan="12" align="center">加载中...</td></tr>');
        },
        success: function(msg,status){
           if(status=='success'){
               var msg = $.parseJSON(msg);
                $("#all_result").html(msg.content);
                scroll(0, 380);
           }
        }
    })
 };

function initSearch(){
    var page = 1;
    /**
     * 点击搜索按钮时ajax请求数据
     */
    $(".disin #search").click(function(){
        search('froms', page);
    });
    
    /**
     * 时间日期控件
     */
    $('#inputtime').datetimepicker({
	lang:'ch',
	format:'Y-m-d H:i:s',
    });
}
function changeTab(ele){
    var status = $(ele).attr('data-status');
    var type = $(ele).attr('data-type');
    $("#status").val(status);
    var page = 1;
    search('alt', page);
    $("#type").val(type);
}

function trunpage(pagenum){
    var ele = $(".confi .cusde");
    var status = $(ele).attr('data-status') !== undefined ? $(ele).attr('data-status') : 0;
    var type = $(ele).attr('data-type');
    search('alt', pagenum);
}

    //  全选 | 取消全选
    $(".dis-main").on('click', '#check_all', function () {
        var check = $(this).prop('checked');
        if (check) {
            $('.dis-main :checkbox').prop('checked', true);
        } else {
            $('.dis-main :checkbox').prop('checked', false);
        }
    });
    //取消单个 全选按钮取消勾选
    $('.dis-main').on('click','.dis-main :checkbox:gt(0)',function(){
        if(!$(this).attr('checked')){
        $('.dis-main #check_all').prop('checked',false);;
        }
    });
    
    function deletes(id){
        opt = [];
        opt['isAjax']   = 1;
        opt['id']       = id;
        opt['text']     = '订单信息';//确定要删除选中的xxx吗？
        deleteFunc(opt);
        return false;
    }
    
    function deleteFunc(option) {
    $('#dialog').dialogBox({
        width: 400,
        hasClose: true,
        hasMask: true,
        effect: 'fade',
        hasBtn: true,
        type: 'error',
        confirmValue: "确定", //确定按钮文字内容
        cancelValue: "取消", //取消按钮文字内容
        confirm: function() {
            if (option['isAjax'] == 1) {
                $id = option['id'];
                $.ajax({
                    type: "GET",
                    url: '/cms/order/delete',
                    data: {"id": $id},
                    dataType: "json",
                    success: function(msg) {
                        console.log(msg);
                        var promptMsg = "删除" + option['text'] + "失败！";
                        if (msg == 1) {
                            promptMsg = "删除" + option['text'] + "成功！";
                            $('#line' + $id).fadeOut('fast', function() {
                                $('#line' + $id).remove();
                            });
                        }
                    }
                });
            } else {
                window.location.href = '/cms/order/index';
            }
        },
        title: '删除提示',
        content: '确定要删除选中的' + option['text'] + '吗？'
    });
}

/*订单详情*/
function detail_click(id){
    $.ajax({
        type: 'get',
        url:'/cms/order/order-detail',
        data:{id: id},
        dataType: 'html',
        beforeSend:function(){
            
        },
        success: function(msg,status){
           if(status=='success'){
               var msg = $.parseJSON(msg);
                $("#table1").html(msg.content);
                scroll(0, 380);
           }
        }
    })
}

/*确认订单信息*/
function order_queren(id){
    var page = $(".curt").html();
    opt = [];
    opt['isAjax']   = 1;
    opt['id']       = id;
    opt['text']     = '订单信息';//确定要删中的xxx吗？
    opt['page']  = page;
    editFunc(opt);
    return false;
}

function editFunc(option) {
    $('#dialog').dialogBox({
        width: 400,
        hasClose: true,
        hasMask: true,
        effect: 'fade',
        hasBtn: true,
        type: 'error',
        confirmValue: "确定", //确定按钮文字内容
        cancelValue: "取消", //取消按钮文字内容
        confirm: function() {
            if (option['isAjax'] == 1) {
                $id = option['id'];
                $page = option['page'];
                var remark = $("#txtRemark").val();
                $.ajax({
                    type: "GET",
                    url: '/cms/order/order-queren',
                    data: {"id": $id,"remark":remark},
                    dataType: "json",
                    success: function(msg) {
                        console.log(msg);
                        var promptMsg = "修改" + option['text'] + "失败！";
                        if (msg == 1) {
                            promptMsg = "修改" + option['text'] + "成功！";
                            search('alt', $page);
                        }
                    }
                });
            } else {
                window.location.href = '/cms/order/index';
            }
        },
        title: '确认提示',
//        content: ''
        content:'确定要修改选中的' + option['text'] + '吗？<div style=\"overflow:hidden;\"><lable style=\"float:left;\">备注:</lable><textarea id=\"txtRemark\" name=\"txtRemark\" style=\"width:300px;height:50px;\"></textarea></div>'
    });
}