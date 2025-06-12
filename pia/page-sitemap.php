<?php
	/* Template Name:サイトマップ*/
	get_header();
?>
	<div id="topView">
		<h1 class="topViewHeading"><?php the_title();?></h1>
	</div>
	<div id="mainWrap">
		<main id="sitemap" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<div class="siteMapWrap">
				<?php menuListOutput(true);?>
				<ul class="ctaList">
					<li>
						<a href="/contact/">お問い合わせ</a>
					</li>
					<li>
						<a href="/consultation/">無料オンライン相談</a>
					</li>
				</ul>
			</div>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
