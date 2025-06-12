<?php
	/* Template Name:サービスページ*/
	get_header();
?>
	<div id="topView">
		<h1 class="topViewHeading"><?php the_title();?></h1>
	</div>
	<div id="mainWrap" class="noSidebar">
		<main id="page">
			<div class="contentsWrapper">
				<?php myBreadcrumbs();?>
			</div>
			<section class="pageDetailSection">
				<div class="contentsWrapper">
					<h2 class="bigTextHeading">
						高品質なSEO対策を<br>ワンストップで。
					</h2>
					<p class="contentsText">PIAでは、日々進化し続けるGoogleの検索エンジンや、Webマーケティングのトレンドを研究し、様々な情報をチームで共有しています。<br>最新のSEO技術を取り入れたWebサイト制作や各種SEO施策で、お客様のサイトや、サイトを訪れるユーザーの目的に合わせた理想の検索体験をご提供します。</p>
					<img class="pageDetailImg" src="<?php echo THEME_URL;?>/img/service/pageDetailImg.webp" alt="高品質なSEO対策をワンストップで。">
				</div>
			</section>
			<section id="seo" class="bgDarkGray">
				<div class="contentsWrapper">
					<h2 class="captionHeading">
						<span class="boldText">SEO Consulting</span>&nbsp;｜&nbsp;SEO対策
					</h2>
					<ul class="serviceList">
						<li id="internal">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_internal.svg" alt="SEO内部施策">
							<div class="textBox">
								<h3 class="serviceListHeading">SEO内部施策</h3>
								<p class="text">Googleの検索エンジンガイドラインに沿って最適化を行います。</p>
							</div>
							<div class="price">
								税込<span class="bigText">55,000</span>円〜／月額
							</div>
						</li>
						<li id="contentsSeo">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_contentsSeo.svg" alt="コンテンツSEO">
							<div class="textBox">
								<h3 class="serviceListHeading">コンテンツSEO</h3>
								<p class="text">リード・コンバージョンが獲得できるページに改善します。</p>
								<p class="noticeText">※料金は上位化したいキーワードの難易度や文字数で変動します。</p>
							</div>
							<div class="price">
								税込<span class="bigText">33,000</span>円〜／1ページ
							</div>
						</li>
						<li id="external">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_external.svg" alt="SEO外部施策">
							<div class="textBox">
								<h3 class="serviceListHeading">SEO外部施策</h3>
								<p class="text">関連性の高い他のサイトから貴社のサイトへのリンクを集める施策です。</p>
							</div>
							<div class="price">
								税込<span class="bigText">55,000</span>円〜／1リンク
							</div>
						</li>
						<li id="articleWriting">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_articleWriting.svg" alt="メディア記事作成">
							<div class="textBox">
								<h3 class="serviceListHeading">メディア記事作成</h3>
								<p class="text">SEOに特化したオウンドメディアに最適な記事を専任のライターが作成します。</p>
							</div>
							<div class="price">
								税込<span class="bigText">33,000</span>円〜／1記事
							</div>
						</li>
					</ul>
				</div>
			</section>
			<section id="website" class="bgDarkGray">
				<div class="contentsWrapper">
					<h2 class="captionHeading">
						<span class="boldText">Website design and development</span>&nbsp;｜&nbsp;Web制作・オウンドメディア構築
					</h2>
					<ul class="serviceList">
						<li id="ownedMedia">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_ownedMedia.svg" alt="オウンドメディア構築">
							<div class="textBox">
								<h3 class="serviceListHeading">オウンドメディア構築</h3>
								<p class="text">メディアの立ち上げから記事作成までをワンストップでサポートします。</p>
								<p class="noticeText">※WordPressでの構築です。</p>
							</div>
							<div class="price">
								税込<span class="bigText">330,000</span>円〜
							</div>
						</li>
						<li id="siteCreation">
							<img class="serviceListImg" src="<?php echo THEME_URL;?>/img/service/service_siteCreation.svg" alt="ウェブサイト・LP制作">
							<div class="textBox">
								<h3 class="serviceListHeading">ウェブサイト・LP制作</h3>
								<p class="text">SEOに強い良質なコンテンツを見やすいデザインで構成します。<br>LP制作もお任せください。</p>
							</div>
							<div class="price">
								税込<span class="bigText">330,000</span>円〜
							</div>
						</li>
					</ul>
				</div>
			</section>
			<section id="advertising" class="bgDarkGray">
				<div class="contentsWrapper">
					<h2 class="captionHeading">
						<span class="boldText">Advertising management</span>&nbsp;｜&nbsp;Web広告運用代行
					</h2>
					<a class="commonBtn" href="/consultation/">お問い合わせください</a>
				</div>
			</section>
		</main>
	</div>
<?php get_footer();?>
