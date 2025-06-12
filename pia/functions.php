<?php
//定数の定義
define ('THEME_URL', WP_CONTENT_URL . '/themes/renew');
define ('CAT_SEO', 'seo');
define ('CAT_ADVERTISEMENT', 'advertisement');
define ('CAT_SNS', 'sns');

//任意のサイズに画像をリサイズ
add_theme_support('post-thumbnails');
add_image_size('mainThumbnail', 760, 400, true);
add_image_size('postList', 350, 185, true);
add_image_size('rankingList', 120, 60, true);
add_image_size('newsList', 85, 85, true);
add_image_size('extraPostBox', 475, 240, true);
add_image_size('schemaThumbnail1_1', 670, 670, true);
add_image_size('schemaThumbnail4_3', 780, 585, true);
add_image_size('schemaThumbnail16_9', 780, 439, true);

//添付ファイルの表示設定のサイズ追加
function addSingleThumbnailSizse($sizes){
	return array_merge($sizes, [
		'mainThumbnail' => 'サムネイルサイズ'
	]);
}
add_filter('image_size_names_choose', 'addSingleThumbnailSizse');

//スラッグを自動で数字にしておく
function slugAutoSetting($slug, $post_ID){
	$post = get_post($post_ID);
	if(preg_match('/(%[0-9a-f]{2})+/', $slug)){
		$slug = $post_ID;
		return $slug;
	}
	return $slug;
}
add_filter('wp_unique_post_slug', 'slugAutoSetting', 10, 4);

//画像のアップロードを許可
function uploadMimes($mimes) {
	$mimes['pdf'] = 'application/pdf';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	return $mimes;
}
add_filter('upload_mimes', 'uploadMimes');

//ツールバーの分余白吐き出し
function adminbarMargin(){
	$adminbarMargin = <<<EOT
	<style>
		.commonHeader.active{
			top: 32px;
		}
		@media screen and (max-width: 1000px){
			#wpadminbar{
				display: none;
			}
		}
	</style>
EOT;
	if(is_user_logged_in()){
		echo $adminbarMargin;
	}
}
add_action('wp_head', 'adminbarMargin', 999);

//プレビューが見られるように設定

//エディタにCSS追加
add_editor_style('editor.css');

//各種「説明」でHTML使用を許可
remove_filter('pre_term_description', 'wp_filter_kses');

//タグをチェックボックスにする
function changeTagCheckbox(){
	$args = get_taxonomy('post_tag');
	$args -> hierarchical = true;
	$args -> meta_box_cb = 'post_categories_meta_box';
	register_taxonomy('post_tag', 'post', $args);
}
add_action('init', 'changeTagCheckbox', 1);

