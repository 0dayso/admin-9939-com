// JavaScript Document
$(function () {
  $('.a_prev li:nth-child(even)').css('margin-right', '0');
	$('.meth').find('li:first').css('margin-right','30px');
	$('.meau').find('li:first').css({'color':'#49c066'});
    $('.meau').find('li:last').css({'margin-left':'64px'});
    $('.onhid ').find('li:last').css({'margin-bottom':'0'});
$(".six-parts>a").hover(function() {
                     var $aThis="six-parts nz-hov"+($(this).index()+1);
                     $(".six-parts").removeClass().addClass($aThis);
                     return false;
              }); 
		   $(".seven-parts>a").hover(function() {
                     var $aThis="seven-parts nf_hov"+($(this).index()+1);
                  $(".seven-parts").removeClass().addClass($aThis);
                return false;
           });
	 $  (".seven-parts>a.me71").hover(function() {
        $(".seven-parts").removeClass().addClass("seven-parts wmb_b8");
        return false;
		  });
		  $(".msix-parts>a").hover(function() {
                     var $aThis="msix-parts mz-hov"+($(this).index()+1);
                  $(".msix-parts").removeClass().addClass($aThis);
                return false;
           }); 	
		   $(".mseven-parts>a").hover(function() {
                     var $aThis="mseven-parts mf_hov"+($(this).index()+1);
                     $(".mseven-parts").removeClass().addClass($aThis);
                   return false;
            });
      $(".mseven-parts>a.wmb71").hover(function() {
        $(".mseven-parts").removeClass().addClass("mseven-parts wmb_b7");
        return false;
		  });
 $('.smain-parts li').click(function(){
	$('.smain-parts li').removeClass('on');
	$(this).addClass('on');
	 var i = $(this).index();
//	 $('.small-parts').hide();
//	 $('.small-parts').eq(i).show();
});
$('.small-parts li').click(function(){
	$('.small-parts li').removeClass('on');
	$(this).addClass('on');
	 var i = $(this).index();
//	 $('.third-parts').hide();
//	 $('.third-parts').eq(i).show();
});
$('.currm').click(function () {
                    var zimu = $(this).attr('switc');
                    var className=".lett-tab-" + zimu;
                    $('.move').removeClass('move');
                    $(this).addClass('move');
                    var div=$(".lett-tab-c").find(className);
                    $(".lett-tab-c div").addClass('curro');
                    if(div){
                        div.removeClass('curro');
                    }
                }).click(function(){
                    return false;
     });
	 $(".lmos i").click(function(){
		$(".lmos").hide();
	});
	 $(".relatom dd").hover(function() {
                       $(this).addClass("hover");
                    }, function() {
                            $(this).removeClass("hover");
                    });
 //�Ա�
	  $('.select .women').click(function () {
            $(".man").removeClass("move")
			$(".women").addClass("move")
});  
     $('.select .man').click(function () {
            $(".women").removeClass("move")
			$(".man").addClass("move")
});

//����
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
		$(".age p").html(li).attr('data-age', $(this).attr('data-age'));
		$(".onhid").hide();
		$("p").removeClass("onku") ;   
	});

//�Ա�����

	$(".sexdul p").click(function(){
		var ul=$(".onlsex");
		if(ul.css("display")=="none"){
			ul.show();
		}else{
			ul.hide();
		}
	});
	$(".currt").click(function(){
		var _name = $(this).attr("name");
		if( $("[name="+_name+"]").length > 1 ){
			$("[name="+_name+"]").removeClass("ons");
			$(this).addClass("ons");
		} else {
			if( $(this).hasClass("ons") ){
				$(this).removeClass("ons");
			} else {
				$(this).addClass("ons");
			}
		}
	});
	
	$(".onlsex li").click(function(){
		var li=$(this).text();
		$(".sexdul p").html(li).attr('data-sex', $(this).attr('data-sex'));
                //根据用户选择的性别来显示不同的性别部位图
                if($(this).attr('data-sex') == 0){
                    $(".sympt-chose .mpl").hide();
                    $(".sympt-chose .opl").show();

                    $(".climok .mok").show();
                    $(".climok .nanmot").hide();
                }else if($(this).attr('data-sex') == 1){
                    $(".sympt-chose .mpl").show();
                    $(".sympt-chose .opl").hide();

                    $(".climok .mok").hide();
                    $(".climok .nanmot").show();
                }
		$(".onlsex").hide();
		$("p").removeClass("ons") ;   
	});

//ְҵ����

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
		$(".profess p").html(li).attr('data-job', $(this).attr('data-job'));
		$(".lmos").hide();
		$("p").removeClass("onm") ;   
	});
	
		

//��������)
    var userAgent = navigator.userAgent.toLowerCase(); 
    if(/msie/.test( userAgent ) && !/opera/.test( userAgent )){
         $('input[placeholder], textarea[placeholder]').placeholder();
    }else{
        $('input.demand').click(function(){
            $(this).attr("placeholder","");
			$(".query-log").show();
        });
    }
	$(".query-log a").click(function(){
		var neva=$(this).html();	
		$('input.demand').val(neva);
		$(".query-log").hide();
	});

    var symli=$(".smain-parts li").length/3-5;
    var symNum=0;
    $("#down-arrow").addClass("addmov");
    $("#up-arrow").click(function() {
        if(symNum<symli) {
            $(this).removeClass("addmov");
            $(".smain-parts").animate({ marginTop: "-=99px" }, 200);
            symNum++;
            $("#down-arrow").removeClass("addmov");
        } else {
            $(this).addClass("addmov");
        };
        return false;
    });
    $("#down-arrow").click(function() {
        if(symNum>0) {
            $(this).removeClass("addmov");
            $(".smain-parts").animate({ marginTop: "+=99px" }, 200);
            symNum--;
            $("#up-arrow").removeClass("addmov");
        } else {
            $(this).addClass("addmov");
        };
        return false;
    });
	$('.third-parts li:nth-child(even)').css('background', '#f9f9f9'); 
	 $('.nanmot').click(function() {
		$('.opl').show();
		$('.mpl ').hide(); 
		$('.mok').show();
		$('.nanmot').hide();
	});
	 $('.mok').click(function() {
		$('.mpl ').show();
		$('.opl').hide(); 
		$('.mok').hide();
		$('.nanmot').show();
	});
	$('.allmot').click(function() {
		$('#allPart').slideUp(300).show();
		$('.sympt-chose').slideDown(500).hide();
                $('.allparts .smain-parts li').eq(0).click();
	});
	$('.huko').click(function() {
		$('.hauman').hide();
		$('.sympt-chose').show();
	});
	$('.hotwor').find('li:odd').css('background','#fafafa');
})
	 