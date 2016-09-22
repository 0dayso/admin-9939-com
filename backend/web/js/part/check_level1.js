$(function () {
    /**
     * 分页部分
     */
    //上一页
    $('.dis-main').on('click', '#pre_page', function () {
        var cur = $('.dis-main .curt').text();
        if (parseInt(cur) <= 1) {
            return false;
        }
        var page = parseInt(cur) - 1;
        depPaging(page);
    });
    //页码
    $('.dis-main').on('click', '.page_click', function () {
        var page = $(this).text();
        depPaging(page);
    });
    //下一页
    $('.dis-main').on('click', '#next_page', function () {
        var cur = $('.dis-main .curt').text();
        var max = $(this).prev().text();
        if (parseInt(cur) === parseInt(max)) {
            return false;
        }
        var page = parseInt(cur) + 1;
        depPaging(page);
    });
    function depPaging(page) {
        var param = {
            id: $('#class_level1_id').val(),
            page: page
        };

        $.ajax({
            url: '/basedata/part/check-level1-search',
            type: 'POST',
            dataType: 'html',
            data: param,
            success: function (html) {
                $('.dis-main table').nextAll().remove();
                $('.dis-main table').remove();
                $('.dis-main ').append(html);
            }

        })
    }
    //删除
    $('.dis-main').on('click', '.d-delet', function () {
        var name = $(this).attr('name');
        var id = $(this).attr('id');
        var level = 2;//$(this).attr('level');
        var cur = $(this);
        var param = [];
        param.push({id: id, level: level});
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
            content: '确定要删除选中的此信息吗？'
        });


    });
    //删除多个
    $('#delete_many').on('click', function () {
        var arrid = [];
        var check_obj = $('input:checkbox:checked');
        var param = [];
        check_obj.each(function () {
            var id = $(this).parent().parent().attr('depid');
            param.push({id: id, level: 2});
        });

        if (param.length == 0) {
            Alert('请选择要删除的科室！', 1000);
        }
        $.ajax({
            url: '/basedata/department/delete',
            type: "POST",
            dataType: 'json',
            data: {param: param},
            success: function (msg) {
                if (msg) {
                    Alert("删除成功！");
                    window.location.reload();
                }
            }
        })

    });
    //  全选 | 取消全选
    $(".dis-main").on('click', '#select_all', function () {
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

    //取消选择
//    $("#cancel_select").on('click', function () {
//        var id = $("#level1").val();
//        window.location.href = "<?php echo Url::to('@domain/department/check-level1?id=')?>" + id;
//    });

});