//投稿メニューを非表示
function removePostMenu(){
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action('admin_menu', 'removePostMenu');

//管理画面の投稿を投稿日で並べ替え
function adminPreGetPost($wp_query){
	if(is_admin() && (empty(wp_unslash($_GET['orderby'])) || empty(wp_unslash($_GET['order'])))){
		$postType = $wp_query->query['post_type'];
		$args = [
			'public' => true,
			'_builtin' => false
		];
		$postTypeArgs = get_post_types($args);
		if(in_array($postType, $postTypeArgs)){
			$wp_query->set('orderby', 'date');
			$wp_query->set('order', 'DESC');
		}elseif($postType == 'page'){
			$wp_query->set('orderby', 'menu_order');
		}
	}
}
add_filter('pre_get_posts', 'adminPreGetPost');

//管理画面並べ替え
function customMenuOrder($menuOrder) {
	if(!$menuOrder) return true;
	return [
		'index.php',
		'separator1',
		'edit.php?post_type=' . CAT_SEO,
		'edit.php?post_type=' . CAT_ADVERTISEMENT,
		'edit.php?post_type=' . CAT_SNS,
		'edit.php?post_type=seonews',
		'edit.php?post_type=news',
		'upload.php',
		'wpcf7',
		'edit.php?post_type=page',
		'separator2',
		'plugins.php',
		'edit.php?post_type=acf-field-group',
		'ai1wm_export',
		'siteguard',
		'filebird-settings',
		'separator-last',
		'options-general.php',
		'tools.php',
		'themes.php',
		'users.php',
	];
}
add_filter('custom_menu_order', 'customMenuOrder');
add_filter('menu_order', 'customMenuOrder');

// Contact Form 7のpタグ・brタグ削除
function wpcf7NoTag(){
	return false;
}
add_filter('wpcf7_autop_or_not', 'wpcf7NoTag');

//アーカイブ系タイトルの：より前の文字を取り除く
function removeColon(){
	return '';
}
add_filter('get_the_archive_title_prefix', 'removeColon');

//タグとカテゴリーのアーカイブにカスタム投稿タイプを含める
function addQueryCustomPostType($query){
	if(is_admin() || !$query->is_main_query()){
		return;
	}
	if($query->is_category() || $query->is_tag()){
		$query->set('post_type', [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS]);
		return;
	}
}
add_action('pre_get_posts', 'addQueryCustomPostType');

//導入文があったらそこから抜粋文を作成する
function makeIntroductoryExcerpt($excerpt){
	if(!empty(get_field('introductory'))){
		$excerpt = get_field('introductory');
		$excerpt = mb_substr($excerpt, 0, 50);
		$excerpt .= '&hellip;<a class="more" href="' . get_permalink() . '">続きを読む</a>';
	}
	return $excerpt;
}
add_filter('get_the_excerpt', 'makeIntroductoryExcerpt');

//導入文ない場合の抜粋文の調整
remove_filter('the_excerpt', 'wpautop');
function changeExcerptLength(){
	return 50;
}
add_filter('excerpt_length', 'changeExcerptLength', 999);
function changeExcerptMore(){
	return '&hellip;<a class="more" href="' . esc_url(get_permalink()) . '">続きを読む</a>';
}
add_filter('excerpt_more', 'changeExcerptMore', 999);

//固定ページ用の抜粋文を出力
function makePageExcerpt($pageId){
	$introductory = get_field('introductory', $pageId);
	$introductory = mb_substr($introductory, 0, 50);
	$introductory .= '&hellip;<a class="more" href="' . get_permalink($pageId) . '">続きを読む</a>';
	echo $introductory;
}

//各種リダイレクト
function redirectAllKinds($post_id){
	$post = get_post($post_id);
	if(is_singular('news')){
		wp_redirect(home_url('/news/'), 301);
		exit;
	}elseif(is_singular('seonews')){
		wp_redirect(home_url('/whatseo/'), 301);
		exit;
	}elseif(is_search() || is_author() || is_date()){
		wp_redirect(home_url(), 301);
		exit;
	}elseif(is_attachment()){
		if($post->post_parent){
			wp_redirect(get_permalink($post->post_parent), 301);
			exit;
		}else{
			wp_redirect(home_url(), 301);
			exit;
		}
	}
}
add_action('template_redirect', 'redirectAllKinds');

//CDNのjQ読みこむ
function myJqRoad(){
	if(!is_admin()){
		wp_deregister_script('jquery');
		wp_enqueue_script('jqueryCdn', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js' );
	}
}
add_action('wp_print_scripts', 'myJqRoad');

//ヘッダーのscriptをフッターで読みこむ
function scriptsHeadtoFooter(){
	wp_dequeue_style('wp-block-library');
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
}
add_action('wp_enqueue_scripts', 'scriptsHeadtoFooter');

//不要タグ削除
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles', 10);

//フォーム以外のreCAPTCHAを削除
function noReadRecaptcha(){
	if(!is_page('consultation') && !is_page('contact')){
		wp_deregister_script('google-recaptcha');
	}
}
add_action('wp_enqueue_scripts', 'noReadRecaptcha', 100);

//各種CSS&JS読み込み
function enqueueStyles(){
	wp_enqueue_style('reset', 'https://cdn.jsdelivr.net/npm/the-new-css-reset@1.8.4/css/reset.min.css');
	wp_enqueue_style('style', THEME_URL . '/style.css', ['reset']);
	wp_enqueue_script('myCommon', THEME_URL . '/js/common.js', ['jqueryCdn']);
	if(is_home()){
		wp_enqueue_style('index', THEME_URL . '/css/index.css', ['style']);
	}elseif(is_single()){
		wp_enqueue_style('single', THEME_URL . '/css/single.css', ['style']);
		wp_enqueue_script('toc', THEME_URL . '/js/toc.js', ['myCommon']);
	}elseif(is_page()){
		$tableOfContents = get_field('tableOfContents');
		if($tableOfContents == true){
			wp_enqueue_script('toc', THEME_URL . '/js/toc.js', ['myCommon']);
		}
		if(is_page('service')){
			wp_enqueue_style('service', THEME_URL . '/css/service.css', ['style']);
		}elseif(is_page('company')){
			wp_enqueue_style('company', THEME_URL . '/css/company.css', ['style']);
		}elseif(is_page('faq')){
			wp_enqueue_style('faq', THEME_URL . '/css/faq.css', ['style']);
			wp_enqueue_script('faq', THEME_URL . '/js/faq.js', ['myCommon']);
		}elseif(is_page('sitemap')){
			wp_enqueue_style('sitemap', THEME_URL . '/css/sitemap.css', ['style']);
		}elseif(is_page('achievement')){
			wp_enqueue_style('slick ', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css', ['style']);
			wp_enqueue_style('achievement', THEME_URL . '/css/achievement.css', ['style']);
			wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['myCommon']);			
			wp_enqueue_script('achievement', THEME_URL . '/js/achievement.js', ['slick']);
		}elseif(is_page_template('form.php')){
			wp_enqueue_style('form', THEME_URL . '/css/form.css', ['style']);
			wp_enqueue_script('thanks', THEME_URL . '/js/thanks.js', ['myCommon']);
		}
	}elseif(is_404()){
		wp_enqueue_style('notFound', THEME_URL . '/css/404.css', ['style']);
	}
}
add_action('wp_enqueue_scripts', 'enqueueStyles');

// 記事のPVをカウントする
function setPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//記事一覧の1ページ目と2ページ目で表示件数を変更
function changePostPerPage($query){
	$perPage = get_option('posts_per_page');
	if(!is_admin() && $query->is_main_query() && $query->is_archive()){
		$paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
		if(!is_paged()){
			$query->set('posts_per_page', $perPage + 1);
		}else{
			$offset = ($perPage + 1) + $perPage * ($paged - 2);
			$query->set('offset', $offset);
			$query->set('posts_per_page', $perPage);
		}		
	}
}
add_action('pre_get_posts', 'changePostPerPage');

//ページャー
function pagenation($range = 7){
	if($range < 7){
		$range = 7;
	}
	global $paged;
	if(empty($paged)) $paged = 1;
	global $wp_query;
	$total = $wp_query->found_posts;
	$perPage = get_option('posts_per_page');
	$pages = '';
	if($total <= $perPage + 1){
		$pages = 1;
	}else{
		$maxNumPage = ($total - ($perPage + 1)) / $perPage;
		$pages = (int)ceil($maxNumPage) + 1;
	}
	$html = '';
	if(1 < $pages){
		$html .= '<ul class="pagenation">';
		if($paged == 1){
			$html .= '<li class="current">1</li>';
		}else{
			$html .= '<li><a href="' . get_pagenum_link(1) . '">1</a></li>';
		}
		$dots = '<li class="dots">…</li>';
		$list = '';
		$quotient = ($range - 5) / 2;
		if($pages <= $range){
			for($i = 2; $i <= $pages; $i++){
				$list = match($i){
					$paged => '<li class="current">' . $i . '</li>',
					default => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
				};
				$html .= $list;
			}
		}elseif($paged < $range - 2){
			for($i = 2; $i <= $pages; $i++){
				$list = match(true){
					$i === $paged => '<li class="current">' . $i . '</li>',
					$i === $range - 1 => $dots,
					$i === $pages => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i < $range => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i >= $range => '',
					default => '',
				};
				$html .= $list;
			}
		}elseif($paged > $pages - ($quotient + 3)){
			for($i = 2; $i <= $pages; $i++){
				$list = match(true){
					$i === $paged => '<li class="current">' . $i . '</li>',
					$i === $pages - $range + 2 => $dots,
					$i === $pages => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i > $pages - $range + 2 => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i < $pages - $range + 2 => '',
					default => '',
				};
				$html .= $list;
			}
		}else{
			for($i = 2; $i <= $pages; $i++){
				$list = match(true){
					$i === $paged => '<li class="current">' . $i . '</li>',
					$i === $paged - ($quotient + 1) => $dots,
					$i === $paged + ($quotient + 1) => $dots,
					$i === $pages => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i < $paged - ($quotient + 1) => '',
					$i > $paged + ($quotient + 1) => '',
					$i >= $paged - $quotient => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					$i <= $paged + $quotient => '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>',
					default => '',
				};
				$html .= $list;
			}
		}
		$html .= '</ul>';
	}
	echo $html;
}

//ぱんくずの指定
function myBreadcrumbs(){
	$queriedObject = get_queried_object();
	$html = '';
	$html .= '<ul class="breadcrumbs"><li><a href="' . home_url() . '">HOME</a></li>';
	if(is_single()){
		$postType = $queriedObject->post_type;
		$html .= '<li><a href="' . get_post_type_archive_link($postType) . '">' . get_post_type_object($postType)->labels->name . '</a></li>';
		$cats = get_the_terms($queriedObject->ID, $postType . 'cat');
		if($cats){
			$cat = $cats[0];
			$html .= '<li><a href="' . get_term_link($cat) . '">' . $cat->name . '</a></li>';
		}
		$html .= '<li>' . $queriedObject->post_title . '</li>';
	}elseif(is_page()){
		if($queriedObject->post_parent !== 0){
			$html .= '<li><a href="' . get_permalink($queriedObject->post_parent) . '">' . get_post($queriedObject->post_parent)->post_title . '</a></li>';
		}
		$html .= '<li>' . $queriedObject->post_title . '</li>';
	}elseif(is_post_type_archive()){
		$html .= '<li>' . $queriedObject->label . '</li>';
	}elseif(is_category()){
		$html .= '<li>' . $queriedObject->name . '</li>';
	}elseif(is_tag()){
		$html .= '<li>' . $queriedObject->name . '</li>';
	}elseif(is_tax()){
		$postType = str_replace('cat', '', $queriedObject->taxonomy);
		$html .= '<li><a href="' . get_post_type_archive_link($postType) . '">' . get_post_type_object($postType)->labels->name . '</a></li>';
		$html .= '<li>' . $queriedObject->name . '</li>';
	}elseif(is_404()){
		$html .= '<li>お探しのページは見つかりませんでした。</li>';
	}
	$html .= '</ul>';
	echo $html;
}

//ぱんくず構造化マークアップ
function breadcrumbsJson(){
	if(is_admin() || is_home()){
		return;
	}
	$array = [];
	$array[] =  [
		'@type' => 'ListItem',
		'position' => 1,
		'name' => 'HOME',
		'item' => home_url()
	];
	$index = 2;
	$queriedObject = get_queried_object();
	if(is_single()){
		$postType = $queriedObject->post_type;
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => get_post_type_object($postType)->labels->name,
			'item' => get_post_type_archive_link($postType)
		];
		$index++;
		$cats = get_the_terms($queriedObject->ID, $postType . 'cat');
		if($cats){
			$cat = $cats[0];
			$array[] = [
				'@type' => 'ListItem',
				'position' => $index,
				'name' => $cat->name,
				'item' => get_term_link($cat)
			];	
			$index++;
		}
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->post_title,
			'item' => get_the_permalink($queriedObject->ID)
		];
	}elseif(is_page()){
		if($queriedObject->post_parent !== 0){
			$array[] = [
				'@type' => 'ListItem',
				'position' => $index,
				'name' => get_post($queriedObject->post_parent)->post_title,
				'item' => get_permalink($queriedObject->post_parent)
			];
			$index++;
		}
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->post_title,
			'item' => get_the_permalink($queriedObject->ID)
		];
	}elseif(is_post_type_archive()){
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->label,
			'item' => get_post_type_archive_link($queriedObject->name)
		];
	}elseif(is_category()){
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->name,
			'item' => get_category_link($queriedObject->cat_ID)
		];
	}elseif(is_tag()){
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->name,
			'item' => get_tag_link($queriedObject->term_id)
		];
	}elseif(is_tax()){
		$postType = str_replace('cat', '', $queriedObject->taxonomy);
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => get_post_type_object($postType)->labels->name,
			'item' => get_post_type_archive_link($postType)
		];
		$index++;
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $queriedObject->name,
			'item' => get_term_link($queriedObject->term_id)
		];
	}elseif(is_404()){
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => 'お探しのページは見つかりませんでした。'
		];
	}else{
		return;
	}
	$jsonld = [
		'@context' => 'https://schema.org',
		'@type' => 'BreadcrumbList',
		'itemListElement' => $array
	];
	echo '<script type="application/ld+json">' . PHP_EOL;
	echo json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;
	echo '</script>' . PHP_EOL;
}
add_action('wp_head', 'breadcrumbsJson');

