<?php mc_template_part('header'); ?>
	<div class="container">
		<ol class="breadcrumb" id="baobei-term-breadcrumb">
			<li class="hidden-xs">
				<a href="<?php echo mc_site_url(); ?>">
					首页
				</a>
			</li>
			<?php if(MODULE_NAME=='Home') : ?>
			<li class="hidden-xs">
				书屋
			</li>
			<li class="active hidden-xs">
				搜索 - <?php echo $_GET['keyword']; ?>
			</li>
			<?php else : ?>
			<li class="active hidden-xs">
				书屋
			</li>
			<?php endif; ?>
			<div class="clearfix"></div>
		</ol>
		<?php 
			$args_id = M('meta')->where("meta_key='parent' AND meta_value>'0' AND type='term'")->getField('page_id',true);
			if($args_id) :
			$condition['id']  = array('not in',$args_id);
			endif;
			$condition['type']  = 'term_pro';
			$terms_pro = M('page')->where($condition)->order('id desc')->select(); 
			if($terms_pro) :
		?>
		<ul class="nav nav-pills mb-10 term-list" role="tablist">
		<?php foreach($terms_pro as $val) : ?>
			<li role="presentation">
				<a href="<?php echo U('pro/index/term?id='.$val['id']); ?>">
					<?php echo $val['title']; ?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="row" id="pro-list">
			<?php foreach($page as $val) : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 col">
				<div class="thumbnail">
					<?php $fmimg_args = mc_get_meta($val['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
					<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>"><img src="<?php echo $fmimg_args[0]; ?>" alt="<?php echo $val['title']; ?>"></a>
					<div class="caption">
						<h4>
							<a href="<?php echo mc_get_url($val['id']); ?>"><?php echo $val['title']; ?></a>
						</h4>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php echo mc_pagenavi($count,$page_now); ?>
	</div>
<?php mc_template_part('footer'); ?>