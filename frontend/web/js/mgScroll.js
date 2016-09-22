
jQuery.fn.imageScroller = function(params){
	var p = params || {
		next:"buttonNext",
		prev:"buttonPrev",
		top:"buttonTop",
		bottom:"buttonBottom",
		frame:"viewerFrame",
		scrolltime:1000,
		width:100,
		height:100,
		child:"a",
		turndirection:"turnLeft",
		auto:"turnLeft"
	}; 
	var _btnNext = $("#"+ p.next);
	var _btnPrev = $("#"+ p.prev);
	var _btnTop = $("#"+ p.top);
	var _btnBottom = $("#"+ p.bottom);
	var _imgFrame = $("#"+ p.frame);
	var _width = p.width;
	var _height = p.height;
	var _top = p.top;
	var _bottom = p.bottom;
	var _child = p.child;
	var _auto = p.auto;
	var _itv;
	var _scrolltime=p.scrolltime;
	var _turndirection=p.turndirection;
	
	var turnLeft = function(){
		_btnPrev.unbind("click",turnLeft);
		if(_auto) autoStop();
		_imgFrame.animate( {marginLeft:-_width}, 'slow', '', function(){
			_imgFrame.find(_child+":first").appendTo( _imgFrame );
			_imgFrame.css("marginLeft",0);
			_btnPrev.bind("click",turnLeft);
			if(_auto) autoPlay();
		});
	};
	
	var turnRight = function(){
		_btnNext.unbind("click",turnRight);
		if(_auto) autoStop();
		_imgFrame.find(_child+":last").clone().show().prependTo( _imgFrame );
		_imgFrame.css("marginLeft",-_width);
		_imgFrame.animate( {marginLeft:0}, 'slow' ,'', function(){
			_imgFrame.find(_child+":last").remove();
			_btnNext.bind("click",turnRight);
			if(_auto) autoPlay(); 
		});
	};
	var turnTop = function(){
		_btnTop.unbind("click",turnTop);
		if(_auto) autoStop();
		_imgFrame.animate( {marginTop:-_height}, 'slow', '', function(){
			_imgFrame.find(_child+":first").appendTo( _imgFrame );
			_imgFrame.css("marginTop",0);
			_btnTop.bind("click",turnTop);
			if(_auto && _turndirection=='turnTop') autoTopPlay();
		});
	};
	var turnBottom = function(){
		_btnBottom.unbind("click",turnBottom);
		if(_auto) autoStop();
		_imgFrame.find(_child+":last").clone().show().prependTo( _imgFrame );
		_imgFrame.css("marginTop",-_height);
		_imgFrame.animate( {marginTop:0}, 'slow' ,'', function(){
			_imgFrame.find(_child+":last").remove();
			_btnBottom.bind("click",turnBottom);
			if(_auto) autoTopPlay(); 
		});
	};
	
	_btnNext.css("cursor","hand").click( turnRight );
	_btnPrev.css("cursor","hand").click( turnLeft );
	_btnTop.css("cursor","hand").click( turnTop );
	_btnBottom.css("cursor","hand").click( turnBottom );
	
	var autoPlay = function(){
	  _itv = window.setInterval(turnLeft, _scrolltime);
	};
	var autoTopPlay = function(){
	  _itv = window.setInterval(turnTop, _scrolltime);
	};
	var autoStop = function(){
		window.clearInterval(_itv);
	};
	if(_auto && _turndirection=='turnTop'){
			autoTopPlay();
		}else{ autoPlay();}
};
	$(function(){
		$("#anbox").imageScroller({
			next:"anleft1",
			prev:"anright1",
			frame:"li_wrap1",
			width:260,
			child: "li",					//不能使用a标签，img标签
			auto: true,
			scrolltime:3000
		});	
		
		$("#anbox").imageScroller({
			next:"anleft7",
			prev:"anright7",
			frame:"li_wrap7",
			width:260,
			child: "li",
			auto: true,
			scrolltime:3000
		});
	});