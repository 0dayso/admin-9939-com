
/**
 * 分页操作
 * @author gaoqing
 * 2016/2/17
 */

$(document).ready(function(){

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
            url: "/disease/index",
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
});
