<?php get_header();?>
	<main id="notFound" class="contentsWrapper">
		<?php myBreadcrumbs();?>
		<section class="largeSection">
			<h2 class="largeHeading">お探しのページはみつかりませんでした</h2>
			<img class="notFoundImg" src="<?php echo THEME_URL;?>/img/page/notFound.svg" alt="お探しのページはみつかりませんでした" width="350" height="197">
			<p>お手数ですが<a href="<?php echo esc_url(home_url('/'))?>">トップページ</a>へお戻りいただき、ご覧になりたいページをお探しください。</p>
		</section>
	</main>
<?php get_footer();?>
