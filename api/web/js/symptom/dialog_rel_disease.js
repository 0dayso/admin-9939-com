$(function(){
    /**
     * 相关疾病条件筛选 二级科室
     */
    $(".qbwrt_shn #class_level1").change(function(){
        var checkValue=$(this).val();  //获取Select选择的Value
        if(checkValue!==''){
            $.ajax({
                type: "POST",
                url: rel_disease_department_level2_ajaxUrl,
                data: "id="+checkValue,
                success: function(data) {
    //                console.log(data);
                    var msg = JSON.parse(data); // 将接收的文本用解析成Json格式
                    if(msg.code!==false){
                        $(".qbwrt_shn #class_level2").html(msg.info);
                    }
                }
            }); 
        }
//        console.log(checkValue);
    });
    
    
    /**
     * 获取筛选结果
     */
    $('.qbwrt_shn #searchBtn').click(function(){
        var class1 = $('.qbwrt_shn #class_level1').val();  //获取Select选择的Value
        var class2 = $('.qbwrt_shn #class_level2').val();  //获取Select选择的Value
        console.log(class1);
        console.log(class2);
//        return false;
        if(class1!==null && class2!==null){
            $.ajax({
                type: "POST",
                url: rel_disease_search_ajaxUrl,
                data: "class_level1="+class1+"&class_level2="+class2,
//                dataType: 'html',
                success: function(msg) {
                    console.log(msg);
                    var msg = JSON.parse(msg); // 将接收的文本用解析成Json格式
                    if(msg.info != '' && msg.info != undefined){
                        $(".qbwrt_shn #disease_list").html(msg.info);
                    }
                }
            });
        }else{
            alert('请选择筛选条件');
            return false;
        }
    });
    
    /**
     * 提交选择项
     */
    $('.qbwrt_shn .d-save-elec').click(function(){
        var _str=_id="";
        var chk_value =[];
        $('.qbwrt_shn input[type=checkbox]').each(function(){
            if(this.checked){
                //<a>拉肚子<b></b></a>
                _val_id = $(this).val();
                _val_str = '<a id="'+_val_id+'" href="javascript:void(0);">'+$(this).attr("data-name")+'<b></b></a>';
                
                _str += _val_str;
                _id += _val_id;
//                chk_value.push($(this).val());
                //alert($(this).val());  
            }
        });
        console.log(_str);
        $("#rel_disease").append(_str);
        $("#disease_rel_hide").val(_id.substring(0, _id.length-1));
        
        $("#rel_disease a b,.hasad a b").click(function(){
            $(this).parent().remove();
        });
        
        $('.qbwrt_shn').hide();
    });
    
    /**
     * 取消
     */
    $('.qbwrt_shn .d-sr-elec').click(function(){
        $('.qbwrt_shn').hide();
    });
});