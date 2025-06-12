<?php get_header();?>
	<div id="topView">
		<h1 class="topViewHeading">
			<?php the_archive_title();?>
		</h1>
	</div>
	<div id="mainWrap">
		<main id="archive" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<?php if(term_description() || tag_description() && !is_paged()):?>
			<section class="descriptionSection largeSection">
				<h2 class="largeHeading"><?php the_archive_title();?></h2>
				<div class="contentsText"><?php echo term_description();?></div>
			</section>
			<?php endif;?>
			<section class="largeSection">
				<?php if(have_posts()):?>
				<h2 class="largeHeading">新着記事</h2>
				<?php
						while(have_posts()):
							the_post();
							if(!is_paged() && $wp_query->current_post < 1):
				?>
				<div class="extraPostBox">
					<a class="imgBox" href="<?php the_permalink();?>">
					<?php
						if(has_post_thumbnail()){
							the_post_thumbnail('extraPostBox');
						}else{
							echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
						}
					?>
					</a>
					<div class="textBox">
						<a class="title" href="<?php the_permalink();?>">
							<?php the_title();?>
						</a>
						<div class="day">
							更新日：<?php the_modified_date('Y.m.d');?>
						</div>
						<p class="excerpt">
							<?php the_excerpt();?>
						</p>
						<?php
							$postType = get_post_type();
							$cats = get_the_terms($post->ID, $postType . 'cat');
							if($cats):
						?>
						<ul class="categoryList">
							<?php foreach($cats as $cat):?>
							<li>
								<a href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->name;?></a>
							</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
					</div>
				</div>
				<?php elseif(!is_paged() && $wp_query->current_post == 1 || is_paged() && $wp_query->current_post < 1):?>
				<ul class="postList">
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<?php
									if(has_post_thumbnail()){
										the_post_thumbnail('postList');
									}else{
										echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
									}
								?>
							</div>
						</a>
						<div class="textBox">
							<div class="day">更新日：<?php the_modified_date('Y.m.d');?></div>
							<a class="title" href="<?php the_permalink();?>">
								<?php the_title();?>
							</a>
							<?php
								$postType = get_post_type();
								$cats = get_the_terms($post->ID, $postType . 'cat');
								if($cats):
							?>
							<ul class="categoryList">
								<?php foreach($cats as $cat):?>
								<li>
									<a href="<?php echo get_term_link($cat);?>"><?php echo $cat->name;?></a>
								</li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</div>
					</li>
				<?php elseif($wp_query->current_post >= 1):?>
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<?php
									if(has_post_thumbnail()){
										the_post_thumbnail('postList');
									}else{
										echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
									}
								?>
							</div>
						</a>
						<div class="textBox">
							<div class="day">更新日：<?php the_modified_date('Y.m.d');?></div>
							<a class="title" href="<?php the_permalink();?>">
								<?php the_title();?>
							</a>
							<?php
								$postType = get_post_type();
								$cats = get_the_terms($post->ID, $postType . 'cat');
								if($cats):
							?>
							<ul class="categoryList">
								<?php foreach($cats as $cat):?>
								<li>
									<a href="<?php echo get_term_link($cat);?>"><?php echo $cat->name;?></a>
								</li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</div>
					</li>
				<?php endif;?>
				<?php if($wp_query->current_post == $wp_query->post_count - 1):?>
				</ul>
				<?php
						endif;
					endwhile;
				?>
				<?php else:?>
				<h2 class="largeHeading">COMING SOON</h2>
				<p class="contentsText">該当の記事は現在誠意作成中です。<br>公開まで今しばらくお待ちください。</p>				
				<?php
					endif;
					wp_reset_postdata();
				?>
				<?php
					if(wp_is_mobile()){
						pagenation();
					}else{
						pagenation(9);
					}
				?>
			</section>
			<?php recommendPostList(6);?>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
