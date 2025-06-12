<?php get_header();?>
	<main id="single" class="contentsWrapper">
		<?php myBreadcrumbs();?>
		<section>
			<h2 class="largeHeading"><?php the_title();?></h2>
			<div id="contentsBox">
				<?php the_content(); ?>
			</div>
		</section>
	</main>
<?php get_footer();?>