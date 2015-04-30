		<div id="pro-links" class="form-group mb-20">
			<div class="row">
				<div class="col-xs-6 col">
					<label>相关链接
						<a id="add-link" href="javacript:;" class="ml-10"><i class="glyphicon glyphicon-plus"></i></a>
						<a id="remove-link" href="javacript:;" class="ml-10"><i class="glyphicon glyphicon-minus"></i></a>
					</label>
					<input name="pro-links[1][url]" type="text" class="form-control" placeholder="http://">
				</div>
			    <div class="col-xs-4 col">
					<label>标题</label>
					<input name="pro-links[1][title]" type="text" class="form-control" placeholder="标题">
				</div>
				<div class="col-xs-2 col">
					<label>类型</label>
					<select name="pro-links[1][type]" class="form-control">
					    <option value="play" selected="selected">播放</option>
					    <option value="article">文章</option>
					    <option value="buy">购买</option>
					</select>
				</div>
			</div>
			<script>
				var num = 1;
				$("#add-link").click(function(){
					num++;
					var row = '<div class="row more mt-10">'
					row += '<div class="col-xs-6 col"><input name="pro-links[' + num + '][url]" type="text" class="form-control" placeholder="http://"></div>';
					row += '<div class="col-xs-4 col"><input name="pro-links[' + num + '][title]" type="text" class="form-control" placeholder="标题"></div>';
					row += '<div class="col-xs-2 col"><select name="pro-links[' + num + '][type]" class="form-control"><option value="play" selected="selected">播放</option><option value="article">文章</option><option value="buy">购买</option></select></div>';
					$(row).appendTo("#pro-links");
					return false;
				});
				$("#remove-link").click(function(){
					$("#pro-links .more:last").remove();
					if (num > 1) {num--;}
				});
			</script>
		</div>
