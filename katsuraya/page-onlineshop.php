<?php get_header();?>
<main class="under">
	<section id="onlineShop" class="repairWrap">
		<?php include get_template_directory() . '/searchArea.php';?>
		<div class="searchBtnSp spView">
			商品を探す
			<div class="imgBox">
				<img src="<?php echo get_template_directory_uri();?>/img/shop/search.svg" alt="商品を探す" width="20" height="20">
			</div>
		</div>
		<div id="onlineShopItem">
			<ul class="breadcrumbs">
				<li><a href="/">TOP</a></li>
				<li><h1 class="specialHeading">オンラインショップ</h1></li>
			</ul>
			<?php
				do_action('usces_action_cart_page_header');
				$recommendArgs = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'category_name' => 'recommended',
					'posts_per_page' => 4,
					'orderby' => 'rand'
				];
				$recommendPosts = new WP_Query($recommendArgs);
				if($recommendPosts->have_posts()):
			?>
			<section class="recommend">
				<h2 class="onlineShopHeading">
					<span class="crimson">Recommended</span>
					<span class="jpText"><?php echo get_category_by_slug('recommended')->name;?></span>
				</h2>
				<ul class="itemList">
					<?php
						while($recommendPosts->have_posts()):
							$recommendPosts->the_post();
							usces_the_item();
					?>
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<?php
									if(usces_the_itemImageURL(0, 'return')){
										usces_the_itemImage( 0, 173, 115);
									}else{
										echo '<img src="' . get_template_directory_uri() . '/img/shop/noImg.svg" alt="' . get_the_title() . '" width="173" height="115">';
									}
									$day = get_the_time('Y-m-d');
									$day = new DateTime($day);
									$today = new DateTime();
									$interval = $today->diff($day);
									if($interval->days < 365){
										echo '<span class="newIcon">NEW</span>';
									}
								?>
							</div>
							<div class="title"><?php the_title();?></div>
							<div class="price">
							<?php while(usces_have_skus()):?>
    						<?php usces_the_firstPrice();?>
							<?php endwhile;?>
								<div class="crcode">
									<?php usces_crcode();?>
									<?php usces_guid_tax();?>
								</div>
							</div>
						</a>
					</li>
					<?php endwhile;?>
				</ul>
			</section>
			<?php
				endif;
				wp_reset_postdata();
			?>
			<section class="lineUp">
				<h2 class="onlineShopHeading">
					<span class="crimson">Line Up</span>
					<span class="jpText">商品カテゴリー</span>
				</h2>
				<ul class="lineUpList itemList">
					<?php
						$allTerms = get_terms(ITEM_CAT, ['parent' => 0]);
						foreach($allTerms as $parentCat){
							$children = get_term_children($parentCat->term_id, ITEM_CAT);
							if(!empty($children)):
					?>
					<li class="parent hasChilds">
						<h3 class="lineUpListHeading"><?php echo $parentCat->name;?></h3>
						<?php
							$childCats = get_terms(ITEM_CAT, ['parent' => $parentCat->term_id]);
							if($childCats):
						?>
						<ul class="itemList">
							<?php foreach($childCats as $childCat):?>
							<li>
								<?php
									$childCatUrl = home_url() . SEARCH_RESULT_URL . '?' . ITEM_CAT . '[]=' . $childCat->slug;
									$childCatUrl = esc_url($childCatUrl);
								?>
								<a href="<?php echo $childCatUrl;?>">
									<div class="imgBox">
										<?php
											$lineUpListImg = get_field('lineUpListImg', $childCat);
											if($lineUpListImg){
												echo '<img src="' . $lineUpListImg['sizes']['medium_large'] . '" alt="' . $lineUpListImg['alt'] . '" width="173" height="107">';
											}else{
												echo '<img src="' . get_template_directory_uri() . '/img/shop/noImg.svg" alt="' . $childCat->name . '" width="173" height="107">';
											}
										?>
									</div>
									<div class="title"><?php echo $childCat->name;?></div>
									<div class="description">
										<?php echo $childCat->description;?>
									</div>
									<?php
										$classifications = get_field('lineUpListClassification', $childCat);
										if($classifications):
									?>
									<ul class="classificationsList">
										<?php foreach($classifications as $classification):?>
										<li class="<?php echo $classification['value'];?>">
											<?php echo $classification['label'];?>
										</li>
										<?php endforeach;?>
									</ul>
									<?php endif;?>
								</a>
							</li>
							<?php endforeach;?>
						</ul>
						<?php 
							$hasChildCatsUrl = home_url() . SEARCH_RESULT_URL . '?' . ITEM_CAT . '[]=' . $parentCat->slug;
							$hasChildCatsUrl = esc_url($hasChildCatsUrl);
							$lineUpListBtn = "<a class='lineUpListBtn' href='{$hasChildCatsUrl}'>{$parentCat->name}をもっと見る</a>";
							echo $lineUpListBtn;
							endif;
						?>
					</li>
					<?php else:?>
					<li class="parent">
						<?php
							$lineUpCatUrl = home_url() . SEARCH_RESULT_URL . '?' . ITEM_CAT . '[]=' . $parentCat->slug;
							$lineUpCatUrl = esc_url($lineUpCatUrl);
						?>
						<a href="<?php echo $lineUpCatUrl;?>">
							<h3 class="lineUpListHeading"><?php echo $parentCat->name;?></h3>
							<div class="imgBox">
								<?php
									$lineUpListImg = get_field('lineUpListImg', $parentCat);
									if($lineUpListImg){
										echo '<img src="' . $lineUpListImg['sizes']['medium_large'] . '" alt="' . $lineUpListImg['alt'] . '" width="173" height="107">';
									}else{
										echo '<img src="' . get_template_directory_uri() . '/img/shop/noImg.svg" alt="' . $parentCat->name . '" width="173" height="107">';
									}
								?>
							</div>
							<div class="description"><?php echo $parentCat->description;?></div>
							<?php
								$classifications = get_field('lineUpListClassification', $parentCat);
								if($classifications):
							?>
							<ul class="classificationsList">
								<?php foreach($classifications as $classification):?>
								<li class="<?php echo $classification['value'];?>">
									<?php echo $classification['label'];?>
								</li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</a>
					</li>
					<?php
							endif;
						}
					?>
				</ul>
				<a class="itemsearchBtn" href="<?php echo SEARCH_RESULT_URL;?>">取り扱い商品一覧</a>
			</section>
		</div>
  	</section>
</main>
<?php get_footer(); ?>