$(function(){
    /**
     * 相关疾病条件筛选 二级科室
     */
    $(".qbwrt_sh #class_level1").change(function(){
        var class_level1=$(this).val();  //获取Select选择的Value
        if(class_level1!==''){
            $.ajax({
                type: "POST",
                url: rel_symptom_part_level2_ajaxUrl,
                data: "id="+class_level1,
                success: function(data) {
    //                console.log(data);
                    var msg = JSON.parse(data); // 将接收的文本用解析成Json格式
                    if(msg.code!==false){
                        $(".qbwrt_sh #class_level2").html(msg.info);
                    }
                }
            }); 
        }
//        console.log(checkValue);
    });
    
    
    /**
     * 获取筛选结果
     */
    $('.qbwrt_sh #searchBtn').click(function(){
        var class1 = $('.qbwrt_sh #class_level1').val();  //获取Select选择的Value
        var class2 = $('.qbwrt_sh #class_level2').val();  //获取Select选择的Value
        var pagenum = 1;
        var params = [class1,class2,pagenum];
        getSymptomDataAjax(params);
    });
    
    /**
     * 提交选择项
     */
    $('.qbwrt_sh .d-save-elec').click(function(){
        var _str=_id="";
        var chk_value =[];
        _id = $("#symptom_rel_hide").val()+',';
        $('.qbwrt_sh input[type=checkbox]').each(function(){
            if(this.checked){
                //<a>拉肚子<b></b></a>
                _val_id = $(this).val();
                _val_str = '<a id="'+_val_id+'" href="javascript:void(0);">'+$(this).attr("data-name")+'<b></b></a>';
                
                _str += _val_str;
//                _id += _val_id;
//                chk_value.push($(this).val());
                //alert($(this).val());  
            }
        });
//        console.log(_str);
        $("#rel_symptom").append(_str);
        $("#symptom_rel_hide").val(_id.substring(0, _id.length-1));
        
        $("#rel_symptom a b,.hasad a b").click(function(){
            $(this).parent().remove();
        });
        
        $('.qbwrt_sh').hide();
    });
    
    /**
     * 取消
     */
    $('.qbwrt_sh .d-sr-elec').click(function(){
        $('.qbwrt_sh .qbwrt_shn').hide();
    }); 
});

function trunpage2(pagenum){
    var class1 = $('.qbwrt_sh #class_level1').val();  //获取Select选择的Value
    var class2 = $('.qbwrt_sh #class_level2').val();  //获取Select选择的Value
    var params = [class1,class2,pagenum];
    getSymptomDataAjax(params);
}

function getSymptomDataAjax(params){
    var class1 = params[0];
    var class2 = params[1];
    var page = params[2];
    var sendData = {
        'class_level1' : class1,
        'class_level2' : class2,
        'page' : page
    };
    if(class1!==null && class2!==null){
        $.ajax({
            type: "POST",
            url: rel_symptom_search_ajaxUrl,
            data: sendData,
            dataType: 'html',
            beforeSend:function(){
                $(".qbwrt_sh #disease_list").html('<tr><td colspan="4">加载中...</td></tr>');
            },
            success: function(msg) {
                $(".qbwrt_sh #disease_list").html(msg);
            }
        });
    }else{
        alert('请选择筛选条件，相关症状');
        return false;
    }
}