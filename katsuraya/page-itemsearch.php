<?php
/* Template Name:オンラインショップ検索結果 */
get_header();
$searchText = get_query_var('s');
$narrowdown = [];
$itemParm = [];
foreach($searchCatArgs as $getQueryVar){
	${$getQueryVar['cat']} = get_query_var($getQueryVar['cat']);
	if(!empty(${$getQueryVar['cat']})){
		$itemParm[$getQueryVar['cat']] = ${$getQueryVar['cat']};
		$child = $getQueryVar['cat'] . '_child';
		if(!empty(get_query_var($child))){
			$itemParm[$child] = get_query_var($child);
			${$getQueryVar['cat']} = get_query_var($child);
		}
		$narrowdown[$getQueryVar['cat']] = ${$getQueryVar['cat']};
	}
}
$taxQuery = ['relation' => 'AND'];
if($narrowdown){
	foreach($narrowdown as $key => $val){
		$taxQuery[] = [
			'taxonomy' => $key,
			'field' => 'slug',
			'operator' => 'IN',
			'terms' => $val
		];
	}
}
?>
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
				<li><a href="/onlineshop/">オンラインショップ</a></li>
				<li>
					<?php if(empty($searchText) && empty($narrowdown)):?>
					全商品一覧
					<?php else:?>
					検索結果
					<?php endif;?>
				</li>
			</ul>
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$itemArgs = [
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 40,
					'orderby' => 'date',
					'order' => 'DESC',
					'paged' => $paged,
					's' => $searchText,
					'tax_query' => $taxQuery
				];
				$onlineShopItems = new WP_Query($itemArgs);
			?>
			<section class="productList">
				<h2 class="onlineShopHeading">
					<span class="crimson">Product List</span>
					<span class="jpText">取り扱い商品一覧</span>
				</h2>
				<?php if($onlineShopItems->have_posts()):?>
				<div class="pagerWrap">
					<div class="quantity">
						<?php if(!empty($searchText) || !empty($narrowdown)):?>
						検索結果：
						<?php endif;?>
						全<?php echo $onlineShopItems->found_posts?>件
					</div>
					<?php
						if($onlineShopItems->max_num_pages > 1){
							$big = 999999999;
							$pagerArgs = [
								'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
								'format' => 'page/%#%/',
								'current' => $paged,
								'total' => $onlineShopItems->max_num_pages,
								'prev_text' => '<',
								'next_text' => '>',
								'mid_size' => 1,
								'type' => 'list'
							];
							echo paginate_links($pagerArgs);
						}
					?>
				</div>
				<ul class="itemList">
					<?php
						while($onlineShopItems->have_posts()):
							$onlineShopItems->the_post();
							usces_the_item();
					?>
					<li>
						<a href="<?php the_permalink();?>">
							<div class="imgBox">
								<?php
									if(usces_the_itemImageURL(0, 'return')){
										usces_the_itemImage( 0, 173, 115);
									}else{
										echo '<img src="' . get_template_directory_uri() . '/img/shop/noImg.svg" alt="' . get_the_title() . '" width="173" height="107">';
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
								<?php usces_the_itemPrice();?>
								<?php endwhile; ?>
								<div class="crcode">
									<?php usces_crcode();?>
									<?php usces_guid_tax();?>
								</div>
							</div>
						</a>
					</li>
					<?php endwhile;?>
				</ul>
				<?php
					if($onlineShopItems->max_num_pages > 1){
						echo paginate_links($pagerArgs);
					}
				?>
				<?php else:?>
				<div class="notfound">
					<div class="quantity">検索結果：0件</div>
					<div class="notfoundText">
						該当する商品が見つかりませんでした。<br>
						お手数ですが条件を変更して<br class="spView">再度お試しください。
					</div>
					<div class="searchBtnSp spView">
						商品を探す
						<div class="imgBox">
							<img src="<?php echo get_template_directory_uri();?>/img/shop/search.svg" alt="商品を探す" width="20" height="20">
						</div>
					</div>
				</div>
				<?
					endif;
					wp_reset_postdata();
				?>
			</section>
		</div>
  	</section>
</main>
<?php get_footer(); ?>