<div id="pro-links" class="form-group mb-20">
	<?php
		$links_num = 0;
		if ($page_id) {
			$links = M('meta')->where("page_id='$page_id' AND meta_key='link'")->getField('meta_value',true);
			if ($links) {
				$links_num = sizeof($links);
			}
		}
		if ($links_num==0) {
			$sample = array('url'=>'','title'=>'','type'=>'play');
			$links = array(json_encode($sample));
			$links_num = 1;
		}
	?>
	<div class="row row-head">
		<div class="col-xs-6 col">
			<label>相关链接
				<a id="add-link" href="javacript:;" class="ml-10"><i class="glyphicon glyphicon-plus"></i></a>
			</label>
		</div>
	    <div class="col-xs-4 col">
			<label>标题</label>
		</div>
		<div class="col-xs-2 col">
			<label>类型</label>
		</div>
	</div>
	<?php for ($i=0; $i<$links_num; $i++): $link = json_decode($links[$i], true); ?>
	<div class="row row-link mb-10">
		<div class="col-xs-6 col">
			<div class="input-group"><input name="pro-links[<?php echo $i+1; ?>][url]" type="text" class="form-control" value="<?php echo $link['url']; ?>" placeholder="http://"><span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div>
		</div>
	    <div class="col-xs-4 col">
			<input name="pro-links[<?php echo $i+1; ?>][title]" type="text" class="form-control" value="<?php echo $link['title']; ?>" placeholder="标题">
		</div>
		<div class="col-xs-2 col">
			<select name="pro-links[<?php echo $i+1; ?>][type]" class="form-control">
			    <option value="play" <?php if($link['type']=='play'): ?>selected="selected"<?php endif ?> >播放链接</option>
			    <option value="page" <?php if($link['type']=='page'): ?>selected="selected"<?php endif ?> >文章链接</option>
			    <option value="buy" <?php if($link['type']=='buy'): ?>selected="selected"<?php endif ?> >购买链接</option>
			</select>
		</div>
	</div>
	<?php endfor ?>
	<script>
		var num = <?php echo $i; ?>;
		$("#pro-links #add-link").click(function(){
			num++;
			var row = '<div class="row row-link mb-10">'
			row += '<div class="col-xs-6 col"><div class="input-group"><input name="pro-links[' + num + '][url]" type="text" class="form-control" placeholder="http://"><span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div></div>';
			row += '<div class="col-xs-4 col"><input name="pro-links[' + num + '][title]" type="text" class="form-control" placeholder="标题"></div>';
			row += '<div class="col-xs-2 col"><select name="pro-links[' + num + '][type]" class="form-control"><option value="play" selected="selected">播放链接</option><option value="page">文章链接</option><option value="buy">购买链接</option></select></div>';
			$(row).appendTo("#pro-links");
			return false;
		});
		$("#pro-links").delegate(".input-group .input-group-addon", "click", function(){
			$(this).parents("div.row-link").remove();
		});
	</script>
</div>
