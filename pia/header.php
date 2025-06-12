<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="<?php bloginfo('charset');?>">
	<?php
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') === false) || (strpos($ua, 'iPad') !== false)):
	?>
	<meta name="viewport" content="width=1200, user-scalable=yes, maximum-scale=1">
	<?php else:?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif;?>
	<?php
		$metaTitle = get_field('metaTitle');
		if(empty($metaTitle) && is_single()){
			$metaTitle = strip_tags(get_the_title()) . '｜SEO対策・ウェブ広告のPIA（ピーアイエー）';
		}elseif(empty($metaTitle) && is_page()){
			$metaTitle = strip_tags(get_the_title()) . '｜SEO対策・ウェブ広告のPIA（ピーアイエー）';
		}elseif(is_archive()){
			$metaTitle = strip_tags(get_the_archive_title()) . '｜SEO対策・ウェブ広告のPIA（ピーアイエー）';
		}elseif(is_home()){
			$metaTitle = 'SEO対策・ウェブ広告・Web集客なら専門集団の株式会社PIA（ピーアイエー）';
		}elseif(empty($metaTitle)){
			$metaTitle = 'SEO対策・ウェブ広告・Web集客なら専門集団の株式会社PIA（ピーアイエー）';
		}
		$description = get_field('description');
		if(empty($description) && is_single()){
			$description =  wp_trim_words(get_the_content(), 160, '');
		}elseif(empty($description) && is_page()){
			$description = 'SEO対策・Webマーケティング・SEOコンサルティングの株式会社PIA（ピーアイエー）の「' . strip_tags(get_the_title()) . '」ページをご覧いただけます。';
		}elseif(is_archive()){
			$description = 'SEO対策・Webマーケティング・SEOコンサルティングの株式会社PIA（ピーアイエー）の「' . strip_tags(get_the_archive_title()) . '」の一覧ページをご覧いただけます。';
		}elseif(is_home()){
			$description = '株式会社PIAはSEO対策をはじめとしたWebマーケティングの専門家が集まる企業です。SEO検定1級保持者、Google認定資格保持者が在籍。';
		}elseif(empty($description)){
			$description = '株式会社PIAはSEO対策をはじめとしたWebマーケティングの専門家が集まる企業です。SEO検定1級保持者、Google認定資格保持者が在籍。';
		}
		$canonical = get_field('canonical');
		if(empty($canonical) && is_single()){
			$canonical = get_the_permalink();
		}elseif(empty($metaTitle) && is_page()){
			$canonical = get_the_permalink();
		}elseif(is_home() || is_404()){
			$canonical = home_url();
		}elseif(empty($canonical)){
			$canonical = home_url() . $_SERVER['REQUEST_URI'];
		}
	?>
	<title><?php echo $metaTitle;?></title>
	<meta name="description" content="<?php echo $description;?>">
	<?php wp_head();?>
	<link rel="canonical" href="<?php echo $canonical;?>">
	<!-- ogp -->
	<meta property="og:title" content="<?php echo $metaTitle;?>">
	<meta property="og:description" content="<?php echo $description;?>">
	<meta property="og:url" content="<?=$canonical;?>">
	<meta property="og:image" content="<?php echo THEME_URL;?>/img/common/ogp.webp">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="株式会社PIA">
	<!-- favicon -->
	<link rel="icon" href="<?php echo THEME_URL;?>/img/favicon/favicon.ico" sizes="any">
	<link rel="icon" href="<?php echo THEME_URL;?>/img/favicon/favicon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="<?php echo THEME_URL;?>/img/favicon/favicon_apple.png">
	<link rel="manifest" href="<?php echo THEME_URL;?>/img/favicon/manifest.webmanifest">
	<!-- css -->
	<link id="fontAwesomeCss" rel="stylesheet" href="">
	<link id="googleFont" rel="stylesheet" href="">
	<!-- schema -->
	<?php printSchema(); ?>
</head>
<body <?php body_class();?>>
	<header class="commonHeader">
		<div class="headerWrap contentsWrapper">
			<div class="headerBox">
				<a class="siteLogo" href="<?php echo home_url()?>">
					<img src="<?php echo THEME_URL;?>/img/common/siteLogo.svg" alt="SEOがわかるメディア" width="115" height="40">
				</a>
				<div class="logos">
					<img class="logoImg" src="<?php echo THEME_URL;?>/img/common/logo.svg" alt="PIA" width="44" height="26">
					<?php if(is_front_page()):?>
					<h1 class="logoText">SEO対策20年<br>株式会社PIA</h1>
					<?php else:?>
					<div class="logoText">SEO対策20年<br>株式会社PIA</div>
					<?php endif;?>
				</div>
				<div id="menuOpen" class="menuBtn spView">
					<i class="fa-solid fa-bars"></i>
				</div>
			</div>
			<ul class="headerCtaList pcView">
				<li>
					<a class="contact" href="/contact/">お問い合わせ</a>
				</li>
				<li>
					<a class="consultation" href="/consultation/">無料オンライン相談</a>
				</li>
			</ul>
		</div>
		<div class="menuWrap">
			<div class="spView">
				<div id="menuClose" class="menuBtn">
					<i class="fa-solid fa-xmark"></i>
				</div>
				<a class="menuWrapLogo" href="<?php echo home_url()?>">
					<img src="<?php echo THEME_URL;?>/img/common/logoWhite.svg" alt="PIA" width="93" height="54">
				</a>
			</div>
			<?php menuListOutput();?>
		</div>
	</header>
