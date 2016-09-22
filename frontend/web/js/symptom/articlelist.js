// 症状文章列表
$(function () {

    $('#page_jump').on('click', function () {
        var jump_num = $('#jump_num').val();
        var maxpage = $(this).attr('maxpage');
        if (!jump_num) {
            jump_num = 1;
        } else if (parseInt(jump_num) > parseInt(maxpage)) {
            jump_num = maxpage;
        }
        var oldurl = window.location.href;
        var arrurl = oldurl.split('/');
        var filename = arrurl[arrurl.length - 1];
        var jumpurl = filename.replace(filename, 'article_list_'+jump_num+'.shtml');
        window.location.href = jumpurl;
    });
});
	 