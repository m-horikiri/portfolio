<?php get_header();?>
	<main id="index" class="contentsWrapper">
		<div class="indexImg">
			<picture>
				<source media="(min-width:781px)" srcset="<?php echo esc_url(THEME_URL);?>/img/index/indexImg_pc.webp">
				<img src="<?php echo esc_url(THEME_URL);?>/img/index/indexImg.webp" alt="<?php bloginfo('name');?>" width="350" height="265">
			</picture>
		</div>
		<?php
			$newsPostType = get_post_type_object('news');
			$newsArgs = [
				'post_type' => 'news',
				'orderby' => 'date'
			];
			$newsPosts = new WP_Query($newsArgs);
		?>
		<section>
			<h2 class="largeHeading">News<span class="jpText"><?php echo esc_html($newsPostType->labels->name);?></span></h2>
			<?php if($newsPosts->have_posts()):?>
			<ul class="newsList">
				<?php
					while($newsPosts->have_posts()):
						$newsPosts->the_post();
				?>
				<li>
					<a href="<?php the_permalink();?>">
						<div class="day"><?php the_date('Y.m.d');?></div>
						<div class="text"><?php the_title();?></div>
					</a>
				</li>
				<?php endwhile;?>
			</ul>
			<a class="commonBtn" href="<?php echo esc_url(home_url('/news/'))?>">More</a>
			<?php else:?>
			<p class="contentsText">該当の記事は現在誠意作成中です。<br>公開まで今しばらくお待ちください。</p>
			<?php
				endif;
				wp_reset_postdata();
			?>
		</section>
	</main>
<?php get_footer();?>
