// JavaScript Document
$(function(){

    $('.mainleve').mouseenter(function () {

        $('.current').find("ul").hide();

        $('.current').removeClass('current');

        $(this).find('i.n_whi').addClass("current");

        $(this).find("ul").slideDown("fast");

    }).mouseleave(function () {

        $(this).find("ul").hide();

        $(this).find('i.n_whi').removeClass('current');

    });
           Qfast.add('widgets', { path: "http://ask.9939.com/ask_details/js/terminator2.2.min.js", type: "js", requires: ['fx'] });  
            Qfast(false, 'widgets', function () {
            K.tabs({
            id: 'fsD1',   //焦点图包裹id  
            conId: "D1pic1",  //** 大图域包裹id  
            tabId:"D1fBt",  
            tabTn:"a",
            conCn: '.fcon', //** 大图域配置class       
            auto: 1,   //自动播放 1或0
            effect: 'fade',   //效果配置
            eType: 'click', //** 鼠标事件
            pageBt:true,//是否有按钮切换页码
            bns: ['.prev', '.next'],//** 前后按钮配置class                          
            interval:5000  //** 停顿时间  
          }) 
       })   
	   $('.currm').mousemove(function () {
                    var zimu = $(this).attr('switc');
                    var className=".lett-tab-" + zimu;
                    $('.move').removeClass('move');
                    $(this).addClass('move');
                    var div=$(".lett-tab-con").find(className);
                    $(".lett-tab-con div").addClass('curro');
                    if(div){
                        div.removeClass('curro');
                    }
                }).click(function(){
                    return false;
     });
	   $('.flonews:nth-child(3)').css('margin-right','0');
});

