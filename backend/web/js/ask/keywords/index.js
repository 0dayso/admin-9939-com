/**
 * 分类管理 列表
 */

$(function () {
    
    /**
     * 搜索
     */
    $("#search").on('click',function(){
        catePaging(1);
    });
    /**
     * 分页部分
     */
    //上一页
    $('.dis-main').on('click', '#pre_page', function () {
        var curdep = $('.dis-main .curt_dep').text();
        if (parseInt(curdep) == 1) {
            return false;
        }
        var page = parseInt(curdep) - 1;
        catePaging(page);
    });
    //下一页
    $('.dis-main').on('click', '#next_page', function () {
        var curdep = $('.dis-main .curt_dep').text();
        var page = parseInt(curdep) + 1;
        catePaging(page);
    });
    //页码
    $('.dis-main').on('click', '.page_click', function () {
        var page = $(this).text();
        catePaging(page);
    });

    function catePaging(page) {
        var page = (parseInt(page) <= 1) ? 1 : parseInt(page);
        var keywords = $("#keywords").val();
        var diseasename = $("#diseasename").val();
        $.ajax({
            url: '/ask/keywords/index-search',
            type: 'POST',
            dataType: 'html',
            data: {
                page: page, keywords: keywords, diseasename: diseasename
            },
            success: function (html) {
                if (html) {
                    $('.dis-main table').nextAll().remove();
                    $('.dis-main table').remove();
                    $('.dis-main').append(html);
                }
            }
        })
    }

    /**
     * 删除
     */
    //删除单个
    $('.dis-main').on('click', '.d-delet', function () {
        var id = $(this).attr('cateid');

        $('#dialog').dialogBox({
            width: 400,
            hasClose: false,
            effect: 'fade',
            hasBtn: true,
            hasMask: true,
            type: 'correct',
            confirmValue: "确定", //确定按钮文字内容
            cancelValue: "取消", //取消按钮文字内容
            confirm: function () {

                $.ajax({
                    url: '/ask/keywords/del',
                    dataType: 'json',
                    type: 'POST',
                    data: {id: id},
                    success: function (msg) {
                        if (msg.error == 0) {
                            Alert("删除成功！");
                            if ($('.dis-main .paget').find('a').length) {
                                $('.dis-main .curt').trigger('click');
                            }else{
                                 window.location.reload();
                            }
                        } else {
                            Alert("删除失败！");
                        }
                    }
                });
            },
            title: '删除提示',
            content: '是否删除选中信息！'
        });
    });
    //删除多个(待留)

    /**
     * 全选
     */
    //全选
    $('.dis-main').on('click', '.d-asrl', function () {
        var check = $(this).prop('checked');
        if (check) {
            $('.dis-main :checkbox').prop('checked', true);
        } else {
            $('.dis-main :checkbox').prop('checked', false);
        }
    });
    $('.dis-main').on('click', '.ddf :checkbox', function () {
        var check = $(this).prop('checked');
        if (!check) {
            $('.dis-main .d-asrl').prop('checked', false);
        }
    });


});


