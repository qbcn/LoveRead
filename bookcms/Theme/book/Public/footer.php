<footer class="page-footer" style="display:none">
	<p>
		<img src="<?php $site_logo=mc_option('logo');if($site_logo) echo $site_logo; else echo C('APP_ASSETS_URL').'/img/logo-s.png'; ?>">
	</p>
	© 2014-2015 Qibaowu.cn 版权所有 | 鄂ICP备14017534
</footer>
<div data-role="widget" data-widget="nav4" class="nav4" style="display:none">
	<nav>
		<div id="nav4_ul" class="nav_4">
			<ul class="box">
				<li>
					<a href="http://wap.koudaitong.com/v2/showcase/homepage?kdt_id=34321"><span>奇宝书屋</span></a>
				</li>
				<li>
					<a href="javascript:;"><span>爱读书</span></a>
					<dl>
						<dd>
							<a href="http://www.qibaowu.cn/article-index-term-id-29.html"><span>有声分享</span></a>
						</dd>
						<dd>
							<a href="http://www.qibaowu.cn/article-index-term-id-30.html"><span>读书分享</span></a>
						</dd>
						<dd>
							<a href="http://www.qibaowu.cn/pro-index-index.html"><span>儿童书库</span></a>
						</dd>
					</dl>
				</li>
				<li>
					<a href="http://wap.koudaitong.com/v2/usercenter/7tn9omrb" ><span>会员中心</span></a>
				</li>
			</ul>
		</div>
	</nav>
	<div id="nav4_masklayer" class="masklayer_div">&nbsp;</div>
</div>
<a id="backtotop" class="goto" href="#site-top"><i class="glyphicon glyphicon-upload"></i></a>
</body>
<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/css/menu.css">
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/headroom.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/placeholder.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/v02/cat.js"></script>
<script>
(function() {
    var header = new Headroom(document.querySelector("#topnav"), {
        tolerance: 5,
        offset : 205,
        classes: {
          initial: "animated",
          pinned: "slideDown",
          unpinned: "slideUp"
        }
    });
    header.init();
}());
$(function(){
	$('input, textarea').placeholder();
	nav4.bindClick(document.getElementById("nav4_ul").querySelectorAll("li>a"), document.getElementById("nav4_masklayer"));
	var isMobile = "ontouchstart" in window;
	if(is_weixin){
		$("div.nav4").show();
	}else{
		$("footer.page-footer").show();
	}
});
</script>
<?php $diag=$_GET['diag'];if($diag): ?>
<script src="/assets/js/<?php echo $diag; ?>"></script>
<?php endif; ?>
<?php echo mc_shoucang_js(); ?>
<?php echo mc_guanzhu_js(); ?>
</html>