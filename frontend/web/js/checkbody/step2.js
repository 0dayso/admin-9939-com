//根据上一步用户选择的性别来显示不同的性别部位图
sex = $('.sexdul .currt').attr('data-sex');
if(sex == 0){
    $(".sympt-chose .mpl").hide();
    $(".sympt-chose .opl").show();

    $(".climok .mok").show();
    $(".climok .nanmot").hide();
}

//点击全部症状查询，3级联动
$('.smain-parts li').click(function(){
    var index = $(this).index();
    var part_level1 = $(this).find('a').attr("data-partid");
    var part_level1_title = $(this).find('a').html();
    var allPartTitle = part_level1_title+'症状';
    $("#allPart .retur-body span").html(allPartTitle);
    $.ajax({
            type: 'post',
            url: '/zicha/query/',
            data: {'type':2, 'partid':part_level1, 'partname':part_level1_title } ,
            dataType: 'html',
            beforeSend: function(){
                $("#allPart2 ul").html('<li><a href="javascript:void(0);" target="_self">加载中...</a></li>');
            },
            success: function(data){
                $("#allPart2 ul").html(data);
                $(".small-parts li a").eq(0).click();
            },
            error: function(){}
        });
    $('.smain-parts li').removeClass('on');
    $(this).addClass('on');
    $('.small-parts').show();
});


//点击人体部位查询结果,排除切换按钮
$(".sympt-chose").find('a').not('.allmot').not('.nanmot').not('.mok').click(function(){
    title = $(this).attr('title');
    partid = $(this).attr('data-partid');
    console.log(partid);
    if(partid!=='0'){
        //隐藏人体部位
        $(".sympt-chose").hide();
        //显示查询结果
        $("#queryResult").show();
        //查询结果标题
    //    console.log( title + '部症状' );
//        $("#resultReturn span").html( title + '部症状' );

        $.ajax({
            type: 'post',
            url: '/zicha/query/',
            data: {'type':1, 'partid':partid, 'partname':title } ,
            dataType: 'html',
            beforeSend: function(){
                $("#queryResult").html('加载中...');
            },
            success: function(data){
                $("#queryResult").html(data);
            },
            error: function(){}
        });
    }
});

//搜索按钮
$(".smko .msech").click(function(){
    $('.hauman').hide();
    var val = $('.sympt-search input.demand').val();
//    console.log(val);
    if( val !== ''){
        //隐藏人体部位
        $(".sympt-chose").hide();
        $(".sympt-search .query-log").hide();
        //显示查询结果
        $("#searchContent").show();
        
        $.ajax({
            type: 'get',
            url: '/zicha/query/',
            data: {'type':6, 'keywords':val} ,
            dataType: 'html',
            beforeSend: function(){
//                $("#searchContent").html('加载中...');
            },
            success: function(data){
                if(data!=='0'){
                    $('#searchContent .hag').hide();//隐藏无信息时提示信息
                    $("#searchContent .hotwor").html(data).find('li:odd').css('background','#fafafa');
                }else{
                    $('#searchContent .hag').show();//显示无信息时提示信息
                    $('#searchContent .hotwor').html('');//重置搜索结果div
                    $('#searchContent .hag h4 span').html(val);
                }
            },
            error: function(){}
        });
    }
});

//搜索下拉)
$(function () {
    var userAgent = navigator.userAgent.toLowerCase();
    if (/msie/.test(userAgent) && !/opera/.test(userAgent)) {
        $('input[placeholder], textarea[placeholder]').placeholder();
    } else {
        $('input.demand').click(function () {
            $(this).attr("placeholder", "");
            $(".query-log").show();
        });
    }
    $(".query-log a").click(function () {
        var neva = $(this).html();
        $('input.demand').val(neva);
        $(".query-log").hide();
    });
    
    $('input[placeholder], textarea[placeholder]').keyup(function(){
        var val = $(this).val();
        if(val!==''){
            $.ajax({
                type: 'post',
                url: '/zicha/query/',
                data: {'type':5, 'keywords':val } ,
                dataType: 'html',
                beforeSend: function(){
//                    $(".query-log").html('加载中...');
                },
                success: function(data){
                    if(data!=='0'){
                        $(".query-log").html(data);
                    }else{
                        $(".query-log").html('').hide();
                    }
                },
                error: function(){}
            });
        }
    });
    
    
//    var userAgent = navigator.userAgent.toLowerCase();
//    if (/msie/.test(userAgent) && !/opera/.test(userAgent)) {
//        $('input[placeholder], textarea[placeholder]').placeholder();
//    } else {
//        $('input[placeholder], textarea[placeholder]').placeholder().focusin(function () {
//            var tips = $(this).attr("placeholder");
//            $(this).attr("default-text", tips);
//            $(this).attr("placeholder", "");
//            $(".query-log").show()
//        }).focusout(function () {
//            var tips = $(this).attr("default-text");
//            $(this).attr("placeholder", tips);
//            $(".query-log").hide()
//        }).keyup(function(){
//            var val = $(this).val();
//            if(val!==''){
//                $.ajax({
//                    type: 'post',
//                    url: '/zicha/query/',
//                    data: {'type':5, 'keywords':val } ,
//                    dataType: 'html',
//                    beforeSend: function(){
//                        $(".query-log").html('加载中...');
//                    },
//                    success: function(data){
//                        $(".query-log").html(data);
//                    },
//                    error: function(){}
//                });
//            }
//        });
//
//    }
});

