/**
 * 缓存管理 列表
 */

$(function () {


    /**
     * 生成缓存
     */
    $(".dis-main").on('click', '.generate_cache', function () {
        if(confirm('可能会引起服务器负载,确定要生成吗?')){
            var cacheid = $(this).attr('cacheid');
            var count = [];
            ShowDiv();
            $.ajax({
                url: '/generate/cache/request',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: cacheid
                },
                success: function (ret) {
                    if (ret['code']=='666') {
                        var count = [];
                            cacheajax(cacheid,ret,1,count);
                    }
                }
            });
        }
    });
    function cacheajax() {
        var cacheid = arguments['0'];
        var ret = arguments['1'];
        var i = arguments['2'];
        var count = arguments['3'];
        $.ajax({
            url: '/generate/cache/generate-cache',
            type: 'POST',
            dataType: 'json',
            data: {
                id: cacheid, offset: i
            },
            success: function (res) {
                if (res['code'] == '200') {
                    count.push(res['message']);
                    
                    if (count.length == ret['message']) {
                        var sum = 0;
                        for (var j = 0; j < ret['message']; j++) {
                            sum += count[j];
                        }
                        var str = '共生成'+sum+'条缓存';
                        Alert(str,3000);
                        CloseDiv(); return;
                    }
                    i++;
                    if(i <= ret['message']){
                        cacheajax(cacheid,ret,i,count);
                    }
                }
            }
        })
    }
    //弹出隐藏层
    function ShowDiv() {
        var show_div = 'mask';
        var bg_div = 'popup';
        document.getElementById(show_div).style.display = 'block';
        document.getElementById(bg_div).style.display = 'block';
//        var bgdiv = document.getElementById(bg_div);
//        bgdiv.style.width = document.body.scrollWidth;
//// bgdiv.style.height = $(document).height();
//        $("#" + bg_div).height($(document).height());
    }
//关闭弹出层
    function CloseDiv()
    {
        var show_div = 'mask';
        var bg_div = 'popup';
        document.getElementById(show_div).style.display = 'none';
        document.getElementById(bg_div).style.display = 'none';
    }





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
        var cacheid = $(this).attr('cacheid');
        var ids = [cacheid];
        
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
                    url: '/generate/cache/del',
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


