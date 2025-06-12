<?php
	/* Template Name:サイドバーなし*/
	get_header();
?>
	<div id="topView">
		<h1 class="topViewHeading"><?php the_title();?></h1>
	</div>
	<div id="mainWrap" class="noSidebar">
		<main id="page">
			<?php myBreadcrumbs();?>
			<div id="pageContentsBox">
				<?php the_content();?>
			</div>
		</main>
	</div>
<?php get_footer();?>
