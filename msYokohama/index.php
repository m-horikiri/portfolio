<?php get_header();?>
	<div id="mainWrap">
		<?php printBreadcrumbs();?>
		<main id="index" class="contentsWrapper">
			<section class="largeSection">
				<h1 class="largeHeading"><?php bloginfo('name')?></h1>
				<p class="contentsText"><?php bloginfo('description')?></p>
				<?php
					$cats = get_categories();
					foreach($cats as $cat):
						$postArgs = [
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 2,
							'cat' => $cat->cat_ID,
							'orderby' => 'modified'
						];
						$posts = new WP_Query($postArgs);
						if($posts->have_posts()):
				?>
				<section class="middleSection">
					<h2 class="middleHeading"><?php echo esc_html($cat->name);?></h2>
					<ul class="postList">
						<?php
							while($posts->have_posts()):
								$posts->the_post();
						?>
						<li>
							<a class="imgBox" href="<?php the_permalink();?>">
								<?php
									if(has_post_thumbnail()){
										the_post_thumbnail('postList');
									}else{
										echo '<img src="' . esc_url(THEME_URL) . '/img/noImg.svg" alt="' . esc_html(get_the_title()) . '" width="250" height="166">';
									}
								?>
							</a>
							<div class="textBox">
								<div class="day">更新日：<?php the_modified_date('Y.m.d');?></div>
								<a class="title" href="<?php the_permalink();?>">
									<?php the_title();?>
								</a>
								<?php
									$tags = get_the_tags();
									if($tags):
								?>
								<ul class="tagList">
									<?php foreach($tags as $tag):?>
									<li>
										<a href="<?php echo esc_url(get_tag_link($tag->term_id));?>"><?php echo esc_html($tag->name);?></a>
									</li>
									<?php endforeach;?>
								</ul>
								<?php endif;?>
							</div>
						</li>
						<?php endwhile;?>
					</ul>
					<a class="moreViewText" href="<?php echo esc_url(get_category_link($cat->cat_ID));?>">もっと見る</a>
				</section>
				<?php
						endif;
					wp_reset_postdata();
					endforeach;
				?>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
