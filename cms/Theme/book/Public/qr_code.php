<div class="text-center mb-10" id="touch-qr-code" style="display:none;">
	<img src="<?php echo $site_url; ?>/Theme/default/img/qbwx_qr.jpg"/><br/>
	<label>长按二维码↑↑↑关注&quot;奇宝书屋&quot; 更多精彩分享等你来</label>
</div>
<script>
	var is_weixin= function{
		var ua = navigator.userAgent.toLowerCase();
		if(ua.match(/MicroMessenger/i)=="micromessenger") {
			return true;
	 	} else {
			return false;
		}
	}();
	if (is_weixin){
		$("#touch-qr-code").show();
	}
</script>