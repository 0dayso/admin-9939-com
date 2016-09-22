// JavaScript Document
$(function(){
	/*用于控制登录页 获得焦点*/
	$('.frla .txt,.frla .pass').focus(function(){
		$(this).css({'border':'1px solid #00b389','color':'#00b389'});
	});
	$('.frla .txt,.frla .pass').blur(function(){
		$(this).css({'border':'1px solid #cdcdcd','color':'#999'});
	});	
	/*用户点击弹出*/
	var isshow=true;//用于控制全局显示与隐藏
	$(document).click(function(){
		if(isshow){
			var dvalatr=$('.lonan').attr('data-ct');
			if(dvalatr==1){
				$('.domenu').hide();
				$('.lonan').attr('data-ct','0');
			}
		}
		isshow=true;
	});
	$('.lonan').click(function(){
		var dval=$('.lonan').attr('data-ct');
		if(dval==1){
			$('.domenu').hide();
			$(this).attr('data-ct','0');
		}
		else{
			$('.domenu').show();
			$(this).attr('data-ct','1');	
		}
		isshow=false;
	});
	
	/*用户首页加粗样式*/
	$('.pebody').find('li:first-child b').css('color','#31ad7c');
	$('.pebody').find('li:nth-child(2) b').css('color','#f60');
	$('.pebody').find('li:nth-child(3) b').css('color','#3ad6d3');
	$('.pebody').find('li:last-child b').css('color','#fa355a');
	
	/*x delete*/
	$('.hasad a b,.imop li b').click(function(){
		var lent=$(this).parent();
		lent.remove();
		
	});
	/*左侧高度*/
	var hei=$(document).height()-90;
	var heir=$(document).height()-215;
	$('.stati').height(hei);
	$('.dis-mainnr').css('height',heir+'px');
	/*模拟select*/
	$('a.dome').click(function(){
		var dvalt=$('a.dome').attr('data-ctt');
		if(dvalt==1){
			$(this).next('.specs').hide();
			$(this).attr('data-ctt','0');
		}
		else{
			$(this).next('.specs').show();
			$(this).attr('data-ctt','1');	
		}
	});
	$('.fihou a').click(function(){
		var neva=$(this).html();
		$(this).parents('.clasfi').find('input').val(neva);
		$(this).parents('.specs').hide();
		$('a.dome').attr('data-ctt','0')
	});
	$('a.closb').click(function(){
		$('.specs').hide();	
	});
	/*审核点击*/
	$('.discov a').click(function(){
		var vlu=$(this).index();
		$(this).removeClass('mo').addClass('cusde');
		$(this).siblings().removeClass('cusde').addClass('mo');
		$('.isshi').hide();
		$('.isshi').eq(vlu).show();
			
	});
	/*编辑alast*/
	$('.brasho').find('a:last').css('text-decoration','none');
	/*弹出框*/
	$('.fihou').find('li:last').css('border-bottom','none');
});






















