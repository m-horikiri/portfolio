<?php
	/* Template Name:会社概要ページ*/
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
						笑顔をモットーに、<br>素直さと謙虚さを忘れずに。
					</h2>
					<p class="contentsText">PIAには、SEO検定資格保持者、エンジニア、デザイナー、ライターが常駐しており、「SEO対策」と「ウェブサイト制作」、「広告運用」の3本柱でWebマーケティングを全方位からサポートいたします。<br>SEO・Webマーケティングに関することなら、どんなことでもお気軽にご相談ください。</p>
					<img class="pageDetailImg" src="<?php echo THEME_URL;?>/img/company/pageDetailImg.webp" alt="笑顔をモットーに、素直さと謙虚さを忘れずに。">
				</div>
			</section>
			<section id="message" class="bgDarkGray">
				<div class="contentsWrapper">
					<h2 class="captionHeading">
						<span class="boldText">Message from the staff</span>&nbsp;｜&nbsp;スタッフからひとこと
					</h2>
					<ul class="messageList">
						<li id="h-i">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">H.Iです！</h3>
									<p class="text"><a href="https://www.zennihon-seo.org/goukakusha/inatsugi_hiroki.html" target="_blank" rel="noopener noreferrer">全日本SEO協会・SEO検定1級保持</a>。最近筋トレをはじめました！</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_h-i.webp" alt="H.Iです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">SEO検定の１級保持者として、自分の持てる知識を最大限生かして効果的な施策をご提案します。<br>ただ順位を上げるだけではなく、お客様の目標を達成できるよう最適な道を選び、一緒にゴールを目指せるよう努めていきます。</p>
							</div>
						</li>
						<li id="m-h">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">M.Hです！</h3>
									<p class="text">Google広告認定資格保持。フロントエンドエンジニア兼デザイナーです。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_m-h.webp" alt="M.Hです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">「丁寧で美しいコード」「SEOに配慮」「簡単お手入れ」な開発が得意です。新しいことにチャレンジすることが、仕事における最大の喜びです！お客様がやりたいことを出来る限り実現するよう努力しますので、ぜひ一度ご相談下さい。</p>
							</div>
						</li>
						<li id="h-m">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">H.Mです！</h3>
									<p class="text">Google広告認定資格保持。セールスデザインが得意なデザイナーです。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_h-m.webp" alt="H.Mです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">LPなどのWEBデザインだけでなく、パンフレットなどのデザインも得意です。PIAは個性豊かな会社なので、いろんなアイデアをお出しできると思います。SEO対策だけでなく、WEBマーケティング・セールスデザインについてもぜひご相談ください！</p>
							</div>
						</li>
						<li id="m-t">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">M.Tです！</h3>
									<p class="text">Webディレクター兼ライターです。得意な分野は「医療系」です。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_m-t.webp" alt="M.Tです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">医療系記事のライター兼編集の経験があります。ウェブマーケティング企画・戦略もPIAにお任せください。<br>長くお付き合いいただけるように精一杯サポートさせていただきます。オンラインミーティングのお申し込みをお待ちしております！</p>
							</div>
						</li>
						<li id="j-s">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">J.Sです！</h3>
									<p class="text">不動産関係、YMYL系の記事が得意なライター兼カメラマンです。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_j-s.webp" alt="J.Sです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">ウェブ広告や動画を使用した広告も撮影から運用までワンストップで実施できます。<br>ウェブ広告や動画制作に興味がある方、検討している方、乗り換えをお考えの方、ぜひ一度PIAにお声掛けいただければと思います。</p>
							</div>
						</li>
						<li id="s-o">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">S.Oです！</h3>
									<p class="text">ウェブコンサルタントとして、日々多くのお客様とお話ししています。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_s-o.webp" alt="S.Oです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">ウェブの知識がない、SEO対策は外部に任せっきりで何もわからない、そんな方にわかりやすい説明を徹底しています。<br>お任せいただいたサイトごとに必要なアプローチを考え、日々ご提案をしていますので、しゃべりは得意です（笑）。サイトへの集客のことなら何でもご相談ください。</p>
							</div>
						</li>
						<li id="h-h">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">H.Hです！</h3>
									<p class="text">エンジニア兼ウェブプログラマーです。システム開発もご相談ください！</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_h-h.webp" alt="H.Hです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">最新のSEO知識とIT技術を駆使して、お客様のサイトが安定して上位化するようにサポートします。サイトのお悩みもなんでもご相談ください。<br>チーム体制で施策を行いますので、デザインもコーディングもライティングも全てまるっとお任せください！</p>
							</div>
						</li>
						<li id="k-k">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">K.Kです！</h3>
									<p class="text">競合サイト調査とキーワード選定が得意です。検索好き。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_k-k.webp" alt="K.Kです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">低コストで集客する一番の方法は、良質なコンテンツを上位表示して自然検索での流入を増やすことです。<br>1,000人集客しても1万人集客しても、広告費用はかかりませんので、どんどん集客いたしましょう！<br>ぜひ私たちにサポートさせてください！</p>
							</div>
						</li>
						<li id="t-i">
							<div class="flexWrap">
								<div class="textBox">
									<h3 class="middleHeading">T.Iです！</h3>
									<p class="text">検索エンジン集客やコンテンツSEOが得意です。</p>
								</div>
								<div class="imgBox">
									<img src="<?php echo THEME_URL;?>/img/company/messageList_t-i.webp" alt="T.Iです！" width="100" height="100">
								</div>
							</div>
							<div class="commentBox">
								<h3 class="middleHeading">ひとこと</h3>
								<p class="text">お客様からの「順位が上がったよ！ありがとう！」が、元気の源です！ <br>いまのSEOは小手先の技術で上位表示はできません。変化に対応しながら、SEOに強い良質なコンテンツを作成します。どうぞ私たちにお任せください！</p>
							</div>
						</li>
					</ul>
				</div>
			</section>
			<section id="aboutUs" class="contentsWrapper">
				<h2 class="captionHeading">
					<span class="boldText">Company overview</span>&nbsp;｜&nbsp;会社概要
				</h2>
				<div class="flexWrap">
					<dl class="aboutUsDl">
						<dt>社名</dt>
						<dd>株式会社 PIA<br class="spView">（ピー・アイ・エー）</dd>
						<dt>代表者</dt>
						<dd>平岡 春彦</dd>
						<dt>資本金</dt>
						<dd>1000万円</dd>
						<dt>所在地</dt>
						<dd>〒160-0023<br>東京都新宿区西新宿4-3-13<br>西新宿三関ビル4F</dd>
						<dt>TEL</dt>
						<dd>03-5302-0055<br class="spView">（平日9:00〜18:00）</dd>
					</dl>
					<dl class="aboutUsDl">
						<dt>事業目的</dt>
						<dd>
							<ul class="objectivesList">
								<li class="noticeText">1. コンピュータ、事務用機器の販売、設置工事、保守管理</li>
								<li class="noticeText">2. WEBサイトの企画、製作保守</li>
								<li class="noticeText">3. 企業の販売促進の企画立案、実施理</li>
								<li class="noticeText">4. 経営コンサルティング業</li>
								<li class="noticeText">5. 各種市場調査の企画、立案、実施</li>
								<li class="noticeText">6. コンピュータソフトウェアの開発、販売</li>
								<li class="noticeText">7. コンピュータネットワークの構築、運用</li>
								<li class="noticeText">8. インターネットにおける接続仲介業務</li>
								<li class="noticeText">9. 前各号に附帯する一切の業務</li>
							</ul>
						</dd>
					</dl>
				</div>
			</section>
		</main>
	</div>
<?php get_footer();?>
