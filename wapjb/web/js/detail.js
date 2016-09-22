// JavaScript Document
$(function(){
	//首页点击切换
	$('.sexn a').click(function(){
		var inde=$(this).index();
		$(this).parent('.sexn').find('a').removeClass('curr');	
		$(this).addClass('curr');
		$(this).parent().next('.male').find('.sechoi').removeClass('shay').addClass('disn');
		$(this).parent().next('.male').find('.sechoi').eq(inde).removeClass('disn').addClass('shay');
	});
	//科室分类
	$('.classfi li').click(function(){
		$('.classfi li').find('div').removeClass('shay').addClass('disn');
		$('.classfi li').find('p').removeClass('disn').addClass('shay');
		$('.classfi li').find('>span').removeClass('disn').addClass('shay');	
		$('.classfi li').removeClass('cust');
		
		if($(this).attr('data-nu')=='0'){
			$(this).removeClass('cust').find('div').addClass('disn');	
			$(this).find('p').removeClass('disn').addClass('shay');
			$(this).find('>span').removeClass('disn').addClass('shay');	
			$(this).attr('data-nu','1');	
		}
		else{
			$(this).addClass('cust').find('p').removeClass('shay').addClass('disn');	
			$(this).find('div').removeClass('disn').addClass('shay');
			$(this).find('>span').removeClass('shay').addClass('disn');	
			$(this).attr('data-nu','0');
		}
	});
	//头部导航弹出
	var bool=true;
	$('a.clna').click(function(){
		if(bool){
			$('.heabar').removeClass('disn').addClass('shay');	
			bool=false;
		}
		else{
			$('.heabar').removeClass('shay').addClass('disn');	
			bool=true;		
		}	
	});
	$('span.arrow').click(function(){
		$('.heabar').removeClass('shay').addClass('disn');	
		bool=true;	
	});
	//其他查找点击展开
	var bo=true;
	$('.find dt').click(function(){
		if(bo){
			$(this).find('div').addClass('cur');
			$(this).nextAll('dd').show();
			bo=false;
		}
		else{
			$(this).find('div').removeClass('cur');
			$(this).nextAll('dd').hide();	
			bo=true;
		}
	});
	//找药品
	$('.metho a').click(function(){
		$('body').css('overflow','hidden');
		var ind=$(this).index();	
		$('.oubra').removeClass('disn').addClass('shay');
		$('.nolim .brand').eq(ind).removeClass('disn').addClass('shay');
		
	});
	$('.brand a').click(function(){
		$('body').css('overflow','visible');
		$(this).parent().removeClass('shay').addClass('disn');
		$('.oubra').removeClass('shay').addClass('disn');
		$('.nolim .brand').eq(ind).removeClass('shay').addClass('disn');
			
	});
	//最后下面没数据
	$('.stati').append('<li class="con">--下面没有更多内容了--</li>');
	//选择医院位置
	$('.lea_01,.spar').height(window.screen.height-40);
	$('.lea_01 a').click(function(){
		$('.lea_01 a').removeClass('cucs');
		$(this).addClass('cucs');
	});
	/*点击下拉*/
	var bo=true;
	$('.headis li span').click(function(){
		if(bo){
			$(this).next('.nexsib').removeClass('disn').addClass('shay');
			$(this).addClass('cusp');
			$(this).parent().css('padding-bottom','0');
			bo=false;	
		}	
		else{
			$(this).next('.nexsib').removeClass('shay').addClass('disn');
			$(this).removeClass('cusp');
			$(this).parent().css('padding-bottom','.23rem');
			bo=true;	
		}
	});
	//食疗展开收起
	var boc=true;
	$('.deserv  p a').click(function(){
		if(boc){
			$(this).parent().removeClass('shay').addClass('disn');
			$(this).parent().next('p').removeClass('disn').addClass('shay');	
			boc=false;	
		}
		else{
			$(this).parent().removeClass('shay').addClass('disn');
			$(this).parent().prev('p').removeClass('disn').addClass('shay');	
			boc=true;	
		}
	});
	//表单提交
	$('.subs').click(function(){
		$('.oubra,.tips').removeClass('disn').addClass('shay');
		$('body').css('overflow','hidden');
	});
	$('.tips a').click(function(){
		$('.oubra,.tips').removeClass('shay').addClass('disn');	
		$('body').css('overflow','visible');
	});
	//一级科室一级部位弹出
	$('.heanew b').click(function(){
		$('.oubra,.choico').removeClass('disn').addClass('shay');	
		$('body').css('overflow','hidden');
		
	});
	$('.oubra').click(function(){
		$('.oubra,.choico,.sio,.agint,.brand,.sio,.tips').removeClass('shay').addClass('disn');	
		$('body').css('overflow','visible');	
	});
	//图集弹出分享
	  $('.lstrc').click(function(){
		$('.feux0,.fred,.oubra').removeClass('disn').addClass('shay');	
	});
	 $('.cairet').click(function(){
		$('.feux0,.fred,.oubra').removeClass('shay').addClass('disn');	
	});
	
	//获得高度算出距离顶部的距离
	$('.choico').css('margin-top','-'+$('.choico').height()/2+'px');;
	/*切换正面背面*/
	var bool=true;
	$('a.fronb').click(function(){
		if($('.mal,.mal_02').is(":visible")){
			if($('.mal').is(':visible')){
				$('.mal').removeClass('shay').addClass('disn');
				$('.mal_02').removeClass('disn').addClass('shay');
				$(this).html('正面');	
			}
			else{
				$('.mal').removeClass('disn').addClass('shay');
				$('.mal_02').removeClass('shay').addClass('disn');
				$(this).html('背面');	
			}
		}	
		else{
			if($('.fem_01').is(':visible')){
				$('.fem_01').removeClass('shay').addClass('disn');
				$('.fem_02').removeClass('disn').addClass('shay');
				$(this).html('正面');	
			}
			else{
				$('.fem_01').removeClass('disn').addClass('shay');
				$('.fem_02').removeClass('shay').addClass('disn');
				$(this).html('背面');	
			}	
		}
	});
	//点击展示男女
	$('.btns span').click(function(){
		var cuclic=$(this).attr('class');
		if(cuclic=='sp_02'){
			$(this).prev('span').removeClass('sp_01c');
			$('.btns span.sp_02').addClass('sp_02c');
			$('.prso').find('div.mal,div.mal_02,div.fem_01,div.fem_02').removeClass('shay').addClass('disn');	
			$('.fem_01').removeClass('disn').addClass('shay');	
		}
		else{
			$(this).next('span').removeClass('sp_02c');
			$('.btns span.sp_01').addClass('sp_01c');
			$('.prso').find('div.mal,div.mal_02,div.fem_01,div.fem_02').removeClass('shay').addClass('disn');	
			$('.mal').removeClass('disn').addClass('shay');			
		}	
	});
	//职位弹出
	$('.yeaid').click(function(){
		$('.oubra,.age').removeClass('disn').addClass('shay');	
	});
	$('.teac').click(function(){
		$('.oubra,.work').removeClass('disn').addClass('shay');	
	});
	$('a.acali,.confo').click(function(){
		$('.oubra,.agint').removeClass('shay').addClass('disn');	
		
	});
	$('.plav a').click(function(){
		$('.plav a').removeClass('defs');
		$(this).addClass('defs');	
	});
	//疾病症状分享
	$('a.shic').click(function(){
		$('.arsha,.oubra').removeClass('disn').addClass('shay');
		$('body').css('overflow','hidden');
	});
	$('.cairet').click(function(){
		$('.arsha,.oubra').removeClass('shay').addClass('disn');	
		$('body').css('overflow','visible');
	});
	//全国科室点击
	$('.ncont a:first-child,.ncont a:nth-child(2),.fincou a:first-child').click(function(){
		$('.oubra').hide();	
	});
	/*点击查看更多下拉*/
	var bo=true;
	$('a.agmor').click(function(){
		if(bo){
			$('.diacl p').removeClass('inde').addClass('dimor');
			$(this).html('收起');
			bo=false;
		}
		else{
			$('.diacl p').removeClass('dimor').addClass('inde');
			$(this).html('点击查看更多');
			bo=true;	
		}
	});
	//文章页加大字体
	var isMax=true;
	$('.sourc a').click(function(){
		if(isMax){
			$('.bocon p').addClass('maxf');
			$(this).find('sup').html('-');
			isMax=false;		
		}
		else{
			$('.bocon p').removeClass('maxf');
			$(this).find('sup').html('+');	
			isMax=true;			
		}
	});
	//展开全部
	var isExpa=true;
	
	$('a.loama').click(function(){
		if(isExpa){
			$('.auwin p').removeClass('inde').addClass('dimor');
			$(this).html('收起');
			isExpa=false;		
		}
		else{
			$('.auwin p').removeClass('dimor').addClass('inde');
			$(this).html('点击查看更多')
			isExpa=true;		
		}
	});
	//疾病自查5标签收起
	var seva=true;
	$('.isno .spfi_02').click(function(){
		$('.bolcy').removeClass('disn').addClass('shay');
		$('.boli').removeClass('shay').addClass('disn');
	});
	//点击弹出页面
	$('.confir a').click(function(){
		$('.bolcy').removeClass('shay').addClass('disn');
		$('.boli').removeClass('disn').addClass('shay');	
	});
	//症状自查5
	
	$('.cusyp a').click(function(){
		var index=$(this).index();
		if(index!=0){
			if($(this).attr('data-s')=='1'){
				$(this).removeClass('cus').css({'border':'1px solid #e6e5e5','color':'#333'});	
				$(this).attr('data-s','0');	
			}
			else{
				$(this).addClass('cus').css({'border':'1px solid #49c066','color':'#49c066'});	
				$(this).attr('data-s','1');	
			}
		}
	});
});