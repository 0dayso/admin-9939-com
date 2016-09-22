// JavaScript Document
$(function () {
//	$('.d-pop-dow').click(function(){
//		$('.qbwrt_shn').show();	
//	});
	$('.d-pop-up').click(function(){
		$('.qbwrt_sh').show();	
	});
//	 $('.d-errtu').click(function(){
//		$('.qbwrt').hide();	
//	});
        $(document).on('click','.d-pop-dow',function(){
            $('.qbwrt_shn').show();	
        });
        $(document).on('click','.d-errtu',function(){
            $('.qbwrt').hide();	
        });
  $('.a_prev li:nth-child(even)').css('margin-right', '0');
	$('.meth').find('li:first').css('margin-right','30px');
	$('.meau').find('li:first').css({'margin-right':'24px'});
    $('.onhid ').find('li:last').css({'margin-bottom':'0'});
$("tr:even").css("background","#f8f8f8");
$('.meth').find('li:first').css('margin-right','30px');
  $('th:nth-child(1)').css(' border-left','1px solid #f60');
	$('.ells-two th:nth-child(1)').css('width', '45px'); 
    $('.ells-two th:nth-child(2)').css('width', '128px;'); 
	 $('.ells-two th:nth-child(3)').css('width', '160px'); 
     $('.ells-two th:nth-child(4)').css('width', '174px');
	  $('.ells-two th:nth-child(5)').css('width', '183px'); 
     $('.ells-two th:nth-child(6)').css('width', '287px');
	 $('.ells-threo th:nth-child(1)').css('width', '45px'); 
    $('.ells-threo th:nth-child(2)').css('width', '111px;'); 
	 $('.ells-threo th:nth-child(3)').css('width', '107px'); 
     $('.ells-threo th:nth-child(4)').css('width', '93px');
	  $('.ells-threo th:nth-child(5)').css('width', '97px'); 
     $('.ells-threo th:nth-child(6)').css('width', '247px');
	 $('.ells-threo th:nth-child(7)').css('width', '94px');
	 $('.ells-threo th:nth-child(8)').css('width', '180px');
	  $('.ells-four th:nth-child(1)').css('width', '62px'); 
     $('.ells-four th:nth-child(2)').css('width', '113px'); 
	 $('.ells-four th:nth-child(3)').css('width', '183px'); 
     $('.ells-four th:nth-child(4)').css('width', '625px');
	  $('.ells-five th:nth-child(1)').css('width', '45px'); 
     $('.ells-five th:nth-child(2)').css('width', '98px'); 
	 $('.ells-fiveth:nth-child(3)').css('width', '215px'); 
     $('.ells-five th:nth-child(4)').css('width', '87px');
	   $('.ells-five th:nth-child(5)').css('width', '72px');
	     $('.ells-five th:nth-child(6)').css('width', '84px');
		   $('.ells-five th:nth-child(7)').css('width', '80px');
		     $('.ells-five th:nth-child(8)').css('width', '64px');
			  $('.ells-five th:nth-child(9)').css('width', '230px');
$(".d-symp-m li").hover(function() {
                       $(this).addClass("hover");
                    }, function() {
                            $(this).removeClass("hover");
                    });
	
$(function () {
	//年龄
	$(".age p").click(function(){
		var ul=$(".onhid");
		if(ul.css("display")=="none"){
			ul.show();
		}else{
			ul.hide();
		}
	});
	$(".set").click(function(){
		var _name = $(this).attr("name");
		if( $("[name="+_name+"]").length > 1 ){
			$("[name="+_name+"]").removeClass("onku");
			$(this).addClass("onku");
		} else {
			if( $(this).hasClass("onku") ){
				$(this).removeClass("onku");
			} else {
				$(this).addClass("onku");
			}
		}
	});
  
	$(".onhid li").click(function(){
		var li=$(this).text();
		$(".age p").html(li);
		$(".onhid").hide();
		$("p").removeClass("onku") ;   
	});
   //职业下拉
	//职业下拉
  $(function(){
	$(".profess  p").click(function(){
		var ul=$(".lmos");
		if(ul.css("display")=="none"){
			ul.show();
		}else{
			$(".profess").css()
			ul.hide();
		
		}
	});
	$(".currmd").click(function(){
		var _name = $(this).attr("name");
		if( $("[name="+_name+"]").length > 1 ){
			$("[name="+_name+"]").removeClass("onm");
			$(this).addClass("onm");
		} else {
			if( $(this).hasClass("onm") ){
				$(this).removeClass("onm");
			} else {
				$(this).addClass("onm");
			}
		}
	});
	
	$(".lmos li").click(function(){
		var li=$(this).text();
		$(".profess p").html(li);
		$(".lmos").hide();
		$("p").removeClass("onm") ;   
	});
	$(".d-symp-m li i").click(function(){
			$(this).parent().eq(0).remove();	   
		  });
})

})
})
