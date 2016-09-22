$(function () {
    //点击保存
    $("#save").on('click', function () {
        $('#form').submit();
        $("#save").attr('diseabled','diseabled');
    });
    //表单验证
    $('#form').submit(function () {
        var name = $('#form_name').val();
        var words = $('#form_key_prefix').val();
        var funame = $('#form_function').val();
        var source = $('#source').val();
        if (name == '') {
            alert('缓存名称不为空！');
            return false;
        }
        if (words == '') {
            alert('缓存前缀KEY不为空！');
            return false;
        }
        if (funame == '') {
            alert('缓存方法名称不为空！');
            return false;
        }
        if (source == '') {
            alert('数据表来源不为空！');
            return false;
        }
        return true;
    });
});


