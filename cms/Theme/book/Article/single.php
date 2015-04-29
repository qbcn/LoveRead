<?php mc_template_part('header'); ?>
<div id="single-head-img" class="pr hidden-xs">
	<div class="single-head-img shi1" style="background-image: url(<?php if(mc_fmimg($_GET['id'])) : echo mc_fmimg($_GET['id']); else : echo mc_theme_url().'/img/user_bg.jpg'; endif; ?>);"></div>
	<div class="single-head-img shi2"></div>
	<div class="single-head-img shi3">
		<h1><?php echo mc_user_display_name($_GET['id']); ?></h1>
		<h4><?php echo mc_cut_str(strip_tags(mc_magic_out(mc_get_page_field($_GET['id'],'content'))), 80); ?></h4>
	</div>
</div>
	<?php foreach($page as $val) : ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<ol class="breadcrumb mb-0" id="baobei-term-breadcrumb">
					<li>
						<a href="<?php echo mc_site_url(); ?>">
							首页
						</a>
					</li>
					<li>
						<a href="<?php echo U('article/index/index'); ?>">
							文章
						</a>
					</li>
					<li>
						<a href="<?php echo U('article/index/term?id='.mc_get_meta($val['id'],'term')); ?>">
							<?php echo mc_get_page_field(mc_get_meta($val['id'],'term'),'title'); ?>
						</a>
					</li>
					<li class="active hidden-xs">
						<?php echo $val['title']; ?>
					</li>
					<div class="pull-right hidden-xs">
						<a href="javascript:;"><i class="glyphicon glyphicon-time"></i> <?php echo date('Y-m-d H:i:s',$val['date']); ?>
						<a href="javascript:;" class="publish"><i class="glyphicon glyphicon-eye-open"></i> <?php echo mc_views_count($val['id']); ?></a>
					</div>
				</ol>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<div id="single">
				<h1 class="title visible-xs-block"><?php echo $val['title']; ?></h1>
				<div id="entry">
					<?php echo mc_magic_out($val['content']); ?>
				</div>
				<?php if(mc_get_meta($val['id'],'tag',false)) : ?>
				<ul id="tags" class="list-inline">
					<li><i class="glyphicon glyphicon-tags"></i></li>
					<?php foreach(mc_get_meta($val['id'],'tag',false) as $tag) : ?>
					<li><a href="<?php echo U('article/index/tag?tag='.$tag); ?>"><?php echo $tag; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
				<hr>
				<div class="text-center">
					<?php if(mc_is_admin() && mc_is_bianji()) : ?>
						<a href="<?php echo U('custom/admin/edit?id='.$val['id']); ?>" class="btn btn-info btn-sm">
							<i class="glyphicon glyphicon-edit"></i> 编辑
						</a> 
						<?php if(mc_option('home_mode')=='post') : ?>
							<?php if(mc_get_meta($val['id'],'tuisong')) : ?>
								<a href="<?php echo U('home/perform/remts?id='.$val['id']); ?>" class="btn btn-default btn-sm">
									<i class="glyphicon glyphicon-bookmark"></i> 取消推送
								</a> 
							<?php else : ?>
								<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tsModal">
									<i class="glyphicon glyphicon-bookmark"></i> 推送至首页
								</a> 
							<?php endif; ?>
						<?php endif; ?>
						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">
							<i class="glyphicon glyphicon-trash"></i> 删除
						</button>
					<?php else : ?>
						<?php echo mc_xihuan_btn($val['id']); ?> 
						<?php echo mc_shoucang_btn($val['id']); ?>
					<?php endif; ?>
				</div>
				<hr>
				<?php echo W("Comment/index",array($val['id'])); ?>
				</div>
			</div>
		</div>
	</div>
	<?php if(mc_is_admin()) : ?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel">
						
					</h4>
				</div>
				<div class="modal-body text-center">
					确认要删除这篇文章吗？
				</div>
				<div class="modal-footer" style="text-align:center;">
					<form method="post" action="<?php echo U('home/perform/delete'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
					<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="tsModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					
				</div>
				<form method="post" action="<?php echo U('home/perform/tuisong'); ?>">
				<div class="modal-body text-center">
					<div id="pub-imgadd">
						<img class="default-img" id="default-img" src="<?php echo mc_theme_url(); ?>/img/upload.jpg">
						<input type="hidden" name="fmimg" id="pub-input" value="">
						<input type="file" id="picfile" onchange="readFile(this,1)" />
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
				<div class="modal-footer" style="text-align:center;">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
				</div>
				<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<?php endif; ?>
	<?php endforeach; ?>
	<?php if(mc_prev_page_id($val['id'])) : ?>
	<a class="prev_btn np_page_btn" href="<?php echo mc_get_url(mc_prev_page_id($val['id'])); ?>">
		<i class="fa fa-chevron-circle-left"></i>
	</a>
	<?php endif; ?>
	<?php if(mc_next_page_id($val['id'])) : ?>
	<a class="next_btn np_page_btn" href="<?php echo mc_get_url(mc_next_page_id($val['id'])); ?>">
		<i class="fa fa-chevron-circle-right"></i>
	</a>
	<?php endif; ?>
<?php mc_template_part('footer'); ?>