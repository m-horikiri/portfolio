<?php get_header();?>
	<div id="topView">
		<h1 class="topViewHeading">404</h1>
	</div>
	<div id="mainWrap">
		<main id="notFound" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<section class="largeSection">
				<h2 class="largeHeading">お探しのページはみつかりませんでした</h2>
				<img class="notFoundImg" src="<?php echo THEME_URL;?>/img/404/404.svg" alt="お探しのページはみつかりませんでした" width="235" height="300">
				<p>お手数ですが<a href="<?php echo home_url();?>">トップページ</a>へお戻りいただき、ご覧になりたいページをお探しください。</p>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
