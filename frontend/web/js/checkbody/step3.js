$(".refres i").click(function(){
    window.location.href = '/zicha/jbzc/';
});

$("#reSelect").click(function(){
    var url = '/zicha/jbzc_zz/';
    var user_sex=user_age=user_job='';
    //获取性别数据
    user_sex = $('.sexdul .currt').attr('data-sex');
    
    //获取年龄
    user_age = $('.age .set').attr('data-age');
    
    //获取职业
    user_job = $('.profess p.currmd').attr('data-job');
    window.location.href = url + '?sex='+user_sex+'&age='+user_age+'&job='+user_job;
});


function addSymptom(ele){
    var txt = $('#'+ele).find('a').html();
    var id = $('#'+ele).find('a').attr("data-symptomid");
    var str = '<dd class="addnum" id="relSymptom_'+id+'" data-symptomid="'+id+'" data-symptomtitle="'+txt+'">'+txt+'<a href="javascript:removeSymptom(\'relSymptom_'+id+'\');"></a></dd>';
    $('#'+ele).remove();
    $("#selectSymptom").append(str);
    showDisease();
}

function removeSymptom(ele){
    var txt = $('#'+ele).attr("data-symptomtitle");
    var id = $('#'+ele).attr("data-symptomid");
    var str = '<dd onclick="addSymptom(\'relSymptom_'+id+'\')" id="relSymptom_'+id+'"><a href="javascript:void(0);" data-symptomid="'+id+'" target="_self">'+txt+'</a><i></i></dd>';
    $('#'+ele).remove();
    $("#relSymptom dd").eq(0).before(str);
    showDisease();
}

function showDisease(){
    var symptomid = '';
    
    $("#selectSymptom dd").each(function(){
        symptomid += $(this).attr('data-symptomid')+'|';
    });
    
    console.log(symptomid);
//    return false;
    $.ajax({
        type: 'post',
        url: '/zicha/query/',
        data: {'type':4, 'symptomid':symptomid},
        dataType: 'html',
        beforeSend: function(){
            $("#acroll").html('<li><a href="javascript:void(0);" target="_self">加载中...</a></li>');
        },
        success: function(data){
            $("#acroll").html(data);
        },
        error: function(){}
    });
}