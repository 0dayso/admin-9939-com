$(function(){
    /**
     * 相关疾病条件筛选 二级科室
     */
    $(".edito #class_level1").change(function(){
        $(".edito #class_level2").empty();
        var class_level1=$(this).val();  //获取Select选择的Value
        console.log(class_level1);
        if(class_level1!==''){
            $.ajax({
                type: "POST",
                url: form_ajaxUrl,
                data: "id="+class_level1,
                success: function(data) {
    //                console.log(data);
                    var msg = JSON.parse(data); // 将接收的文本用解析成Json格式
                    if(msg.code!==false){
                        $(".edito #class_level2").html(msg.info);
                    }
                }
            }); 
        }
//        console.log(checkValue);
    });
    
    
//    return false;
    $(".savea a").click(function(){
        relSymptom();
        relDisease();
        setDisImage();
//        return false;
        isValid = checkForm();
        if(isValid){
            $('.edito').submit();
        }
        
    })
});



function checkForm(){
    var isValid = true;
    iptTips = new Array("症状名称","关键词");
    $(".edito input[type=text][required=true]").each(function(i){
        inputVal = $(this).val();
        if(inputVal == ''){
            alert('请填写'+ iptTips[i]);
            $(this).focus();
            isValid = false;
            return false;
        }
        
        if(inputVal.length > 30){
            alert(iptTips[i] + '超过字数限制');
            $(this).focus();
            isValid = false;
            return false;
        }
    });
    
    if(!isValid){
        return false;
    }
    
    part_level1 = parseInt($(".edito #class_level1").val());
//    alert(part_level1);
//    console.log(typeof(part_level1));
    if( isNaN(part_level1) ){
        alert('请选择所属一级部位');
        $(".edito #class_level1").focus();
        isValid = false;
        return false;
    }
//    return false;
    
    if(!isValid){
        return false;
    }
    
    hidTips = new Array("相关疾病", '相关症状');
    hidLen = $(".edito #rel_disease a").length;
    if(hidLen < 1){
        alert('请选择'+ hidTips[0]);
        isValid = false;
        return false;
    }
    
    hidLen2 = $(".edito #rel_symptom a").length;
    if(hidLen2 < 1){
        alert('请选择'+ hidTips[1]);
        isValid = false;
        return false;
    }
    
    imgLen = $(".edito #selectedImages li").length;
    if(imgLen < 1){
        alert('请上传图片');
        isValid = false;
        return false; 
    }
    
    if(!isValid){
        return false;
    }
    
    txtTips = new Array("概述", "原因", "检查", "鉴别诊断", "缓解方法", "宜吃饮食", "忌吃饮食");
    $(".edito textarea[required=true]").each(function(i){
        txtVal = $(this).val();
        console.log(txtVal);
        if(txtVal == ''){
            alert('请填写'+ txtTips[i]);
            $(this).focus();
            isValid = false;
            return false;
        }
    });
    
    return isValid;
}

function relDisease(){
    var len = $("#rel_disease a").length;
    var ids = '';
    $("#rel_disease a").each(function(i){
        ids = ids + $(this).attr("id") + ',';
    })
    ids = ids.substring(0, ids.length-1);
    $("#disease_rel_hide").val(ids);
//    console.log(ids);
}

function relSymptom(){
    var len = $("#rel_symptom a").length;
    var ids = '';
    $("#rel_symptom a").each(function(i){
        ids = ids + $(this).attr("id") + ',';
    })
    ids = ids.substring(0, ids.length-1);
    $("#symptom_rel_hide").val(ids);
//    console.log(ids);
}

function setDisImage() {
    var content = "";
    var n = 0;
    $(".edito #selectedImages input").each(function(i, checkbox) {
        if (checkbox.checked) {
            n = n + 1;
        }
    });

    if (n <= 0) {
        //默认设置第一张图片为主图
        if(confirm('您还未选择头图，默认将第一张图片设置为头图！')){
            $(".edito #selectedImages input").eq(0).attr("checked", true).click();
        }else{
            return false;
        }
//            isValid = false;
//            return false; 
    }

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
//        return false;
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