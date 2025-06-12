<?php get_header();?>
<?php
	if(!is_user_logged_in() && !is_robots()){
		setPostViews(get_the_ID());
	}
?>
	<div id="mainWrap">
		<main id="single" class="contentsWrapper">
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
					<?php the_content(); ?>
				</div>
			</section>
			<?php
				$tags = get_the_tags();
				if($tags):
			?>
			<section class="largeSection">
				<h2 class="largeHeading">この記事のタグ</h2>
				<ul class="tagList">
					<?php
						foreach($tags as $tag):
					?>
					<li>
						<a href="<?php echo get_tag_link($tag->term_id);?>"><?php echo $tag->name;?></a>
					</li>
					<?php endforeach;?>
				<ul>
			</section>
			<?php endif;?>
			<?php
				$supervisors = get_the_terms(get_the_ID(), 'supervisor');
				if($supervisors):
			?>
			<section class="largeSection">
				<h2 class="largeHeading">この記事の監修者</h2>
				<ul class="supervisorList">
					<?php foreach($supervisors as $supervisor):?>
					<li>
						<div class="imgBox">
							<?php
								$supervisorImg = get_field('supervisorImg', $supervisor);
								if($supervisorImg){
									echo '<img src="' . $supervisorImg['url'] . '" alt="' . $supervisorImg['alt'] . '" width="100" height="100">';
								}else{
									echo '<img src="' . THEME_URL . '/img/common/noImg.svg" alt="noImg" width="100" height="100">';
								}
							?>
						</div>
						<div class="textBox">
							<a class="name" href="/company/#<?php echo $supervisor->slug; ?>">
								<?php echo $supervisor->name; ?>｜株式会社PIA
							</a>
							<div class="description"><?php echo $supervisor->description; ?></div>
						</div>
					</li>
					<?php endforeach;?>
				</ul>
			</section>
			<?php endif;?>
			<?php recommendPostList();?>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
