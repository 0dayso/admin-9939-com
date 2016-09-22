$(function(){
    checkAll();
    
    /**
     * 管理界面筛选条件
     */
    $(".disin #class_level1").change(function(){
        var class_level1=$(this).val();  //获取Select选择的Value
        console.log(class_level1);
        
        if( class_level1 == '0' ){
            $("#class_level2").html('');
            return false;
        }
        
        if(class_level1 !== ''){
            $.ajax({
                type: "POST",
                url: part_level2_ajaxUrl,
                data: "id="+class_level1,
                success: function(data) {
    //                console.log(data);
                    var msg = JSON.parse(data); // 将接收的文本用解析成Json格式
                    if(msg.code!==false){
                        $("#class_level2").html(msg.info);
                    }
                }
            });
        }
//        console.log(class_level1);
    });
    
    
    /**
     * 管理列表界面筛选查询结果
     */
    $(".disin #searchBtn").click(function(){
        search();
    });
    
    $(".disin").keydown(function(e){
        if(e.keyCode==13){
            search();
        }
    });
    
    
    /**
     * 删除按钮确认提示
     */
    $('.d-delet').click(function(){
        opt = [];
        opt['isAjax']   = 0;
        opt['id']       = $(this).attr("data-id");
        opt['url']      = $(this).attr("data-url");
        opt['href']     = $(this).attr("data-href");
        opt['text']     = '症状';//确定要删除选中的xxx吗？
        deleteFunc(opt);
    });
    
    
    
    //全选或全不选 
    $(".d-asrl").click(function() {
        if (this.checked) {
            $("#list :checkbox").attr("checked", true);
        } else {
            $("#list :checkbox").attr("checked", false);
        }
    });
    
    //全选   
    $("#selectAll").click(function() {
        $("#list :checkbox,#all").attr("checked", true);
    });
    //全不选 
    $("#unSelect").click(function() {
        $("#list :checkbox,#all").attr("checked", false);
    });
    //反选  
    $("#reverse").click(function() {
        $("#list :checkbox").each(function() {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        allchk();
    });
    
});

function search(){
    symptomid = $(".disin #symptomid").val()=='' ? 0 : $(".disin #symptomid").val();
    symptomname = $(".disin #symptomName").val()=='' ? 0 : $(".disin #symptomName").val();
    username = $(".disin #username").val()=='' ? 0 : $(".disin #username").val();
    class_level1 = $('.disin #class_level1').val()=='' || $('.disin #class_level2').val()==null ? 0 : $(".disin #class_level1").val();
    class_level2 = $('.disin #class_level2').val()=='' || $('.disin #class_level2').val()==null ? 0 : $(".disin #class_level2").val();
//        console.log(class_level2);
//        
//        console.log(symptomid);
//        console.log(username);

    if(!symptomid && !username && !symptomname && class_level1==0 && class_level2==0){
        alert('请至少输入一个条件');
        $(".disin #symptomid").focus();
        return false;
    }

    $.ajax({
        type: 'post',
        url: search_ajaxUrl,
        data: 'symptomid='+symptomid+'&symptomname='+symptomname+'&username='+username+'&class_level1='+class_level1+'&class_level2='+class_level2,
        dataType: 'html',
        beforeSend:function(){
            $("#result").html('<tr><td colspan="14" align="center">加载中...</td></tr>');
        },
        success: function(msg, status){
            if(status=='success'){
//                   $("#class_level2").html(msg.info); 
               $("#result").html(msg); 
            }
        }
    })
}


//删除疾病信息
function deleteFunc(option){
    $('#dialog').dialogBox({
        width:400,
        hasClose: true,
        effect: 'fade',
        hasBtn: true,
        type: 'error',
        confirmValue: "确定",  //确定按钮文字内容
        cancelValue: "取消",  //取消按钮文字内容
        confirm:function(){
            if(opt['isAjax'] == 1){
                $id = id;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {"id" : $id},
                    dataType: "json",
                    success: function(msg){
                        var promptMsg = "删除"+text+"失败！";
                        if(msg['flag'] == 1){
                            promptMsg = "删除"+text+"成功！";
                        }
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
                    }
                });
            }else{
                window.location.href = option['href'];
            }
        },
        title: '删除提示',
        content: '确定要删除选中的'+option['text']+'吗？'
    });
}

function allchk() {
    var chknum = $("#list :checkbox").size();//选项总个数 
    var chk = 0;
    $("#list :checkbox").each(function() {
        if ($(this).attr("checked") == true) {
            chk++;
        }
    });
    if (chknum == chk) {//全选 
        $("#all").attr("checked", true);
    } else {//不全选 
        $("#all").attr("checked", false);
    }
}


function checkAll(){
    //全选或全不选 
    $(".d-asrl").click(function() {
        v = $(this).val();
        console.log(v);
        if (this.checked) {
            $("#result :checkbox").attr("checked", true);
        } else {
            $("#result :checkbox").attr("checked", false);
        }
    });
//    console.log(v);
    
    //当其中一个不选的时候，全选按钮设置为不选的状态
    $("#result :checkbox").click(function(){
        var num = $("#result :checkbox").length;
        var m = 0;
        for(var n=0;n<num;n++){
            ele = $("#result :checkbox").eq(n);
            if ($(ele).attr("checked") !== 'checked') {
                m = m-1;
            }else{
                m = m+1;
            }
        }
        if( num !== m ){
            $(".d-asrl").attr("checked", false);
        }else{
            $(".d-asrl").attr("checked", true);
        }
        
    });
}