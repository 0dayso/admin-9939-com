$(function () {
    //查找
    $("#search_button").on('click', function () {
        disPaging(1);
    });
    /**
     * 分页部分
     */
    // 上一页
    $('.dis-main').on('click','#pre_page',function(){
        var cur = $('.dis-main .curt').text();
        if(parseInt(cur) === 1){
            return false;
        }
        var page = parseInt(cur) - 1;
        disPaging(page);
    });
    //页码
    $('.dis-main').on('click','.page_click',function(){
        var page = $(this).text();
        disPaging(page);
    });
    //下一页
    $('.dis-main').on('click','#next_page',function(){
        var cur = $('.dis-main .curt').text();
        var max = $(this).prev().text();
        if(parseInt(cur) === parseInt(max)){
            return false;
        }
        var page = parseInt(cur) + 1;
        disPaging(page);
    });
    function disPaging(page){
        
        var param = {
            name: $('#dis_name').val(),
            departmentid: $('#departmentid').val(),
            page: page
        };

        $.ajax({
            url: '/basedata/department/check-level2-search',
            type: 'POST',
            dataType: 'html',
            data: param,
            success: function (html) {
                $('form').nextAll().remove();
                $('.dis-main').append(html);
            }

        })
    }
    
    //删除疾病
    $(document).on('click', '.d-delet', function () {

        var name = $(this).attr('name');
        var arrdiseaseid = [$(this).attr('id')];
        var departmentid = $("#departmentid").val();
        var check = $(this);

        $('#dialog').dialogBox({
            width: 400,
            hasClose: true,
            effect: 'fade',
            hasBtn: true,
            hasMask: true,
            type: 'error',
            confirmValue: "确定", //确定按钮文字内容
            cancelValue: "取消", //取消按钮文字内容
            confirm: function () {

                $.ajax({
                    url: '/basedata/department/delete-disease-department',
                    type: 'POST',
                    dataType: 'json',
                    data: {arrdiseaseid: arrdiseaseid, departmentid: departmentid},
                    success: function (msg) {
                        var promptMsg = "删除科室失败！";
                        if (msg == 1) {
                            promptMsg = "删除科室成功！";
                        }
                        $('#dialog').dialogBox({
                            width: 400,
                            hasClose: false,
                            effect: 'fade',
                            hasBtn: true,
                            hasMask: true,
                            type: 'correct',
                            confirmValue: "确定", //确定按钮文字内容
                            cancelValue: null, //取消按钮文字内容
                            confirm: function () {
                                if (msg == 1) {
                                    $('.dis-main .curt').click();
                                }
                            },
                            title: '删除提示',
                            content: promptMsg
                        });
                    }
                });
            },
            title: '删除提示',
            content: '确定要删除选中的此信息吗？'
        });

    });

    //删除多个
    $('#delete_many').on('click', function () {
        var arrdiseaseid = [];
        var departmentid = $("#departmentid").val();
        var check_obj = $('input[name="checkbox[]"]:checked');
        check_obj.each(function (k, v) {
            arrdiseaseid[k] = $(this).parent().next().text();
        });
        if (arrdiseaseid.length > 0) {
            $.ajax({
                url: '/basedata/department/delete-disease-department',
                type: 'POST',
                dataType: 'json',
                data: {arrdiseaseid: arrdiseaseid, departmentid: departmentid},
                success: function (msg) {
                    if (msg) {
                        Alert('删除成功！');
                        window.location.reload();
                    }
                }
            });
        } else {
            Alert('请选择要删除的科室！', 1000);
        }

    });

    // 全选/取消全选
    $(".dis-main").on('click','#select_all', function () {
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
        $('.dis-main #select_all').prop('checked',false);;
        }
    });


});
            