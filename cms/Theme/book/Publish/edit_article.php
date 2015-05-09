<?php mc_template_part('header_admin'); ?>
	<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote.css">
	<script src="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote.min.js"></script>
	<script src="<?php echo C('APP_ASSETS_URL'); ?>/editor/summernote-zh-CN.js"></script>
	<div class="container-admin">
		<div class="row">
			<form role="form" method="post" action="<?php echo U('custom/perform/edit'); ?>" onsubmit="return postForm()">
			<div class="col-sm-9">
				<div class="form-group">
					<label>
						标题
					</label>
					<input name="title" type="text" class="form-control" placeholder="" value="<?php echo mc_get_page_field($_GET['id'],'title'); ?>">
				</div>
				<div class="form-group">
					<label>
						内容
					</label>
					<textarea name="content" class="form-control" rows="3" id="summernote"><?php echo mc_magic_out(mc_get_page_field($_GET['id'],'content')); ?></textarea>
				</div>
				<div class="form-group">
					<label>
						标签（多个标签以空格隔开）
					</label>
					<input name="tags" type="text" class="form-control" value="<?php foreach(mc_get_meta($_GET['id'],'tag',false) as $tag) : echo $tag.' '; endforeach; ?>" placeholder="">
				</div>
				<?php echo W("Media/edit",array($_GET['id'])); ?>
				<?php echo W("Links/edit",array($_GET['id'])); ?>
				<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
				<button type="submit" class="btn btn-warning btn-block">
					保存
				</button>
				
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>
						选择分类
					</label>
					<select class="form-control" name="term">
						<?php $terms = M('page')->where('type="term_article"')->order('id desc')->select(); ?>
						<?php foreach($terms as $val) : ?>
						<option value="<?php echo $val['id']; ?>" <?php if(mc_get_meta($_GET['id'],'term')==$val['id']) echo 'selected'; ?>>
							<?php echo $val['title']; ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>
							封面图片
					</label>
					<div id="pub-imgadd">
						<img class="default-img" id="default-img" src="<?php $fmimg=mc_fmimg($_GET['id']); if($fmimg) echo $fmimg; else echo C('APP_ASSETS_URL').'/img/upload.jpg'; ?>">
						<input type="hidden" name="fmimg" id="pub-input" value="<?php if($fmimg) echo $fmimg; else echo C('APP_ASSETS_URL').'/img/upload.jpg'; ?>">
						<input type="file" id="picfile" onchange="readFile(this,1)" />
					</div>
				</div>
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
				        	$('#pub-imgadd img').attr('src',this.result);
				        	$('#pub-imgadd #pub-input').val(this.result);
				            //alert(this.result);
				        } 
				} 
				</script>
			</div>
			</form>
		</div>
	</div>
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
		}
	</script>
<?php mc_template_part('footer_admin'); ?>