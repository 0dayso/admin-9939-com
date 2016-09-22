$(function () {

    var al_a = $('.lent a');

    al_a.mousemove(function () {

        var data_id = $(this).attr("data-id");

        var div_chg_obj = $("#div_"+data_id);

        div_chg_obj.find(".bpics").hide().eq($(this).index()).show();

        $(this).addClass('a_curr').siblings().removeClass('a_curr');

    });
    var navLi = $(".subNav");
    navLi.hover(function () {
        $(this).children("ul.navContent").show();
    }, function () {
        $(this).children("ul.navContent").hide();
    });
    var tab_a = $('.tabqh a');
    var tab_box = $('.tabbox');
    tab_a.mousemove(function () {
        $(this).addClass('omline').siblings().removeClass('omline');
        tab_box.hide().eq($(this).index()).show();
    });
    $(".tab").find(".tip a").css({'color': '#fff'});
    $(".bpics").find(".ims:nth-child(2),.ims:nth-child(4)").css({'margin-right': '0'});
    $(".Rcolumn").find("span:nth-child(3)").css({'margin-botttom': '0'});
    $(".tab").find(".tip a").css({'color': '#fff'});
    $(".bpics").find(".ims:nth-child(2),.ims:nth-child(4)").css({'margin-right': '0'});
    $(".bpics").find(".ims:nth-child(3),.ims:nth-child(4)").css({'margin-bottom': '0'});
    $(".Rcolumn").find("span:nth-child(3)").css({'margin-botttom': '0'});
    $(".label").find("a:nth-child(4),a:nth-child(8),a:nth-child(12)").css({'margin-right': '0'});

    $(".label").find("a:nth-child(9),a:nth-child(10),a:nth-child(11),a:nth-child(12)").css({'margin-bottom': '0'});
	$('.cancer li:nth-child(9),.cancer li:nth-child(18)').css('margin-right','0');
	$('.cancer li:nth-child(1),.cancer li:nth-child(4),.cancer li:nth-child(14)').css({'background':'url(images/yel_02.gif) no-repeat'}).find('a').css('color','#f60').append('<div class="hotar">閻戯拷</div>');
	$('.provi p:last-child').css('color','#666');
	$('.diran,.inran').find('li:nth-child(1) span.srt,li:nth-child(2) span.srt,li:nth-child(3) span.srt').css('background','#f60');
	$('.diran').find('li:nth-child(1) .rand_01 a,li:nth-child(2) .rand_01 a').css('color','#f60');
	$('.hanpo,.exnic').find('li:last').css('border-bottom','none');
	$('.diran li:last-child .rand_01').css('border-bottom','none');
	$('.focar').find('a:nth-child(3),a:nth-child(1),a:nth-child(2),a:nth-child(4)').css('border-right','none');
	$('.cuchei').find('p:last').css({'height':'100px','overflow':'hidden'});
	$('.lodrea').find('dd:first-child span.nuto_01,dd:nth-child(2) span.nuto_01,dd:nth-child(3) span.nuto_01').css('background','#f60');
	$('.lodrea').find('dd:first-child a,dd:nth-child(2) a').css('color','#f60');
	$('.lodrea').find('dd:last').css('border-bottom','none');
	$('.protex').find('p:nth-last-child(1),p:nth-last-child(2)').css('margin-bottom','0');
	//712
	$('.finin').find('li:nth-child(3n+3)').css('margin-right','0');
	
	
	
	$('.shacon div').hover(function(){
		$(this).parent().find('ul').show();	
	});
	$('.shacon ul,.shacon').mouseleave(function(){
		$('.shacon ul').hide();	
	});
	$('.art_s').find('a:last').css('text-decoration','none');
	$('.hotei,.drupro').find('li:last').css('border-bottom','none');
	$('.rig a.rist').click(function(){
		$('.adse').fadeIn(500,function(){
			$(this).fadeOut(3000);	
		});	
		
	});
	$('.rig a.nori').click(function(){
		$('.succe').fadeIn(500,function(){
			$(this).fadeOut(3000);	
		});	
		
	});
	$('.hoque').find('li:odd').css('margin-right','0');
	$('.einfo').find('li:nth-child(3n+3)').css('margin-right','0');
	$('.enam').find('li:last-child').css('margin-right','0');
	$('.List_box_tul').find('li:last').css('border-right','none');
	$('.fitmou').find('li:first').css('border-top','none');
	$('.placn').append('<a class="riga" href=""></a>');
	
	$('.rightbar dd.hel_01').hover(function(){
		$('.rightbar dt').show();	
	},function(){
		$('.rightbar dt').hide();		
	});
	$('.rightbar dt').hover(function(){
		$(this).show();
		$('.rightbar dd.hel_01').addClass('hecur');
	},function(){
		$(this).hide();	
		$('.rightbar dd.hel_01').removeClass('hecur');
	});
	//1閻ゅ墽姊剧粻鈧禒瀣剨閸戝搫鐪�
	$('a.aind').hover(function(){
		$(this).parent('p').next('.stat').removeClass('disn').addClass('shay');
		
	});
	$('.stat').hover(function(){
		$(this).removeClass('disn').addClass('shay');
		
	},function(){
		$(this).removeClass('shay').addClass('disn');	
	});
	//妫ｆ牠銆夌€涙鐦濇稉瀣拨
	$('.lettf a').not(":eq(0)").hover(function(){
		var ind=$(this).index();
		
		$('.lettf a').removeClass('indexahover');
		$(this).addClass('indexahover');
		$('.outro').removeClass('shc').addClass('disn');	
		$('.outro').eq(ind-1).removeClass('disn').addClass('shc');
	});
	//閸掓銆冩い闈涚摟濮ｅ秳绗呭锟�
	$('.leume a').hover(function(){
		var inde=$(this).index();
		$('.leume a').removeClass('indexahover');
		$(this).addClass('indexahover');	
		$('.lett-tab-con div').removeClass('shc').addClass('disn');	
		$('.lett-tab-con div').eq(inde).removeClass('disn').addClass('shc');
	});
	//鐢瓕顫嗛悿鍓ф⒕閵嗕胶顫栫€广倕鍨忛幑锟�
	$('.bdisea a').hover(function(){
		var inde=$(this).index();
		$('.bdisea a').removeClass('indexahover');
		$(this).addClass('indexahover');	
		$('.wd_qh').removeClass('shc').addClass('disn');	
		$('.wd_qh').eq(inde).removeClass('disn').addClass('shc');
	});
	//鐢瓕顫嗛悿鍓ф⒕
	$('.syname a').hover(function(){
		var inde=$(this).index();
		$(this).parent().find('a').removeClass('indexahover');
		$(this).addClass('indexahover');	
		$(this).parent().next('.prout').find('.power').removeClass('shc').addClass('disn');	
		$(this).parent().next('.prout').find('.power').eq(inde).removeClass('disn').addClass('shc');
	});
	//妫ｆ牠銆夐幐澶夋眽缂囥倖鐓￠悿鍓ф⒕
	$('.dislid a').hover(function(){
		var inde=$(this).index();
		$(this).parent().find('a').removeClass('indexahover');
		$(this).addClass('indexahover');	
		$(this).parents('.comdi').find('.expsy').removeClass('shc').addClass('disn');	
		$(this).parents('.comdi').find('.expsy').eq(inde).removeClass('disn').addClass('shc');
	});
	//閸栧娅岄柅鐔哥叀
	$('.fasf a').hover(function(){
		var inde=$(this).index();
		$(this).parent().find('a').removeClass('indexahover');
		$(this).addClass('indexahover');	
		$(this).parents('.inqui').find('.hosfa').removeClass('shc').addClass('disn');	
		$(this).parents('.inqui').find('.hosfa').eq(inde).removeClass('disn').addClass('shc');
	});
	
	
	/*闁劋缍呴崪宀€妫侀悩锟�*/
	$('.point_more').addClass('disn');
	var nearr_01=$('.part-list1').find('>dl,>div');
	var nearr_02=$('.part-list2').find('>dl,>div');
	nearr_01.each(function(index){
		if($('.part-list1').height()>56){
			nearr_01.eq(-index).addClass('disn new');
			$('.part-list1').find('.point_more3').removeClass('disn').addClass('shay');;
		}
	});
	nearr_02.each(function(index){
		if($('.part-list2').height()>56){
			nearr_02.eq(-index).addClass('disn new');
			$('.part-list2').find('.point_more4').removeClass('disn').addClass('shay');;
		}
			
	});
	/*娴兼挳娈㈤惀鍥╁Ц闂勬劕鍩楃€涙鏆�*/
	var nearr_01=$('.limwo').find('li .fisin a');
	var heico=$('.limwo li .fisin');
	var len=$('.limwo').find('li .fisin a').length;
	nearr_01.each(function(){
		if(heico.height()>32){
			nearr_01.eq(-index-1).addClass('disn');
		}
		
		
	});
	
	
	/*鐏炴洖绱戦梾鎰*/
	$('.point_more').click(function(){
		if($(this).attr('data_t')=='1'){
			$(this).parent().find('>dl[class*="new"],>div[class*="new"]').removeClass('shay').addClass('disn');
			
			
			$(this).removeClass('point_more2');	
			$(this).attr('data_t','0');
		}
		else{
			$(this).parent().find('>dl,>div').removeClass('disn').addClass('shay');	
			$(this).addClass('point_more2');
			$(this).attr('data_t','1');
		}
	});	


	$('.tocun a.mopla').click(function(){
		var dval=$(this).attr('data-ct');
		if(dval==1){
			$(this).parents('.unkno').next('.palce').hide();
			$(this).attr('data-ct','0');
		}
		else{
			$(this).parents('.unkno').next('.palce').show();
			$(this).attr('data-ct','1');	
		}
		isshow=false;
	});
	$('.palce img').click(function(){
		$(this).parents('.palce').hide();
		$(this).parents('.palce').prev('.unkno').find('.mopla').attr('data-ct','0');	
	});
	
	$('.city dd').find('a:last').css('margin-right','0');
	$('.direl li:odd').css('margin-right','0');
	$('.fitfoo li:odd').css('left','418px');
	/*鐎佃壈鍩呴弽宄扮础*/
	/*閸掑洦宕查崺搴＄*/
	$('.sepla').click(function(){
		$(this).next('.city:eq(0)').removeClass('disnon').addClass('shw');
		$('.city:eq(0) a').click(function(){
			var newv=$(this).html();
			$('.choar span:first').html(newv);
			$(this).parents('.city').removeClass('shw').addClass('disnon');
			$(this).parents('.city').next('.city').removeClass('disnon').addClass('shw');
		});
		$('.city:eq(1) a').click(function(){
			var newv_=$(this).html();
			$('.choar span:last').html(newv_);
			$(this).parents('.city').removeClass('shw').addClass('disnon');	
		});
	});
	 $('.city p img').click(function(){
		$(this).parents('.city').removeClass('shw').addClass('disnon'); 
	});
	 $('.city dt b').click(function(){
		$(this).parents('.city').removeClass('shw').addClass('disnon'); 
		$(this).parents('.city').prev().removeClass('disnon').addClass('shw');
	});
	/*鐎规粌鎮嗚箛灞芥倖*/
	$('.fitfoo p.def_01 a').click(function(){
		$(this).parent().removeClass('shw').addClass('disnon'); 
		$(this).parent().next('.def_02').removeClass('disnon').addClass('shw');
		$(this).parents('li').addClass('refit');
	});
	$('.fitfoo p.def_02 a').click(function(){
		$(this).parent().removeClass('shw').addClass('disnon'); 
		$(this).parent().prev('.def_01').removeClass('disnon').addClass('shw');
		$(this).parents('li').removeClass('refit');
	});
	//鐎佃壈鍩呮潻钘夊div
	$('.diack a').append('<div></div>');
	/*ends*/
	$('.eddi dd a').each(function(){
		var conle=$(this).width();
		if(conle>100){
			$(this).css('width','129px');
			$(this).parent().find('.hola').css({"position":"absolute","right":"-5px","top":"0"});	
		}	
		else{
				
		}
	});
	$('.yanz a').mouseover(function(){
		$(this).parent().find('a').removeClass('indexahover');
		$(this).addClass('indexahover');
		var vaf=$(this).index();
		
		$('.newn').find('.eddi').removeClass('shw').addClass('disnon');
		$('.newn').find('.eddi:eq('+vaf+')').removeClass('disnon').addClass('shw');
		
	});
	 
	
	$('.lefna li').hover(function(){
		var $index=$('.lefna li').index(this);
		var $shol=$('.slaye .sholay');
		$shol.parent().find('.sholay').hide();
		$(this).parent().find('li').removeClass('cures');
		$(this).parent().find('li').css('border-right','1px solid #5ccd78');
		$(this).css('border-right','none');
		if($index==0){
			
			$(this).find('span.spi_01').addClass('spi_01c');	
		}
		else if($index==1){
			$(this).find('span.spi_02').addClass('spi_02c');	
		}
		else if($index==2){
			$(this).find('span.spi_03').addClass('spi_03c');	
		}
		else if($index==3){
			$(this).find('span.spi_04').addClass('spi_04c');	
		}
		else if($index==4){
			$(this).find('span.spi_05').addClass('spi_05c');	
		}
		else if($index==5){
			$(this).find('span.spi_06').addClass('spi_06c');	
		}
		else if($index==6){
			$(this).find('span.spi_07').addClass('spi_07c');	
		}
		else if($index==7){
			$(this).find('span.spi_08').addClass('spi_08c');	
		}
		else if($index==8){
			$(this).find('span.spi_09').addClass('spi_09c');	
		}
		else if($index==9){
			$(this).find('span.spi_10').addClass('spi_10c');	
		}
		else{
			$(this).find('span.spi_11').addClass('spi_11c');	
		}
		
		$shol.eq($index).show();
		
	},function(){
		var $index=$('.lefna li').index(this);
		
		if($index==0){
			
			$(this).parent().find('span').removeClass('spi_01c');	
		}
		else if($index==1){
			$(this).parent().find('span').removeClass('spi_02c');	
		}
		else if($index==2){
			$(this).parent().find('span').removeClass('spi_03c');	
		}
		else if($index==3){
			$(this).parent().find('span').removeClass('spi_04c');	
		}
		else if($index==4){
			$(this).parent().find('span').removeClass('spi_05c');	
		}
		else if($index==5){
			$(this).parent().find('span').removeClass('spi_06c');	
		}
		else if($index==6){
			$(this).parent().find('span').removeClass('spi_07c');	
		}
		else if($index==7){
			$(this).parent().find('span').removeClass('spi_08c');	
		}
		else if($index==8){
			$(this).parent().find('span').removeClass('spi_09c');	
		}
		else if($index==9){
			$(this).parent().find('span').removeClass('spi_10c');	
		}
		else{

			$(this).parent().find('span').removeClass('spi_11c');	
		}
		
	});
	$('.lefna').mouseleave(function(){
		$(this).find('li').css('border-right','none');
	});
	$('.slaye .sholay').hover(function(){
		var $index1=$('.slaye .sholay').index(this);
		var $lic=$('.lefna li');
		$(this).show();
		//$lic.css('border-right','1px solid #58c573');
		$lic.eq($index1).addClass('cures');
		$lic.eq($index1).parent().find('li').css('border-right','1px solid #5ccd78');
		$lic.eq($index1).css('border-right','none');
		
		if($index1==0){
			$lic.find('span.spi_01').addClass('spi_01c');	
		}
		else if($index1==1){
			$lic.find('span.spi_02').addClass('spi_02c');	
		}
		else if($index1==2){
			$lic.find('span.spi_03').addClass('spi_03c');	
		}
		else if($index1==3){
			$lic.find('span.spi_04').addClass('spi_04c');	
		}
		else if($index1==4){
			$lic.find('span.spi_05').addClass('spi_05c');	
		}
		else if($index1==5){
			$lic.find('span.spi_06').addClass('spi_06c');	
		}
		else if($index1==6){
			$lic.find('span.spi_07').addClass('spi_07c');	
		}
		else if($index1==7){
			$lic.find('span.spi_08').addClass('spi_08c');	
		}
		else if($index1==8){
			$lic.find('span.spi_09').addClass('spi_09c');	
		}
		else if($index1==9){
			$lic.find('span.spi_10').addClass('spi_10c');	
		}
		else{
			$lic.find('span.spi_11').addClass('spi_11c');	
		}
		
	},function(){
		var $index1=$('.slaye .sholay').index(this);	
		var $lic=$('.lefna li');
		$lic.eq($index1).parent().find('li').css('border-right','none');
		if($index1==0){
			
			$lic.parent().find('span').removeClass('spi_01c');	
		}
		else if($index1==1){
			$lic.parent().find('span').removeClass('spi_02c');	
		}
		else if($index1==2){
			$lic.parent().find('span').removeClass('spi_03c');	
		}
		else if($index1==3){
			$lic.parent().find('span').removeClass('spi_04c');	
		}
		else if($index1==4){
			$lic.parent().find('span').removeClass('spi_05c');	
		}
		else if($index1==5){
			$lic.parent().find('span').removeClass('spi_06c');	
		}
		else if($index1==6){
			$lic.parent().find('span').removeClass('spi_07c');	
		}
		else if($index1==7){
			$lic.parent().find('span').removeClass('spi_08c');	
		}
		else if($index1==8){
			$lic.parent().find('span').removeClass('spi_09c');	
		}
		else if($index1==9){
			$lic.parent().find('span').removeClass('spi_10c');	
		}
		else{
			$lic.parent().find('span').removeClass('spi_11c');	
		}
		
	});
	$('.lefna,.slaye .sholay').mouseleave(function(){
		$('.lefna li').removeClass('cures');
		$('.slaye .sholay').hide();	
	});
	
	
	
	$('.lewom').click(function(){
			$('.perge>div').hide();
			$('.perge>a').removeClass('decur');
			$(this).addClass('decur');
			$('.risy').addClass('decur');
			$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
			$('.wobod').removeClass('disn').addClass('shc');
			$('.womfr').show();
	});
	
	$('.lefsy').click(function(){
		$('.perge>div').hide();
		$('.perge>a').removeClass('decur');
		$(this).addClass('decur');
		$('.risy').addClass('decur');
		$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
		$('.mabod').removeClass('disn').addClass('shc');
		$('.mafron').show();
		
	});
	$('.bacb').click(function(){
		if($('.lefsy').hasClass('decur')){
			$('.perge>div').hide();
			$('.perge>a').removeClass('decur');
			$(this).addClass('decur');
			$('.lefsy').addClass('decur');
			$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
			$('.mabeh').removeClass('disn').addClass('shc');
			$('.manbe').show();	
		}
		else if($('.lewom').hasClass('decur')){
			$('.perge>div').hide();
			$('.perge>a').removeClass('decur');
			$(this).addClass('decur');
			$('.lewom').addClass('decur');
			$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
			$('.wobeh').removeClass('disn').addClass('shc');
			$('.wombe').show();		
			
		}
		
	});
	
	$('.risy').click(function(){
		if($('.lefsy').hasClass('decur')){
			$('.perge>div').hide();
			$('.perge>a').removeClass('decur');
			$(this).addClass('decur');
			$('.lefsy').addClass('decur');
			$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
			$('.mabod').removeClass('disn').addClass('shc');
			$('.mafron').show();	
		}
		else if($('.lewom').hasClass('decur')){
			$('.perge>div').hide();
			$('.perge>a').removeClass('decur');
			$(this).addClass('decur');
			$('.lewom').addClass('decur');
			$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
			$('.wobod').removeClass('disn').addClass('shc');
			$('.womfr').show();		
		}
	});
	
	var cleartime;
	$('.total div').mouseover(function(){
		var $this = $(this);
		
		clearTime = setTimeout(function () {
		var inde=$this.index();
			var valc=$this.parent();
			var male=$('.mafron');
			var maleb=$('.manbe');
			var woma=$('.womfr');
			var womab=$('.wombe');
			
			valc.find('div').removeClass('shocon').addClass('dinone');	
			$this.removeClass('dinone').addClass('shocon');
			if(male.is(":visible")){
				$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
				$('.mabod').removeClass('disn').addClass('shc');
				$('.mabod .hurt').removeClass('shc').addClass('disn');
				$('.mabod').find('.hurt:eq('+inde+')').removeClass('disn').addClass('shc');	
				
			}
			else if(maleb.is(":visible")){
				$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
				$('.mabeh').removeClass('disn').addClass('shc');
				$('.mabeh .hurt').removeClass('shc').addClass('disn');
				$('.mabeh').find('.hurt:eq('+inde+')').removeClass('disn').addClass('shc');	
			}
			else if(woma.is(":visible")){
				$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
				$('.wobod').removeClass('disn').addClass('shc');
				$('.wobod .hurt').removeClass('shc').addClass('disn');
				$('.wobod').find('.hurt:eq('+inde+')').removeClass('disn').addClass('shc');	
			}
			else{
				$('.mabod,.mabeh,.wobod,.wobeh').removeClass('shc').addClass('disn');
				$('.wobeh').removeClass('disn').addClass('shc');
				$('.wobeh .hurt').removeClass('shc').addClass('disn');
				$('.wobeh').find('.hurt:eq('+inde+')').removeClass('disn').addClass('shc');	
			}
		},150)
		
	 }).mouseout(function () {
        clearTimeout(clearTime);
    });
	
	
	$('.absbar ul').find('li:last').css('border-bottom','none');
	$('.diran li').hover(function(){
		$('.diran').find('.rand_02').hide();	
		$(this).find('.rand_02').show();
		$('.diran').find('.rand_01').css('border-bottom','1px dotted #e4e3e3');
		$('.diran').find('li:last .rand_01').css('border-bottom','none');
		$(this).find('.rand_01').css('border-bottom','none');
	});
	
    $(".fxah").hover(function () {

        $(this).find(".zomm").show();

    }, function () {

        $(this).find(".zomm").hide();

    });
	
	/*9.8*/
	$('.firin a').hover(function(){
		var ind=$(this).index();
		$(this).parent().find('a').removeClass('indexahover');
		$(this).addClass('indexahover');           
		$(this).parent().next().find('.sepce').removeClass('shay').addClass('disn');
		$(this).parent().next().find('.sepce').eq(ind).removeClass('disn').addClass('shay');
		
			
	});
	
	
	
	$.fn.smartFloat = function() {
	var position = function(element) {
		var top = element.position().top, pos = element.css("position");
		$(window).scroll(function() {
			var scrolls = $(this).scrollTop();
			if (scrolls > top) {
				if (window.XMLHttpRequest) {
					element.css({
						height:"52px",  <!--閺€鐟板綁妤傛ê瀹�-->
						position: "fixed",
						top: 0,
						
						margin:"0 0 20px 0"
						
					});	
				} else {
					element.css({
						top: scrolls
					});	
				}
			}else {
				element.css({
					height:"52px",	<!--鏉╂ê甯妯哄-->
					position: pos,
					top: top,
					margin:"15px 0 20px 0"
				});	
			}
		});
};
	return $(this).each(function() {
		position($(this));						 
	});
};
$.fn.smartFloatc= function() {
	var positi = function(elem) {
		var topc = elem.position().top, post = elem.css("position");
		
		$(window).scroll(function() {
			var scrol =$(this).scrollTop();
			var nval=(navigator.userAgent.toLowerCase().indexOf('se')>-1)?(scrol-105):(scrol+140);
			
			if (nval > topc) {
				if (window.XMLHttpRequest) {
					elem.css({
						position: "fixed",
						top: "52px",
						border:"1px solid #e9e9e9",
						background:"#fff"
						
					});	
				} else {
					elem.css({
						top: scrol
					});	
				}
			}else {
				elem.css({
					
					position: post,
					top: topc,
					border:"none"
				});	
			}
			
		});
};
	return $(this).each(function() {
		positi($(this));						 
	});
};
$("#float").smartFloat();	
    //缂佹垵鐣�
$("#a_floa").smartFloatc();
	
	$('.meth').find('li:first').css('margin-right','30px');
	$('.sadne').find('li:last').css('margin','20px 0 0 0');
	$('.laspa').find('li:last').css('margin-right','0');

});