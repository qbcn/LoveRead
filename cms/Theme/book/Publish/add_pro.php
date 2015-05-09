<?php mc_template_part('header_admin'); ?>
<style>
#single-top {padding-top:0;}
#pro-index-tr .row.pro-parameter .col-xs-6 {margin-top:10px;}
#pro-index-trin .form-group {padding-top:10px;}
#pro-single {padding:0;}
</style>
	<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote.css">
	<script src="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote.min.js"></script>
	<script src="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote-zh-CN.js"></script>
	<form role="form" method="post" action="<?php echo U('custom/perform/publish_pro'); ?>" onsubmit="return postForm()">
	<div id="single-top">
		<div class="container-admin">
			<div class="row">
				<div class="col-sm-6" id="pro-index-tl">
					<div id="pro-index-tlin">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<script>
							function readFile(obj,id){ 
						        var file = obj.files[0]; 	
						        //判断类型是不是图片
						        if(!/image\/\w+/.test(file.type)){   
						                alert("请确保文件为图像类型"); 
						                return false; 
						        } 
						        var reader = new FileReader(); 
						        reader.readAsDataURL(file); 
						        reader.onload = function(e){ 
						        	//alert(this.result);
						            $('.item').removeClass('active');
									$('<div class="item active"><div class="imgshow"><img src="'+this.result+'"></div><input type="hidden" name="fmimg[]" value="'+this.result+'"></div>').prependTo('#pub-imgadd');
									var index = $('.carousel-indicators li').last().index()*1+1;
									$('<li data-target="#carousel-example-generic" data-slide-to="'+index+'"></li>').appendTo('.carousel-indicators');
						        } 
							} 
						</script>
						<ol class="carousel-indicators" id="publish-carousel-indicators"><li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li></ol>
						<div class="carousel-inner" id="pub-imgadd">
							<div class="item active">
								<div class="imgshow"><img src="<?php echo C('APP_ASSETS_URL'); ?>/img/upload.jpg"></div>
								<input type="file" id="picfile" onchange="readFile(this,1)" />
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class="col-sm-6" id="pro-index-tr">
					<div id="pro-index-trin">
					<h1>
						<textarea name="title" class="form-control" placeholder="请填写图书标题"></textarea>
					</h1>
					<div class="row">
						<div class="col-xs-6 col">
							<label>ISBN <span style="color:#ff4a00">*</span></label>
							<input name="isbn" type="text" class="form-control" placeholder="10位或13位数字">
						</div>
						<div class="col-xs-6 col">
							<label>定价</label>
							<div class="input-group">
								<input name="price" type="text" class="form-control" placeholder="0.00">
								<span class="input-group-addon">元</span>
							</div>
						</div>
						<div class="col-xs-6 col hidden">
							<label>库存</label>
							<input name="kucun" type="text" class="form-control" placeholder="0">
						</div>
					</div>
					<div class="row pro-parameter">
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
						<div class="col-xs-6">
							<label><?php echo $par['meta_value']; ?></label>
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]" type="text" class="form-control" placeholder="参数">
						</div>
					<?php endforeach; endif; ?>
					</div>
					<?php echo W("Buyurl/edit"); ?>
					<div class="form-group">
						<label>选择分类</label>
						<select multiple class="form-control" name="term">
							<?php $terms = M('page')->where('type="term_pro"')->order('id desc')->select(); ?>
							<?php foreach($terms as $val) : ?>
							<option value="<?php echo $val['id']; ?>">
								<?php echo $val['title']; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-admin" id="pro-single">
		<?php echo W("Links/edit"); ?>
		<div class="row">
			<div class="col-sm-12" id="single">
				<div id="entry">
					<div class="form-group">
						<textarea name="content" class="form-control" rows="3" id="summernote">在这里添加图书的简要描述</textarea>
					</div>
				</div>
				<div class="form-group">
					<input name="keywords" type="text" class="form-control" placeholder="关键词（Keywords），多个关键词以英文半角逗号隔开（选填）">
				</div>
				<div class="form-group">
					<textarea name="description" class="form-control" rows="3" placeholder="摘要（Description），会被搜索引擎抓取为网页描述（选填）"></textarea>
				</div>
				<button type="submit" class="btn btn-warning btn-block">
					<i class="glyphicon glyphicon-ok"></i> 提交
				</button>
			</div>
		</div>
	</div>
	</form>
	<script>
		$(document).ready(function() {
			$('#summernote').summernote({
				height: "500px",
				lang:"zh-CN",
				toolbar: [
				    ['style', ['style']],
				    ['color', ['color']],
				    ['font', ['bold', 'underline', 'clear']],
				    ['para', ['ul', 'paragraph']],
				    ['table', ['table']],
				    ['insert', ['link', 'picture']],
				    ['misc', ['codeview', 'fullscreen']]
				]
			});
		});
		var postForm = function() {
			var content = $('textarea[name="content"]').html($('#summernote').code());
			var len = $('textarea[name="title"]').val().length;
			if (len<6){alert("请输入标题"); return false;}
			len = $('input[name="isbn"]').val().length;
			if (len<6){alert("请输入ISBN"); return false;}
		}
	</script>
<?php mc_template_part('footer_admin'); ?>