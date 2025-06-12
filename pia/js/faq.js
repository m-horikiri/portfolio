$(function(){
	//FAQ CLICK
	$('.faqDl dd').hide();
	$('.faqDl dt').on('click', function(){
		$(this).toggleClass('active');
		$(this).next('dd').stop().slideToggle();
	});
});