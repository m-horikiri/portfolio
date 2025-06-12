jQuery(document).ready(function($){
	var btnWrapH;
	$(window).on('load scroll resize', function(){
		var winW = $(window).outerWidth();
		var winH = $(window).outerHeight();
		var winS = $(window).scrollTop();
		var headerH = $('header').outerHeight();
		btnWrapH = $('#searchArea .btnWrap').outerHeight();
		if(winW < 1023){
			$('#searchArea').css('top', 0);
			$('#searchArea .searchBoxWrap').css('height', 'initial');
			$('#searchArea .searchBoxWrap').css('padding-bottom', btnWrapH);
		}else{
			$('#searchArea .searchBoxWrap').css('padding-bottom', 0);
			var onlineShopItemH = $('#onlineShopItem').outerHeight();
			var searchAreaH = $('#searchArea').outerHeight();
			var onlineShopOfs = $('#onlineShop').offset().top;
			var searchBoxWrapOfs = $('#searchArea .searchBoxWrap').position().top;
			var searchBoxWrapH;
			if(onlineShopOfs < winS){
				searchBoxWrapH = winH - headerH - searchBoxWrapOfs - btnWrapH;
				if(onlineShopItemH < searchBoxWrapH){
					$('#onlineShopItem').css('height', searchBoxWrapH);
				}
				$('#searchArea .searchBoxWrap').css('height', searchBoxWrapH);
				$('#searchArea').css('top', headerH);
				var mainH = $('main').outerHeight();
				if(mainH - winH < winS){
					$('#onlineShop').addClass('endOnlineShop');
				}else{
					$('#onlineShop').removeClass('endOnlineShop');
				}
			}else{
				searchBoxWrapH = winH - onlineShopOfs - searchBoxWrapOfs - btnWrapH;
				$('#searchArea .searchBoxWrap').css('height', searchBoxWrapH);
				$('#searchArea').css('top', onlineShopOfs);
			}
		}
	});
	$('.searchBtnSp').on('click', function(){
		$('#searchArea').fadeIn();
		$('body').css('overflow-y', 'hidden');
		btnWrapH = $('#searchArea .btnWrap').outerHeight();
		$('#searchArea .searchBoxWrap').css('padding-bottom', btnWrapH);
	});
	$('#searchArea .closeBtn').on('click', function(){
		$('#searchArea').fadeOut();
		$('body').css('overflow-y','auto');
	});
	$('#searchArea .searchBox:not(.color_cat) .childList li input:checked').parents('.childList').stop().slideDown();
	$('#searchArea .searchBox:not(.color_cat) .parent > label input:checkbox').change(function(){
		if($(this).prop('checked')){
			$(this).parents('li').find('.childList').stop().slideDown();
		}else{
			$(this).parents('li').find('.childList li input').removeAttr('checked').prop('checked', false).change();
			$(this).parents('li').find('.childList').stop().slideUp();
		}
	});
	$('#searchArea input:reset').on('click', function(){
		$('#searchArea input:checkbox').removeAttr('checked').prop('checked', false).change();
		$('#searchArea input:text').val('');
	});
});
