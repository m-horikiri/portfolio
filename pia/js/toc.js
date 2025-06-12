$(function(){
	//ADD TOC TITLE
	var tocHtml = `
		<div class="title">目次</div>					
		<div id="tocBtn">[<span class="btnText">OPEN</span>]</div>
	`;
	$('.ez-toc-title').html(tocHtml);

	//TOC BTN
	$('#tocBtn').on('click', function(){
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$('.btnText').text('CLOSE');
		}else{
			$('.btnText').text('OPEN');
		}
		$('.tocList, #ez-toc-container nav').stop().slideToggle();
	});
	//SMOOTH SCROLL
	$('.ez-toc-section').each(function(){
		var decoded = decodeURI($(this).attr('id'));
		$(this).attr('id', decoded);
	});
	$('a[href^="#"]').on('click', function() {
		var speed = 1500;
		var href = $(this).attr("href");
		var decode = decodeURI(href);
		var target = $(decode == "#" || decode == "" ? 'html' : decode);
		var headerH = $('.commonHeader').outerHeight(true) + 50;
		var position;
		if($('.menuWrap').hasClass('active')){
			$('.menuWrap').removeClass('active');
		}
		if(target == '#'|| target == ""){
			position = target.offset().top;
		}else{
			position = target.offset().top - headerH;
		}
		$('body,html').animate({
			scrollTop: position
		}, speed, 'swing');
		return false;
	});
})
