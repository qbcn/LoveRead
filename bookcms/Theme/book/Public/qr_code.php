<div class="text-center mb-10" id="qrcode-wx">
	<img src="<?php echo C('APP_ASSETS_URL'); ?>/img/qbwx_qr.jpg"/><br/>
	<label id="qrcode-text-tap" style="display:none;">长按二维码↑↑↑关注&quot;奇宝书屋&quot; 更多精彩分享等你来</label>
	<label id="qrcode-text-sao" style="display:none;">微信扫一扫关注&quot;奇宝书屋&quot; 更多精彩分享等你来</label>
</div>
<script>
$(function(){
	if (is_weixin){
		$("#qrcode-text-tap").show();
	} else {
		$("#qrcode-text-sao").show();
	}
});
</script>