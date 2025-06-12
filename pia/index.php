<?php get_header();?>
	<div id="mainWrap">
		<main id="index" class="contentsWrapper">
			<section class="largeSection">
				<h2 class="largeHeading">おすすめ記事</h2>
				<div class="extraPostBox">
					<?php
						$pageSlug = 'what' . CAT_SEO;
						$pageId = get_page_by_path($pageSlug);
						$page = get_post($pageId);
					?>
					<a class="imgBox" href="<?php echo get_permalink($pageId);?>">
						<?php if(has_post_thumbnail($pageId)):?>
						<img src="<?php echo get_the_post_thumbnail_url($pageId, 'extraPostBox');?>" alt="<?php echo $page->post_title;?>" width="350" height="185">
						<?php else:?>
						<img src="<?php echo THEME_URL;?>/img/common/noImg.svg" alt="<?php echo $page->post_title;?>" width="350" height="185">
						<?php endif;?>
					</a>
					<div class="textBox">
						<a class="title" href="<?php echo get_permalink($pageId);?>">
							<?php echo $page->post_title;?>
						</a>
						<div class="day">
							更新日：<?php echo get_the_modified_date('Y.m.d', $pageId);?>
						</div>
						<p class="excerpt">
							<?php makePageExcerpt($pageId);?>
						</p>
					</div>
					<?php wp_reset_postdata();?>
				</div>
				<?php
					$seoCat = CAT_SEO . 'cat';
					$seoFundamentals = CAT_SEO . '-fundamentals';
					$fundamentalsCat = get_term_by('slug', $seoFundamentals, $seoCat);
					$fundamentalsArgs = [
						'post_type' => CAT_SEO,
						'tax_query' => [
							[
								'taxonomy' => $seoCat,
								'field' => 'slug',
								'terms' => $seoFundamentals
							]
						],
						'posts_per_page' => 3,
						'orderby' => 'modified'
					];
					$fundamentals = new WP_Query($fundamentalsArgs);
					if($fundamentals->have_posts()):	
				?>
				<section class="middleSection">
					<h3 class="middleHeading"><?php echo $fundamentalsCat->name;?></h3>
					<ul class="postList">
						<?php
							while($fundamentals->have_posts()):
								$fundamentals->the_post();
						?>
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
						<?php endwhile;?>
					</ul>
					<a class="moreViewText" href="<?php echo get_term_link($seoFundamentals, $seoCat);?>">もっと見る</a>
				</section>
				<?php
					endif;
					wp_reset_postdata();
				?>
				<?php indexPostList(CAT_SEO);?>
				<?php indexPostList(CAT_ADVERTISEMENT);?>
				<?php indexPostList(CAT_SNS);?>
				<section id="tagSection" class="middleSection">
					<h3 class="middleHeading">キーワードから探す</h3>
					<?php tagListOutput();?>
				</section>
			</section>
			<section class="largeSection">
				<h2 class="largeHeading">新着記事</h2>
				<?php
					$allPostArgs = [
						'post_type' => [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS],
						'posts_per_page' => 6,
						'orderby' => 'modified'
					];
					$allPosts = new WP_Query($allPostArgs);
					if($allPosts->have_posts()):	
				?>
				<ul class="postList">
					<?php
						while($allPosts->have_posts()):
							$allPosts->the_post();
					?>
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
					<?php endwhile;?>
				</ul>
				<?php
					endif;
					wp_reset_postdata();
				?>
			</section>	
			<?php
				$newsPostType = get_post_type_object('news');
				$newsArgs = [
					'post_type' => 'news',
					'posts_per_page' => 5,
					'orderby' => 'date'
				];
				$newsPosts = new WP_Query($newsArgs);
				if($newsPosts->have_posts()):
			?>
			<section class="largeSection">
				<h2 class="largeHeading"><?php echo $newsPostType->labels->name;?></h2>
				<ul class="newsList">
					<?php
						while($newsPosts->have_posts()):
							$newsPosts->the_post();
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
				<a class="moreViewText" href="/news/">もっと見る</a>
			</section>
			<?php
				endif;
				wp_reset_postdata();
			?>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
