<?php
	$chs = M('meta')->where("page_id='$page_id' AND meta_key='buyurl'")->getField('type,meta_value');
	$ch_names = array('wx_url'=>'微商城', 'tb_url'=>'淘宝', 'tm_url'=>'天猫', 'az_url'=>'亚马逊');
	foreach($chs as $type=>$url):
?>
<a class="btn btn-default gotobuy <?php echo $type; ?>" target="_blank" style="display:none;" href="<?php echo $url ?>">
	<i class="glyphicon glyphicon-send"></i> 去<?php echo $ch_names[$type]; ?>购买
</a>
<script>
$(function(){
	var is_weixin= function(){
		var ua = navigator.userAgent.toLowerCase();
		if(ua.match(/MicroMessenger/i)=="micromessenger") {
			return true;
	 	} else {
			return false;
		}
	}();
	if (is_weixin){
		$('a.wx_url').show();
		$('a.az_url').show();
	} else {
		$('a.tb_url').show();
		$('a.tm_url').show();
		$('a.az_url').show();
	}
});
</script>
<?php endforeach; ?>
