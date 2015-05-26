<footer>
	<p>
		<img src="<?php $site_logo=mc_option('logo');if($site_logo) echo $site_logo; else echo C('APP_ASSETS_URL').'/img/logo-s.png'; ?>">
	</p>
	© 2014-2015 Qibaowu.cn 版权所有 | 鄂ICP备14017534
</footer>
<a id="backtotop" class="goto" href="#site-top"><i class="glyphicon glyphicon-upload"></i></a>
</body>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/bootstrap.min.js"></script>
<?php if(mc_option('homehdys')==2 && MODULE_NAME=='Home') : ?>
<?php else : ?>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/headroom.min.js"></script>
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
</script>
<?php endif; ?>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/placeholder.js"></script>
<script type="text/javascript">
	$(function() {
		$('input, textarea').placeholder();
	});
</script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/cat.js"></script>
<?php echo mc_xihuan_js(); ?>
<?php echo mc_shoucang_js(); ?>
<?php echo mc_guanzhu_js(); ?>
</html>