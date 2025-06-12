<?php
// 定数の定義
define ('THEME_URL', WP_CONTENT_URL . '/themes/kirariPharmacy');

// 任意のサイズに画像をリサイズ
add_theme_support('post-thumbnails');
add_image_size('mainThumbnail', 400, 240, true);

// 添付ファイルの表示設定のサイズ追加
function addSingleThumbnailSizse($sizes){
	return array_merge($sizes, [
		'mainThumbnail' => 'サムネイルサイズ'
	]);
}
add_filter('image_size_names_choose', 'addSingleThumbnailSizse');

// スラッグを自動で数字にしておく
function slugAutoSetting($slug, $post_ID){
	$post = get_post($post_ID);
	if(preg_match('/(%[0-9a-f]{2})+/', $slug)){
		$slug = $post_ID;
		return $slug;
	}
	return $slug;
}
add_filter('wp_unique_post_slug', 'slugAutoSetting', 10, 4);

// 画像のアップロードを許可
function uploadMimes($mimes) {
	$mimes['pdf'] = 'application/pdf';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	return $mimes;
}
add_filter('upload_mimes', 'uploadMimes');

// エディタにCSS追加
add_editor_style('editor.css');

// 各種「説明」でHTML使用を許可
remove_filter('pre_term_description', 'wp_filter_kses');

// 管理画面並べ替え
function customMenuOrder($menuOrder) {
	if(!$menuOrder) return true;
	return [
		'index.php',
		'separator1',
		'edit.php?post_type=news',
		'edit.php?post_type=shop',
		'upload.php',
		'wpcf7',
		'edit.php?post_type=page',
		'separator2',
		'plugins.php',
		'edit.php?post_type=acf-field-group',
		'ai1wm_export',
		'cloudsecurewp',
		'separator-last',
		'options-general.php',
		'tools.php',
		'themes.php',
		'users.php',
	];
}
add_filter('custom_menu_order', 'customMenuOrder');
add_filter('menu_order', 'customMenuOrder');

// メニューを非表示
function removePostMenu(){
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action('admin_menu', 'removePostMenu');
function adminMenuDisplayControl($adminBar){
	$adminBar->remove_menu('new-post');
}
add_action('admin_bar_menu', 'adminMenuDisplayControl', 99);

// 指定ID以外は管理画面上の指定メニュー削除
function themeFileEditorDisplayControl(){
	$userId = get_current_user_id();
	if($userId !== 1){
		remove_menu_page('edit.php?post_type=acf-field-group');
		remove_menu_page('ai1wm_export');
		remove_submenu_page('options-general.php', 'tinymce-advanced');
		remove_submenu_page('tools.php', 'better-search-replace');
		remove_submenu_page('themes.php', 'theme-editor.php');
		remove_submenu_page('plugins.php', 'plugin-editor.php');
	}
}
add_action('admin_menu', 'themeFileEditorDisplayControl', 999);

// ツールバーの分余白吐き出し
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

// メニュー有効
function registerMenus() { 
	register_nav_menus([
		'header' => 'ヘッダー',
		'footer' => 'フッター'
	]);
}
add_action('after_setup_theme', 'registerMenus');

// Contact Form 7のpタグ・brタグ削除
function wpcf7NoTag(){
	return false;
}
add_filter('wpcf7_autop_or_not', 'wpcf7NoTag');

// アーカイブ系タイトルの：より前の文字を取り除く
function removeColon(){
	return '';
}
add_filter('get_the_archive_title_prefix', 'removeColon');

// タグとカテゴリーのアーカイブにカスタム投稿タイプを含める
function addQueryCustomPostType($query){
	if(is_admin() || !$query->is_main_query()){
		return;
	}
	if($query->is_category() || $query->is_tag()){
		$query->set('post_type', ['news', 'shop']);
		return;
	}
}
add_action('pre_get_posts', 'addQueryCustomPostType');

// 各種リダイレクト
function redirectAllKinds($post_id){
	$post = get_post($post_id);
	if(is_singular('shop')){
		wp_redirect(home_url('/shop/'), 301);
		exit;
	}elseif(is_search() || is_author() || is_date()){
		wp_redirect(home_url('/'), 301);
		exit;
	}elseif(is_attachment()){
		if($post->post_parent){
			wp_redirect(get_permalink($post->post_parent), 301);
			exit;
		}else{
			wp_redirect(home_url('/'), 301);
			exit;
		}
	}
}
add_action('template_redirect', 'redirectAllKinds');

// ヘッダーのscriptをフッターで読みこむ
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

// 不要タグ削除
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

// フォーム以外のreCAPTCHAを削除
function noReadRecaptcha(){
	if(!is_page('contact')){
		wp_deregister_script('google-recaptcha');
	}
}
add_action('wp_enqueue_scripts', 'noReadRecaptcha', 100);

// 各種CSS&JS読み込み
function enqueueStyles(){
	wp_enqueue_style('reset', 'https://cdn.jsdelivr.net/npm/the-new-css-reset@1.8.4/css/reset.min.css');
	wp_enqueue_style('style', THEME_URL . '/style.css', ['reset'], filemtime(__DIR__ . '/style.css'));
	wp_enqueue_script('myCommon', THEME_URL . '/js/common.js', [], filemtime(__DIR__ . '/js/common.js'));
}
add_action('wp_enqueue_scripts', 'enqueueStyles');

// 店舗用フィールドエスケープ処理
function shopFieldEscape($text){
	$allowedArgs = [
		'div' => [
			'class' => [],
			'id' => []
		],
		'p' => [
			'class' => [],
			'id' => []
		],
		'a' => [
			'href' => [],
			'target' => []
		],
		'span' => [
			'class' => [],
			'id' => []
		],
		'br' => [
			'class' => []
		]
	];
	$escaped = wp_kses($text, $allowedArgs);
	return $escaped;
}

// ページャー
function pagenation(){
	global $wp_query;
	$paged = max(get_query_var('paged'), 1);
	if($wp_query->max_num_pages > 1){
		$big = 999999999;
		$pagerArgs = [
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format' => 'page/%#%/',
			'current' => $paged,
			'total' => $wp_query->max_num_pages,
			'prev_text' => '<span class="pcView">Prev</span>',
			'next_text' => '<span class="pcView">Next</span>',
			'mid_size' => 1,
			'type' => 'list'
		];
		echo paginate_links($pagerArgs);
	}
}

// ぱんくずの指定
function myBreadcrumbs(){
	$queriedObject = get_queried_object();
	$html = '';
	$html .= '<ul class="breadcrumbs"><li><a href="' . home_url() . '">HOME</a></li>';
	if(is_singular('news')){
		$postType = $queriedObject->post_type;
		$html .= '<li><a href="' . get_post_type_archive_link($postType) . '">' . get_post_type_object($postType)->labels->name . '</a></li>';
		$html .= '<li>' . $queriedObject->post_title . '</li>';
	}elseif(is_page()){
		if($queriedObject->post_parent !== 0){
			$html .= '<li><a href="' . get_permalink($queriedObject->post_parent) . '">' . get_post($queriedObject->post_parent)->post_title . '</a></li>';
		}
		$html .= '<li>' . $queriedObject->post_title . '</li>';
	}elseif(is_post_type_archive()){
		$html .= '<li>' . $queriedObject->label . '</li>';
	}elseif(is_404()){
		$html .= '<li>お探しのページは見つかりませんでした。</li>';
	}
	$html .= '</ul>';
	echo $html;
}

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