//構造化マークアップ追加
function printSchema(){
	$schema = '';
	$homeUrl = home_url();
	$themeUrl = THEME_URL;
	if(is_home()){
/*		if ($_SERVER['REQUEST_URI'] === '/'){
			//Website
			$Website = <<< EOT
			<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "WebSite",
				"name": "株式会社PIA",
				"url" : "https://www.pi-a.jp/",
				"headline": "{$GLOBALS['title']}",
				"description": "{$GLOBALS['description']}",
				"inLanguage": "jp",
				"mainEntityOfPage": {
					"@type": "WebPage",
					"@id": "https://www.pi-a.jp/"
				},
				"image": {
					"@type": "ImageObject",
					"url": "https://www.pi-a.jp/img/ogp.webp"
				},
				"publisher": {
					"@type": "Organization",
					"name": "株式会社PIA",
					"logo": {
						"@type": "ImageObject",
						"url": "https://www.pi-a.jp/img/logo.svg"
					}
				}
			}
			</script>
EOT;
			echo $Website;
			//LocalBusiness
			$LocalBusiness = <<< EOT
			<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "LocalBusiness",
				"name": "株式会社PIA",
				"address": {
					"@type": "PostalAddress",
					"streetAddress": "西新宿4-3-13 西新宿三関ビル4F",
					"addressLocality": "新宿区",
					"addressRegion": "東京都",
					"postalCode": "160-0023",
					"addressCountry": "JP"
				},
				"geo": {
					"@type": "GeoCoordinates",
					"latitude": "35.690601264047494",
					"longitude": "139.68569008465838"
				},
				"telephone": "+81-3-5302-0055",
				"openingHoursSpecification": [{
					"@type": "OpeningHoursSpecification",
					"dayOfWeek": [
						"Monday",
						"Tuesday",
						"Wednesday",
						"Thursday",
						"Friday"
					],
					"opens": "09:00",
					"closes": "18:00",
					"validFrom": "2023-12-29",
					"validThrough": "2024-01-03"
				}],
				"url": "https://www.pi-a.jp/",
				"priceRange": "￥33,000～"
			}
			</script>
EOT;
			echo $LocalBusiness;
		}elseif ($_SERVER['REQUEST_URI'] === '/company/'){
			//Organization
			$Organization = <<< EOT
			<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "Corporation",
				"name": "株式会社PIA",
				"foundingDate": "2000-04-01",
				"description": "企業の概略",
				"url": "https://www.pi-a.jp/",
				"logo": "https://www.pi-a.jp/img/logo.svg",
				"telephone": "+81-3-5302-0055",
				"faxNumber": "+81-3-5302-0050",
				"address": {
					"@type": "PostalAddress",
					"streetAddress": "西新宿4-3-13 西新宿三関ビル4F",
					"addressLocality": "新宿区",
					"addressRegion": "東京都",
					"postalCode": "160-0023",
					"addressCountry": "JP"
				},
				"sameAs": "https://lin.ee/50B4srD"
			}
			</script>
EOT;
			echo $Organization;
		}*/

	}elseif(is_single()){
		$supervisors = get_the_terms(get_the_ID(), 'supervisor');
		if($supervisors){
			$headline = get_the_title();
			$image1_1 = get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail1_1');
			$image4_3 = get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail4_3');
			$image16_9 = get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail16_9');
			$author = '';
			foreach($supervisors as $supervisor){
				$author .= '{
					"@type": "Person",
					"name": "' . $supervisor->name .'",
					"url": "' . $homeUrl . '/company/#' . $supervisor->slug . '"
				}';
				if($supervisor !== end($supervisors)){
					$author .= ',';
				}
			}
			$schema = <<<EOT
			<script type="application/ld+json">
				{
					"@context": "https://schema.org",
					"@type": "BlogPosting",
					"headline": "{$headline}",
					"image": [
						"{$image1_1}",
						"{$image4_3}",
						"{$image16_9}"
					 ],
					"author": [{$author}]
				}
			</script>
EOT;
		}
	}elseif(is_page('company')){
		$schema = <<<EOT
		<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "Corporation",
				"name": "株式会社PIA",
				"foundingDate": "2000-04-01",
				"description": "株式会社PIAはSEO対策をはじめとしたWebマーケティングの専門家が集まる企業です。SEO検定1級保持者、Google認定資格保持者が在籍。",
				"url": "{$homeUrl}",
				"logo": "{$themeUrl}/img/common/logo.svg",
				"telephone": "+81-3-5302-0055",
				"faxNumber": "+81-3-5302-0050",
				"address": {
					"@type": "PostalAddress",
					"streetAddress": "西新宿4-3-13 西新宿三関ビル4F",
					"addressLocality": "新宿区",
					"addressRegion": "東京都",
					"postalCode": "160-0023",
					"addressCountry": "JP"
				},
				"sameAs": "https://lin.ee/50B4srD"
			}
		</script>
