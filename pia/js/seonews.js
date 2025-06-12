$(function(){
	//ACCORDION
	$('.seonewsPost:not(.active) .seonewsContent > p:nth-of-type(3) ~ *').hide();
	$('.seonewsPost .moreViewText').on('click', function(){
		var parent = $(this).parent('.seonewsPost');
		if(!parent.hasClass('active')){
			parent.addClass('active');
			parent.find('.seonewsContent > p:nth-of-type(3) ~ *').stop().slideDown();
			$(this).text('閉じる');
		}else{
			$(this).text('続きを読む');
			parent.removeClass('active');
			parent.find('.seonewsContent > p:nth-of-type(3) ~ *').stop().slideUp();
		}
	});
})
