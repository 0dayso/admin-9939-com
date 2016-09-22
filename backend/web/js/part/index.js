$(function () {

    //查询科室
    $("#search").on('click', function () {
        var page = 1;
        depPaging(page);
    });
    //页码
    $(document).on('click', '.dis-main .page_click', function () {
        var page = $(this).text();
        depPaging(page);
    });
    //上一页
    $(document).on('click', '.dis-main #pre_page', function () {
        var curdep = $('.dis-main .curt_dep').text();
        if (parseInt(curdep) == 1) {
            return false;
        }
        var page = parseInt(curdep) - 1;
        depPaging(page);
    });
    //下一页
    $(document).on('click', '.dis-main #next_page', function () {
        var curdep = $('.dis-main .curt_dep').text();
        
        var max = $(this).prev().text();
        if (parseInt(curdep) === parseInt(max)) {
            return false;
        }
        var page = parseInt(curdep) + 1;
        depPaging(page);
    });

    function depPaging(page) {
        var param = {
            id: $('.dis-main #search_id').val(),
            name: $('.dis-main #search_name').val(),
            level: $('.dis-main #search_level').val(),
            page: page
        };
        $.ajax({
            url: '/basedata/part/index-search',
            type: 'POST',
            dataType: 'html',
            data: param,
            success: function (msg) {
                $('.dis-main form').nextAll().remove();
                $('.dis-main').append(msg);
            }

        })
    }

    //删除科室
    $('.dis-main').on('click', '.d-delet', function () {
        var child = $(this).attr("child");
        if (child == '1') {

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
                    return false;
                },
                title: '删除提示',
                content: '存在子部位！'
            });
        } else {
            var dep = $(this).attr('name');
            var id = $(this).attr('id');
            var level = $(this).attr('level');
            var param = [];

            //param.push({'id': id, 'level': level});
			//alert(param['id']);
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
                        url: '/basedata/part/delete',
                        type: "POST",
                        dataType: '',
                        data: {id:id},
                        success: function (msg) {
                            console.log(msg);
                            var promptMsg = "删除部位失败！";
                            if (msg == 1) {
								promptMsg = "删除部位成功！";
								$('#line' + id).remove();
								//location.href = "/basedata/part/index";//客户端页面的跳转
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
                content: '确定要删除此信息吗？'
            });
        }
    });
    //删除多个(暂时未用)
    $("#delete_many").on('click', function () {
        var param = [];
        var obj_check = $('.dis-main input[name="checkbox[]"]:checked');
        var id, level, child;
        obj_check.each(function () {
            id = $(this).parent().parent().attr('depid');
            level = $(this).parent().parent().attr('level');
            child = $(this).parent().parent().attr('child');
            if (child == 1) {
                Alert('所选科室存在子科室！请手动删除！');
                return false;
            }
            param.push({'id': id, 'level': level});
        });
        $.ajax({
            url: '/basedata/department/delete',
            type: "POST",
            dataType: 'json',
            data: {param: param},
            success: function (msg) {
                if (msg) {
                    Alert('删除成功！');
                    $("#search").click();
                }
            }
        });
    });
    //  全选 | 取消全选
    $('.dis-main').on('click', "#select_all", function () {
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