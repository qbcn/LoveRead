<?php mc_template_part('header-admin'); ?>
	<link rel="stylesheet" href="<?php echo mc_site_url(); ?>/editor/summernote.css">
	<script src="<?php echo mc_site_url(); ?>/editor/summernote.min.js"></script>
	<script src="<?php echo mc_site_url(); ?>/editor/summernote-zh-CN.js"></script>
	<form role="form" method="post" action="<?php echo U('Home/perform/edit'); ?>" onsubmit="return postForm()">
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
						商品
					</a>
				</li>
				<li class="active">
					编辑商品
				</li>
				<div class="pull-right">
					<?php if(mc_is_admin()) : ?>
					<a href="<?php echo U('publish/index/index'); ?>" class="publish">发布商品</a>
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
		</script>
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
						<textarea name="title" class="form-control" placeholder="请填写商品标题"><?php echo mc_get_page_field($_GET['id'],'title'); ?></textarea>
					</h1>
					<div class="h3s">
						<div class="row">
							<div class="col-xs-5 col">
								<label>现价</label>
								<div class="input-group">
									<input name="price" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'price'); ?>" placeholder="0.00">
									<span class="input-group-addon">
										元
									</span>
								</div>
							</div>
							<div class="col-xs-4 col">
								<label>原价</label>
								<div class="input-group">
									<input name="price-old" type="text" class="form-control ml-20" value="<?php echo mc_get_meta($_GET['id'],'price-old'); ?>" placeholder="0.00">
									<span class="input-group-addon">
										元
									</span>
								</div>
							</div>
							<div class="col-xs-3 col">
								<label>销量</label>
								<input name="xiaoliang" type="text" class="form-control ml-20" value="<?php echo mc_get_meta($_GET['id'],'xiaoliang'); ?>" placeholder="0">
							</div>
							<div class="col-xs-5 col mt-10">
								<label>库存</label>
								<input name="kucun" type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'kucun'); ?>" placeholder="没有参数时此项有效">
							</div>
						</div>
					</div>
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
					<div class="form-group pro-parameter" id="pro-parameter-<?php echo $par['id']; ?>">
						<label><?php echo $par['meta_value']; ?></label>
						<?php $pro_parameter = mc_get_meta($_GET['id'],$par['id'],false,'parameter'); if($pro_parameter) : ?>
						<?php foreach($pro_parameter as $pro_par) : $num++; ?>
						<div class="row">
							<div class="col-sm-5">
								<div class="input-group"><input name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][name]" type="text" class="form-control" value="<?php echo $pro_par; ?>" placeholder="参数"><span class="input-group-addon"><i class="fa fa-remove"></i></span></div>
							</div>
							<div class="col-sm-4">
								<input name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][price]" type="text" class="form-control mt-10" value="<?php echo M('meta')->where("page_id='".$_GET['id']."' AND meta_key='$pro_par' AND type ='price'")->getField('meta_value'); ?>" placeholder="差价">
							</div>
							<div class="col-sm-3">
								<input name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][kucun]" type="text" class="form-control mt-10" value="<?php echo M('meta')->where("page_id='".$_GET['id']."' AND meta_key='$pro_par' AND type ='kucun'")->getField('meta_value'); ?>" placeholder="库存">
							</div>
						</div>
						<?php endforeach; else : ?>
						<div class="row">
							<div class="col-sm-5">
								<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]" type="text" class="form-control" placeholder="参数">
							</div>
							<div class="col-sm-4">
								<input name="pro-parameter[<?php echo $par['id']; ?>][1][price]" type="text" class="form-control" placeholder="差价">
							</div>
							<div class="col-sm-3">
								<input name="pro-parameter[<?php echo $par['id']; ?>][1][kucun]" type="text" class="form-control" placeholder="库存">
							</div>
						</div>
						<?php endif; ?>
					</div>
					<a id="pro-parameter-btn-<?php echo $par['id']; ?>" href="#" class="btn btn-block btn-default mb-10">+</a>
					<script>
						num = <?php echo $num+1; ?>;
						$('#pro-parameter-btn-<?php echo $par['id']; ?>').click(function(){
							$('<div class="row row-par"><div class="col-sm-5"><div class="input-group"><input name="pro-parameter[<?php echo $par['id']; ?>]['+num+'][name]" type="text" class="form-control" placeholder="参数"><span class="input-group-addon"><i class="fa fa-remove"></i></span></div></div><div class="col-sm-4"><input name="pro-parameter[<?php echo $par['id']; ?>]['+num+'][price]" type="text" class="form-control mt-10" placeholder="差价"></div><div class="col-sm-3"><input name="pro-parameter[<?php echo $par['id']; ?>]['+num+'][kucun]" type="text" class="form-control mt-10" placeholder="库存"></div></div>').appendTo('#pro-parameter-<?php echo $par['id']; ?>');
							$('#pro-parameter-<?php echo $par['id']; ?> .input-group .input-group-addon').click(function(){
								$(this).parents('.row-par').remove();
							});
							num++;
							return false;
						});
						$('#pro-parameter-<?php echo $par['id']; ?> .input-group .input-group-addon').click(function(){
							$(this).parent('.input-group').parent('.col-sm-7').parent('.row').remove();
						});
					</script>
					<?php endforeach; endif; ?>
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