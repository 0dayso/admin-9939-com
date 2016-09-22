/**
 * 分类管理 添加分类
 */

$(function () {
//问诊问答查看更多
    $(".fimor").on('click', function () {
        var keywords = $("#keywords").val();
        var offset = $(".askan li").length;
        var length = 5;

        $.ajax({
            url: '/symptom/load-ask/',
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
        var symptomid = $("#symptomid").val();
        var offset = $(".raatu a").length;
        var length = 5;
        var total_1 = $(".raatu a").length;
        $.ajax({
            url: '/symptom/load-article/',
            type: 'POST',
            dataType: 'html',
            data: {symptomid: symptomid, offset: offset, length: length},
            success: function (html) {
                $(".raatu").append(html);
                var total_2 = $(".raatu a").length;
//                parseInt(num2) > parseInt(num1)
                if ((parseInt(total_2) - parseInt(total_1)) < parseInt(length)) {
                    $(".article_load").text('显示没有可加载内容');
                    $(this).unbind("click");
                }
            }
        });
    });

});


