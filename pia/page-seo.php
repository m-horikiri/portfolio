<?php
	/* Template Name:SEOとは/SEOの歴史*/
	get_header();
?>
	<div id="mainWrap">
		<main id="<?php echo 'page_' . CAT_SEO?>" class="contentsWrapper">
			<?php myBreadcrumbs();?>
			<section class="largeSection">
				<ul class="dayList">
					<li>更新日：<?php the_modified_date('Y.m.d');?></li>
					<li>投稿日：<?php the_time('Y.m.d');?></li>
				</ul>
				<h1 class="mainHeding"><?php the_title();?></h1>
				<div class="mainThumbnail">
				<?php
					if(has_post_thumbnail()){
						the_post_thumbnail('mainThumbnail');
					}else{
						echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
					}
				?>
				</div>
				<?php
					$introductory = get_field('introductory');
					if($introductory):
						$introductoryText = nl2br($introductory);
				?>
				<div class="introductoryText">
					<?php echo $introductoryText;?>
				</div>
				<?php endif;?>
				<div id="contentsBox">
					<?php the_content();?>
					<?php
						if(is_page('what' . CAT_SEO)){
							addSeoNews();
						}
					?>
				</div>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
