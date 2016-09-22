$(function(){
    initSearch();//条件筛选
    batchAction();//批量删除
    checkAll();//全选
});

/**
 * 
 * @param {type} cache 是否缓存
 * @param {type} action 事件来源，formBtn:表单搜索按钮，enter:回车键，tab:下方切换标签
 * @param {type} type unshow|show 未审核|已审核
 * @returns {Boolean}
 */
function search(cache, action, type){
//    console.log(type);
    if(cache == 0){
        if(type==undefined || type==null){
            type = 'unshow';
        }
        articleid = $(".disin #articleid").val()=='' ? 0 : $(".disin #articleid").val();
        title = $(".disin #title").val()=='' ? 0 : $(".disin #title").val();
        diseasename = $(".disin #diseasename").val()=='' ? 0 : $(".disin #diseasename").val();
        inputtime_begin = $(".disin #inputtime_begin").val()=='' ? 0 : $(".disin #inputtime_begin").val();
        inputtime_end = $(".disin #inputtime_end").val()=='' ? 0 : $(".disin #inputtime_end").val();
        username = $(".disin #username").val()=='' ? 0 : $(".disin #username").val();
        
        status = $(".disin #status").val()=='' ? 0 : $(".disin #status").val();
        
        if(action=='formBtn' || action=='enter'){
            if(!articleid && !title && !diseasename && !inputtime_begin && !inputtime_end && !username){
                userAlertAndFocus('请至少输入一个查询条件', '.disin #articleid');
                return false;
            }
        }
        
        if(inputtime_begin!='' && !inputtime_end){
            userAlertAndFocus('请选择截止日期', '.disin #inputtime_end');
            return false;
        }
        
        if(inputtime_end!='' && !inputtime_begin){
            userAlertAndFocus('请选择开始日期', '.disin #inputtime_begin');
            return false;
        }

//        console.log(type);
        var params = {
            'articleid' : articleid,
            'status' : status,
            'title' : title,
            'diseasename' : diseasename,
            'inputtime_begin' : inputtime_begin==0?'':datetime_to_unix(inputtime_begin),
            'inputtime_end' : inputtime_end==0?'':datetime_to_unix(inputtime_end),
            'username' : username
        };
        $.ajax({
            type: 'get',
            url: search_ajaxUrl,
            data: params,
            dataType: 'html',
            beforeSend:function(){
                $("#"+type+"_result").html('<tr><td colspan="9" align="center">加载中...</td></tr>');
            },
            success: function(msg, status){
                if(status=='success'){
                   $("#"+type+"_result").html(msg);
                }
            }
        })
        
        $(this).attr('data-cache', 1);//取消缓存标记
    }
    if(action=='tab'){
        $(".disin #type").val(type);//
    }
}


function initSearch(){
    /**
     * 点击搜索按钮时ajax请求数据
     */
    $(".disin #searchBtn").click(function(){
        var stype = $(".disin #type").val();
        search(0, 'formBtn', stype);
    });
    
    /*
     * 点击回车时ajax请求数据
     */
    $(".disin").keydown(function(e){
        var stype = $(".disin #type").val();
        if(e.keyCode==13){
            search(0, 'enter', stype);
        }
    });
    
    
    /**
     * 时间日期控件
     */
    $('#inputtime_begin').datetimepicker({
	lang:'ch',
	format:'Y-m-d H:i:s',
    });
    
    $('#inputtime_end').datetimepicker({
	lang:'ch',
	format:'Y-m-d H:i:s',
    });
}

/**
 * 批量删除
 * @returns {undefined}
 */
function batchAction(){
    option = [];
    option['isAjax']    = 1;
    option['url']       = $("#batDelete").attr("data-action");
    option['text']      = '疾病文章';//确定要删除选中的xxx吗？
    
    idArr = [];
    $("#batDelete").click(function(){
        $(":checkbox:checked").each(function(index, element){
            idArr[index] = $(element).val();
        });
    
//        console.log(idArr);
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
                $.each(idArr, function(index, $id){
                    $('#line' + $id).fadeOut('normal', function() {
                        $('#line' + $id).remove();
                    });
                    
                    if (option['isAjax'] == 1) {
                        $.ajax({
                            type: "GET",
                            url: option['url'],
                            data: {"id": $id},
                            dataType: "json",
                            success: function(msg) {
                                if (msg['flag'] == 1) {
//                                    promptMsg = "删除" + option['text'] + "成功！";
                                }
                            }
                        });
                    } else {
                        window.location.reload();
                    }
                    
                });
            },
            title: '删除提示',
            content: '确定要删除选中的' + option['text'] + '吗？'
        });
    });
}