EOT;
	}
	echo $schema;
}

//目次生成
function addTableOfContents($content){
	$tableOfContents = get_field('tableOfContents');
	if(is_page() && $tableOfContents == true){
		$pattern = '/<(h2|h3)(.*?)>(.*?)<\/(h2|h3)>/is';
		$hTagLenge = preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
		if($hTagLenge >= 2){
			$toc = '<div class="tableOfContents"><div class="titleBox"><div class="title">目次</div><div id="tocBtn">[<span class="btnText">OPEN</span>]</div></div><ul class="tocList">';
			$anchor = 1;
			$childAnchor = 1;
			$index = 0;
			$headings = [];
			foreach($matches as $matche){
				if(isset($matches[$index + 1][1])){
					if($matche[1] === 'h2' && $matches[$index + 1][1] === 'h3'){
						$index++;
						$headings[] = [
							'id' => 'anchor_' . $anchor
						];
						$toc .= '<li><a href="#anchor_' . $anchor . '">' . $matche[3] . '</a><ul class="childTocList">';
					}elseif($matche[1] === 'h3' && $matches[$index + 1][1] === 'h3'){
						$index++;
						$headings[] = [
							'id' => 'anchor_' . $anchor . '_' . $childAnchor
						];
						$toc .= '<li><a href="#anchor_' . $anchor . '_' . $childAnchor . '">' . $matche[3] . '</a></li>';
						$childAnchor++;
					}elseif($matche[1] === 'h3' && $matches[$index + 1][1] === 'h2'){
						$index++;
						$headings[] = [
							'id' => 'anchor_' . $anchor . '_' . $childAnchor
						];
						$toc .= '<li><a href="#anchor_' . $anchor . '_' . $childAnchor . '">' . $matche[3] . '</a></li></ul>';
						$anchor++;
						$childAnchor = 1;
					}else{
						$index++;
						$headings[] = [
							'id' => 'anchor_' . $anchor
						];
						$toc .= '<li><a href="#anchor_' . $anchor . '">' . $matche[3] . '</a></li>';
					}
				}elseif(empty($matches[$index + 1][1]) && $matche[1] === 'h2'){
					$index++;
					$headings[] = [
						'id' => 'anchor_' . $anchor
					];
					$toc .= '<li><a href="#anchor_' . $anchor . '">' . $matche[3] . '</a></li>';
				}elseif(empty($matches[$index + 1][1]) && $matche[1] === 'h3'){
					$index++;
					$headings[] = [
						'id' => 'anchor_' . $anchor . '_' . $childAnchor
					];
					$toc .= '<li><a href="#anchor_' . $anchor . '_' . $childAnchor . '">' . $matche[3] . '</a></li></ul>';
					$anchor++;
					$childAnchor = 1;
				}
			}
			$toc .= '</ul></div>';
			$content = preg_replace_callback($pattern, function($matches) use ($headings){
				static $i = 0;
				static $attr = '';
				if(isset($headings[$i])){
					$attr = $headings[$i]['id'];
				}
				$i++;
				return '<' . $matches[1] . ' id="' . $attr . '"' . $matches[2] . '>' . $matches[3] . '</' . $matches[1] . '>';
			}, $content);
		}else{
			$toc = '';
		}
		$content = substr_replace($content, $toc, 0, 0);
	}
	return $content;	
}
add_filter('the_content', 'addTableOfContents');

