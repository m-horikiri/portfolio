<?php get_header();?>
	<div id="topView">
		<h1 class="topViewHeading">
			<?php the_archive_title();?>
		</h1>
	</div>
	<div id="mainWrap">
		<main id="archive" class="contentsWrapper">
			<?php
				myBreadcrumbs();
				$newsPostType = get_post_type_object('news');
				if(have_posts()):
			?>
			<section class="largeSection">
				<h2 class="largeHeading"><?php echo $newsPostType->labels->name;?>一覧</h2>
				<ul class="newsList">
					<?php
						while(have_posts()):
							the_post();
					?>
					<li>
						<div class="day"><?php the_date('Y.m.d');?></div>
						<div class="textBox">
							<?php
								if(has_post_thumbnail()){
									the_post_thumbnail('newsList');
								}
							?>
							<div class="text">
								<?php the_content();?>
							</div>
						</div>
					</li>
					<?php endwhile;?>
				</ul>
				<?php
					endif;
				?>
				<?php pagenation();?>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
