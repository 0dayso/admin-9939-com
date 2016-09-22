/**
 * 分类管理 添加分类
 */

$(function () {

    //科室联动
    $("#class_level1").on('change', function () {
        var class_level1 = $(this).val();
        if (class_level1 == 0) {
            $("#class_level2 option:gt(0)").remove();
            return false;
        }
        var option = '';
        $.ajax({
            url: '/basedata/department/get-level2',
            type: 'POST',
            dataType: 'json',
            data: {class_level1: class_level1},
            success: function (msg) {
                if (msg) {
                    $.each(msg, function (k, v) {
                        option += '<option value="' + v.id + '">' + v.name + '</option>';
                    });
                    $("#class_level2 option:gt(0)").remove();
                    $("#class_level2").append(option);
                }
            }
        })
    });
    $("#class_level1").trigger('change');
    /**
     * 搜索疾病
     */
    $('#dis-search').click(function () {
        var page = 1;
        disPaging(page);
    });
    //上一页
    $('.qbwrt').on('click', '#pre_page', function () {
        var curdep = $('.qbwrt .curt').text();
        if (parseInt(curdep) == 1) {
            return false;
        }
        var page = parseInt(curdep) - 1;
        disPaging(page);
    });
    //下一页
    $('.qbwrt').on('click', '#next_page', function () {
        var curdep = $('.qbwrt .curt').text();
        var page = parseInt(curdep) + 1;
        disPaging(page);
    });
    //页码
    $('.qbwrt').on('click', '.page_click', function () {
        var page = $(this).text();
        disPaging(page);
    });
    function disPaging(page) {
        var class_level1 = $("#class_level1").val();
        var class_level2 = $("#class_level2").val();
        var name = $("#name").val();
        if ((class_level1 == 0) && (class_level2 == 0) && !name) {
            return false;
        }

        var page = (parseInt(page) <= 1) ? 1 : parseInt(page);

        var disease = '';
        $.ajax({
            url: '/basedata/category/get-disease',
            type: 'POST',
            dataType: 'html',
            data: {
                class_level1: class_level1,
                class_level2: class_level2,
                name: name,
                page: page
            },
            success: function (html) {
                if (html) {
                    $('.qbwrt .d-list-form table').nextAll().remove();
                    $('.qbwrt .d-list-form table').remove();
                    $('.qbwrt .d-list-form').append(html);
                }
            }
        })
    }
    $('#dis-search').trigger('click');//加载页面是自动点击搜索一次

    //保存勾选
    $(".qbwrt").on('click', '.d-save-elec', function () {
        var arrdisease = [];
        $(".qbwrt [name='checkbox[]']:checked").each(function (k, v) {
            var disid = $(this).val();
            if (delduplicate(disid)) {
                var class_level1 = $(this).attr('class_level1');
                var class_level2 = $(this).attr('class_level2');
                var name = $(this).attr('disname');
                $('.d-pop-cidr').css({'display': 'block'});
                $('.d-pop-cidr .d-symp-m').append('<li disid="' + disid + '" class_level1="' + class_level1 + '" class_level2="' + class_level2 + '" name="' + name + '">' + name + '<i></i></li>');

            }

        });
        $('.qbwrt .d-errtu').trigger('click');
        $(".d-symp-m li").hover(function () {
            $(this).addClass("hover");
        }, function () {
            $(this).removeClass("hover");
        });
        $(".d-symp-m li i").click(function () {
            $(this).parent().eq(0).remove();
        });
    });
    //删除重复选择项
    function delduplicate(disid) {
        var flag = true;
        $('.d-pop-cidr .d-symp-m li').each(function (k, v) {
            if ($(this).attr('disid') == disid) {
                flag = false;
                return false;
            }
        });
        return flag;
    }
    
    //添加页面 保存
    $('.dis-main').on('click', '.save-add', function () {
        var url = '/basedata/category/add-save';
        cateSave(url);
    });
    //修改页面 保存
    $('.dis-main').on('click', '.save-edit', function () {
        var url = '/basedata/category/edit-save';
        var id = $('#catename').attr('cateid');
        var oldname = $('#oldname').val();
        cateSave(url, id, oldname);
    });
    //保存提交（添加页面）
    function cateSave(url) {
        var url = arguments['0'];
        var id = arguments['1'] ? arguments['1'] : '';
        var oldname = arguments['2'] ? arguments['2'] : '';
        var name = $('#catename').val();
        if (!name) {
            return false;
        }

        var data = [];
        var obj = $('.d-pop-cidr .d-symp-m li');
        obj.each(function (k, v) {
            var id = $(this).attr('disid');
            var class_level1 = $(this).attr('class_level1');
            var class_level2 = $(this).attr('class_level2');
            data.push({diseaseid: id, class_level1: class_level1, class_level2: class_level2});
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {name: name, data: data, id: id, oldname: oldname},
            success: function (msg) {

                if (msg.code == 'error') {
                    Alert(msg.message);
                }
                if (msg.code == 'success') {
                    Alert(msg.message);
                    window.location.href = '/basedata/category/index';
                }
            }
        })

    };

    //取消选择
    $(document).on('click', '.d-sr-elec', function () {
        $('.qbwrt :checkbox').prop('checked', false);
    });












    //全选-取消全选
    $('.qbwrt').on('click', ".d-asrl", function () {
        var check = $(this).prop('checked');
        if (check) {
            $('.qbwrt :checkbox').prop('checked', true);
        } else {
            $('.qbwrt :checkbox').prop('checked', false);
        }
    });
    //取消单个 全选按钮取消勾选
    $('.qbwrt').on('click', '.qbwrt :checkbox:gt(0)', function () {
        if (!$(this).attr('checked')) {
            $('.qbwrt .d-asrl').prop('checked', false);

        }
    });
});


