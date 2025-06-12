	<footer class="commonFooter">
		<div class="contentsWrapper">
			<a class="siteLogo" href="<?php echo esc_url(home_url('/'))?>">
				<img src="<?php echo esc_url(THEME_URL);?>/img/common/siteLogo.png" alt="<?php bloginfo('name');?>" width="160" height="40">
			</a>
			<div class="menuWrap">
				<?php
					$headerNavArgs = [
						'theme_location' => 'footer',
						'container' => 'nav',
						'menu_class' => 'menuNav',
					];
					wp_nav_menu($headerNavArgs);
				?>
			</div>
			<div class="copy">Copyright © <?php echo esc_html(date('Y')) ?> <?php bloginfo('name');?></div>
		</div>
	</footer>
</body>
<?php wp_footer();?>
</html>