/**
 * 删除按钮确认提示
 */
function delInfo(obj){
    opt = [];
    opt['isAjax']   = 1;
    opt['id']       = $(obj).attr("data-id");
    opt['url']      = $(obj).attr("data-url");
    opt['href']     = $(obj).attr("data-href");
    opt['text']     = '疾病文章';//确定要删除选中的xxx吗？
    deleteFunc(opt);
    return false;
}


//删除信息弹窗提示
/*
<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->
 */
/**
 * 
 * @param {type} option
 * @returns {undefined}
 */
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
            
            
            if (opt['isAjax'] == 1) {
                $id = option['id'];
                $.ajax({
                    type: "GET",
                    url: option['url'],
                    data: {"id": $id},
                    dataType: "json",
                    success: function(msg) {
                        console.log(msg);
                        var promptMsg = "删除" + option['text'] + "失败！";
                        if (msg['flag'] == 1) {
                            promptMsg = "删除" + option['text'] + "成功！";
                            $('#line' + $id).fadeOut('fast', function() {
                                $('#line' + $id).remove();
                            });
                        }
                        
                        /*
                         $('#dialog').dialogBox({
                         width:400,
                         hasClose: false,
                         effect: 'fade',
                         hasBtn: true,
                         type: 'correct',
                         confirmValue: "确定",  //确定按钮文字内容
                         cancelValue: null,  //取消按钮文字内容
                         confirm:function(){
                         if(msg['flag'] == 1){
                         window.location.reload();
                         }
                         },
                         title: '删除提示',
                         content: promptMsg
                         });
                         */

                    }
                });
            } else {
                window.location.href = option['href'];
            }
        },
        title: '删除提示',
        content: '确定要删除选中的' + option['text'] + '吗？'
    });
}

function datetime_to_unix(datetime) {
    var tmp_datetime = datetime.replace(/:/g, '-');
    tmp_datetime = tmp_datetime.replace(/ /g, '-');
    var arr = tmp_datetime.split("-");
    var now = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2], arr[3] - 8, arr[4], arr[5]));
    return parseInt(now.getTime() / 1000);
}

function unix_to_datetime(unix) {
    var now = new Date(parseInt(unix) * 1000);
    return now.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}

/**
* 点击【未审核，已审核】时不重复请求ajax加载
*/
function changeTab(ele){
    var status = $(ele).attr('data-status');
    var type = $(ele).attr('data-type');
    var cache = $(ele).attr('data-cache');
    $("#status").val(status);
    search(cache, 'tab', type);
    $("#type").val(type);
    $(ele).attr('data-cache', 1);//增加缓存标记 
}


function userAlertAndFocus(content, ele) {
    $('#dialog').dialogBox({
        title: '',
        hasClose: true,
//            hasMask: true,
        hasBtn: true,
        effect: '',
        type: 'error',
        confirmValue: "确定", //确定按钮文字内容
        content: '<b style="color:#f00">' + content + '</b>',
        confirm: function() {
            $(ele).focus();
            return false;
        },
    });
}

/**
 * 
 */
function checkAll(){
    //全选或全不选 
    $(".d-asrl").click(function() {
        v = $(this).val();
        console.log(v);
        if (this.checked) {
            $("#"+ v +" :checkbox").attr("checked", true);
        } else {
            $("#"+ v +" :checkbox").attr("checked", false);
        }
    });
//    console.log(v);
    
    //当其中一个不选的时候，全选按钮设置为不选的状态
    var actType = $(".cusde").attr("data-type");
    console.log(actType);
    actType = actType+"_result";
    $("#"+ actType +" :checkbox").click(function(){
        var num = $("#"+ actType +" :checkbox").length;
        var m = 0;
        for(var n=0;n<num;n++){
            ele = $("#"+ actType +" :checkbox").eq(n);
            if ($(ele).attr("checked") !== 'checked') {
                m = m-1;
            }else{
                m = m+1;
            }
        }
        if( num !== m ){
            $(".til_01 :checkbox[value="+ actType +"]").attr("checked", false);
        }else{
            $(".til_01 :checkbox[value="+ actType +"]").attr("checked", true);
        }
        
    });
}