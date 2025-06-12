		<aside class="shopSideWrap sub-section sub-section--col--two">
			<div class="cartViewBtn">
				<a href="<?php echo esc_url( USCES_CART_URL ); ?>">
					<i class="fa fa-shopping-cart"></i>
					<span class="cartText">カートの中を見る</span>
					<?php if ( ! defined( 'WCEX_WIDGET_CART' ) ) : ?>
					<span class="total"><?php usces_totalquantity_in_cart(); ?></span>
					<?php endif; ?>
				</a>
			</div>
			<h2 class="shopLargeHeading">商品一覧</h2>
			<ul class="shopSideList">
				<?php
				$args = [
					'post_type' => 'post',
					'orderby' => 'date',
					'order' => 'ASC',
					'posts_per_page' => -1
				];
				$query = new WP_Query($args);
				if($query->have_posts()){
					while($query->have_posts()){
						$query->the_post();
						$query->usces_the_item();
						if(usces_is_item()){
				?>
				<li>
					<h3 class="shopMiddleHeading">
						<a href="<?php the_permalink(); ?>">
							<?php usces_the_itemName(); ?>
							<i class="fa-solid fa-chevron-right"></i>
						</a>
					</h3>
				</li>
				<?php
						}
					}
				};
				wp_reset_postdata();
				?>
			</ul>
			<?php
			function widgetCalendar($html) {
				$html = '<div class="closeDayColor">休業日</div>';
				return $html;
			}
			add_filter('usces_filter_widget_calendar',  'widgetCalendar', 11);
			$args = [
				'before_widget' => '<div class="calendar">',
				'after_widget' => '</div>',
				'before_title' => '<h2 class="shopLargeHeading">',
				'after_title' => '</h2>'
			];
			$welcartCalendar = [
				'title' => '営業日'
			];
			the_widget('Welcart_calendar', $welcartCalendar, $args);
			?>
		</aside>
