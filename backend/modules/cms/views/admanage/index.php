
<!-- 广告内容管理 首页 -->
<?php
use yii\helpers\Url;

$this->title = "广告内容管理";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/admanage/index'); ?>" class="bolde">广告内容管理</a>
</div>
<div class="dis-main">

    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('/cms/admanage/add'); ?>" style="width: 120px;">添加广告内容</a>
        <a href="<?php echo Url::toRoute('/cms/admanage/addart'); ?>" style="width: 170px;">添加疾病、咨询文章广告</a>
        <h3>广告内容管理</h3>
    </div>

    <form class="disin fosub" action="" method="post">
        <p>
            <label>ID：</label>
            <input type="text" value="" id="sid">
            <label>广告名称：</label>
            <input type="text" value="" id="sname">
            <label>广告类型：</label>
            <select class="level" name="category" id="scategory">
                <option value="">请选择类型</option>
                <option value="1">疾病文章</option>
                <option value="2">资讯文章</option>
                <option value="3">图片</option>
                <option value="4">代码</option>
            </select>
            <a href="javascript:;" id="search">搜索</a>
        </p>
    </form>

    <table border="1" cellspacing="0" class="tablay">
        <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th class="to_01">ID</th>
                <th class="to_02">广告名称</th>
                <th class="to_03">广告位</th>
                <th class="to_04">广告类型</th>
                <th class="to_05">发布者</th>
                <th class="to_06">发布时间</th>
                <th class="to_07">操 作</th>
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
            url:  '/cms/admanage/search',
            data:  {
                'id': $('#sid').val(),
                'archive_name': $("#sname").val(),
                'category': $("#scategory").val(),
                'page': page
            },
            dataType: 'JSON',
            'async': false,
            success: function (advertisements) {
                setDatas(advertisements);
            }
        });
    }

    //将返回的数据，绑定到页面中
    function setDatas(advertisements) {
        var html = '';
        if (advertisements.advertisements != null && advertisements.advertisements.length > 0){
            for (var i = 0; i < advertisements.advertisements.length; i++){
                var advertisement = advertisements.advertisements[i];
                html += bindAdvertisement(advertisement);
            }
        }else {
            html = '<tr>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '</tr>';
        }
        $("tbody").html(html);
        $(".paget").html(advertisements.pageHTML);
    }

    //绑定单个 tr 的内容
    function bindAdvertisement(advertisement) {
        var detail = '/cms/admanage/stat?id=' + advertisement.id;
        var html = "<tr>";
        html += "<td>"+ advertisement.id +"</td>";
        html += '<td><a href="'+ detail +'">'+ advertisement.archive_name +'</a></td>';
        html += "<td>"+ advertisement.position_name +"</td>";
        html += "<td>"+ advertisement.category_name +"</td>";
        html += "<td>"+ advertisement.create_name +"</td>";
        html += "<td>"+ advertisement.createtime_str +"</td>";

        var edit = '/cms/admanage/edit?id=' + advertisement.id + '&category=' + advertisement.category;
        html += '<td>' +
            '<a href="'+ detail +'" class="d-scee">广告效果</a>&nbsp;' +
            '<a href="'+ edit +'" class="d-editor">编辑</a>&nbsp;' +
            '<a href="javascript:;" onclick="del('+ advertisement.id +')" class="d-delet">删除</a>' +
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
                    url:  '/cms/admanage/delete',
                    data:  {
                        'id': id,
                    },
                    dataType: 'JSON',
                    success: function (msg) {
                        if (msg.msg > 0){
                            tip_box('correct', '确定', null, '删除提示', '删除成功！', function () {
                                window.location.href = '/cms/admanage/index';
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