function showAllSymptom(){
    $('.hauman').hide();
    $('.sympt-chose').slideDown(500).hide();
    $('#allPart').slideUp(300).show();
    $('#allPart .smain-parts li').eq(0).click();
}


//根据二级部位展示症状
function showSymptoms(obj){
    var i = $(this).index();
    var part_level1 = $(obj).attr("data-partid");
    var part_level1_title = $(this).html();
    $.ajax({
            type: 'post',
            url: '/zicha/query/',
            data: {'type':3, 'partid':part_level1, 'partname':part_level1_title } ,
            dataType: 'html',
            beforeSend: function(){
                $("#allPart3 ul").html('<li><a href="javascript:void(0);" target="_self">加载中...</a></li>');
            },
            success: function(data){
                $("#allPart3 ul").html(data);
            },
            error: function(){}
    });
        
    $(this).addClass('on');
    $('.small-parts li').removeClass('on');
    $('.third-parts').hide();
    $('.third-parts').show();
}

function showDisease(url){
    var user_sex=user_age=user_job='';
    //获取性别数据
    user_sex = $('.sexdul .currt').attr('data-sex');
    
    //获取年龄
    user_age = $('.age .set').attr('data-age');
    
    //获取职业
    user_job = $('.profess p.currmd').attr('data-job');
    window.location.href = url + '&sex='+user_sex+'&age='+user_age+'&job='+user_job;
    return false;
}
/**
 * 
 * @param {type} ele 当前操作对象
 * @param {type} cookie 是否写入cookie
 * @returns {Boolean}
 */
function jumpUrl(ele,cookie){
    var user_sex=user_age=user_job='';
    //获取性别数据
    user_sex = $('.sexdul .currt').attr('data-sex');
    //获取年龄
    user_age = $('.age .set').attr('data-age');
    //获取职业
    user_job = $('.profess p.currmd').attr('data-job');
    var url = $(ele).attr("data-url");
    var symptomid = $(ele).attr("data-symptomid");
    var symptomname = $(ele).attr("title");
    if(cookie==1){
        setHistoryCookie(symptomid, symptomname);
    }
    window.location.href = url + '&sex='+user_sex+'&age='+user_age+'&job='+user_job;
    return false;
}
//http://img.39.net/js/db/jbk/selfDiagnosisAll_new.js
function setHistoryCookie(sid, sname) {
    var oldCookie=$.cookie("symSelectHistory");
    var newCookie=sid+"|"+sname;
    if(oldCookie!=undefined&&oldCookie.length>0) {
        var cookieArr=oldCookie.split(',');
        var iToRemove= -1;
        for(var i=0; i<cookieArr.length; i++) {
            if(sname==cookieArr[i].split('|')[1]) {
                iToRemove=i;
            }
        }
        if(iToRemove>=0) {
            for(var i=0; i<cookieArr.length; i++) {
                if(i!=iToRemove) {
                    newCookie+=","+cookieArr[i];
                }
            }
        }
        else {
            newCookie+=","+oldCookie;
        }
    }
    var cookieLength=newCookie.split(',').length;
    if(cookieLength>7) {
        newCookie=newCookie.substring(0, newCookie.lastIndexOf(','));
    }
    $.cookie("symSelectHistory", newCookie, { expires: 30, path: '/' });
};

function loadHistory(cookieHistory) {
    var cookieArr=cookieHistory.split(',');
    for(var i=0; i<cookieArr.length; i++) {
        var item=cookieArr[i].split('|');
        $(".query-log").append("<a href='javascript:void(0);' onclick='jumpUrl(this,0)' data-url='/zicha/jbzc_jg/?symptomid="+item[0]+"' data-symptomid='"+item[0]+"'>"+item[1]+"</a>");
    }
    $(".query-log a").click(function() {
        var sid=parseInt($(this).attr("data-symptomid"));
        if(sid>0) {
            setHistoryCookie(sid, $(this).html());
            //selectFirstSym(sid, $(this).html());
//            gotoPage3(sid,$(this).html());
        }
//        else {
//            clickHintToSearch($(this).html());
//        }
    });
//    $(".query-log").append("<span id='clearHistory'>-清空历史记录-</span>");
//    $("#clearHistory").click(function() {
//        clearHistory();
//    });
//    $("#searchHints").addClass("mySearList2");
}
var cookieHistory=$.cookie("symSelectHistory");
if(cookieHistory!=''&&cookieHistory!=undefined) {
    loadHistory(cookieHistory);
}