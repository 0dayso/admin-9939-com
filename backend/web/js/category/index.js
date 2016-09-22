/**
 * 分类管理 列表
 */

$(function () {

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
        //       var max = $(this).prev().text();
//        if (parseInt(curdep) === parseInt(max)) {
//            return false;
//        }//当前页为最后一页时
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
        $.ajax({
            url: '/basedata/category/index-search',
            type: 'POST',
            dataType: 'html',
            data: {
                page: page
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
        var cateid = $(this).attr('cateid');
        var ids = [cateid];

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
                    url: '/basedata/category/del-category',
                    dataType: 'json',
                    type: 'POST',
                    data: {'ids': ids},
                    success: function (msg) {
                        if (msg.code == 'success') {
                            Alert(msg.message);
                            if ($('.dis-main .paget').find('a').length) {
                                $('.dis-main .curt').trigger('click');
                            }else{
                                 window.location.reload();
                            }
                        } else {
                            Alert(msg.message);
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


