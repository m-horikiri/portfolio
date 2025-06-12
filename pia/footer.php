	<footer class="commonFooter">
		<div class="contentsWrapper">
			<div class="footerMenuBox">
				<a class="logo" href="<?php echo home_url()?>">
					<img class="logoImg" src="<?php echo THEME_URL;?>/img/common/logoWhite.svg" alt="PIA" width="85" height="50">
				</a>
				<div class="company">株式会社 PIA（ピー・アイ・エー）<br>〒160-0023 東京都新宿区西新宿4-3-13-4F</div>
			</div>
			<?php menuListOutput(true);?>
			<ul class="footerCtaList">
				<li>
					<a class="commonBtn" href="/contact/">お問い合わせ</a>
				</li>
				<li>
					<a class="commonBtn" href="/consultation/">無料オンライン相談</a>
				</li>
			</ul>
		</div>
		<div class="copy">Copyright © <?php echo date('Y') ?> PIA Co., Ltd. All rights reserved.</div>
	</footer>
	<ul id="spCtaList" class="spView">
		<li>
			<a class="contact" href="/contact/">お問い合わせ</a>
		</li>
		<li>
			<a class="consultation" href="/consultation/">無料オンライン相談</a>
		</li>
	</ul>
</body>
<?php wp_footer();?>
</html>
