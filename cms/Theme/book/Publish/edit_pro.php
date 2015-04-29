<?php mc_template_part('header-admin'); ?>
<style>
#pro-index-tr .row.pro-parameter .col-xs-6{margin-top:10px;}
#pro-single {padding:0;}
</style>
	<link rel="stylesheet" href="<?php echo mc_site_url(); ?>/editor/summernote.css">
	<script src="<?php echo mc_site_url(); ?>/editor/summernote.min.js"></script>
	<script src="<?php echo mc_site_url(); ?>/editor/summernote-zh-CN.js"></script>
	<form role="form" method="post" action="<?php echo U('custom/perform/edit'); ?>" onsubmit="return postForm()">
	<div id="single-top">
		<div class="container-admin">
			<ol class="breadcrumb hidden-xs mb-20 mt-20" id="baobei-term-breadcrumb">
				<li>
					<a href="<?php echo U('home/index/index'); ?>">
						首页
					</a>
				</li>
				<li>
					<a href="<?php echo U('control/index/pro_index'); ?>">
						书库
					</a>
				</li>
				<li class="active">
					编辑图书
				</li>
				<div class="pull-right">
					<?php if(mc_is_admin()) : ?>
					<a href="<?php echo U('custom/admin/add_pro'); ?>" class="publish">发布图书</a>
					<?php endif; ?>
				</div>
			</ol>
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
								<div class="imgshow"><img src="<?php echo mc_theme_url(); ?>/img/upload.jpg"></div>
								<input type="file" id="picfile" onchange="readFile(this,1)" />
							</div>
							<?php else : ?>
							<div class="item active">
								<div class="imgshow"><img src="<?php echo mc_theme_url(); ?>/img/upload.jpg"></div>
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
							<label>定价</label>
							<div class="input-group">
								<input name="price" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'price'); ?>" placeholder="0.00">
								<span class="input-group-addon">
									元
								</span>
							</div>
						</div>
						<div class="col-xs-6 col hidden">
							<label>原价</label>
							<div class="input-group">
								<input name="price-old" type="text" class="form-control ml-20" value="<?php echo mc_get_meta($_GET['id'],'price-old'); ?>" placeholder="0.00">
								<span class="input-group-addon">
									元
								</span>
							</div>
						</div>
						<div class="col-xs-6 col hidden">
							<label>销量</label>
							<input name="xiaoliang" type="text" class="form-control ml-20" value="<?php echo mc_get_meta($_GET['id'],'xiaoliang'); ?>" placeholder="0">
						</div>
						<div class="col-xs-6 col">
							<label>库存</label>
							<input name="kucun" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'kucun'); ?>" placeholder="没有参数时此项有效">
						</div>
					</div>
					<div class="row pro-parameter">
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
						<?php $pro_parameter = mc_get_meta($_GET['id'],$par['id'],false,'parameter'); if($pro_parameter) : ?>
						<div class="col-xs-6">
							<label><?php echo $par['meta_value']; ?></label>
							<?php foreach($pro_parameter as $pro_par) : $num++; ?>
							<input name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][name]" type="text" class="form-control" value="<?php echo $pro_par; ?>" placeholder="参数">
							<?php endforeach; else : ?>
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]" type="text" class="form-control" placeholder="参数">
							<?php endif; ?>
						</div>
					<?php endforeach; endif; ?>
					</div>
					<div class="h3s mt-20 mb-0">
						<div class="row">
							<div class="col-xs-4 col">
								<label>第三方购买</label>
								<input name="tb_name" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'tb_name'); ?>" placeholder="名称">
							</div>
							<div class="col-xs-8 col">
								<label>链接</label>
								<input name="tb_url" type="text" class="form-control ml-20" value="<?php echo mc_get_meta($_GET['id'],'tb_url'); ?>" placeholder="http://">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>
							选择分类
						</label>
						<select class="form-control" name="term">
							<?php $terms = M('page')->where('type="term_pro"')->order('id desc')->select(); ?>
							<?php foreach($terms as $val) : ?>
							<option value="<?php echo $val['id']; ?>" <?php if(mc_get_meta($_GET['id'],'term')==$val['id']) echo 'selected'; ?>>
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
		<div class="form-group pro-links mb-20">
			<?php
				$links = mc_get_meta($_GET['id'],'link', false);
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
					<input name="pro-links[<?php echo $i; ?>][url]" type="text" class="form-control" value="<?php echo $link['url']; ?>" placeholder="http://">
				</div>
			    <div class="col-xs-4 col">
					<input name="pro-links[<?php echo $i; ?>][title]" type="text" class="form-control" value="<?php echo $link['title']; ?>" placeholder="标题">
				</div>
				<div class="col-xs-2 col">
					<select name="pro-links[<?php echo $i; ?>][type]" class="form-control">
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
					$(row).appendTo("#pro-single .pro-links");
					return false;
				});
				$("#remove-link").click(function(){
					$("#pro-single .pro-links .more:last").remove();
					if (num > 1) {num--;}
				});
			</script>
		</div>
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
				}
				</script>
<?php mc_template_part('footer'); ?>