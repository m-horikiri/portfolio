<?php get_header();?>
	<div id="topView">
		<h1 class="topViewHeading"><?php the_title();?></h1>
	</div>
	<div id="mainWrap">
		<main id="page" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<div id="contentsBox">
				<?php the_content();?>
			</div>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
