$(function(){
	//CSS
	setTimeout(function() {
		$('#fontAwesomeCss').attr('href',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');
		$('#googleFont').attr('href',
			'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap');
	}, 1);
	//MENU BTN
	$('#menuOpen').on('click', function() {
		$('.menuWrap').addClass('active');
		$('.menuWrap').css('transition', 'right .7s');
	});
	$('#menuClose').on('click', function() {
		$('.menuWrap').removeClass('active');
	});
	//SMOOTH SCROLL
	$('a[href^="#"]').click(function() {
		var speed = 1500;
		var href = $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		if($('.menuWrap').hasClass('active')){
			$('.menuWrap').removeClass('active');
		}
		$('body,html').animate({
			scrollTop: position
		}, speed, 'swing');
		return false;
	});
	//HEADER FIX
	function headerFix(){
		var fixPosition = $('.headerBox').outerHeight(true);
		var scroll = $(window).scrollTop();
		if(scroll > fixPosition){
			$('.commonHeader').addClass('active');
		}else if(scroll < fixPosition){
			$('.commonHeader').removeClass('active');
		}
	}
	//PC MENU
	function pcMenu(){
		var winW = $(window).outerWidth();
		if(winW > 1149){
			$('.commonHeader .menuWrap .menuList > li').on({
				'mouseenter' : function(){
					$('.childMenuList.active').removeClass('active');
					$(this).find('.childMenuList').addClass('active');
				}
			});
			$('.commonHeader .menuWrap .menuList > li').on({
				'mouseleave' : function(){
					$(this).find('.active').removeClass('active');
				}
			});
		}
	}
	//SP CTA
	function spCta(){
		var scroll = $(window).scrollTop();
		if(scroll > 500){
			$('#spCtaList').addClass('active');
			$('#spCtaList').css('transition', 'bottom .7s');
		}else if(scroll < 500){
			$('#spCtaList').removeClass('active');
		}
	}
	$(window).on('load scroll resize', function(){
		headerFix();
		pcMenu();
		spCta();
	});
})
