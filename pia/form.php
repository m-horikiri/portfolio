<?php
	/* Template Name:フォーム用*/
	get_header();
?>
	<div id="topView">
		<h1 class="topViewHeading"><?php the_title();?></h1>
	</div>
	<div id="mainWrap">
		<main id="form" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<section class="bgGray largeSection">
				<div class="formWrap">
					<?php the_content();?>
				</div>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