?>
<?php
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			以下独自出力関数
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php //大カテゴリーと中カテゴリーのメニューリスト出力関数
	function menuListOutput($newsFlug = false){
		$catArgs = [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS];
		if($newsFlug == true){
			$catArgs = [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS, 'news'];
		}
		$pageArgs = ['what' . CAT_SEO, 'service', 'company'];
?>
	<ul class="menuList">
		<li class="pcView">
			<a class="parentLink" href="<?php echo home_url();?>">ホーム</a>
		</li>
		<?php
			foreach($catArgs as $catArg):
				$thisType = get_post_type_object($catArg);
		?>
		<li>
			<a class="parentLink" href="<?php echo get_post_type_archive_link($catArg);?>"><?php echo $thisType->labels->name;?></a>
			<?php
				$childCats = get_terms(['taxonomy' => $catArg . 'cat']);
				if($childCats && $catArg != 'news'):
			?>
			<ul class="childMenuList">
				<?php foreach($childCats as $child):?>
				<li>
					<a class="childLink" href="<?php echo get_term_link($child->term_id);?>"><?php echo $child->name;?></a>
				</li>
				<?php endforeach;?>
			</ul>
			<?php endif;?>
		</li>
		<?php endforeach;?>
		<?php
			foreach($pageArgs as $pageArg):
				$pageCat = get_page_by_path($pageArg);
				$pageTitle = get_the_title($pageCat->ID);
				if($pageArg == 'what' . CAT_SEO){
					$pageTitle = 'SEOとは？';
				}
		?>
		<li>
			<a class="parentLink" href="<?php echo esc_url(get_permalink($pageCat->ID));?>"><?php echo $pageTitle?></a>
			<?php
				$childsArgs = [
					'post_type' => 'page',
					'posts_per_page' => -1,
					'post_parent' => $pageCat->ID,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				];
				$childs = new WP_Query($childsArgs);
				if($childs->have_posts()):
			?>
			<ul class="childMenuList">
				<?php while($childs->have_posts()) : ($childs->the_post())?>
				<li>
					<a class="childLink" href="<?php the_permalink();?>"><?php the_title();?></a>
				</li>
				<?php endwhile;?>
			</ul>
		<?php
			endif;
			wp_reset_postdata();
		?>
		</li>
		<?php endforeach;?>
	</ul>
<?php
	}
