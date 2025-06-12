$(function() {
	//ready processing
	var winW = $(window).outerWidth();
	var viewFlag = false;
	var blindFlag = false;
	var internalizationLen = $('.internalizationList li').length;
	var numberOf = 12;
	var page = internalizationLen / numberOf - 1;
	var counter = 0;
	$('.pcMoreControl .view, .pcMoreControl .blind').hide();
	$('.industrySliderList').slick({
		autoplay: true,
		autoplaySpeed: 0,
		arrows: false,
		cssEase: "linear",
		pauseOnFocus: false,
		pauseOnHover: false,
		speed: 7000,
		swipe: false,
		variableWidth: true,
	});
	//scroll processing
	$(window).on('load scroll resize', function(){
		var scroll = $(window).scrollTop();
		var winH = $(window).height();
		//internalizationBtn
		var internalizationOfs = $('.internalizationList').offset().top;
		var internalizationH = $('.internalizationList').outerHeight();
		if(winW > 780 && scroll > internalizationOfs - winH + (winH / 2) && scroll < internalizationOfs + internalizationH - winH + (winH / 2)){
			$('.pcMoreControl').stop().fadeIn(500);
			if(viewFlag == false && counter <= page - 1){
				$('.pcMoreControl .view').stop().fadeIn(500);
				viewFlag = true;
			}else if(blindFlag == false && counter > 0){
				$('.pcMoreControl .blind').stop().fadeIn(500);
				blindFlag = true;
			}
		}else{
			$('.pcMoreControl, .pcMoreControl .view, .pcMoreControl .blind').stop().fadeOut(500);
			viewFlag = false;
			blindFlag = false;
		}
	});
	//internalization more
	$('.moreViewText, .pcMoreControl .view').on('click', function(){
		if(blindFlag == false){
			$('.pcMoreControl .blind').stop().fadeIn(500);
			blindFlag = true;
		}
		if(winW < 781){
			$('.internalizationList .spMore, .reduceDisplay').stop().fadeIn(500);
			$('.moreViewText').stop().fadeOut(500);
		}else if(winW > 780 && counter == 0){
			$('.internalizationList .pcMore').slice(numberOf * counter, numberOf * (counter + 1)).stop().fadeIn(500);
			counter++;
		}else if(winW > 780 && counter == page - 1){
			$('.reduceDisplay').stop().fadeIn(500);
			$('.moreViewText, .pcMoreControl .view').stop().fadeOut(500);
			$('.internalizationList .pcMore').slice(numberOf * (counter - 1)).stop().fadeIn(500);
			viewFlag = true;
			counter++;
		}else if(winW > 780 && counter < page){
			$('.internalizationList .pcMore').slice(numberOf * counter, numberOf * (counter + 1)).stop().fadeIn(500);
			counter++;
		}
		internalizationH = $('#internalization').outerHeight();
	});
	//internalization fewer
	$('.reduceDisplay, .pcMoreControl .blind').on('click', function(){
		if(winW < 781){
			$('.internalizationList .spMore, .reduceDisplay').stop().slideUp(500);
			$('.moreViewText').stop().fadeIn(500);
		}else if(winW > 780 && counter == page){
			$('.pcMoreControl .view').stop().fadeIn(500);
			$('.internalizationList .pcMore').slice(-numberOf).stop().slideUp(500);
			viewFlag = true;
			counter--;
		}else if(winW > 780 && counter == 1){
			$(' .reduceDisplay, .pcMoreControl .blind').stop().fadeOut(500);
			$('.moreViewText').stop().fadeIn(500);
			$('.internalizationList .pcMore').slice(0).stop().slideUp(500);
			blindFlag = false;
			counter--;
		}else if(winW > 780 && counter < page){
			$('.internalizationList .pcMore').slice(-numberOf * counter, -numberOf * (counter - 1)).stop().slideUp(500);
			counter--;
		}
		internalizationH = $('#internalization').outerHeight();
	});
});