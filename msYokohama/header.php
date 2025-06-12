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
			$metaTitle = get_the_title() . '｜MSクリニック横浜';
		}elseif(is_archive()){
			$metaTitle = get_the_archive_title() . '｜MSクリニック横浜';
		}elseif(is_front_page()){
			$metaTitle = get_bloginfo('name') . '｜MSクリニック横浜';
		}elseif(empty($metaTitle)){
			$metaTitle = get_bloginfo('name') . '｜MSクリニック横浜';
		}
		$strH1 = $metaTitle;
		$description = get_field('description');
		if(empty($description) && is_single()){
			$description =  wp_trim_words(get_the_content(), 160, '');
		}elseif(is_archive()){
			$description = 'MSクリニック横浜の' . get_bloginfo('name') . '「' . get_the_archive_title() . '」の一覧ページをご覧いただけます。';
		}elseif(is_front_page()){
			$description = '神奈川・横浜のMSクリニックは包茎手術・長茎術・亀頭増大術・ペニス増大・早漏治療・ED薬処方から男性美容まで、高度な医療技術で患者さまのお悩みを解消する男性専門クリニックです。';
		}elseif(empty($description)){
			$description = '神奈川・横浜のMSクリニックは包茎手術・長茎術・亀頭増大術・ペニス増大・早漏治療・ED薬処方から男性美容まで、高度な医療技術で患者さまのお悩みを解消する男性専門クリニックです。';
		}
		$canonical = get_field('canonical');
		if(empty($canonical) && is_single()){
			$canonical = get_the_permalink();
		}elseif(is_front_page() || is_404()){
			$canonical = home_url();
		}elseif(empty($canonical)){
			$canonical = DOMAIN_URL . $_SERVER['REQUEST_URI'];
		}
		$ogpImg = get_the_post_thumbnail('mainThumbnail');
		if(empty($ogpImg)){
			$ogpImg = THEME_URL . '/img/ogp.webp';
		}
	?>
	<title><?php echo esc_html($metaTitle);?></title>
	<meta name="description" content="<?php echo esc_html($description);?>">
	<?php wp_head();?>
	<link rel="canonical" href="<?php echo esc_url($canonical);?>">
	<!-- ogp -->
	<meta property="og:title" content="<?php echo esc_html($metaTitle);?>">
	<meta property="og:description" content="<?php echo esc_html($description);?>">
	<meta property="og:url" content="<?php echo esc_url($canonical);?>">
	<meta property="og:image" content="<?php echo esc_url($ogpImg);?>">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?php echo esc_html(get_bloginfo('name'));?>｜MSクリニック横浜">
	<!-- favicon -->
	<link rel="shortcut icon" href="<?php echo esc_url(DOMAIN_URL);?>/imgs/favicon.ico" >
	<!-- css -->
	<link id="fontAwesomeCss" rel="stylesheet" href="">
	<link id="googleFont" rel="stylesheet" href="">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124450759-5"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-124450759-5');
		gtag('config', 'G-NNW5QYQ1LF');
	</script>
</head>
<body id="column" <?php body_class();?>>
	<?php include_once(dirname(__FILE__, 5). '/readfiles/header.php');?>