<?php
/*Template Name: createrrashop*/

use ParagonIE\Sodium\Core\Curve25519\H;
use VektorInc\VK_Breadcrumb\VkBreadcrumb;
function shopStyles() {
	wp_enqueue_style('shop', get_template_directory_uri() . '/original.css?v=' . date('s'), array('usces_cart_css'), 'all');
}
add_action('wp_enqueue_scripts', 'shopStyles');
?>
<?php lightning_get_template_part( 'header' ); ?>
<?php
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
	lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );
?>
<?php
do_action( 'lightning_page_header_before','lightning_page_header_before' );
if ( apply_filters( 'lightning_is_page_header', true, 'page_header' ) ) {
	lightning_get_template_part( 'template-parts/page-header' );
}
do_action( 'lightning_page_header_after', 'lightning_page_header_after' );
?>
<?php
do_action( 'lightning_breadcrumb_before', 'lightning_breadcrumb_before' );
if ( apply_filters( 'lightning_is_breadcrumb_position_normal', true, 'breadcrumb_position_normal' ) ) {
	if ( apply_filters( 'lightning_is_breadcrumb', true, 'breadcrumb' ) ) {
		$vk_breadcrumb      = new VkBreadcrumb();
		$breadcrumb_options = array(
			'id_outer'        => 'breadcrumb',
			'class_outer'     => 'breadcrumb',
			'class_inner'     => 'container',
			'class_list'      => 'breadcrumb-list',
			'class_list_item' => 'breadcrumb-list__item',
		);
		$vk_breadcrumb->the_breadcrumb( $breadcrumb_options );
	}
}
do_action( 'lightning_breadcrumb_after', 'lightning_breadcrumb_after' );
?>
<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="createrrashop <?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">
		<div class="<?php lightning_the_class_name( 'main-section' ); ?>" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

			<?php //createrrashop ?>
			<section class="shopLink">
				<h2 class="shopLargeHeading">土壌分析一覧</h2>
				<ul class="shopLinkList">
				<?php
				$args = [
					'post_type' => 'post',
					'category_name' => 'soilanalysis',
					'orderby' => 'date',
					'order' => 'ASC',
					'posts_per_page' => -1
				];
				$query = new WP_Query($args);
				if($query->have_posts()){
					while($query->have_posts()){
						$query->the_post();
						$query->usces_the_item();
						if(usces_is_item()){
				?>
					<li class="item">
						<h3 class="shopMiddleHeading">
							<a href="<?php the_permalink(); ?>"><?php usces_the_itemName(); ?></a>
						</h3>
						<div class="tags">
							<div class="tagTitle">試験項目：</div>
							<ul class="tagList">
							<?php
							$tags = get_the_tags();
							foreach($tags as $tag){
								echo '<li>' . $tag->name . '</li>';
							}
							?>
							</ul>
						</div>
						<div class="itemPrice">
							<?php usces_the_firstPriceCr(); ?>
							<?php usces_guid_tax(); ?>
						</div>
						<div class="btnWrap">
							<div class="cartBtn">
							<?php
							$skus = wel_get_skus( $post->ID);
							usces_direct_intoCart($post->ID, $skus[0]['code'], false, '注文');
							?>
							</div>
							<div class="more">
								<a href="<?php the_permalink(); ?>">
									詳細はこちら
									<i class="fa-solid fa-arrow-pointer"></i>
								</a>
							</div>
						</div>
					</li>
				<?php
						}
					};
				};
				wp_reset_postdata();
				?>
				</ul>
				<section>
					<h3 class="shopMiddleHeading">分析の流れ</h3>
					<div class="flexWrap">
						<section>
							<h4 class="shopSmallHeading">①土壌の採取</h4>
							<p class="shopText">土壌分析申し込み後、注文受付内容ご確認メールが届きましたら、<span class="redText boldText">移植ゴテで表土から20cm程度撹拌した土を200g程度採取して弊社にお送りください</span>。</p>
						</section>
						<section>
							<h4 class="shopSmallHeading">②土壌の測定</h4>
							<p class="shopText">受け取った試料を分析いたします。採取した土が弊社に到着してから<span class="redText boldText">2週間程度で試験結果をお届け</span>します。</p>
						</section>
					</div>
				</section>
			</section>
			<section class="shopLink">
				<h2 class="shopLargeHeading">試薬一覧</h2>
				<ul class="shopLinkList">
				<?php
				$args = [
					'post_type' => 'post',
					'category_name' => 'reagent',
					'orderby' => 'date',
					'order' => 'ASC',
					'posts_per_page' => -1
				];
				$query = new WP_Query($args);
				if($query->have_posts()){
					while($query->have_posts()){
						$query->the_post();
						$query->usces_the_item();
						if(usces_is_item()){
				?>
					<li class="item">
						<h3 class="shopMiddleHeading">
							<a href="<?php the_permalink(); ?>"><?php usces_the_itemName(); ?></a>
						</h3>
						<div class="itemImg">
							<?php
							add_filter('usces_filter_img_alt', 'imgAlt', 10, 5);
							function imgAlt($alt){
								$alt = 'alt="' . usces_the_itemName('return') . '"';
								return $alt;
							}
							if(usces_the_itemImageURL(0, 'return')){
								usces_the_itemImage(0, 390, 292);
							}else{
								echo '<img src="'. get_template_directory_uri() .'/shopImg/noImg.png" alt="noImg" width="390" height="292">';
							}
							?>
						</div>
						<div class="itemPrice">
							<?php usces_the_firstPriceCr(); ?>
							<?php usces_guid_tax(); ?>
						</div>
						<div class="btnWrap">
							<div class="cartBtn">
							<?php
							$skus = wel_get_skus( $post->ID);
							usces_direct_intoCart($post->ID, $skus[0]['code'], false, '注文');
							?>
							</div>
							<div class="more">
								<a href="<?php the_permalink(); ?>">
									詳細はこちら
									<i class="fa-solid fa-arrow-pointer"></i>
								</a>
							</div>
						</div>
					</li>
				<?php
						}
					};
				};
				wp_reset_postdata();
				?>
				</ul>
				<p class="shopText noticeText">※お客様の輸送費のご負担をできる限り抑えるため、冷蔵便でない形(保冷剤同封)でお送りさせていただきますが、到着しましたら冷蔵保存をお願いいたします。輸送中に劣化のご心配はございませんのでご安心ください。</p>
			</section>
			<?php //createrrashop end ?>

			<?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
		</div><!-- [ /.main-section ] -->
		<?php
		do_action( 'lightning_sub_section_before', 'lightning_sub_section_before' );
		?>

		<?php //createrrashop side ?>
		<?php get_template_part( 'createrrashop-side' ); ?>

		<?php
		do_action( 'lightning_sub_section_after', 'lightning_sub_section_after' );
		?>
	</div><!-- [ /.site-body-container ] -->
	<?php do_action( 'lightning_site_body_append', 'lightning_site_body_append' ); ?>
</div><!-- [ /.site-body ] -->

<?php if ( is_active_sidebar( 'footer-before-widget' ) ) : ?>
<div class="site-body-bottom">
	<div class="container">
		<?php dynamic_sidebar( 'footer-before-widget' ); ?>
	</div>
</div>
<?php endif; ?>
<?php
do_action( 'lightning_site_footer_before', 'lightning_site_footer_before' );
if ( apply_filters( 'lightning_is_site_footer', true, 'site_footer' ) ) {
	lightning_get_template_part( 'template-parts/site-footer' );
}
do_action( 'lightning_site_footer_after', 'lightning_site_footer_after' );
?>
<?php lightning_get_template_part( 'footer' ); ?>
