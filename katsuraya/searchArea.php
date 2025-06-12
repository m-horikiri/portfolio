<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/repair.css?v=<?php echo date('His');?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/onlineShop.css?v=<?php echo date('His');?>">
<script src="<?php echo get_template_directory_uri();?>/js/searchArea.js?v=<?php echo date('His');?>"></script>

<div id="searchArea">
	<div class="searchAreaheadingBox">
		こだわり検索
		<div class="closeBtn spView">
			<img src="<?php echo get_template_directory_uri();?>/img/shop/close.svg" alt="閉じる" width="30" height="30">
		</div>
	</div>
	<form action="<?php echo SEARCH_RESULT_URL;?>" method="get">
		<div class="searchBoxWrap">
			<div class="searchBox textsearch">
				<input type="text" name="s" id='s' class="searchText" value="<?php get_search_query();?>">
				<input type="submit" value="検索">
			</div>
			<?php
				foreach($searchCatArgs as $searchCat):
			?>
			<div class="searchBox <?php echo $searchCat['cat'];?>">
				<div class="searchBoxTitle"><?php echo $searchCat['title'];?></div>
				<ul class="searchBoxList">
					<?php
						$searchTerms = get_terms($searchCat['cat'], ['parent' => 0]);
						foreach($searchTerms as $term):
					?>
					<li class="parent">
						<label>
							<?php
								$parentInput = "<input type='checkbox' name='{$searchCat['cat']}[]' value='{$term->slug}'";
								if($searchCat['cat'] == 'color_cat'){
									$bgColor = get_field('searchBoxColor', $term);
									$grdFlag = get_field('gradationFlag', $term);
									if($grdFlag){
										$grdColor = get_field('gradationColor', $term);
										$parentInput .= " style='background: linear-gradient(45deg, {$bgColor} 0%, {$grdColor} 50%, {$bgColor} 100%)'";
									}else{
										$parentInput .= " style='background-color: {$bgColor}'";
									}
								}
								if(!empty($itemParm[$searchCat['cat']]) && in_array($term->slug, $itemParm[$searchCat['cat']])){
									$parentInput .= ' checked';
								}
								$parentInput .= '>';
								echo $parentInput;
								echo $term->name;
							?>
						</label>
						<?php
							$childTerms = get_terms($searchCat['cat'], ['parent' => $term->term_id]);
							if($childTerms):
						?>
						<ul class="childList">
							<?php foreach($childTerms as $childTerm):?>
							<li>
								<label>
									<?php
										$childInput = "<input type='checkbox' name='{$searchCat['cat']}_child[]' value='{$childTerm->slug}'";
										if(!empty($itemParm[$searchCat['cat'] . '_child']) && in_array($childTerm->slug, $itemParm[$searchCat['cat'] . '_child'])){
											$childInput .= ' checked';
										}
										$childInput .= '>';
										echo $childInput;
										echo $childTerm->name;
									?>
								</label>
							</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<?php endforeach;?>
		</div>
		<div class="btnWrap">
			<input type="reset" value="リセット">
			<input type="submit" value="選ぶ">
		</div>
	</form>
</div>