?>
<?php //タグ一覧の出力関数
	function tagListOutput(){
		$tags = get_tags(['orderby' => 'name']);
		if($tags):
?>
	<ul class="tagList">
		<?php foreach($tags as $tag):?>
		<li>
			<a class="childLink" href="<?php echo get_tag_link($tag->term_id);?>"><?php echo $tag->name;?></a>
		</li>
		<?php endforeach;?>
	</ul>
<?php
		endif;
	}
?>
<?php //indexの各記事出力関数
	function indexPostList($slug){
		$indexArgs = [
			'post_type' => $slug,
			'posts_per_page' => 3,
			'orderby' => 'modified'
		];
		$indexPosts = new WP_Query($indexArgs);
		if($indexPosts->have_posts()):
?>
		<section class="middleSection">
			<h3 class="middleHeading"><?php echo get_post_type_object($slug)->label;?></h3>
			<ul class="postList">
				<?php
					while($indexPosts->have_posts()):
						$indexPosts->the_post();
				?>
				<li>
					<a href="<?php the_permalink();?>">
						<div class="imgBox">
							<?php
								if(has_post_thumbnail()){
									the_post_thumbnail('postList');
								}else{
									echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
								}
							?>
						</div>
					</a>
					<div class="textBox">
						<div class="day">更新日：<?php the_modified_date('Y.m.d');?></div>
						<a class="title" href="<?php the_permalink();?>">
							<?php the_title();?>
						</a>
						<?php
							global $post;
							$cats = get_the_terms($post->ID, $slug . 'cat');
							if($cats):
						?>
						<ul class="categoryList">
							<?php foreach($cats as $cat):?>
							<li>
								<a href="<?php echo get_term_link($cat);?>"><?php echo $cat->name;?></a>
							</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
					</div>
				</li>
				<?php endwhile;?>
			</ul>
			<a class="moreViewText" href="<?php echo get_post_type_archive_link($slug);?>">もっと見る</a>
		</section>
<?php
		endif;
		wp_reset_postdata();
	}
