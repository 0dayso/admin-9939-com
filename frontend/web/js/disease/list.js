// 疾病文章列表
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
        var arrurl = oldurl.split('?');
        window.location.href = arrurl['0']+'?page='+jump_num;
    });
});
	 