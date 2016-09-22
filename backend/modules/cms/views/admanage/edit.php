<!-- 新增广告位内容 -->
<?php
use yii\helpers\Url;

$this->title = "编辑广告内容";
?>

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/uploadify/uploadify.css')?>"/>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/uploadify/jquery.uploadify.min.js')?>"></script>

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
        <h3>广告内容管理 -- 编辑广告内容</h3>
    </div>

    <form class="edito clinic" action="<?php echo Url::to(['/cms/admanage/update']);?>" method="post" id="add_content_form">
        <div>
            <label>
                <span>*</span>
                广告名称：
            </label>
            <input type="text" class="txco" name="adc[name]" id="ad_name" value="<?php echo $adr['archive_name']; ?>">
            <input type="hidden" class="txco" name="adr[archive_name]" id="adr_name">
        </div>
        <div>
            <label>
                广告短标题：
            </label>
            <input type="text" class="txco" name="adr[slug]"  value="<?php echo $adr['slug']; ?>">
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
        <div id="isstat">
            <label>是否统计：</label>
            <span><input type="radio" class="txco" id="isstat_yes" value="1" <?php if ($adc['isstat'] == 1){echo 'checked=checked';} ?> >是 &nbsp;&nbsp;&nbsp;</span>
            <span><input type="radio" class="txco" id="isstat_no" value="0" <?php if ($adc['isstat'] == 0){echo 'checked=checked';} ?> >否</span>
            <input type="hidden" id="isstat_val" value="" name="adc[isstat]" />
        </div>
        <div>
            <label>链接地址：</label>
            <input type="text" class="txco" name="adr[link_url]"  value="<?php echo $adr['link_url']; ?>" >
        </div>
        <div id="data_type">
            <label>广告类型：</label>
            <span><input type="radio" class="txco" id="data_type_pic" <?php if ($adr['category'] == 3){echo 'checked=checked';} ?> value="3" >图片 &nbsp;&nbsp;&nbsp;</span>
            <span><input type="radio" class="txco" id="data_type_code" value="4" <?php if ($adr['category'] == 4){echo 'checked=checked';} ?>>代码</span>
            <input type="hidden" id="data_type_val" value="" name="adr[category]" />
        </div>

        <div id="data_type_pic_part" class="scal" <?php if ($adr['category'] == 4){echo 'style="display: none;"';} ?> >
            <label>选择图片：</label>
            <input type="hidden" value="1215154" id="id_file">
            <input type="file" class="infil" id="file_upload">
            <ul class="imop" id = "selectedImages">
                <?php
                if (isset($adi) && !empty($adi)) {
                    $name = strstr($adi['name'], ".", true);
                    ?>
                    <li>
                        <input type="checkbox" value="<?php echo $adi['name'];?>" data-type = "checkbox"
                            <?php echo ($adi['weight'] == 1 ? 'checked="checked" data-value="1"' : 'data-value="0"')?>
                               onclick="bindCheck(this)"
                        >
                        <img src="<?php echo $adr['thumbnail_url']; ?>" alt="<?php echo $adi['name'];?>">
                        <b id="<?php echo $name;?>" data-id = "<?php echo $adi['name'];?>" data-type = "exist"></b>

                        <input type="hidden" name="condition[adi_id]" value="<?php echo $adi['id']; ?>" >
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="clear"></div>

            <?php
                $adi_name = '';
                $adi_weight = '';
                if (!empty($adi)){
                    $adi_name = $adi['name'];
                    $adi_weight = $adi['weight'];
                }
            ?>
            <input type="hidden" name="adi[name]" id = "adiName" value="<?php echo $adi_name; ?>" data-id = "insert" data-name = "adi[name]" ><br/>
            <input type="hidden" name="adi[weight]" id = "adiWeight" value="<?php echo $adi_weight; ?>" data-id = "insert" data-name = "adi[weight]" ><br/>
            <input type="hidden" name="adr[thumbnail_url]" id = "imageURL" value="<?php echo $adr['thumbnail_url']; ?>" data-id = "insert" data-name = "adr[thumbnail_url]">
        </div>

        <div id="data_type_code_part" class="scal" <?php if ($adr['category'] == 3){echo 'style="display: none;"';} ?> >
            <label>代码：</label>
            <textarea class="woro"  data-id = "insert" data-name = "adc[code]" ><?php echo $adc['code']; ?></textarea>
        </div>

        <div>
            <label>权重：</label>
            <input type="text" class="txco" name="adr[sort]" value="<?php echo $adr['sort']; ?>" >
        </div>
        <div>
            <label>简介：</label>
            <textarea class="woro" name="adc[description]" ><?php echo $adc['description']; ?></textarea>
        </div>

        <input type="hidden" name="condition[adc_id]" value="<?php echo $adc['id']; ?>" >
        <input type="hidden" name="condition[adr_id]" value="<?php echo $adr['id']; ?>" >

    </form>

    <div class="d-heir"></div>
    <div class="savew">
        <a href="javascript:;" id="save">保存</a>
    </div>

</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    <?php $sign = \Yii::$app->params['uploadPath']['ad']['api_id']; ?>
    img_upload_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/index/','category'=>'ad', 'sign'=>$sign]);?>';
    img_delete_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/delete/','category'=>'ad', 'sign'=>$sign]);?>';
</script>

<script>
    function clickRadio(currID, disID) {
        $("#" + currID).on('click', function () {
            $("#" + disID).removeAttr('checked');
        });
    }
    function showCurr(currID, showID, disID) {
        $("#" + currID).on('click', function () {
            //隐藏
            $("#" + disID).hide();
            $("#" + disID).find("[data-id='insert']").each(function () {
                $(this).removeAttr('name');
            });

            //显示
            $("#" + showID).show();
            //添加对应的 name 属性
            $("#" + showID).find("[data-id='insert']").each(function () {
                $(this).attr("name", $(this).attr("data-name"));
            });
        });
    }
    clickRadio('data_type_pic', 'data_type_code');
    showCurr('data_type_pic', 'data_type_pic_part', 'data_type_code_part');
    clickRadio('data_type_code', 'data_type_pic');
    showCurr('data_type_code', 'data_type_code_part', 'data_type_pic_part');

    clickRadio('isstat_yes', 'isstat_no');
    clickRadio('isstat_no', 'isstat_yes');

    /**
     * 绑定图集的选中操作
     * @param Object param 要绑定的对象
     */
    function bindCheck(param){
        if($(param).attr('data-value') == '1'){
            $(param).removeAttr('checked');
            $(param).attr('data-value', '0');
        }else{
            $('input[data-type="checkbox"]:checked').each(function(){
                $(this).removeAttr('checked');
                $(this).attr('data-value', '0');
            });
            $(param).attr('checked', 'checked');
            $(param).attr('data-value', '1');
        }
    }

    $("#save").on('click', function () {
        /*
            1、验证必填项
            2、设置 radio 部分的值
            3、提交
         */

        //1、验证必填项
        var ad_name = $("#ad_name").val();
        var position_id = $("#ad_position").val();
        if (ad_name.length == 0){
            tip_box('correct', '确定', null, '提示信息', '广告名称不能为空！', null);
            return false;
        }
        $("#adr_name").val(ad_name);
        if (position_id == '0'){
            tip_box('correct', '确定', null, '提示信息', '请选择广告位！', null);
            return false;
        }

        //2、设置 radio 部分的值
        var isstat_val = $("#isstat input[type='radio']:checked").val();
        $("#isstat_val").val(isstat_val);
        var data_type_val = $("#data_type input[type='radio']:checked").val();
        $("#data_type_val").val(data_type_val);

        //设置上传的广告图
        setImages();

        //3、提交
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

    function setImages() {
        var adiName = "";
        var adiWeight = 0;
        var imageURL = '';

        $("#selectedImages li:first").each(function(){
           adiName = $(this).find("b").attr("data-id");
            var fileChecked = $(this).find("input[checked=checked]");

            if (fileChecked != null && fileChecked != undefined && fileChecked.length != 0) {
                adiWeight = 1;
            }
            imageURL = $(this).find("img").attr("src");
        });
        $("#adiName").val(adiName);
        $("#adiWeight").val(adiWeight);
        $("#imageURL").val(imageURL);
    }

</script>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/cms/ad/upload.js')?>"></script>