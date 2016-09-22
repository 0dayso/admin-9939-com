/**
 * 分类管理 添加分类
 */

$(function () {

    //问诊问答查看更多
    $(".fimor").on('click', function () {
        var keywords = $("#keywords").val();
        var total = $("#total").val();
        var offset = $(".askan li").length;
        var length = 5;

        $.ajax({
            url: '/disease/load-ask',
            type: 'POST',
            dataType: 'html',
            data: {keywords: keywords, offset: offset, length: length},
            success: function (html) {
                $(".askan").append(html);
                if ($(".askan li").length == total) {
                    $(".fimor").text('显示没有可加载内容');
                    $(this).unbind("click");
                }
            }
        });
    });

//疾病文章查看更多
    $(".article_load").on('click', function () {
        var diseaseid = $("#diseaseid").val();
        var type = $("#type").val();
        var offset = $(".raatu a").length;
        var length = 5;
        var total = $("#total").val();
        $.ajax({
            url: '/disease/load-article',
            type: 'POST',
            dataType: 'html',
            data: {diseaseid: diseaseid, type: type, offset: offset, length: length},
            success: function (html) {
                $(".raatu").append(html);
                if ($(".raatu a").length == total) {
                    $(".article_load").text('显示没有可加载内容');
                    $(this).unbind("click");
                }
            }
        });
    });

});


