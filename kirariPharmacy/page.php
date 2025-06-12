<?php get_header();?>
	<main id="page" class="contentsWrapper">
		<?php myBreadcrumbs();?>
		<section>
			<h2 class="largeHeading">
				<?php the_title();?>
				<?php
					$jpText = get_field('jptitle');
					if(!empty($jpText)){
						echo "<span class='jpText'>{$jpText}</span>";
					}
				?>
			</h2>
			<div id="contentsBox">
				<?php the_content(); ?>
			</div>
		</section>
	</main>
<?php get_footer();?>