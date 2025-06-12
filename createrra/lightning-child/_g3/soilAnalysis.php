<?php
/*Template Name: soilAnalysis*/

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

<div class="soilAnalysis <?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">
		<div class="<?php lightning_the_class_name( 'main-section' ); ?>" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

			<?php //soilAnalysis ?>
			<p class="shopText">土壌診断を行い、適切な施肥計画や土壌改良を実施することにより、収量・品質アップなどの生産性向上に繋がります。<br>創業1975年より培ったノウハウで営農の効率化を図り、生産者様をサポートいたします。シンプルかつ、分かりやすい土壌診断カルテを用いて適切なアドバイスを行います。</p>
			<section>
				<h2 class="shopLargeHeading">土壌分析から結果診断までの流れ</h2>
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
					<h3 class="shopMiddleHeading">③分析結果の送付</h3>
					<p class="shopText">土壌診断カルテの作成および送付</p>
					<div class="captionImg shopImgBox flexImg">
						<img src="<?php echo get_template_directory_uri(); ?>/shopImg/03.png?v=20240509" alt="※診断結果イメージ1" width="350" height="247">
						<img src="<?php echo get_template_directory_uri(); ?>/shopImg/04.png?v=20240509" alt="※診断結果イメージ2" width="350" height="247">
					</div>
					<p class="captionText noticeText">※診断結果イメージ</p>
					<a class="shopLinkBtn" href="/createrrashop/">土壌分析申し込み<i class="fa-solid fa-cart-shopping"></i></a>
				</section>
			</section>
			<section>
				<h2 class="shopLargeHeading">土壌分析の重要性</h2>
				<ul class="imgList">
					<?php
					$img01 = get_field('shopImgList_01');
					$img02 = get_field('shopImgList_02');
					$img03 = get_field('shopImgList_03');
					$img04 = get_field('shopImgList_04');
					?>
					<li>
						<img src="<?= $img01['url'] ?>" alt="土壌分析の重要性" width="<?= $img01['width'] ?>" height="<?= $img01['height'] ?>">
					</li>
					<li>
						<img src="<?= $img02['url'] ?>" alt="土壌分析の重要性" width="<?= $img02['width'] ?>" height="<?= $img02['height'] ?>">
					</li>
					<li>
						<img src="<?= $img03['url'] ?>" alt="土壌分析の重要性" width="<?= $img03['width'] ?>" height="<?= $img03['height'] ?>">
					</li>
					<li>
						<img src="<?= $img04['url'] ?>" alt="土壌分析の重要性" width="<?= $img04['width'] ?>" height="<?= $img04['height'] ?>">
					</li>
				</ul>
				<p class="shopText">作物を正常に生育させるためには、土壌中の養分状態を作物の要求する量に調節するとともに他の成分とのバランスをとる必要があります。<br>土壌診断をすることにより適正な施肥で作物の収量の安定、施肥コストの低減をすることができます。</p>
				<div class="flexWrap">
					<section>
						<h3 class="shopMiddleHeading">不健康な土から</h3>
						<div class="shopImgBox">
							<img src="<?php echo get_template_directory_uri(); ?>/shopImg/05.png?v=20240509" alt="不健康な土から" width="390" height="290">
						</div>
						<p class="shopText">土壌中の栄養分が不足しても過剰でも作物の生育に大きな影響を及ぼしてしまいます。</p>
					</section>
					<section>
						<h3 class="shopMiddleHeading">健康な土へ</h3>
						<div class="shopImgBox">
							<img src="<?php echo get_template_directory_uri(); ?>/shopImg/06.png?v=20240509" alt="健康な土へ" width="390" height="290">
						</div>
						<p class="shopText">土壌診断をもとに栄養バランスを整え健康な土壌に変えます。</p>
					</section>
				</div>
			</section>
			<section>
				<h2 class="shopLargeHeading">土壌診断のための項目</h2>
				<div class="textImgFlex">
					<div class="textBox">
						<p class="shopText">作物舞に必要な栄養バランスや管理方法が異なります。<br>土壌診断を行うことにより対象作物の適切な成育環境作りに役立てることができます。</p>
						<p class="shopText">土壌の適正判断には以下の項目を測定します。</p>
					</div>
					<div class="imgBox">
						<img src="<?php echo get_template_directory_uri(); ?>/shopImg/07.png?v=20240509" alt="土壌分析から結果診断までの流れ" width="579" height="427">
					</div>
				</div>
				<dl class="soilAnalysisDl">
					<?php
					$tags = get_tags(['orderby' => 'name']);
					foreach($tags as $tag){
					?>
					<dt><?php echo $tag->name;?></dt>
					<dd><?php if($tag->description != null){echo $tag->description;} ?></dd>
					<?php } ?>
				</dl>
				<a class="shopLinkBtn" href="/createrrashop/">土壌分析申し込み<i class="fa-solid fa-cart-shopping"></i></a>
			</section>
			<?php //soilAnalysis end ?>

			<?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
		</div><!-- [ /.main-section ] -->

		<?php
		do_action( 'lightning_sub_section_before', 'lightning_sub_section_before' );
		if ( lightning_is_subsection() ) {
			lightning_get_template_part( 'sidebar', get_post_type() );
		}
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
