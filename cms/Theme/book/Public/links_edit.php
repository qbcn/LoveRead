		<div id="pro-links" class="form-group mb-20">
			<?php
				$links = mc_get_meta($page_id,'link', false);
				if ($links) {
					$first = json_decode($links[0], true);
					$links_num = sizeof($links);
				} else {
					$first = array('url'=>'', 'title'=>'', 'type'=>'audio');
					$links_num = 0;
				}
			?>
			<div class="row">
				<div class="col-xs-6 col">
					<label>相关链接
						<a id="add-link" href="javacript:;" class="ml-10"><i class="glyphicon glyphicon-plus"></i></a>
						<a id="remove-link" href="javacript:;" class="ml-10"><i class="glyphicon glyphicon-minus"></i></a>
					</label>
					<input name="pro-links[1][url]" type="text" class="form-control" value="<?php echo $first['url']; ?>" placeholder="http://">
				</div>
			    <div class="col-xs-4 col">
					<label>标题</label>
					<input name="pro-links[1][title]" type="text" class="form-control" value="<?php echo $first['title']; ?>" placeholder="标题">
				</div>
				<div class="col-xs-2 col">
					<label>类型</label>
					<select name="pro-links[1][type]" class="form-control">
						<?php if($first['type']=='audio'): ?>
					    <option value="audio" selected="selected">音频</option>
					    <option value="article">文章</option>
					    <?php else: ?>
					    <option value="audio">音频</option>
					    <option value="article" selected="selected">文章</option>
					    <?php endif ?>
					</select>
				</div>
			</div>
			<?php for ($i=1; $i<$links_num; $i++): $link = json_decode($links[$i], true); ?>
			<div class="row more mt-10">
				<div class="col-xs-6 col">
					<input name="pro-links[<?php echo $i+1; ?>][url]" type="text" class="form-control" value="<?php echo $link['url']; ?>" placeholder="http://">
				</div>
			    <div class="col-xs-4 col">
					<input name="pro-links[<?php echo $i+1; ?>][title]" type="text" class="form-control" value="<?php echo $link['title']; ?>" placeholder="标题">
				</div>
				<div class="col-xs-2 col">
					<select name="pro-links[<?php echo $i+1; ?>][type]" class="form-control">
						<?php if($link['type']=='audio'): ?>
					    <option value="audio" selected="selected">音频</option>
					    <option value="article">文章</option>
					    <?php else: ?>
					    <option value="audio">音频</option>
					    <option value="article" selected="selected">文章</option>
					    <?php endif ?>
					</select>
				</div>
			</div>
			<?php endfor ?>
			<script>
				var num = <?php echo $i; ?>;
				$("#add-link").click(function(){
					num++;
					var row = '<div class="row more mt-10">'
					row += '<div class="col-xs-6 col"><input name="pro-links[' + num + '][url]" type="text" class="form-control" placeholder="http://"></div>';
					row += '<div class="col-xs-4 col"><input name="pro-links[' + num + '][title]" type="text" class="form-control" placeholder="标题"></div>';
					row += '<div class="col-xs-2 col"><select name="pro-links[' + num + '][type]" class="form-control"><option value="audio" selected="selected">音频</option><option value="article">文章</option></select></div>';
					$(row).appendTo("#pro-links");
					return false;
				});
				$("#remove-link").click(function(){
					$("#pro-links .more:last").remove();
					if (num > 1) {num--;}
				});
			</script>
		</div>
