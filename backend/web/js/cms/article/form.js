$(function() {
//    return false;
    $(".savea a").click(function() {
        relDisease();
        setDisImage();
//        return false;
        isValid = checkForm();
        if (isValid) {
            $('.edito').submit();
        }

    })
});


/**
 * 验证表单
 * @returns {Boolean}
 */
function checkForm() {
    var isValid = true;
    iptTips = ["文章标题", "来源", "作者", "关健字"];
    $(".edito input[type=text][required=true]").each(function(i) {
        inputVal = $(this).val();
        if (inputVal == '') {
            alert('请填写' + iptTips[i]);
            $(this).focus();
            isValid = false;
            return false;
        }

        if (inputVal.length > 30) {
            alert(iptTips[i] + '超过字数限制');
            $(this).focus();
            isValid = false;
            return false;
        }
    });

    if (!isValid) {
        return false;
    }

    type = parseInt($(".edito #type").val());
    if (isNaN(type)) {
        alert('请选择所属文章分类');
        $(".edito #type").focus();
        isValid = false;
        return false;
    }
//    return false;

    if (!isValid) {
        return false;
    }

    hidTips = ["所属疾病"];
    hidLen = $(".edito #rel_disease a").length;
    if (hidLen < 1) {
        alert('请选择' + hidTips[0]);
        isValid = false;
        return false;
    }

//    var imgLen = $(".edito #selectedImages li").length;
//    if(imgLen < 1){
//        alert('请上传图片');
//        isValid = false;
//        return false; 
//    }
////    return false;
//    if (!isValid) {
//        return false;
//    }

    txtTips = ["文章摘要"];
    $(".edito textarea[required=true]").each(function(i) {
        txtVal = $(this).val();
        console.log(txtVal);
        if (txtVal == '') {
            alert('请填写' + txtTips[i]);
            $(this).focus();
            isValid = false;
            return false;
        }
    });

    return isValid;
}

/**
 * 设置上传缩略图
 * @returns {Boolean}
 */
function setDisImage() {
    var content = "";
    var n = 0;
    $(".edito #selectedImages input").each(function(i, checkbox) {
        if (checkbox.checked) {
            n = n + 1;
        }
    });

//    if (n <= 0) {
//        //默认设置第一张图片为主图
//        if(confirm('您还未选择头图，默认将第一张图片设置为头图！')){
//            $(".edito #selectedImages input").eq(0).attr("checked", true).click();
//        }else{
//            return false;
//        }
//    }
    
    $("#selectedImages li").each(function() {
        var fileName = $(this).find("b").attr("data-id");
        var fileChecked = $(this).find("b").attr("data-weight");
        if(fileName !== '' && fileName !== undefined){
            content += '{"name": "' + fileName + '", "weight": "' + fileChecked + '"}' + ",";
        }
    });
    content = content.substring(0, content.length - 1);
    content = '[' + content + ']';
    console.log(content);
    $("#diseaseImage").val(content);
    //return true;
}

/**
 * 设置所属疾病
 * @returns {undefined}
 */
function relDisease() {
    var len = $("#rel_disease a").length;
    var ids = '';
    $("#rel_disease a").each(function(i) {
        ids = ids + $(this).attr("id") + ',';
    });
    ids = ids.substring(0, ids.length - 1);
    $("#disease_rel_hide").val(ids);
    console.log(ids);
}


function thumbPreview(obj) {
    src = $(obj).attr('src');
    
    $('#dialog').dialogBox({
        title: '图片预览',
        hasClose: true,
        hasMask: true,
        hasBtn: false,
        effect: 'fall',
        type: 'normal',
        content: '<img src="' + src + '" width="500" height="420">',
        confirm: function() {
//            $(ele).focus();
//            return false;
        },
    });
}