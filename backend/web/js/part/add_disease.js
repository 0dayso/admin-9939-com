/**
 * 添加疾病部分
 */
$(function () {

    //点击添加疾病是记录科室id
    $(document).on('click', '.note_level2', function () {
        $("#note_level2").val($(this).attr('depid'));
    });

    //科室联动
    $("#part_level1").on('change', function () {
        var part_level1 = $(this).val();
        if (part_level1 == 0) {
            $("#part_level2 option:gt(0)").remove();
            return false;
        }
        var option = '';
        $.ajax({
            url: '/basedata/part/get-level2',
            type: 'POST',
            dataType: 'json',
            data: {part_level1: part_level1},
            success: function (msg) {
                if (msg) {
                    $.each(msg, function (k, v) {
                        option += '<option value="' + v.id + '">' + v.name + '</option>';
                    });
                    $("#part_level2 option:gt(0)").remove();
                    $("#part_level2").append(option);
                }
            }
        })
    });
    $("#part_level1").trigger('change');

    // ajax 筛选疾病
    //点击搜索
    $('.qbwrt').on('click','#search_dis', function () {
        var page = 1;
        disPaging(page);
    });
    //页码
    $(document).on('click', '.qbwrt .page_click', function () {
        var page = $(this).text();
        disPaging(page);
    });
    //上一页
    $(document).on('click', '.qbwrt #pre_page', function () {
        var curdep = $('.qbwrt .curt_dep').text();
        if (parseInt(curdep) == 1) {
            return false;
        }
        var page = parseInt(curdep) - 1;
        disPaging(page);
    });
    //下一页
    $(document).on('click', '.qbwrt #next_page', function () {
        var curdep = $('.qbwrt .curt_dep').text();
        var max = $(this).prev().text();
        if (parseInt(curdep) === parseInt(max)) {
            return false;
        }
        var page = parseInt(curdep) + 1;
        disPaging(page);
    });

    function disPaging(page) {
        var part_level1 = $("#part_level1").val();
        var part_level2 = $("#part_level2").val();
        var name = $("#name").val();
        if ((part_level1 == 0) && (part_level2 == 0) && !name) {
            return false;
        }

        var page = (parseInt(page) <= 1) ? 1 : parseInt(page);
       
        var disease = '';
        $.ajax({
            url: '/basedata/part/get-disease',
            type: 'POST',
            dataType: 'html',
            data: {
                part_level1: part_level1,
                part_level2: part_level2,
                name: name,
                page: page
            },
            success: function (html) {
                if (html) {
                    $('.d-list-form table').nextAll().remove();
                    $('.d-list-form table').remove();
                    $('.d-list-form').append(html);
                }
            }
        })
    }
    //筛选结束
    //页面加载完毕 执行一次查询
    $('.qbwrt #search_dis').trigger('click');
    //保存选择
    $(document).on('click', '.qbwrt .d-save-elec', function () {
        var arrdisease = [];
        $(".qbwrt [name='checkbox[]']:checked").each(function (k, v) {
            arrdisease[k] = $(this).val();
			
        });
        var part_level2 = $("#note_level2").val();
        $.ajax({
            url: '/basedata/part/add-disease-rel',
            type: 'POST',
            dattatype: 'json',
            data: {part_level2: part_level2, arrdisease: arrdisease},
            success: function (msg) {
                Alert('添加成功！');
                $('.qbwrt').hide();
//                $('.d-list-form table').nextAll().remove();
//                $('.d-list-form table').remove();
                $('.qbwrt :checkbox').prop('checked', false);
            }
        })
    });
    //取消选择
    $(document).on('click', '.d-errtu', function () {
        $('.qbwrt :checkbox').prop('checked', false);
    });
    
    //  全选 | 取消全选
    $('.qbwrt').on('click',"#select_all", function () {
        var check = $(this).prop('checked');
        if (check) {
            $('.qbwrt :checkbox').prop('checked', true);
        } else {
            $('.qbwrt :checkbox').prop('checked', false);
        }
    });
    //取消单个 全选按钮取消勾选
    $('.qbwrt').on('click','.qbwrt :checkbox:gt(0)',function(){
        if(!$(this).attr('checked')){
        $('.qbwrt #select_all').prop('checked',false);;
        }
    });
    
});

