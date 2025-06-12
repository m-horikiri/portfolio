<?php get_header();?>
<?php
	if(!is_user_logged_in() && !is_robots()){
		setPostViews(get_the_ID());
	}
?>
	<div id="mainWrap">
		<?php printBreadcrumbs();?>
		<main id="single" class="contentsWrapper">
			<section class="largeSection">
				<h1 class="largeHeading"><?php the_title();?></h1>
				<ul class="dayList">
					<li>更新日：<?php the_modified_date('Y.m.d');?></li>
					<li>投稿日：<?php the_time('Y.m.d');?></li>
				</ul>
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
				<div class="mainThumbnail">
				<?php
					if(has_post_thumbnail()){
						the_post_thumbnail('mainThumbnail');
					}else{
						echo '<img src="' . esc_url(THEME_URL) . '/img/noImg.svg" alt="' . get_the_title() . '" width="350" height="185">';
					}
				?>
				</div>
				<div id="contentsBox">
					<?php the_content();?>
				</div>
				<?php
					$summaryTitle = !empty(get_field('summaryTitle')) ? get_field('summaryTitle') : '';
					$summaryText = !empty(get_field('summaryText')) ? get_field('summaryText') : '';
					if(!empty($summaryTitle) && !empty($summaryText)):
				?>
				<div class="summaryBox">
					<h2 class="summaryTitle">
						<?php echo esc_html($summaryTitle);?>
					</h2>
					<p class="summaryText">
						<?php
							$summaryText = nl2br($summaryText);
							echo $summaryText;
						?>
					</p>
				</div>
				<?php endif;?>
			</section>
			<section class="supervisors largeSection">
				<h2 class="supervisorsHeading">ページ監修：総院長「葉山芳貴」紹介</h2>
				<div class="supervisorsWrap">
					<div class="imgBox">
						<img src="<?php echo esc_url(THEME_URL);?>/img/drHayama.webp" alt="葉山芳貴" width="270" height="242">
					</div>
					<div class="textBox">
						<h3 class="title">
							<span class="position">総院長、医学博士</span>
							<span class="name">葉山芳貴</span>
						</h3>
						<h4 class="smallTitle">経歴</h4>
						<dl class="careerDl">
							<dt>平成14年</dt>
							<dd>聖マリアンナ医科大学 卒業</dd>
							<dt>平成20年</dt>
							<dd>大阪医科大学 大学院 卒業</dd>
							<dt>平成22年</dt>
							<dd>大手美容形成外科 院長 就任</dd>
							<dt>平成27年</dt>
							<dd>メンズサポートクリニック開設</dd>
							<dt>平成28年</dt>
							<dd>メンズサポートクリニック新宿 院長就任</dd>
							<dt>平成28年</dt>
							<dd>医療法人清佑会 理事長 就任</dd>
						</dl>
						<h4 class="smallTitle">資格</h4>
						<p class="text">医師免許（医籍登録番号：453182）</p>
						<p class="text">保険医登録（保険医登録番号：阪医52752）</p>
					</div>
				</div>
			</section>
		</main>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>
