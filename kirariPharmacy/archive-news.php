<?php get_header();?>
	<main id="newsArchive" class="contentsWrapper">
		<?php
			myBreadcrumbs();
			$newsPostType = get_post_type_object('news');
		?>
		<section>
			<h2 class="largeHeading">News<span class="jpText"><?php echo esc_html($newsPostType->labels->name);?></span></h2>
			<?php if(have_posts()):?>
			<ul class="newsList">
				<?php
					while(have_posts()):
						the_post();
				?>
				<li>
					<a href="<?php the_permalink();?>">
						<div class="day"><?php the_date('Y.m.d');?></div>
						<div class="text"><?php the_title();?></div>
					</a>
				</li>
				<?php endwhile;?>
			</ul>
			<?php pagenation();?>
			<?php else:?>
			<p class="contentsText">現在誠意作成中です。公開まで今しばらくお待ちください。</p>
			<?php endif;?>
		</section>
	</main>
<?php get_footer();?>
