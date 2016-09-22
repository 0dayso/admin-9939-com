$(function() {
    $("#allSymptom a").click(function() {
        opt = $(this).html();
        opt_val = $(this).attr("data-id");

        str = $("#symptom_rel").val();
        str_val = $("#symptom_rel_hide").val();

        if (str == '') {
            $("#symptom_rel").val(opt);
            $("#symptom_rel_hide").val(opt_val);
        } else {
            $("#symptom_rel").val(str + ',' + opt);
            $("#symptom_rel_hide").val(str_val + ',' + opt_val);
        }
        console.log(str);
    });

    
    /**
     * add-rel-disease 添加相关疾病页面ajax
     * @returns {undefined}
     */
    $("#class_level1").change(function(){
        var checkValue=$(this).val();  //获取Select选择的Value
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: "id="+checkValue+'&type='+resType,//type:select checkbox
            success: function(data) {
//                console.log(data);
                msg = eval('('+data+')');
                if(msg.code!==false){
                    $("#class_level2").html(msg.info);
                }
            }
        }); 
//        console.log(checkValue);
    });
    
});

$(function() {
    //全选或全不选 
    $("#all").click(function() {
        if (this.checked) {
            $("#list :checkbox").attr("checked", true);
        } else {
            $("#list :checkbox").attr("checked", false);
        }
    });
    //全选   
    $("#selectAll").click(function() {
        $("#list :checkbox,#all").attr("checked", true);
    });
    //全不选 
    $("#unSelect").click(function() {
        $("#list :checkbox,#all").attr("checked", false);
    });
    //反选  
    $("#reverse").click(function() {
        $("#list :checkbox").each(function() {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        allchk();
    });

    //设置全选复选框 
    $("#list :checkbox").click(function() {
        allchk();
    });

    //获取选中选项的值 
    $("#getValue").click(function() {
        var valArr = new Array;
        $("#list :checkbox[checked]").each(function(i) {
            valArr[i] = $(this).val();
        });
        var vals = valArr.join(',');
        alert(vals);
    });
});
function allchk() {
    var chknum = $("#list :checkbox").size();//选项总个数 
    var chk = 0;
    $("#list :checkbox").each(function() {
        if ($(this).attr("checked") == true) {
            chk++;
        }
    });
    if (chknum == chk) {//全选 
        $("#all").attr("checked", true);
    } else {//不全选 
        $("#all").attr("checked", false);
    }
}