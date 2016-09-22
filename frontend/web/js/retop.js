/*浮动窗口*/
$(window).scroll(function () {
        if ($(this).scrollTop() >= 396) {
			$('.absbar').css({"position":"fixed","top":"17px"});
			if(($(this).scrollTop() >= 2558)&&($(this).scrollTop() <= 2900)){
				$("#a_float").css({'position':'fixed','top':'27px'});
			}
			else{
				$("#a_float").css({'position':'static'});	
			}
		}
		else {
			$('.absbar').css({"position":"absolute","left":"50%","marign":"0 0 0 -600px","top":"420px"});
        }
});