?>
<?php //おすすめ記事出力関数
	function recommendPostList($outputs = 3, $orderby = 'rand'){
		$recommendPostArgs = [
			'post_type' => [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS],
			'posts_per_page' => $outputs,
			'category_name' => 'recommend',
			'orderby' => $orderby
		];
		$recommendPost = new WP_Query($recommendPostArgs);
		if($recommendPost->have_posts()):
?>
		<section class="largeSection">
			<h2 class="largeHeading"><?php echo get_category_by_slug('recommend')->name;?>はこちら</h2>
			<ul class="postList">
				<?php
					while($recommendPost->have_posts()):
						$recommendPost->the_post();
				?>
				<li>
					<a href="<?php the_permalink();?>">
						<div class="imgBox">
							<?php
								if(has_post_thumbnail()){
									the_post_thumbnail('postList');
								}else{
									echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
								}
							?>
						</div>
					</a>
					<div class="textBox">
						<div class="day">更新日：<?php the_modified_date('Y.m.d');?></div>
						<a class="title" href="<?php the_permalink();?>">
							<?php the_title();?>
						</a>
						<?php
							global $post;
							$postType = get_post_type();
							$cats = get_the_terms($post->ID, $postType . 'cat');
							if($cats):
						?>
						<ul class="categoryList">
							<?php foreach($cats as $cat):?>
							<li>
								<a href="<?php echo get_term_link($cat);?>"><?php echo $cat->name;?></a>
							</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
					</div>
				</li>
				<?php endwhile;?>
			</ul>
		</section>
<?php
		endif;
		wp_reset_postdata();
	}
