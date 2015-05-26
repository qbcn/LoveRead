<?php mc_template_part('header'); ?>
<style>
#single{padding:10px 0;}
#entry p{margin-bottom:15px;font-size:15px;}
</style>
<div id="single-head-img" class="pr hidden-xs">
	<div class="single-head-img shi1" style="background-image: url(<?php $fmimg=mc_fmimg($_GET['id']); if($fmimg) : echo $fmimg; else : echo C('APP_ASSETS_URL').'/img/user_bg.jpg'; endif; ?>);"></div>
	<div class="single-head-img shi2"></div>
	<div class="single-head-img shi3">
		<h1><?php echo mc_user_display_name($_GET['id']); ?></h1>
	</div>
	<?php if($fmimg): ?>
	<div class="hidden"><img src="<?php echo $fmimg; ?>" style="width:500px;height:500px;"></div>
	<?php endif; ?>
</div>
	<?php foreach($page as $val) : ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<ol class="breadcrumb mb-0 hidden-xs" id="baobei-term-breadcrumb">
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
						<a href="<?php $term_id=mc_get_meta($val['id'],'term');echo U('article/index/term?id='.$term_id); ?>">
							<?php echo mc_get_page_field($term_id,'title'); ?>
						</a>
					</li>
					<li class="active">
						<?php echo $val['title']; ?>
					</li>
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
				<?php echo W("Media/play",array($val['id'])); ?>
				<div class="text-center">
					<?php if(mc_is_admin() && mc_is_bianji()) : ?>
						<a href="<?php echo U('custom/admin/edit?id='.$val['id']); ?>" class="btn btn-info btn-sm">
							<i class="glyphicon glyphicon-edit"></i> 编辑
						</a> 
						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">
							<i class="glyphicon glyphicon-trash"></i> 删除
						</button>
					<?php endif; ?>
					<?php echo mc_shoucang_btn($val['id']); ?><br/><label id="shoucang-playlist"  style="display:none;">(收藏之后可以定制你的专属播放列表哦)</label>
					<?php $fmimg=mc_get_meta($val['id'],'fmimg');if($fmimg): ?>
					<br/><img class="visible-xs-inline" src="<?php echo $fmimg; ?>">
					<?php endif; ?>
				</div>
				<?php mc_template_part('qr_code'); ?>
				<?php echo W("Links/showlist",array($val['id'])); ?>
				<h4 class="title mb-0">
					<i class="fa fa-comments"></i> 评论
				</h4>
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
	<?php endif; ?>
	<?php endforeach; ?>
	<?php $prev_pge=mc_prev_page_id($val['id']);if($prev_pge) : ?>
	<a class="prev_btn np_page_btn" href="<?php echo mc_get_url($prev_pge); ?>">
		<i class="fa fa-chevron-circle-left"></i>
	</a>
	<?php endif; ?>
	<?php $next_page=mc_next_page_id($val['id']);if($next_page) : ?>
	<a class="next_btn np_page_btn" href="<?php echo mc_get_url($next_page); ?>">
		<i class="fa fa-chevron-circle-right"></i>
	</a>
	<?php endif; ?>
<?php mc_template_part('footer'); ?>