<?php get_header();?>
	<main id="shopArchive" class="contentsWrapper">
		<?php myBreadcrumbs();?>
		<section>
			<h2 class="largeHeading">Shop<span class="jpText">店舗一覧</span></h2>
			<?php if(have_posts()):?>
			<section>
				<h3 class="middleHeading">グループ会社 店舗一覧</h3>
				<ul class="shopList">
					<?php
						while(have_posts()):
							the_post();
					?>
					<li>
						<h4 class="shopListTitle"><?php the_title();?></h4>
						<dl class="twoColumnDl">
							<dt>住所</dt>
							<dd><?php echo nl2br(shopFieldEscape(get_field('address')));?></dd>
							<dt>TEL</dt>
							<dd><a href="tel:<?php the_field('phoneNumber');?>"><?php the_field('phoneNumber');?></a></dd>
							<dt>営業時間</dt>
							<dd><?php echo nl2br(shopFieldEscape(get_field('businessHours')));?></dd>
							<dt>お支払い方法</dt>
							<dd><?php echo nl2br(shopFieldEscape(get_field('paymentMethods')));?></dd>
							<dt>その他</dt>
							<dd><?php echo nl2br(shopFieldEscape(get_field('others')));?></dd>
						</dl>
					</li>
					<?php endwhile;?>
				</ul>
				<?php pagenation();?>
			</section>
			<?php endif;?>
		</section>
	</main>
<?php get_footer();?>