?>
<?php //最新SEO情報出力
	function addSeoNews($showPost = 4, $outputs = -1){
		$seonewsArgs = [
			'post_type' => CAT_SEO . 'news',
			'posts_per_page' => $outputs,
			'orderby' => 'date'
		];
		$seonewsPosts = new WP_Query($seonewsArgs);
		if($seonewsPosts->have_posts()):
			$postIndex = 0;
			while($seonewsPosts->have_posts()):
				$postIndex++;
				$seonewsPosts->the_post();
				if($postIndex >= $showPost): 
?>
			<div class="seonewsPost">
				<div class="smallHeading"><?php the_title(); ?></div>
				<div class="day">投稿日：<?php the_time('Y.m.d');?></div>
				<div class="seonewsContent">
					<?php the_content(); ?>
				</div>
				<div class="moreViewText">続きを読む</div>
			</div>
			<?php else:?>
			<div class="seonewsPost active">
				<div class="smallHeading"><?php the_title(); ?></div>
				<div class="day">投稿日：<?php the_time('Y.m.d');?></div>
				<div class="seonewsContent">
					<?php the_content(); ?>
				</div>
			</div>
<?php
			endif;
		endwhile;
	endif;
	wp_reset_postdata();
	wp_enqueue_style('seonews', THEME_URL . '/css/seonews.css', ['style']);
	wp_enqueue_script('seonews', THEME_URL . '/js/seonews.js', ['myCommon']);
}
?>