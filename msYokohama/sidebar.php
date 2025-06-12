		<aside id="commonSide">
			<?php
				$newArgs = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 5,
					'orderby' => 'date'
				];
				$newList = new WP_Query($newArgs);
				if($newList->have_posts()):
			?>
			<section class="sideSection">
				<h2 class="sideHeading">新着記事</h2>
				<ul class="newList">
					<?php
						while($newList->have_posts()):
							$newList->the_post();
					?>
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<?php if(has_post_thumbnail()){
									the_post_thumbnail('newList');
								}else{
									echo '<img src="' . THEME_URL . '/img/noImg.svg" alt="' . esc_html(get_the_title()) . '" width="128" height="85">';
								}?>
							</div>
							<div class="title"><?php the_title();?></div>
						</a>
					</li>
					<?php endwhile;?>
				</ul>
			</section>
			<?php
				endif;
				wp_reset_postdata();
				$cats = get_categories();
				if($cats):
			?>
			<section class="sideSection">
				<h2 class="sideHeading">カテゴリー</h2>
				<ul class="categoryList">
					<?php foreach($cats as $cat):?>
						<li>
							<a class="commonBtn" href="<?php echo esc_url(get_category_link($cat->cat_ID));?>"><?php echo esc_html($cat->name);?></a>
						</li>
					<?php endforeach;?>
				</ul>
			</section>
			<?php endif;?>
		</aside>