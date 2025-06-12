<?php get_header();?>
	<div id="mainWrap">
		<?php printBreadcrumbs();?>
		<main id="archive" class="contentsWrapper">
			<section class="largeSection">
				<?php if(have_posts()):?>
				<h1 class="largeHeading"><?php the_archive_title();?></h1>
					<ul class="postList">
						<?php
							while(have_posts()): the_post();
							$postStatus = get_post_status();
							if($postStatus !== 'publish'){
								$postStatus = false;
							}
						?>
						<li <?php if($postStatus === false) echo 'class="noPublish"';?>>
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
					<?php
						if($wp_query->max_num_pages > 1){
							printPager();
						}
					?>
				<?php else:?>
				<h1 class="largeHeading">COMING SOON</h1>
				<p class="contentsText">該当の記事は現在誠意作成中です。<br>公開まで今しばらくお待ちください。</p>
				<?php endif;?>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
