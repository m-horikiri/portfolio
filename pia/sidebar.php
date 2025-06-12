		<aside id="commonSide">
			<a class="serviceBnr" href="<?php echo get_permalink(get_page_by_path('service')->ID);?>">
				<img src="<?php echo THEME_URL;?>/img/common/serviceBnr.webp" alt="PIAのサービス紹介" width="350" height="291">
			</a>
			<section class="sideSection">
				<h2 class="sideHeading">人気のキーワード</h2>
				<?php tagListOutput();?>
			</section>
			<?php
				$rankingArgs = [
					'post_type' => [CAT_SEO, CAT_ADVERTISEMENT, CAT_SNS],
					'posts_per_page' => 5,
					'meta_key' => 'post_views_count',
					'orderby' => 'meta_value_num'
				];
				$rankings = new WP_Query($rankingArgs);
				if($rankings->have_posts()):
			?>
			<section class="sideSection">
				<h2 class="sideHeading">人気記事TOP5</h2>
				<ul class="rankingList">
					<?php
						$rankIndex = 0;
						while($rankings->have_posts()):
							$rankings->the_post();
							$rankIndex ++;
					?>
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<div class="index"><?php echo $rankIndex;?></div>
								<?php if(has_post_thumbnail()){
									the_post_thumbnail('rankingList');
								}else{
									echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="120" height="60">';
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
			?>
			<a class="consultationBnr" href="/consultation/">
				<img src="<?php echo THEME_URL;?>/img/common/consultationBnr.webp" alt="無料オンライン相談" width="350" height="280">
			</a>			
		</aside>