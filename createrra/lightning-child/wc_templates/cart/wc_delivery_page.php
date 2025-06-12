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
			<li class="breadcrumb-list__item">配送・支払方法</li>
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
				<li>カート</li>
				<li>お客様情報</li>
				<li class="active">配送・<br class="spView">支払方法</li>
				<li>内容確認</li>
			</ul>
			<div class="header_explanation">
				<?php do_action( 'usces_action_customer_page_header' ); ?>
			</div>
			<div class="error_message">
				<?php usces_error_message(); ?>
			</div>
			<form action="<?php usces_url( 'cart' ); ?>" method="post">
					<?php if ( wel_have_shipped() ) : ?>
						<table class="customer_form" id="delivery_flag">
							<tr>
								<th rowspan="2" scope="row">
									<?php esc_html_e( 'shipping address', 'usces' ); ?>
								</th>
								<td>
									<input name="delivery[delivery_flag]" type="radio" id="delivery_flag1" onclick="document.getElementById('delivery_table').style.display = 'none';" value="0"
									<?php checked( $usces_entries['delivery']['delivery_flag'], 0 ); ?>
									onKeyDown="if (event.keyCode == 13) {return false;}" />
									<label for="delivery_flag1"><?php esc_html_e( 'same as customer information', 'usces' ); ?></label>
								</td>
							</tr>
							<tr>
								<td>
									<input name="delivery[delivery_flag]" id="delivery_flag2" onclick="document.getElementById('delivery_table').style.display = 'table'" type="radio" value="1"
									<?php checked( $usces_entries['delivery']['delivery_flag'], 1 ); ?>
									onKeyDown="if (event.keyCode == 13) {return false;}" />
									<label for="delivery_flag2"><?php esc_html_e( 'Chose another shipping address.', 'usces' ); ?></label>
								</td>
							</tr>
						</table>
						<?php do_action( 'usces_action_delivery_flag' ); ?>
						<table class="customer_form" id="delivery_table">
							<?php uesces_addressform( 'delivery', $usces_entries, 'echo' ); ?>
						</table>
					<?php endif; ?>
						<table class="customer_form" id="time">
						<?php if ( wel_have_shipped() ) : ?>
							<tr>
								<th scope="row">
									発送方法
								</th>
								<td colspan="2">
									<?php
									usces_the_delivery_method( $usces_entries['order']['delivery_method'] );
									global $usces;
									$cart = $usces->cart->get_cart();
									$cartIndex = count($cart);
									$cartDelivmethod = [];
									for($i = 0; $i < $cartIndex; $i++){
										$cartItemId = $cart[$i]['post_id'];
										$cartDelivmethod[] = $usces->getItemDeliveryMethod($cartItemId);
									}
									if(in_array(['1'], $cartDelivmethod) && $cartIndex > 1){
										$nekopos = $usces->options['delivery_method'][1]['name'];
										echo '<div class="noticeText nekoposText">※試薬は' . $nekopos . 'にて別便でお届けします';
									}
									?>
								</td>
							</tr>
						<?php endif; ?>
							<tr>
								<th scope="row">
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
									<?php esc_html_e( 'payment method', 'usces' ); ?>
								</th>
								<td colspan="2">
									<?php usces_the_payment_method( $usces_entries['order']['payment_name'] ); ?>
								</td>
							</tr>
						</table>
						<?php usces_delivery_secure_form(); ?>
					<?php
					$meta = usces_has_custom_field_meta( 'order' );
					if ( ! empty( $meta ) && is_array( $meta ) ) :
						?>
						<table class="customer_form" id="custom_order">
							<?php usces_custom_field_input( $usces_entries, 'order', '' ); ?>
						</table>
						<?php
					endif;
					?>
					<?php if ( wel_have_dlseller_content() ) : ?>
						<table class="customer_form" id="dlseller_terms">
							<tr>
								<th rowspan="2" scope="row">
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
									<?php esc_html_e( 'Terms of Use', 'dlseller' ); ?>
								</th>
								<td colspan="2">
									<div class="dlseller_terms"><?php dlseller_terms(); ?></div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<label for="terms"><input type="checkbox" name="offer[terms]" id="terms" />
										<?php esc_html_e( 'Agree', 'dlseller' ); ?>
									</label>
								</td>
							</tr>
						</table>
					<?php endif; ?>
						<table class="customer_form" id="notes_table">
							<tr>
								<?php $entry_order_note = ( empty( $usces_entries['order']['note'] ) ) ? apply_filters( 'usces_filter_default_order_note', null ) : $usces_entries['order']['note']; ?>
								<th scope="row">
									<?php esc_html_e( 'Notes', 'usces' ); ?>
								</th>
								<td colspan="2">
									<textarea name="offer[note]" id="note" class="notes"><?php echo esc_html( $entry_order_note ); ?></textarea>
								</td>
							</tr>
						</table>
						<div class="send">
							<input name="offer[cus_id]" type="hidden" value="" />
							<input name="backCustomer" type="submit" class="back_to_customer_button" value="<?php esc_attr_e( 'Back', 'usces' ); ?>"<?php echo apply_filters( 'usces_filter_deliveryinfo_prebutton', null ); ?> />&nbsp;&nbsp;
							<input name="confirm" type="submit" class="to_confirm_button" value="<?php esc_attr_e( ' Next ', 'usces' ); ?>"<?php echo apply_filters( 'usces_filter_deliveryinfo_nextbutton', null ); ?> />
						</div>
						<?php do_action( 'usces_action_delivery_page_inform' ); ?>
					</form>
					<div class="footer_explanation">
						<?php do_action( 'usces_action_delivery_page_footer' ); ?>
					</div>
				</div>
			</article>
			<?php else : ?>
			<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'usces' ); ?></p>
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
