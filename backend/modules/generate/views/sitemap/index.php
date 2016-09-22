
<!-- sitemap 主页 -->

<?php

use yii\helpers\Url;

$this->title = '生成 sitemap';
?>
<style>
    .text-left{text-align: center;}
</style>
<div class="dis-bread">
    <a href="<?php echo Url::to('@domain') ?>">首页</a>>
    <a href="<?php echo Url::to('@domain/generate') ?>">生成管理</a>>
    <a href="<?php echo Url::to('@domain/generate/cache/index') ?>" class="bolde">生成sitemap</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar">
        <h3>缓存列表</h3>
    </div>

    <table border="1" cellspacing="0" class="tablay">
        <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th class="clabe">sitemap类型</th>
                <th class="cret">操 作</th>
            </tr>
        </thead>

        <tbody class="ddf">
            <tr>
                <td class="text-left">疾病Xml sitemap(搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" id="disease_sitemap" name="disease" where="jb">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">Wap疾病Xml sitemap(搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" name="disease" where="wap_jb">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">Wap疾病Xml sitemap(百度搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" name="disease" where="wap_baidu">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">Wap文章Xml sitemap(搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" name="article" where="wap_article">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">Wap文章Xml sitemap(百度搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" name="article" where="wap_article_baidu">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">PC疾病专题Xml sitemap(搜索引擎)</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" name="zt" where="pc">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">PC疾病、症状简介等 sitemap</td>
                <td>
                    <a class="d-editor generate_cache disease_sitemap" href = "javascript:;" id="disease_sitemap" name="disSymCol" where="pc_disease_symptom_column">生&nbsp;成</a>
                </td>
            </tr>
            <tr>
                <td class="text-left">疾病地图</td>
                <td>
                    <a class="d-editor generate_cache" href = "javascript:;" id="disease_html_sitemap">生&nbsp;成</a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="paget">
        <?php //echo $page_html->view(); ?>
    </div>
</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css') ?>">
<div id="dialog"></div>
<div id="dialog_result"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js') ?>"></script>
<!-- 弹出提示框部分 End -->

<script>
//    $("#disease_sitemap").on('click', function () {
//        $('#dialog').dialogBox({
//            width:400,
//            hasClose: true,
//            effect: 'fade',
//            hasBtn: true,
//            type: 'error',
//            confirmValue: "确定",  //确定按钮文字内容
//            cancelValue: "取消",  //取消按钮文字内容
//            confirm:function(){
//                $.ajax({
//                    'type': 'get',
//                    'url': '/generate/sitemap/generate?name=disease',
//                    'dataType': 'json',
//                    'success': function (ret) {
//                        if (ret != undefined && ret != null && ret != '' && ret.flag == 1){
//                            $('#dialog').dialogBox({
//                                width:400,
//                                hasClose: true,
//                                effect: 'fade',
//                                hasBtn: true,
//                                type: 'error',
//                                confirmValue: "确定",  //确定按钮文字内容
//                                cancelValue: "取消",  //取消按钮文字内容
//                                title: '生成提示',
//                                content: '生成成功！地址是：<br/> <a href="'+ ret.url +'" target="_blank">'+ ret.url +'</a>'
//                            });
//                        }else {
//                            $('#dialog').dialogBox({
//                                width:400,
//                                hasClose: true,
//                                effect: 'fade',
//                                hasBtn: true,
//                                type: 'error',
//                                confirmValue: "确定",  //确定按钮文字内容
//                                cancelValue: "取消",  //取消按钮文字内容
//                                title: '生成提示',
//                                content: '生成失败！请重试！'
//                        });
//                        }
//                    }
//                });
//            },
//            title: '生成提示',
//            content: '确定要生成疾病sitemap吗？'
//        });
//    });

    $(".disease_sitemap").on('click', function () {
        var name = $(this).attr('name');
        var where = $(this).attr('where'); //a标签where属性标明sitemap归属
        $('#dialog').dialogBox({
            width: 400,
            hasClose: true,
            effect: 'fade',
            hasBtn: true,
            type: 'error',
            confirmValue: "确定", //确定按钮文字内容
            cancelValue: "取消", //取消按钮文字内容
            confirm: function () {
                $.ajax({
                    'type': 'get',
                    'url': '/generate/sitemap/generate?name=' + name + '&where=' + where,
                    'dataType': 'json',
                    'success': function (ret) {
                        if (typeof (ret) != 'undefined' && ret.flag == 1) {
                            var siteindex = '';
                            if (typeof (ret.siteindex) != 'undefined') {
                                siteindex = '索引地址：<a href="' + ret.siteindex + '"target="_blank">' + ret.siteindex + '</a>';
                            }
                            $('#dialog_result').dialogBox({
                                width: 400,
                                hasClose: true,
                                effect: 'fade',
                                hasBtn: true,
                                type: 'error',
                                confirmValue: "确定", //确定按钮文字内容
                                cancelValue: "取消", //取消按钮文字内容
                                title: '生成提示',
                                content: '生成成功！' + siteindex + '地址是：<br/> <a href="' + ret.url + '" target="_blank">' + ret.url + '</a>'
                            });
                        } else if (typeof (ret) != 'undefined' && ret.flag == 2) {
                            var siteindex = '';
                            if (typeof (ret.siteindex) != 'undefined') {
                                siteindex = '索引地址：<a href="' + ret.siteindex + '"target="_blank">' + ret.siteindex + '</a>';
                            }
                            $('#dialog_result').dialogBox({
                                width: 400,
                                hasClose: true,
                                effect: 'fade',
                                hasBtn: true,
                                type: 'error',
                                confirmValue: "确定", //确定按钮文字内容
                                cancelValue: "取消", //取消按钮文字内容
                                title: '生成提示',
                                content: '生成完毕，不必再点击生成！' + siteindex
                            });
                        } else {
                            $('#dialog_result').dialogBox({
                                width: 400,
                                hasClose: true,
                                effect: 'fade',
                                hasBtn: true,
                                type: 'error',
                                confirmValue: "确定", //确定按钮文字内容
                                cancelValue: "取消", //取消按钮文字内容
                                title: '生成提示',
                                content: '生成失败！请重试！'
                            });
                        }
                    }
                });
            },
            title: '生成提示',
            content: '确定要生成疾病sitemap吗？'
        });
    });

    $("#disease_html_sitemap").on('click', function () {
        $('#dialog').dialogBox({
            width: 400,
            hasClose: true,
            effect: 'fade',
            hasBtn: true,
            type: 'error',
            confirmValue: "确定", //确定按钮文字内容
            cancelValue: "取消", //取消按钮文字内容
            confirm: function () {
                $.ajax({
                    'type': 'get',
                    'url': '/generate/sitemap/generate?name=diseasehtml',
                    'dataType': 'json',
                    'success': function (ret) {
                        if (ret != undefined && ret != null && ret != '' && ret.flag == 1) {
                            $('#dialog_result').dialogBox({
                                width: 400,
                                hasClose: true,
                                effect: 'fade',
                                hasBtn: true,
                                type: 'error',
                                confirmValue: "确定", //确定按钮文字内容
                                cancelValue: "取消", //取消按钮文字内容
                                title: '生成提示',
                                content: '生成成功！地址是：<br/> <a href="' + ret.url + '" target="_blank">' + ret.url + '</a>'
                            });
                        } else {
                            $('#dialog_result').dialogBox({
                                width: 400,
                                hasClose: true,
                                effect: 'fade',
                                hasBtn: true,
                                type: 'error',
                                confirmValue: "确定", //确定按钮文字内容
                                cancelValue: "取消", //取消按钮文字内容
                                title: '生成提示',
                                content: '生成失败！请重试！'
                            });
                        }
                    }
                });
            },
            title: '生成提示',
            content: '确定要生成疾病sitemap吗？'
        });
    });
</script>