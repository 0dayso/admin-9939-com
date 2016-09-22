<!-- 新增广告位内容 -->
<?php
use yii\helpers\Url;

$this->title = "编辑疾病、咨询文章广告";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/admanage/index'); ?>" class="bolde">广告内容管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('/cms/admanage/index'); ?>">返回</a>
        <h3>广告内容管理 -- 编辑疾病、咨询文章广告</h3>
    </div>

    <form class="edito clinic" action="<?php echo Url::to(['/cms/admanage/updateart']);?>" method="post" id="add_content_form">

        <div>
            <label><span>*</span>添加文章：</label>
            <a class="add admale d-pop-dow">添加</a>
            <b class="lema">注：添加疾病文章、咨询文章</b>
        </div>
        <div class="hasad" id="show_article_tile">
            <a><?php echo $adr['archive_name']; ?></a>
        </div>
        <input type="hidden" class="txco" name="adr[archive_name]" id="adr_name" value="<?php echo $adr['archive_name']; ?>">
        <input type="hidden" id="data_type_val"  name="adr[category]" value="<?php echo $adr['category']; ?>" />
        <input type="hidden" id="adr_archive_id"  name="adr[archive_id]" value="<?php echo $adr['archive_id']; ?>" />

        <input type="hidden" name="condition[adr_id]" value="<?php echo $adr['id']; ?>" >

        <div>
            <label>
                广告短标题：
            </label>
            <input type="text" class="txco" name="adr[slug]" value="<?php echo $adr['slug']; ?>">
        </div>

        <div>
            <label>
                <span>*</span>广告位：
            </label>
            <select class="level infose" name="adr[position_id]" id="ad_position">
                <option value="0">请选择广告位</option>
                <?php
                if (isset($positions) && !empty($positions)) {
                    foreach ($positions as $position){
                        $checked = '';
                        if ($position['id'] == $adr['position_id']){
                            $checked = 'selected=selected';
                        }
                ?>
                        <option value="<?php echo $position['id']; ?>" <?php echo $checked;?> ><?php echo $position['name']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <label>链接地址：</label>
            <input type="text" class="txco" name="adr[link_url]" value="<?php echo $adr['link_url']; ?>">
        </div>

        <div>
            <label>权重：</label>
            <input type="text" class="txco" name="adr[sort]" value="<?php echo $adr['sort']; ?>">
        </div>
    </form>

    <div class="d-heir"></div>
    <div class="savew">
        <a href="javascript:;" id="save">保存</a>
    </div>

</div>


<div class="qbwrt qbwrt_shn" style=" display:none;" id="select_article_part">
    <div class="d-list-form">
        <div class="d-titr  d-grew">
            <a href="javascript:;" class="d-errtu">
                <img  src="/images/d-wor.png"/>
            </a>
            <h3>广告内容管理 — 添加文字</h3>
        </div>

        <form class="disin fosub infc" action="" method="post">
            <label>文章ID：</label>
            <input type="text" value="" class="dina dindex" id="articleid">

            <label>文章类型：</label>
            <select class="level infose" name = "type" id="type">
                <option value="0">请选择文章类型</option>
                <option value="1">疾病文章</option>
                <option value="2">资讯文章</option>
            </select>

            <a href="javascript:;" id="add_art_search">搜索</a>
        </form>
        <!--表格 开始-->
        <table width="990" border="1" cellspacing="0">
            <thead class="ells-four">
            <tr>
                <th></th>
                <th>文章名称 </th>
                <th>URL地址 </th>
            </tr>
            </thead>
            <tbody class="ddf" id="search_tbody">

            </tbody>
        </table>
        <!--表格 结束-->

        <div class="d-kodrl">
            <a href="javascript:;" class="d-save-elec" id="save_select">保存选择</a>
            <a href="javascript:;" class="d-sr-elec" id="cancel_select">取消选择</a>
        </div>
        <div class="paget">
            <a href="">10</a>
            <a href="" class="hko">&gt;&gt;</a>
        </div>
    </div>
</div>

<!--文字弹出 开始-->


<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    //添加文字
    $("#add_art_search").on('click', document, function () {
        var articleid = $("#articleid").val();
        var type = $("#type").val();
        if (articleid.length == 0){
            tip_box('correct', '确定', null, '提示信息', '文章id不能为空！', null);
            return false;
        }
        if (type == 0){
            tip_box('correct', '确定', null, '提示信息', '请选择文章类型！', null);
            return false;
        }
        $.ajax({
            type: 'GET',
            url:  '/cms/admanage/searchart',
            data:  {
                'articleid': articleid,
                'type': type
            },
            dataType: 'JSON',
            'async': false,
            success: function (article) {
                setDatas(article);
            }
        });
        return false;
    });
    
    $("#cancel_select").on('click', document, function () {
        $("#select_article_part").hide();
    });
    $("#save_select").on('click', document, function () {
        //设置 文章的信息
        var articleid = $("#search_article_id").val();
        if (articleid != null && articleid != undefined && articleid.length > 0){
            $("#adr_archive_id").val(articleid);
            $("#adr_name").val($("#search_article_name").val());
            $("#data_type_val").val($("#type").val());

            $("#show_article_tile").html('<a>'+ $("#search_article_name").val() +'</a>');

            $("#select_article_part").hide();
        }
    });

    function setDatas(article) {
        if (article != null && article != undefined){
            var html = '<tr>';
            html += '<td>' +
                '<input  type="checkbox" value="'+ article.id +'" id="search_article_id"/>' +
                '<input type="hidden" id="search_article_name" value="'+ article.title +'" />' +
                '</td>';
            html += '<td>'+ article.title +'</td>';
            html += '<td>'+ article.url +'</td>';
            html += '</tr>';

            $("#search_tbody").html(html);
        }
    }


    $("#save").on('click', function () {
        //1、验证必填项
        var ad_id = $("#adr_archive_id").val();
        var position_id = $("#ad_position").val();
        if (ad_id.length == 0 || ad_id == 0){
            tip_box('correct', '确定', null, '提示信息', '请添加文章！', null);
            return false;
        }
        if (position_id == '0'){
            tip_box('correct', '确定', null, '提示信息', '请选择广告位！', null);
            return false;
        }
        //2、提交
        $("#add_content_form").submit();
    });

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
