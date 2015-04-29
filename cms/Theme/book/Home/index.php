<?php mc_template_part('header'); ?>
	<div class="container">
		<div class="row mb-20 hidden-xs" id="home-top">
			<div class="col-md-12 col">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<?php if(mc_option('homehdimg2')) : ?>
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active">
						</li>
						<li data-target="#carousel-example-generic" data-slide-to="1">
						</li>
						<?php if(mc_option('homehdimg3')) : ?>
						<li data-target="#carousel-example-generic" data-slide-to="2">
						</li>
						<?php endif; ?>
					</ol>
					<?php endif; ?>
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<a class="img-div" href="<?php echo mc_option('homehdlnk1'); ?>"><img src="<?php echo mc_option('homehdimg1'); ?>"></a>
						</div>
						<?php if(mc_option('homehdimg2')) : ?>
						<div class="item">
							<a class="img-div" href="<?php echo mc_option('homehdlnk2'); ?>"><img src="<?php echo mc_option('homehdimg2'); ?>"></a>
						</div>
						<?php endif; ?>
						<?php if(mc_option('homehdimg3')) : ?>
						<div class="item">
							<a class="img-div" href="<?php echo mc_option('homehdlnk3'); ?>"><img src="<?php echo mc_option('homehdimg3'); ?>"></a>
						</div>
						<?php endif; ?>
					</div>
					<?php if(mc_option('homehdimg2')) : ?>
					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left">
						</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right">
						</span>
					</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="home-main-pro" class="home-main">
			<div class="row">
				<div class="col-md-8 col-lg-9" id="pro-list">
					<?php
					$args_id = M('meta')->where("meta_key='parent' AND meta_value>'0' AND type='term'")->getField('page_id',true);
					if($args_id) {
						$condition['id']  = array('not in',$args_id);
					};
					$condition['type']  = 'term_pro';
					$terms_pro = M('page')->where($condition)->order('id desc')->select(); 
					if($terms_pro) :
					?>
					<?php foreach($terms_pro as $val) : ?>
					<h4 class="title">
						<i class="fa fa-th-large"></i> <?php echo $val['title']; ?>
						<a class="pull-right" href="<?php echo U('pro/index/term?id='.$val['id']); ?>"><i class="fa fa-angle-right"></i></a>
					</h4>
					<div class="row mb-20">
					<?php 
						//检索子分类
			        	$args_id_t = M('meta')->where("meta_key='parent' AND meta_value='".$val['id']."' AND type='term'")->getField('page_id',true);
			        	$condition_t['id']  = array('in',$args_id_t);
						$condition_t['type']  = 'term_pro';
						$terms_pro_t = M('page')->where($condition_t)->getField('id',true);
						if($terms_pro_t) {
							//如果有子分类，获取子分类下商品
							$condition_child['meta_key'] = 'term';
							$condition_child['meta_value'] = array('in',$terms_pro_t);
							$condition_child['type'] = 'basic';
							$args_id_child = M('meta')->where($condition_child)->getField('page_id',true);
							//获取当前分类下商品
							$args_id_this = M('meta')->where("meta_key='term' AND meta_value='".$val['id']."' AND type='basic'")->getField('page_id',true);
							if($args_id_child) {
								if($args_id_this) {
									$args_id = array_merge($args_id_child,$args_id_this);
								} else {
									$args_id = $args_id_child;
								}
							} else {
								$args_id = $args_id_this;
							}
						} else {
							//如果没有子分类，直接获取当前分类下商品
							$args_id = M('meta')->where("meta_key='term' AND meta_value='".$val['id']."' AND type='basic'")->getField('page_id',true);
						};
						if($args_id) :
							$condition['id']  = array('in',$args_id);
							$condition['type'] = 'pro';
					    	$newpro = M('page')->where($condition)->order('date desc')->page(1,8)->select();
				    	endif;
				    	$num_newproa=0;
			    	?>
					<?php foreach($newpro as $val) : ?>
					<?php $num_newproa++; ?>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 col <?php if($num_newproa==7 || $num_newproa==8) echo 'hidden-md'; ?>">
							<div class="thumbnail">
								<?php $fmimg_args = mc_get_meta($val['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
								<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>"><img src="<?php echo $fmimg_args[0]; ?>" alt="<?php echo mc_get_page_field($val['id'],'title'); ?>"></a>
								<div class="caption">
									<h4>
										<a href="<?php echo mc_get_url($val['id']); ?>"><?php echo mc_get_page_field($val['id'],'title'); ?></a>
									</h4>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
					<?php endforeach; ?>
					<?php else : ?>
					<div id="nothing">
						暂时没有任何商品，去<a href="<?php echo U('pro/index/index'); ?>">添加更多商品</a>吧！
					</div>
					<?php endif; ?>
				</div>
				<div class="col-md-4 col-lg-3 hidden-xs hidden-sm">
					<?php mc_template_part('sidebar'); ?>
				</div>
			</div>
		</div>
	</div>
<?php mc_template_part('footer'); ?>