<?php mc_template_part('header'); ?>
	<div class="container">
		<ol class="breadcrumb mb-20 mt-20" id="baobei-term-breadcrumb">
			<li class="hidden-xs">
				<a href="<?php echo mc_site_url(); ?>">
					首页
				</a>
			</li>
			<li class="hidden-xs">
				<a href="<?php echo U('book/index/index'); ?>">
					书库
				</a>
			</li>
			<?php $parent = mc_get_meta($id,'parent',true,'term'); if($parent) : ?>
			<li class="hidden-xs">
				<a href="<?php echo U('book/index/term?id='.$parent); ?>">
					<?php echo mc_get_page_field($parent,'title'); ?>
				</a>
			</li>
			<?php endif; ?>
			<li class="active hidden-xs">
				<?php echo mc_get_page_field($id,'title'); ?>
			</li>
			<div class="clearfix"></div>
		</ol>
		<?php 
			if($parent=='') :
			$args_id_t = M('meta')->where("meta_key='parent' AND meta_value='$id' AND type='term'")->getField('page_id',true);
			if($args_id_t) :
			$condition_t['id']  = array('in',$args_id_t);
			$condition_t['type']  = 'term_pro';
			$terms_pro_t = M('page')->where($condition_t)->order('id desc')->select(); 
			endif;
			if($terms_pro_t) :
		?>
		<ul class="nav nav-pills mb-10 term-list" role="tablist">
		<?php foreach($terms_pro_t as $val) : ?>
			<li role="presentation">
				<a href="<?php echo U('pro/index/term?id='.$val['id']); ?>">
					<?php echo $val['title']; ?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php endif; endif; ?>
		<div class="row" id="pro-list">
			<?php foreach($page as $val) : ?>
			<div class="col-sm-6 col-md-4 col-lg-3 col">
				<div class="thumbnail">
					<?php $fmimg_args = mc_get_meta($val['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
					<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>"><img src="<?php echo $fmimg_args[0]; ?>" alt="<?php echo $val['title']; ?>"></a>
					<div class="caption">
						<h4>
							<a href="<?php echo mc_get_url($val['id']); ?>"><?php echo $val['title']; ?></a>
						</h4>
						<p class="price pull-left">
							<span><?php echo mc_price_now($val['id']); ?></span> <small>元</small>
						</p>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php echo mc_pagenavi($count,$page_now); ?>
	</div>
<?php mc_template_part('footer'); ?>