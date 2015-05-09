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
	<form role="form" method="post" action="<?php echo U('custom/perform/edit'); ?>" onsubmit="return postForm()">
	<div id="single-top">
		<div class="container-admin">
			<div class="row">
				<div class="col-sm-6" id="pro-index-tl">
					<div id="pro-index-tlin">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<script>
							function mc_fmimg_delete() {
								$('.item i').click(function(){
									var index = $(this).parent(".item").index()*1+1;
									$('#pub-imgadd .item:eq('+index +')').addClass('active');
									$(this).parent(".item").remove();
									$('.carousel-indicators li').last().remove();
								});
							};
							$(document).ready(function(){
								mc_fmimg_delete();
							});
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
									$('<div class="item active"><div class="imgshow"><img src="'+this.result+'"></div><i class="glyphicon glyphicon-remove-circle"></i><input type="hidden" name="fmimg[]" value="'+this.result+'"></div>').prependTo('#pub-imgadd');
									var index = $('.carousel-indicators li').last().index()*1+1;
									$('<li data-target="#carousel-example-generic" data-slide-to="'+index+'"></li>').appendTo('.carousel-indicators');
									mc_fmimg_delete();
						        } 
							} 
						</script>
						<ol class="carousel-indicators" id="publish-carousel-indicators"><?php $fmimg = mc_get_meta($_GET['id'],'fmimg',false); $fmimg = array_reverse($fmimg); foreach($fmimg as $val) : $num0++; ?><li data-target="#carousel-example-generic" data-slide-to="<?php echo $num0-1; ?>" class="<?php if($num0==1) echo 'active'; ?>"></li><?php endforeach; ?><li data-target="#carousel-example-generic" data-slide-to="<?php echo $num0; ?>"></li></ol>
						<div class="carousel-inner" id="pub-imgadd">
							<?php if($fmimg) : ?>
							<?php foreach($fmimg as $val) : ?>
							<?php $num++; ?>
							<div class="item <?php if($num==1) echo 'active'; ?>">
								<div class="imgshow"><img src="<?php echo $val; ?>"><input type="hidden" name="fmimg[]" value="<?php echo $val; ?>"></div>
								<i class="glyphicon glyphicon-remove-circle"></i>
							</div>
							<?php endforeach; ?>
							<div class="item">
								<div class="imgshow"><img src="<?php echo C('APP_ASSETS_URL'); ?>/img/upload.jpg"></div>
								<input type="file" id="picfile" onchange="readFile(this,1)" />
							</div>
							<?php else : ?>
							<div class="item active">
								<div class="imgshow"><img src="<?php echo C('APP_ASSETS_URL'); ?>/img/upload.jpg"></div>
								<input type="file" id="picfile" onchange="readFile(this,1)" />
							</div>
							<?php endif; ?>
						</div>
					</div>
					</div>
				</div>
				<div class="col-sm-6" id="pro-index-tr">
					<div id="pro-index-trin">
					<h1>
						<textarea name="title" class="form-control" placeholder="请填写图书标题"><?php echo mc_get_page_field($_GET['id'],'title'); ?></textarea>
					</h1>
					<div class="row">
						<div class="col-xs-6 col">
							<label>ISBN <span style="color:#ff4a00">*</span></label>
							<input name="isbn" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'isbn'); ?>" placeholder="10位或13位数字">
						</div>
						<div class="col-xs-6 col">
							<label>定价</label>
							<div class="input-group">
								<input name="price" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'price'); ?>" placeholder="0.00">
								<span class="input-group-addon">元</span>
							</div>
						</div>
						<div class="col-xs-6 col hidden">
							<label>库存</label>
							<input name="kucun" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'kucun'); ?>" placeholder="0">
						</div>
					</div>
					<div class="row pro-parameter">
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
						<div class="col-xs-6">
							<label><?php echo $par['meta_value']; ?></label>
							<?php $pro_parameter = mc_get_meta($_GET['id'],$par['id'],true,'parameter'); if($pro_parameter) : ?>
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]" type="text" class="form-control" value="<?php echo $pro_parameter; ?>" placeholder="参数">
							<?php else : ?>
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]" type="text" class="form-control" placeholder="参数">
							<?php endif; ?>
						</div>
					<?php endforeach; endif; ?>
					</div>
					<?php echo W("Buyurl/edit",array($_GET['id'])); ?>
					<div class="form-group">
						<label>选择分类</label>
						<select id="term-selection" class="form-control" name="term[]" multiple>
							<?php 
								$terms = M('page')->where('type="term_pro"')->order('id desc')->select();
								$pro_terms = mc_get_meta($_GET['id'],'term', false);
							?>
							<?php foreach($terms as $val) : ?>
							<option value="<?php echo $val['id']; ?>" <?php if(in_array($val['id'], $pro_terms)) echo 'selected'; ?>>
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
		<?php echo W("Links/edit",array($_GET['id'])); ?>
		<div class="row">
			<div class="col-sm-12" id="single">
				<div id="entry">
					<div class="form-group">
						<textarea name="content" class="form-control" rows="3" id="summernote"><?php echo mc_magic_out(mc_get_page_field($_GET['id'],'content')); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<input name="keywords" type="text" class="form-control" placeholder="关键词（Keywords），多个关键词以英文半角逗号隔开（选填）" value="<?php echo mc_get_meta($_GET['id'],'keywords'); ?>">
				</div>
				<div class="form-group">
					<textarea name="description" class="form-control" rows="3" placeholder="摘要（Description），会被搜索引擎抓取为网页描述（选填）"><?php echo mc_get_meta($_GET['id'],'description'); ?></textarea>
				</div>
				<button type="submit" class="btn btn-warning btn-block">
					<i class="glyphicon glyphicon-ok"></i> 提交
				</button>
			</div>
		</div>
	</div>
	<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
	</form>
	<script type="text/javascript">
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