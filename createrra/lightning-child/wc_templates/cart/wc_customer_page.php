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
			<li class="breadcrumb-list__item">お客様情報</li>
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
				<li class="active">お客様情報</li>
				<li>配送・<br class="spView">支払方法</li>
				<li>内容確認</li>
			</ul>
			<div class="header_explanation">
				<?php do_action( 'usces_action_customer_page_header' ); ?>
			</div>
			<div class="error_message">
				<?php usces_error_message(); ?>
			</div>
				<?php if ( usces_is_membersystem_state() ) : ?>
					<?php if ( ! wel_have_ex_order() ) : ?>
					<h5><?php esc_html_e( 'The member please enter at here.', 'usces' ); ?></h5>
					<?php endif; ?>
					<form action="<?php usces_url( 'cart' ); ?>" method="post" name="customer_loginform" onKeyDown="if(event.keyCode == 13){return false;}">
						<table width="100%" cellpadding="0" cellspacing="0" class="customer_form">
							<tr>
								<th scope="row"><?php esc_html_e( 'e-mail adress', 'usces' ); ?></th>
								<td><input name="loginmail" id="loginmail" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress1'] ); ?>" style="ime-mode: inactive" /></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'password', 'usces' ); ?></th>
								<td><input name="loginpass" id="loginpass" type="password" autocomplete="new-password" value="" /></td>
							</tr>
						</table>
					<?php if ( wel_have_ex_order() ) : ?>
						<p id="nav"><a class="lostpassword" href="<?php usces_url( 'lostmemberpassword' ); ?>"><?php esc_html_e( 'Did you forget your password?', 'usces' ); ?></a></p>
						<p id="nav"><a class="newmember" href="<?php usces_url( 'newmember' ); ?>&dlseller_transition=newmember"><?php esc_html_e( 'New enrollment for membership.', 'usces' ); ?></a></p>
					<?php endif; ?>
						<div class="send"><input name="customerlogin" class="to_memberlogin_button" type="submit" value="<?php esc_html_e( ' Next ', 'usces' ); ?>" /></div>
						<?php do_action( 'usces_action_customer_page_member_inform' ); ?>
					</form>
				<?php endif; ?>
				<?php if ( ! wel_have_ex_order() ) : ?>
					<?php if ( usces_is_membersystem_state() ) : ?>
					<h5><?php esc_html_e( 'The nonmember please enter at here.', 'usces' ); ?></h5>
					<?php endif; ?>
					<form action="<?php echo esc_url_raw( USCES_CART_URL ); ?>" method="post" name="customer_form" onKeyDown="if(event.keyCode == 13){return false;}">
						<table cellpadding="0" cellspacing="0" class="customer_form">
							<?php uesces_addressform( 'customer', $usces_entries, 'echo' ); ?>
							<tr>
								<th scope="row">
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
									<?php esc_html_e( 'e-mail adress', 'usces' ); ?>
								</th>
								<td colspan="2">
									<input name="customer[mailaddress1]" id="mailaddress1" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress1'] ); ?>" style="ime-mode: inactive" autocomplete="off" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
									<?php esc_html_e( 'e-mail adress', 'usces' ); ?>(<?php esc_html_e( 'Re-input', 'usces' ); ?>)
								</th>
								<td colspan="2">
									<input name="customer[mailaddress2]" id="mailaddress2" type="text" value="<?php echo esc_attr( $usces_entries['customer']['mailaddress2'] ); ?>" style="ime-mode: inactive" autocomplete="off" />
								</td>
							</tr>
						<?php if ( usces_is_membersystem_state() ) : ?>
							<tr>
								<th scope="row">
								<?php if ( 'editmemberfromcart' === $member_regmode ) : ?>
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
								<?php endif; ?><?php esc_html_e( 'password', 'usces' ); ?>
								</th>
								<td colspan="2">
									<input name="customer[password1]" style="width:100px" type="password" value="<?php echo esc_attr( $usces_entries['customer']['password1'] ); ?>" autocomplete="new-password" />
								<?php if ( 'editmemberfromcart' !== $member_regmode ) : ?>
									<?php esc_html_e( 'When you enroll newly, please fill it out.', 'usces' ); ?>
								<?php endif; ?>
									<?php wel_password_policy_message(); ?>
								</td>
							</tr>
							<tr>
								<th scope="row">
								<?php if ( 'editmemberfromcart' === $member_regmode ) : ?>
									<em><?php esc_html_e( '*', 'usces' ); ?></em>
								<?php endif; ?>
									<?php esc_html_e( 'Password (confirm)', 'usces' ); ?>
								</th>
								<td colspan="2">
									<input name="customer[password2]" style="width:100px" type="password" value="<?php echo esc_attr( $usces_entries['customer']['password2'] ); ?>" autocomplete="new-password" />
								<?php if ( 'editmemberfromcart' !== $member_regmode ) : ?>
									<?php esc_html_e( 'When you enroll newly, please fill it out.', 'usces' ); ?>
								<?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
						</table>
						<input name="member_regmode" type="hidden" value="<?php echo esc_attr( $member_regmode ); ?>" />
						<div class="send">
							<?php usces_get_customer_button(); ?>
						</div>
						<?php usces_agree_member_field(); ?>
						<?php do_action( 'usces_action_customer_page_inform' ); ?>
					</form>
				<?php endif; ?>
					<div class="footer_explanation">
						<?php do_action( 'usces_action_customer_page_footer' ); ?>
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
