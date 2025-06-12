<?php
/*
Template Name: createrrashop-single
*/

use ParagonIE\Sodium\Core\Curve25519\H;
use VektorInc\VK_Breadcrumb\VkBreadcrumb;
function shopStyles() {
	wp_enqueue_style('shop', get_template_directory_uri() . '/original.css?v=' . date('Hms'), array('usces_cart_css'), 'all');
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
			<li class="breadcrumb-list__item">カートの中</li>
		</ol>
	</div>
</div>
<?php //createrrashop breadcrumb end ?>

<?php
do_action( 'lightning_breadcrumb_after', 'lightning_breadcrumb_after' );
?>
<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="cartPage createrrashop <?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">
		<div class="main-section" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

			<?php //createrrashop ?>
			<?php
			if(have_posts()) :
				usces_remove_filter();
			?>
			<ul class="cartNavi">
				<li class="active">カート</li>
				<li>お客様情報</li>
				<li>配送・<br class="spView">支払方法</li>
				<li>内容確認</li>
			</ul>
			<div class="header_explanation">
				<?php do_action( 'usces_action_cart_page_header' ); ?>
			</div>
			<div class="error_message">
				<?php usces_error_message(); ?>
			</div>
			<form action="<?php usces_url( 'cart' ); ?>" method="post" onKeyDown="if(event.keyCode == 13){return false;}">
			<?php if ( usces_is_cart() ) : ?>
				<div id="cart">
					<?php
					echo apply_filters( 'usces_theme_filter_upbutton', '<div class="upbutton">' . __( 'Press the `update` button when you change the amount of items.', 'usces' ) . '<input name="upButton" type="submit" value="' . __( 'Quantity renewal', 'usces' ) . '" onclick="return uscesCart.upCart()" /></div>' );
					?>
					<table cellspacing="0" id="cart_table">
						<thead>
							<tr>
								<th class="productname">注文品名</th>
								<th class="quantity"><?php esc_html_e( 'Quantity', 'usces' ); ?></th>
								<th class="subtotal"><?php esc_html_e( 'Amount', 'usces' ); ?><?php usces_guid_tax(); ?></th>
								<th class="action"></th>
							</tr>
						</thead>
						<tbody>
							<?php usces_get_cart_rows();?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2" scope="row" class="aright"><?php esc_html_e( 'total items', 'usces' ); ?><?php usces_guid_tax(); ?></th>
								<th class="aright amount"><?php usces_crform( usces_total_price( 'return' ), true, false ); ?></th>
								<th class="action"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<?php else : ?>
					<div class="no_cart send">
						<?php
						add_filter('usces_filter_get_cart_button', 'returnBtn');
						function returnBtn($res){
							$res = '<a href="/createrrashop/" class="continue_shopping_button">ONLINE SHOPへ戻る</a>';
							return $res;
						}
						esc_html_e( 'There are no items in your cart.', 'usces' );
						?>
					</div>
				<?php endif; ?>
					<div class="send">
						<?php usces_get_cart_button(); ?>
					</div>
					<?php do_action( 'usces_action_cart_page_inform' ); ?>
				</form>
				<div class="footer_explanation">
					<?php do_action( 'usces_action_cart_page_footer' ); ?>
				</div><!-- .footer_explanation -->
			<?php else : ?>
			<p class="shopText"><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'usces' ); ?></p>
			<?php endif; ?>
			<?php //createrrashop end ?>

			<?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
		</div><!-- [ /.main-section ] -->
		<?php
		do_action( 'lightning_sub_section_before', 'lightning_sub_section_before' );
		?>
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
