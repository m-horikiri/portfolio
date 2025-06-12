<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="<?php bloginfo('charset');?>">
	<?php
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if((str_contains($ua, 'Android') === true) && (str_contains($ua, 'Mobile') === false) || (str_contains($ua, 'iPad') === true)):
	?>
	<meta name="viewport" content="width=1200, user-scalable=yes, maximum-scale=1">
	<?php else:?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif;?>
	<?php
		$metaTitle = get_field('metaTitle');
		if(empty($metaTitle) && is_single()){
			$metaTitle = strip_tags(get_the_title()) . '｜' . get_bloginfo('name');
		}elseif(empty($metaTitle) && is_page()){
			$metaTitle = strip_tags(get_the_title()) . '｜' . get_bloginfo('name');
		}elseif(is_archive()){
			$metaTitle = strip_tags(get_the_archive_title()) . '｜' . get_bloginfo('name');
		}elseif(is_home()){
			$metaTitle = get_bloginfo('name');
		}elseif(empty($metaTitle)){
			$metaTitle = get_bloginfo('name');
		}
		
		$description = get_field('description');
		if(empty($description) && is_single()){
			$description =  wp_trim_words(get_the_content(), 160, '');
		}elseif(empty($description) && is_page()){
			$description = get_bloginfo('name') . 'の「' . strip_tags(get_the_title()) . '」ページをご覧いただけます。';
		}elseif(is_archive()){
			$description = get_bloginfo('name') . 'の「' . strip_tags(get_the_archive_title()) . '」の一覧ページをご覧いただけます。';
		}elseif(is_home()){
			$description = get_bloginfo('description');
		}elseif(empty($description)){
			$description = get_bloginfo('description');
		}
		
		$canonical = get_field('canonical');
		if(empty($canonical)){
			$canonical = home_url('/') . preg_replace('/\?.+?\=.*/', '', $_SERVER['REQUEST_URI']);
		}
	?>
	<title><?php echo esc_html($metaTitle);?></title>
	<meta name="description" content="<?php echo esc_html($description);?>">
	<?php wp_head();?>
	<link rel="canonical" href="<?php echo esc_url($canonical);?>">
	<!-- favicon -->
	<link rel="icon" href="<?php echo esc_url(THEME_URL);?>/img/favicon/favicon.ico" sizes="any">
	<link rel="apple-touch-icon" href="<?php echo esc_url(THEME_URL);?>/img/favicon/favicon_apple.png">
	<link rel="manifest" href="<?php echo esc_url(THEME_URL);?>/img/favicon/manifest.webmanifest">
	<!-- css -->
	<link id="googleFont" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap">
</head>
<body <?php body_class();?>>
	<h1 class="topHeadingText"><?php echo esc_html($metaTitle);?></h1>
	<header class="commonHeader">
		<a class="siteLogo" href="<?php echo esc_url(home_url('/'))?>">
			<img src="<?php echo esc_url(THEME_URL);?>/img/common/siteLogo.png" alt="<?php bloginfo('name');?>" width="200" height="50">
		</a>
		<div class="headerBtns spView">
			<a class="menuBtn mail" href="<?php echo esc_url(home_url('/contact/'))?>">
				<img src="<?php echo esc_url(THEME_URL);?>/img/common/icon_mail.svg" alt="MAIL" width="28" height="24">
				<span class="btnText">MAIL</span>
			</a>
			<div id="menuOpen" class="menuBtn">
				<img src="<?php echo esc_url(THEME_URL);?>/img/common/icon_menu.svg" alt="MENU" width="30" height="22">
				<span class="btnText">MENU</span>
			</div>
		</div>
		<div id="headerNav" class="menuWrap">
			<div id="menuClose" class="menuBtn spView">
				<img src="<?php echo esc_url(THEME_URL);?>/img/common/icon_close.svg" alt="CLOSE" width="30" height="22">
				<span class="btnText">CLOSE</span>
			</div>
			<?php
				$headerNavArgs = [
					'theme_location' => 'header',
					'container' => 'nav',
					'menu_class' => 'menuNav',
				];
				wp_nav_menu($headerNavArgs);
			?>
		</div>
	</header>
