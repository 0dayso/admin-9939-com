$(function(){
    initSearch();//条件筛选
    batchAction();//批量删除
    checkAll();//全选
});

/**
 * 查询数据集合
 * @param {type} action 触发方式
 * @param {type} type 类型 0全部类型 1已发布 2屏蔽
 * @param {type} pagenum 页码
 * @returns {Boolean}
 */
function search(action, type, pagenum){
   var id = $("#id").val() ? $("#id").val() : '';
   var title = $("#title").val() ? $("#title").val() : '';
   var client = $("#client").val() ? $("#client").val() : '';
   var inputtime = $("#inputtime").val() ? $("#inputtime").val() : '';
   var status = $("#status").val();
   if(action=='froms'){
        if(id=='' && title=='' && client=='' && inputtime==''){
            alert('系统提示:\n\n请输入至少一个条件！');
            return false;
        }
    }
   console.log(pagenum);
   $.ajax({
        type: 'get',
        url:'/cms/push/index-ajax-seach',
        data:{id: id,title: title,client: client,inputtime: inputtime,page:pagenum,status:status},
        dataType: 'html',
        beforeSend:function(){
            $("#"+type+"_result_tbody").html('<tr><td colspan="9" align="center">加载中...</td></tr>');
        },
        success: function(msg,status){
           if(status=='success'){
               var msg = $.parseJSON(msg);
                $("#"+type+"_result").html(msg.content);
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
        var stype = $(".disin #type").val();
        search('froms', stype, page);
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
    search('alt', type, page);
    $("#type").val(type);
}

function trunpage(pagenum){
    var ele = $(".confi .cusde");
    var status = $(ele).attr('data-status') !== undefined ? $(ele).attr('data-status') : 0;
    var type = $(ele).attr('data-type');
    search('alt', type, pagenum);
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
        opt['text']     = '资讯信息';//确定要删除选中的xxx吗？
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
                    url: '/cms/push/delete',
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
                window.location.href = '/cms/notice/index';
            }
        },
        title: '删除提示',
        content: '确定要删除选中的' + option['text'] + '吗？'
    });
}