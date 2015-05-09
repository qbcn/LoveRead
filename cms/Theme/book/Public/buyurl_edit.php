<?php
	$buy_chs = array();
	$buy_chs[0] = array('type'=>'wx_url', 'url'=>'');
	$buy_chs[1] = array('type'=>'tb_url', 'url'=>'');
	if ($page_id) {
		$chs = M('meta')->where("page_id='$page_id' AND meta_key='buyurl'")->getField('type,meta_value');
		if ($chs) {
			$chs_num = 0;
			foreach($chs as $type=>$url){
				$buy_chs[$chs_num] = array('type'=>$type, 'url'=>$url);
				$chs_num++;
				if ($chs_num>2){
					break;
				}
			}
		}
	}
?>
<div class="row mt-10">
	<div class="col-xs-4 col">
		<label>购买渠道</label>
	</div>
	<div class="col-xs-8 col">
		<label>购买链接</label>
	</div>
	<?php $chs_num = sizeof($buy_chs); for($i=0;$i<$chs_num;$i++): $ch=$buy_chs[$i]; ?>
	<div class="col-xs-4 col">
		<select name="goto-buy[<?php echo $i+1; ?>][ch]" class="form-control">
			<option value="wx_url" <?php if($ch['type']=="wx_url"):?>selected="selected"<?php endif; ?> >微商城</option>
			<option value="tb_url" <?php if($ch['type']=="tb_url"):?>selected="selected"<?php endif; ?> >淘宝</option>
			<option value="tm_url" <?php if($ch['type']=="tm_url"):?>selected="selected"<?php endif; ?> >天猫</option>
			<option value="az_url" <?php if($ch['type']=="az_url"):?>selected="selected"<?php endif; ?> >亚马逊</option>
		</select>
	</div>
	<div class="col-xs-8 col">
		<input name="goto-buy[<?php echo $i+1; ?>][url]" type="text" class="form-control" value="<?php echo $ch['url']; ?>" placeholder="http://">
	</div>
	<?php endfor; ?>
</div>
