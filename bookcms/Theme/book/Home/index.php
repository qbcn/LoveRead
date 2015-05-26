<?php mc_template_part('header'); ?>
	<div class="container">
		<div class="row mb-20 hidden-xs" id="home-top">
			<div class="col-md-12 col">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<?php
						$homehdimg1 = mc_option('homehdimg1');
						$homehdimg2 = mc_option('homehdimg2');
						$homehdimg3 = mc_option('homehdimg3');
						if($homehdimg2) :
					?>
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active">
						</li>
						<li data-target="#carousel-example-generic" data-slide-to="1">
						</li>
						<?php if($homehdimg3) : ?>
						<li data-target="#carousel-example-generic" data-slide-to="2">
						</li>
						<?php endif; ?>
					</ol>
					<?php endif; ?>
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<a class="img-div" href="<?php echo mc_option('homehdlnk1'); ?>"><img src="<?php echo $homehdimg1; ?>"></a>
						</div>
						<?php if($homehdimg2) : ?>
						<div class="item">
							<a class="img-div" href="<?php echo mc_option('homehdlnk2'); ?>"><img src="<?php echo $homehdimg2; ?>"></a>
						</div>
						<?php endif; ?>
						<?php if($homehdimg3) : ?>
						<div class="item">
							<a class="img-div" href="<?php echo mc_option('homehdlnk3'); ?>"><img src="<?php echo $homehdimg3; ?>"></a>
						</div>
						<?php endif; ?>
					</div>
					<?php if($homehdimg2) : ?>
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
					$new_pro = M('page')->where("type='pro'")->order('id desc')->limit(0,16)->select(); 
					if($new_pro) :
					?>
					<h4 class="title">
						<i class="fa fa-th-large"></i> 新书速递
						<a class="pull-right" href="<?php echo U('pro/index/index'); ?>"><i class="fa fa-angle-right"></i></a>
					</h4>
					<div class="row mb-20">
					<?php foreach($new_pro as $val) : ?>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 col">
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
					<?php else : ?>
					<div id="nothing">
						暂时没有任何商品，去<a href="<?php echo U('pro/index/index'); ?>">添加更多商品</a>吧！
					</div>
					<?php 
					endif;
					$hot_id = M('count')->where("meta_key='views' AND type='pro'")->order('meta_value desc')->limit(0,16)->getField('page_id',true);
					if($hot_id){
						$condition['id'] = array('in', $hot_id);
						$condition['type'] = 'pro';
						$hot_pro = M('page')->where($condition)->select();
					}
					if($hot_pro) :
					?>
					<h4 class="title">
						<i class="fa fa-th-large"></i> 最受关注
						<a class="pull-right" href="<?php echo U('pro/index/index'); ?>"><i class="fa fa-angle-right"></i></a>
					</h4>
					<div class="row mb-20">
					<?php foreach($hot_pro as $val) : ?>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 col">
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
					<?php endif; ?>
				</div>
				<div class="col-md-4 col-lg-3 hidden-xs hidden-sm">
					<?php mc_template_part('sidebar'); ?>
				</div>
			</div>
		</div>
	</div>
<?php mc_template_part('footer'); ?>