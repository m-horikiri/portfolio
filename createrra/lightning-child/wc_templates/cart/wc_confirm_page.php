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
			<li class="breadcrumb-list__item">内容確認</li>
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
				<li>配送・<br class="spView">支払方法</li>
				<li class="active">内容確認</li>
			</ul>
			<div class="header_explanation">
				<?php do_action( 'usces_action_cart_page_header' ); ?>
			</div>
			<div class="error_message">
				<?php usces_error_message(); ?>
			</div>
			
				<div id="cart" class="confirm">
					<table cellspacing="0" id="cart_table">
						<thead>
							<tr>
								<th class="productname">注文品名</th>
								<th class="quantity"><?php esc_html_e( 'Quantity', 'usces' ); ?></th>
								<th class="subtotal"><?php esc_html_e( 'Amount', 'usces' ); ?><?php usces_guid_tax(); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php usces_get_confirm_rows(); ?>
						</tbody>
						<tfoot>
							<?php if ( ! empty( $usces_entries['order']['discount'] ) ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php echo apply_filters( 'usces_confirm_discount_label', __( 'Campaign disnount', 'usces' ) ); ?></td>
								<td class="aright" style="color:#FF0000"><?php usces_crform( $usces_entries['order']['discount'], true, false ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( usces_is_tax_display() && 'products' === usces_get_tax_target() ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php usces_tax_label(); ?></td>
								<td class="aright"><?php usces_tax( $usces_entries ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( usces_is_member_system() && usces_is_member_system_point() && ! empty( $usces_entries['order']['usedpoint'] ) && 0 === usces_point_coverage() ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php esc_html_e( 'Used points', 'usces' ); ?></td>
								<td class="aright" style="color:#FF0000"><?php echo number_format( $usces_entries['order']['usedpoint'] ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( wel_have_shipped() ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php esc_html_e( 'Shipping', 'usces' ); ?></td>
								<td class="aright"><?php usces_crform( $usces_entries['order']['shipping_charge'], true, false ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( ! empty( $usces_entries['order']['cod_fee'] ) ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php echo apply_filters( 'usces_filter_cod_label', __( 'COD fee', 'usces' ) ); ?></td>
								<td class="aright"><?php usces_crform( $usces_entries['order']['cod_fee'], true, false ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( usces_is_tax_display() && 'all' === usces_get_tax_target() ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php usces_tax_label(); ?></td>
								<td class="aright"><?php usces_tax( $usces_entries ); ?></td>
							</tr>
						<?php endif; ?>
						<?php if ( usces_is_member_system() && usces_is_member_system_point() && ! empty( $usces_entries['order']['usedpoint'] ) && 1 === usces_point_coverage() ) : ?>
							<tr>
								<td colspan="2" class="aright"><?php esc_html_e( 'Used points', 'usces' ); ?></td>
								<td class="aright" style="color:#FF0000"><?php echo number_format( $usces_entries['order']['usedpoint'] ); ?></td>
							</tr>
						<?php endif; ?>
							<tr>
								<th colspan="2" scope="row" class="aright"><?php esc_html_e( 'Total Amount', 'usces' ); ?></th>
								<th class="aright amount"><?php usces_crform( $usces_entries['order']['total_full_price'], true, false ); ?></th>
							</tr>
						</tfoot>
					</table>
					<?php do_action( 'usces_action_confirm_table_after' ); ?>
					<?php if ( usces_is_member_system() && usces_is_member_system_point() && usces_is_login() && wel_is_available_point() ) : ?>
						<form action="<?php usces_url( 'cart' ); ?>" method="post" onKeyDown="if(event.keyCode == 13){return false;}">
							<div class="error_message"><?php usces_error_message(); ?></div>
							<table cellspacing="0" id="point_table">
								<tr>
									<td class="c-point"><?php esc_html_e( 'The current point', 'usces' ); ?></td>
									<td><span class="point"><?php echo esc_html( $usces_members['point'] ); ?></span>pt</td>
								</tr>
								<tr>
									<td class="u-point"><?php esc_html_e( 'Points you are using here', 'usces' ); ?></td>
									<td><input name="offer[usedpoint]" class="used_point" type="text" value="<?php echo esc_attr( $usces_entries['order']['usedpoint'] ); ?>" />pt</td>
								</tr>
								<tr>
									<td colspan="2" class="point-btn"><input name="use_point" type="submit" class="use_point_button" value="<?php esc_attr_e( 'Use the points', 'usces' ); ?>" /></td>
								</tr>
							</table>
							<?php do_action( 'usces_action_confirm_page_point_inform' ); ?>
						</form>
						<?php endif; ?>
						<?php do_action( 'usces_action_confirm_after_form' ); ?>
				</div>
				<table id="confirm_table">
					<tr class="ttl">
						<td colspan="2"><h3><?php esc_html_e( 'Customer Information', 'usces' ); ?></h3></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'e-mail adress', 'usces' ); ?></th>
							<td><?php echo esc_html( $usces_entries['customer']['mailaddress1'] ); ?></td>
					</tr>
					<?php uesces_addressform( 'confirm', $usces_entries, 'echo' ); ?>
					<tr class="ttl">
						<td colspan="2"><h3><?php esc_html_e( 'Others', 'usces' ); ?></h3></td>
					</tr>
				<?php if ( wel_have_shipped() ) : ?>
					<tr>
						<th>発送方法</th>
						<td><?php echo esc_html( usces_delivery_method_name( $usces_entries['order']['delivery_method'], 'return' ) ); ?></td>
					</tr>
				<?php endif; ?>
					<tr>
						<th><?php esc_html_e( 'payment method', 'usces' ); ?></th>
						<td><?php echo esc_html( $usces_entries['order']['payment_name'] . usces_payment_detail( $usces_entries ) ); ?></td>
					</tr>
					<?php usces_custom_field_info( $usces_entries, 'order', '' ); ?>
					<tr>
						<th><?php esc_html_e( 'Notes', 'usces' ); ?></th>
						<td><?php echo nl2br( esc_html( $usces_entries['order']['note'] ) ); ?></td>
					</tr>
				<?php if ( wel_have_dlseller_content() ) : ?>
					<tr>
						<th><?php esc_html_e( 'Terms of Use', 'dlseller' ); ?></th>
						<td><?php echo esc_html( $usces_entries['order']['terms'] ? __( 'Agree', 'welcart_basic' ) : '' ); ?></td>
					</tr>
				<?php endif; ?>
			</table>
			<?php do_action( 'usces_action_confirm_page_notes' ); ?>
			<?php usces_purchase_button(); ?>
			<div class="footer_explanation">
				<?php do_action( 'usces_action_confirm_page_footer' ); ?>
			</div>
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
