
<!-- 广告位管理 首页 -->
<?php
use yii\helpers\Url;

$this->title = "广告位管理";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/position/index'); ?>" class="bolde">广告位管理</a>
</div>
<div class="dis-main">

    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('/cms/position/add'); ?>">添加广告位</a>
        <h3>广告位管理</h3>
    </div>

    <form class="disin fosub" action="" method="post">
        <p>
            <label>ID：</label>
            <input type="text" value="" id="id">
            <label>广告位名称：</label>
            <input type="text" value="" id="name">
            <a href="" id="search">搜索</a>
        </p>
    </form>

    <table border="1" cellspacing="0" class="tablay">
        <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th class="to_01">ID</th>
                <th class="to_02">广告位名称</th>
                <th class="to_03">宽</th>
                <th class="to_04">高</th>
                <th class="to_05">实际广告数量</th>
                <th class="to_06">操 作</th>
            </tr>
        </thead>

        <tbody class="ddf">

        </tbody>
    </table>

    <div class="paget" id="paget"></div>

</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    $(document).ready(function () {
        paging(1);
    });

    //搜索操作
    $("#search").on('click', function () {
        paging(1);
        return false;
    });

    //分页操作
    $(document).on('click',"#paget a[data-id='page']", function(){
        var page = $(this).text();
        paging(page);
    });

    //上一页
    $(document).on('click', "#paget a[data-id='pre']", function(){
        //判断当前页是否等于 1，如果等于 1 ，则该操作不可用
        var page = $("#paget a[class='curt']").text();
        page = parseInt(page);
        if (page == '1'){
            return ;
        }
        paging(page - 1);
    });

    //下一页
    $(document).on('click', "#paget a[data-id='next']", function(){
        //判断当前页是否等于 最后一页，如果是 最后一页 ，则该操作不可用
        var page = $("#paget a[class='curt']").text();
        page = parseInt(page);
        var next = page + 1;
        var end = $("#paget a[data-value='end']").text();
        end = parseInt(end);
        if (page == end){
            return ;
        }
        paging(next);
    });

    //分页操作
    function paging(page) {
        $.ajax({
            type: 'POST',
            url:  '/cms/position/search',
            data:  {
                'id': $('#id').val(),
                'name': $("#name").val(),
                'page': page
            },
            dataType: 'JSON',
            'async': false,
            success: function (positions) {
                setDatas(positions);
            }
        });
    }

    //将返回的数据，绑定到页面中
    function setDatas(positions) {
        if (positions.positions != null && positions.positions.length > 0){
            var html = '';
            for (var i = 0; i < positions.positions.length; i++){
                var position = positions.positions[i];
                html += bindPosition(position);
            }
            $("tbody").html(html);
        }
        $(".paget").html(positions.pageHTML);
    }

    //绑定单个 tr 的内容
    function bindPosition(position) {
        var detail = '/cms/position/detail?id=' + position.id;
        var html = "<tr>";
        html += "<td>"+ position.id +"</td>";
        html += '<td><a href="'+ detail +'">'+ position.name +'</a></td>';
        html += "<td>"+ position.width +"</td>";
        html += "<td>"+ position.height +"</td>";
        html += "<td>"+ position.items +"</td>";

        var edit = '/cms/position/edit?id=' + position.id;
        html += '<td>' +
            '<a href="'+ detail +'" class="d-scee">查看</a>&nbsp;' +
            '<a href="'+ edit +'" class="d-editor">编辑</a>&nbsp;' +
            '<a href="javascript:;" onclick="del('+ position.id +')" class="d-delet">删除</a>' +
            '</td>';
        html += "</tr>";
        return html;
    }

    function del(id) {
        $('#dialog').dialogBox({
            width:400,
            hasClose: false,
            effect: 'fade',
            hasBtn: true,
            type: 'normal',
            confirmValue: "确定",  //确定按钮文字内容
            cancelValue: "取消",  //取消按钮文字内容
            confirm: function(){
                $.ajax({
                    type: 'get',
                    url:  '/cms/position/delete',
                    data:  {
                        'id': id,
                    },
                    dataType: 'JSON',
                    success: function (msg) {
                        if (msg.msg > 0){
                            tip_box('correct', '确定', null, '删除提示', '删除成功！', function () {
                                window.location.href = '/cms/position/index';
                            });
                        }else{
                            tip_box('correct', '确定', null, '删除提示', '删除失败，请重试！', null);
                        }
                    }
                });
            },
            title: '删除提示',
            content: '确定要删除吗？'
        });
    }

    function tip_box(type, confirmValue, cancelValue, title, content, confirm_func) {
        $('#dialog').dialogBox({
            width:400,
            hasClose: false,
            effect: 'fade',
            hasBtn: true,
            type: type,
            confirmValue: confirmValue,  //确定按钮文字内容
            cancelValue: cancelValue,  //取消按钮文字内容
            confirm: confirm_func,
            title: title,
            content: content
        });
    }

</script>