<div id="media-list" class="form-group mb-20">
	<?php
		$medias_num = 0;
		if ($page_id) {
			$medias = mc_get_meta($page_id, 'media', false, 'media');
			$medias = array_reverse($medias);
			if ($medias) {
				$medias_num = sizeof($medias);
			}
		}
		if ($medias_num==0) {
			$sample = array('url'=>'','title'=>'','type'=>'mp3');
			$medias = array(json_encode($sample));
			$medias_num = 1;
		}
	?>
	<div class="row row-head">
		<div class="col-xs-6 col">
			<label>音频链接
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
	<?php for ($i=0; $i<$medias_num; $i++): $media = json_decode($medias[$i], true); ?>
	<div class="row row-media mb-10">
		<div class="col-xs-6 col">
			<div class="input-group"><input name="media-list[<?php echo $i+1; ?>][url]" type="text" class="form-control" value="<?php echo $media['url']; ?>" placeholder="http://"><span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div>
		</div>
	    <div class="col-xs-4 col">
			<input name="media-list[<?php echo $i+1; ?>][title]" type="text" class="form-control" value="<?php echo $media['title']; ?>" placeholder="标题">
		</div>
		<div class="col-xs-2 col">
			<select name="media-list[<?php echo $i+1; ?>][type]" class="form-control">
			    <option value="mp3" selected="selected">MP3</option>
			</select>
		</div>
	</div>
	<?php endfor ?>
	<script>
		var num = <?php echo $i; ?>;
		$("#media-list #add-link").click(function(){
			num++;
			var row = '<div class="row row-media mb-10">'
			row += '<div class="col-xs-6 col"><div class="input-group"><input name="media-list[' + num + '][url]" type="text" class="form-control" placeholder="http://"><span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div></div>';
			row += '<div class="col-xs-4 col"><input name="media-list[' + num + '][title]" type="text" class="form-control" placeholder="标题"></div>';
			row += '<div class="col-xs-2 col"><select name="media-list[' + num + '][type]" class="form-control"><option value="mp3" selected="selected">MP3</option></select></div>';
			$(row).appendTo("#media-list");
			return false;
		});
		$("#media-list").delegate(".input-group .input-group-addon", "click", function(){
			$(this).parents("div.row-media").remove();
		});
	</script>
</div>
