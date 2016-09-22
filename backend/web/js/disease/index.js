/**
 * Created by gaoqing on 2016/1/29.
 */

//编辑疾病信息
    function updateDis(current){
        var tr = $(current).parent().parent();
        var checkboxTag = $(tr).find("input[data-name=checkbox]");
        $id = $(checkboxTag).val();

        $(current).attr("href", "/basedata/disease/goupdate?id=" + $id);
    }

//删除疾病信息
function deleteDis(current){
    $('#dialog').dialogBox({
        width:400,
        hasClose: true,
        effect: 'fade',
        hasBtn: true,
        type: 'error',
        confirmValue: "确定",  //确定按钮文字内容
        cancelValue: "取消",  //取消按钮文字内容
        confirm:function(){
            var tr = $(current).parent().parent();
            var checkboxTag = $(tr).find("input[data-name=checkbox]");
            $id = $(checkboxTag).val();
            $.ajax({
                type: "GET",
                url: "/basedata/disease/delete",
                data: {"id" : $id},
                dataType: "json",
                success: function(msg){
                    var promptMsg = "删除疾病失败！";
                    if(msg['flag'] == 1){
                        promptMsg = "删除疾病成功！";
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
        },
        title: '删除提示',
        content: '确定要删除选中的疾病吗？'
    });
}

//全选操作
function fullChecked(obj) {
    //判断当前是否已经选中：
    var checked = $(obj).prop('checked');
    if (checked) {
        //全选操作：
        $("#index_tbody input[type=checkbox]").prop("checked", true);
    } else {
        //取消操作：
        $("#index_tbody input[type=checkbox]").prop("checked", false);
    }
}

//checkbox 选中操作
function singleChecked(obj) {
    var checked = $(obj).prop('checked');
    if (checked) {
        $(obj).prop("checked", true);
    } else {
        //判断是否已经 【全选】，如果【全选】，取消全选的操作
        if ($("#thCheckbox").prop('checked')) {
            $("#thCheckbox").prop('checked', false);
        }
        //取消操作：
        $(obj).prop("checked", false);
    }
}

$(document).ready(function(){

    //提交查询操作
    function searchDis() {
        var class_level2_val = $("#class_level2").val();
        if (class_level2_val == null || class_level2_val == undefined) {
            class_level2_val = "0";
        }
        $.ajax({
            type: "POST",
            url: "/basedata/disease/index",
            data: {
                "query[id]": $("#diseaseid").val(),
                "query[class_level1]": $("#class_level1").val(),
                "query[class_level2]": class_level2_val,
                "query[name]": $("#diseasename").val(),
                "query[symptomname]": $("#symptomname").val(),
                "isSearch": 1
            },
            dataType: 'html',
            success: function (msg) {
                $("#diseaseOuterID").html(msg);
            }
        });
    }

    $("#searchA").click(function () {
        searchDis();
    });

    //回车搜索操作
    $("#indexForm").keydown(function(event){
        if (event.keyCode == 13){
            searchDis();
        }
    });

    //选择一级科室，级联显示二级科室
    $("#class_level1").on('change', function(){

        var class_level1_id = $(this).val();

        if(class_level1_id != undefined && class_level1_id != '' && class_level1_id != '0'){
            $.ajax({
                type:"GET",
                url: "/basedata/disease/getclasslevel2",
                data: "class_level1=" + class_level1_id,
                dataType: 'json',
                success: function(msg){
                    if(msg != undefined && msg != null){
                        var content = '<option value="0">二级科室</option>';
                        var len = msg.length;
                        for(var i = 0; i < len;i++){
                            content += '<option value="'+ msg[i]['id'] +'">'+ msg[i]['name'] +'</option>';
                        }
                        $("#class_level2").html(content);
                    }
                }
            });
        }
    });

    //批量生成操作：
    $("#batchGenerate").on('click', function(){
        /*
            1、如果未选中记录，提示其选中记录，再操作
            2、将选中的数据，批量生成到指定的位置
         */

        //1、如果未选中记录，提示其选中记录，再操作
        var checkedCount = $("#index_tbody input[data-name='checkbox']:checked").length;
        if (checkedCount == 0){
            $('#dialog').dialogBox({
                width: 400,
                hasClose: true,
                effect: 'fade',
                hasBtn: true,
                type: 'normal',
                confirmValue: "确定",  //确定按钮文字内容
                title: '提示信息',
                content: '请选择要生成的记录！'
            });
            return ;
        }
        //2、将选中的数据，批量生成到指定的位置

    });

    /******************************分页部分 Start *********************************/
        //分页操作
    $(document).on('click',"#paget a[data-id='page']", function(){
        var page = $(this).text();
        paging(page);
    });

    //上一页
    $(document).on('click', "#paget a[data-id='pre']", function(){
        //判断当前页是否等于 1，如果等于 1 ，则该操作不可用
        var page = $("#paget a[class='curt']").text();
        page = parseInt(page);
        if (page == '1'){
            return ;
        }
        paging(page - 1);
    });

    //下一页
    $(document).on('click', "#paget a[data-id='next']", function(){
        //判断当前页是否等于 最后一页，如果是 最后一页 ，则该操作不可用
        var page = $("#paget a[class='curt']").text();
        page = parseInt(page);
        var next = page + 1;
        var end = $("#paget a[data-value='end']").text();
        end = parseInt(end);
        if (page == end){
            return ;
        }
        paging(next);
    });

    /**
     * 分页操作
     * @param page 当前页
     */
    function paging(page){
        var class_level2_val = $("#class_level2").val();
        if (class_level2_val == null || class_level2_val == undefined){
            class_level2_val = "0";
        }
        $.ajax({
            type: "POST",
            url: "/basedata/disease/index",
            data: {
                "query[id]": $("#diseaseid").val(),
                "query[class_level1]": $("#class_level1").val(),
                "query[class_level2]": class_level2_val,
                "query[name]": $("#diseasename").val(),
                "query[symptomname]": $("#symptomname").val(),
                "isSearch" : 1,
                "page" : page
            },
            dataType: 'html',
            success: function (msg) {
                $("#diseaseOuterID").html(msg);
            }
        });
    }
    /******************************分页部分 End *********************************/

});
