$(function () {
    //点击保存
    $("#depsave").on('click', function () {
        $('#form').submit();
    });
    //表单验证
    $('#form').submit(function () {
        var name = $('#form_name').val();
        var words = $('#form_keywords').val();
        var desc = $('#form_description').val();
        if (name == '') {
            alert('科室名称不为空！');
            return false;
        } else if (words == '') {
            alert('关键词不为空！');
            return false;
        } else if (desc == '') {
            alert('简介不为空！');
            return false;
        }
        return true;
    });
});


