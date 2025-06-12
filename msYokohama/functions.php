<?php
//定数の定義
define ('THEME_URL', WP_CONTENT_URL . '/themes/column');
define ('DOMAIN_URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST']);

//任意のサイズに画像をリサイズ
add_theme_support('post-thumbnails');
add_image_size('mainThumbnail', 420, 280, true);
add_image_size('postList', 250, 166, true);
add_image_size('newList', 128, 85, true);
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

//ツールバー調整
function adminbarMargin(){
	$adminbarMargin = <<<EOT
	<style>
		@media screen and (max-width: 782px){
			html{
				margin-top: 0 !important;
			}
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

//エディタにCSS追加
add_editor_style('editor.css');

//投稿保存時に余計なタグを削除
function removeUnnecessaryTags($data){
	$pattern = '/\sstyle=\\\\".*?\\\\"/';
	$data['post_content'] = preg_replace($pattern, '', $data['post_content']);
	$data['post_content'] = preg_replace('/\<span\>(.*?)\<\/span\>/', '$1', $data['post_content']);
	return $data;
}
add_filter('wp_insert_post_data', 'removeUnnecessaryTags');

//タグをチェックボックスにする
function changeTagCheckbox(){
	$args = get_taxonomy('post_tag');
	$args -> hierarchical = true;
	$args -> meta_box_cb = 'post_categories_meta_box';
	register_taxonomy('post_tag', 'post', $args);
}
add_action('init', 'changeTagCheckbox', 1);

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

//コメントメニューを非表示
function removePostMenu(){
	remove_menu_page( 'edit-comments.php' );
}
add_action('admin_menu', 'removePostMenu');

//管理画面並べ替え
function customMenuOrder($menuOrder) {
	if(!$menuOrder) return true;
	return [
		'index.php',
		'separator1',
		'edit.php',
		'upload.php',
		'edit.php?post_type=page',
		'separator2',
		'plugins.php',
		'edit.php?post_type=acf-field-group',
		'ai1wm_export',
		'siteguard',
		'separator-last',
		'options-general.php',
		'tools.php',
		'themes.php',
		'users.php',
	];
}
add_filter('custom_menu_order', 'customMenuOrder');
add_filter('menu_order', 'customMenuOrder');

//アーカイブ系タイトルの：より前の文字を取り除く
function removeColon(){
	return '';
}
add_filter('get_the_archive_title_prefix', 'removeColon');

//各種リダイレクト
function redirectAllKinds($post_id){
	$post = get_post($post_id);
	if(is_search() || is_author() || is_date()){
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

//各種CSS&JS読み込み
function enqueueStyles(){
	wp_enqueue_style('css_critical', DOMAIN_URL . '/css/critical.css');
	wp_enqueue_style('css_common', DOMAIN_URL . '/css/common.css', ['css_critical']);
	wp_enqueue_style('css_style', DOMAIN_URL . '/css/style.css', ['css_common']);
	wp_enqueue_style('style', THEME_URL . '/style.css', ['css_style']);
	wp_deregister_script('jquery');
	wp_enqueue_script('jqueryCdn', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
	wp_enqueue_script('js_jsScroll', DOMAIN_URL . '/js/jsScroll.js', ['jqueryCdn']);
	wp_enqueue_script('myCommon', THEME_URL . '/js/common.js', ['js_jsScroll']);
	if(is_single()){
		wp_enqueue_script('toc', THEME_URL . '/js/toc.js', ['myCommon']);
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

//ぱんくずの指定
function printBreadcrumbs(){
	$queriedObject = get_queried_object();
	$html = '<ul class="breadcrumbs contentsWrapper"><li><a href="/">HOME</a></li><li><a href ="' . esc_url(home_url()) . '">' . esc_html(get_bloginfo('name')) . '</a></li>';
	if(is_front_page()){
		$html = '<ul class="breadcrumbs contentsWrapper"><li><a href="/">HOME</a></li><li>' . esc_html(get_bloginfo('name')) . '</li>';
	}elseif(is_single()){
		$cat = get_the_category();
		$cat = $cat[0];
		$html .= '<li><a href="' . esc_url(get_category_link($cat->cat_ID)) . '">' . $cat->name . '</a></li>';
		$html .= '<li>' . esc_html(get_the_title()) . '</li>';
	}elseif(is_category()){
		$html .= '<li>' . $queriedObject->name . '</li>';
	}elseif(is_tag()){
		$html .= '<li>' . $queriedObject->name . '</li>';
	}elseif(is_archive()){
		$html .= '<li>記事一覧</li>';
	}elseif(is_404()){
		$html .= '<li>お探しのページは見つかりませんでした。</li>';
	}
	$html .= '</ul>';
	echo $html;
}

//構造化マークアップ追加
function printSchema(){
	if(is_admin()){
		return;
	}

	//isPartOf
	$isPartOf = [
		'@type' => 'WebSite',
		'name' => 'MSクリニック 横浜',
		'url' => DOMAIN_URL,
		'publisher' => [
			'@type' => 'MedicalClinic',
			'name' => 'MSクリニック 横浜',
			'legalName' => '医療法人社団 清佑会 MSクリニック 横浜',
			'description' => '横浜市西区にあるのMSクリニック横浜院は、JR横浜駅みなみ西口から徒歩5分、私鉄各線の横浜駅からも近く、アクセスの良い立地にあります。当院は男性治療専門のクリニックで、包茎手術だけでなくペニス増大・亀頭増大術、切らない長茎術、早漏治療他も行なっており、ご相談から治療、アフターケアに至るまで、最上のサービス・最良の医療技術を提供いたします。また、麻酔は複数の組み合わせで、痛みを感じずに手術を終えることができます。',
			'url' => DOMAIN_URL,
			'telephone' => '0120-76-6800',
			'isAcceptingNewPatients' => true,
			'medicalSpecialty' => 'PlasticSurgery',
			'priceRange' => '¥770～¥550,000',
			'currenciesAccepted' => 'JPY',
			'paymentAccepted' => '現金, クレジットカード, デビットカード, 銀行振込, QRコード決済, 医療ローン（各種取り扱い有）',
			'openingHours' => 'Mo, Tu, We, Th, Fr, Sa, Su 10:00-20:00',
			'logo' => [
				'@type' => 'ImageObject',
				'url' => 'https://www.clairvoyancecorp.com/img/logo.webp',
				'width' => 220,
				'height' => 177
			],
			'image' => [
				[
					'@type' => 'ImageObject',
					'url' => DOMAIN_URL . '/img/clinic/entrans.jpg',
					'name' => 'エントランス',
					'description' => '入りやすく明るく開放的な受付窓口で、受付スタッフがお迎えいたします。'
				],
				[
					'@type' => 'ImageObject',
					'url' => DOMAIN_URL . '/img/clinic/machiaishitsu.jpg',
					'name' => '待合室',
					'description' => '待合室は全て仕切りを設け、落ち着いた空間づくりを提供いたします。'
				],
				[
					'@type' => 'ImageObject',
					'url' => DOMAIN_URL . '/img/clinic/sinryoshitsu.jpg',
					'name' => '診察室',
					'description' => 'わかりやすく丁寧を第一に、明るく落ち着きのある診察室にて診察いたします。'
				],
				[
					'@type' => 'ImageObject',
					'url' => DOMAIN_URL . '/img/clinic/kaunsering.jpg',
					'name' => 'カウンセリングルーム',
					'description' => 'リラックスできる完全個室にて、患者さまのプライバシーを第一に配慮して行います。'
				],
				[
					'@type' => 'ImageObject',
					'url' => DOMAIN_URL . '/img/clinic/ope.jpg',
					'name' => '処置室・オペ室',
					'description' => '最良の治療を提供するため、徹底したクリーンな処置室・オペ室に最新の医療機器を導入し治療を行います。'
				]
			],
			'member' => [
				'@type' => 'Person',
				'name' => '三原康紀',
				'jobTitle' => 'MSクリニック横浜 院長',
				'image' => DOMAIN_URL . '/imgs/clinic/doctor.webp',
				'url' => DOMAIN_URL . '/clinic.html#s_incho',
			],
			'address' => [
				'@type' => 'PostalAddress',
				'postalCode' => '220-0005',
				'addressRegion' => '神奈川県',
				'addressLocality' => '横浜市',
				'streetAddress' => '西区南幸2-11-1 横浜MSビル6階',
				'addressCountry' => 'JP'
			],
			'geo' => [
				'@type' => 'GeoCoordinates',
				'latitude' => '35.463408804123304',
				'longitude' => '139.6169216678676'
			],
			'hasMap' => 'https://maps.app.goo.gl/T2hLj3j3WEan37k5A'
		]
	];

	//breadcrumb
	$breadcrumb = [
		[
			'@type' => 'ListItem',
			'position' => 1,
			'name' => 'HOME',
			'item' => DOMAIN_URL
		],
		[
			'@type' => 'ListItem',
			'position' => 2,
			'name' => esc_html(get_bloginfo('name')),
			'item' => esc_url(home_url())
		]
	];
	$index = 3;
	$queriedObject = get_queried_object();

	//schema
	$schemaType = 'Blog';
	$schemaUrl = esc_url(home_url());
	$schemaName = esc_html(get_bloginfo('name'));
	$schemaDescription = esc_html(get_bloginfo('description'));

	if(is_category()){
		$schemaUrl = esc_url(get_category_link($queriedObject->cat_ID));
		$schemaName = $queriedObject->name;
		$breadcrumb[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $schemaName,
			'item' => $schemaUrl
		];
	}elseif(is_tag()){
		$schemaUrl = esc_url(get_tag_link($queriedObject->term_id));
		$schemaName = $queriedObject->name;
		$breadcrumb[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $schemaName,
			'item' => $schemaUrl
		];
	}elseif(is_single()){
		$schemaType = 'BlogPosting';
		$schemaUrl = esc_url(get_the_permalink());
		$schemaName = esc_html(get_the_title());
		$schemaDescription = esc_html(get_the_excerpt());

		$cat = get_the_category();
		$cat = $cat[0];
		$breadcrumb[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $cat->name,
			'item' => esc_url(get_category_link($cat->cat_ID))
		];
		$index++;
		$breadcrumb[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => $schemaName,
			'item' => $schemaUrl
		];
	}elseif(is_404()){
		$array[] = [
			'@type' => 'ListItem',
			'position' => $index,
			'name' => 'お探しのページは見つかりませんでした。'
		];
	}
	$schema = [
		[
			'@context' => 'http://schema.org',
			'@type' => $schemaType,
			'inLanguage' => 'ja',
			'url' => $schemaUrl,
			'name' => $schemaName,
			'description' => $schemaDescription,
			'isPartOf' => $isPartOf,
		],
		[
			'@context' => 'http://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => $breadcrumb
		]
	];

	if(is_single()){
		$schema[0]['headline'] = $schemaName;
		$schema[0]['datePublished'] = get_the_date('c');
		$schema[0]['dateModified'] = get_the_modified_date('c') ? get_the_modified_date('c') : get_the_date('c');
		$schema[0]['image'] = [
			esc_url(get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail1_1')),
			esc_url(get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail4_3')),
			esc_url(get_the_post_thumbnail_url(get_the_ID(), 'schemaThumbnail16_9'))
		];
		$schema[0]['author'] = [
			'@type' => 'Person',
			'name' => '葉山芳貴',
			'url' => 'https://www.clairvoyancecorp.com/introduction.html',
			'jobTitle' => '総院長',
			'image' => 'https://www.clairvoyancecorp.com/newimg/introduction/doctorHayama.webp',
			'hasCredential' => [
				'@type' => 'EducationalOccupationalCredential',
				'name' => '医学博士'
			]
		];
	}

	echo '<script type="application/ld+json">' . PHP_EOL;
	echo json_encode($schema, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE) . PHP_EOL;
	echo '</script>' . PHP_EOL;
}
add_action('wp_head', 'printSchema');

//ページャー
function printPager(){
	global $wp_query;
	$big = 999999999;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$pagerArgs = [
		'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format' => 'page/%#%/',
		'current' => $paged,
		'total' => $wp_query->max_num_pages,
		'prev_text' => '<',
		'next_text' => '>',
		'mid_size' => 1,
		'type' => 'list'
	];
	echo paginate_links($pagerArgs);
}
