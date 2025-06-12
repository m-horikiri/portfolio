<?php
/*
Template Name: createrrashop-single
*/

use ParagonIE\Sodium\Core\Curve25519\H;
use VektorInc\VK_Breadcrumb\VkBreadcrumb;
function shopStyles(){
	wp_enqueue_style('shop', get_template_directory_uri() . '/original.css?v=' . date('s'), array('usces_cart_css'), 'all');
}
add_action('wp_enqueue_scripts', 'shopStyles');
function shopTitle($page_header_title_html){
	$itemName = usces_the_itemName('return');
	$html = '<h1 class="page-header-title">' . $itemName . '</h1>';
	return $html;
}
add_filter( 'lightning_page_header_title_html', 'shopTitle', 11 );
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
?>

<?php //createrrashop breadcrumb ?>
<div id="breadcrumb" class="breadcrumb">
	<div class="container">
		<ol class="breadcrumb-list">
			<li class="breadcrumb-list__item breadcrumb-list__item--home">
				<a href="<?php echo home_url('/')?>">
					<i class="fas fa-fw fa-home"></i>
					HOME
				</a>
			</li>
			<li class="breadcrumb-list__item">
				<a href="<?php echo home_url('/createrrashop/')?>">株式会社クレアテラ&nbsp;ONLINE SHOP</a>				
			</li>
			<li class="breadcrumb-list__item"><?php usces_the_itemName(); ?></li>
		</ol>
	</div>
</div>
<?php //createrrashop breadcrumb end ?>

<?php
do_action( 'lightning_breadcrumb_after', 'lightning_breadcrumb_after' );
?>
<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="singleItem createrrashop <?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">
		<div class="<?php lightning_the_class_name( 'main-section' ); ?>" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

			<?php //createrrashop ?>
			<?php
			$categories = get_the_category();
			foreach($categories as $category){
				if($category->slug == 'soilanalysis'){
					$cat = 'soilanalysis';
				}elseif($category->slug == 'reagent'){
					$cat = 'reagent';
				}
			}
			if($cat == 'soilanalysis'){
			?>
			<p class="shopText">土壌診断を行い、適切な施肥計画や土壌改良を実施することにより、収量・品質アップなどの生産性向上に繋がります。<br>創業1975年より培ったノウハウで営農の効率化を図り、生産者様をサポートいたします。シンプルかつ、分かりやすい土壌診断カルテを用いて適切なアドバイスを行います。</p>
			<div class="flexWrap">
					<section>
						<h3 class="shopMiddleHeading">①土壌の採取</h3>
						<div class="shopImgBox">
							<img src="<?php echo get_template_directory_uri(); ?>/shopImg/01.png?v=20240509" alt="①土壌の採取" width="390" height="290">
						</div>
						<p class="shopText">土壌分析申し込み後、注文受付内容ご確認メールが届きましたら、<span class="redText boldText">移植ゴテで表土から20cm程度撹拌した土を200g程度採取して弊社にお送りください</span>。</p>
					</section>
					<section>
						<h3 class="shopMiddleHeading">②土壌の測定</h3>
						<div class="shopImgBox">
							<img src="<?php echo get_template_directory_uri(); ?>/shopImg/02.png?v=20240509" alt="②土壌の測定" width="390" height="290">
						</div>
						<p class="shopText">受け取った試料を分析いたします。採取した土が弊社に到着してから<span class="redText boldText">2週間程度で試験結果をお届け</span>します。</p>
					</section>
				</div>
			<section>
				<h2 class="shopLargeHeading"><?php usces_the_itemName(); ?>分析項目</h2>
				<p class="noticeText shopText">※以下の表にない項目や方法もお気軽にお問い合わせ下さい。</p>
				<dl class="soilAnalysisDl">
				<?php
					$tags = get_the_tags();
					foreach($tags as $tag){
					?>
					<dt><?php echo $tag->name;?></dt>
					<dd><?php if($tag->description != null){echo $tag->description;} ?></dd>
				<?php } ?>
				</dl>
				<section class="detailBox">
					<div class="shopText">
						<?php
						$content = get_the_content();
						$content = nl2br($content);
						echo $content;
						?>
					</div>
				</section>
				<?php }elseif($cat == 'reagent'){?>
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
				<section class="detailBox">
					<div class="shopText">
						<?php
						$content = get_the_content();
						$content = nl2br($content);
						echo $content;
						?>
					</div>
				</section>
				<?php }?>
				<section class="order">
					<h3 class="shopMiddleHeading">ご注文はこちら</h3>
					<div class="orderWrap">
						<div class="itemName"><?php usces_the_itemName(); ?></div>
						<div class="priceBox">
							<div class="price">
								<?php usces_the_firstPriceCr(); ?>
								<?php usces_guid_tax(); ?>
							</div>
							<div class="cart">
								<?php
								the_post();
								usces_the_item();
								usces_have_skus();
								if(!usces_have_zaiko()){
								?>
								<div class="noUketsuke">現在ご注文を受け付けておりません</div>
								<?php }else{ ?>
								<form action="<?php echo esc_url( USCES_CART_URL ); ?>" method="post">
									<div class="cartBtn">
										<?php usces_the_itemSkuButton('注文'); ?>
									</div>
									<?php do_action( 'usces_action_single_item_inform' ); ?>
								</form>
								<?php } ?>
							</div>
						</div>
					</div>
				</section>
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
