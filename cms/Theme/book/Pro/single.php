<?php mc_template_part('header'); ?>
<style>
#single-top {padding:10px 0;}
#single-top .container {max-width:970px;}
#single-top #pro-index-tlin {padding:0;}
#single-top #pro-index-tlin .imgshow {width:450px;height:450px;}
#pro-index-trin .pro-par-row {border-bottom: 1px solid #e3e6e9;padding-bottom: 5px;margin:20px 0;}
#pro-index-trin .pro-par-list-title {border-bottom:0;padding-top:5px;padding-bottom:0;margin:0;}
#pro-index-trin .pro-par-list {margin-bottom:0;}
#pro-index-trin .pro-par-list label {margin-bottom:0;}
#pro-index-trin .pro-par-price {font-size:16px;}
#pro-index-trin .pro-par-price #price {font-size:20px;color:#e33a3c;}
#pro-index-trin .form-group {margin-top:20px;padding-top:0;}
#pro-index-trin .buy-num-container {display:none;}
#pro-index-trin .btn-group .btn {margin-left:0;margin-right:10px;}
#pro-index-trin .wish {font-size:16px;padding:2px 10px 2px 0;}
#pro-index-trin .shoucang {font-size:16px;color:#777;padding:2px 5px;}
#pro-index-trin .shoucang:hover {color:#ff4a00;text-decoration:none;}
#pro-index-trin .shoucang:focus {text-decoration:none;}
#pro-index-trin .shoucang i {color:#ff4a00;}
#pro-index-trin .shoucang span {margin-left:8px;}
@media (max-width: 768px) {
  #pro-index-trin .btn-group button.add-cart {width:auto;}
}
#pro-single {padding:0;}
.home-main h4.title a.pull-right {width:auto;font-size:16px;}
</style>
	<?php foreach($page as $val) : ?>
	<div class="container">
		<ol class="breadcrumb" id="baobei-breadcrumb">
			<li>
				<a href="<?php echo mc_site_url(); ?>">
					首页
				</a>
			</li>
			<li>
				<a href="<?php echo U('pro/index/index'); ?>">
					书屋
				</a>
			</li>
			<?php $term_id = mc_get_meta($val['id'],'term'); $parent = mc_get_meta($term_id,'parent',true,'term'); if($parent) : ?>
			<li class="hidden-xs">
				<a href="<?php echo U('pro/index/term?id='.$parent); ?>">
					<?php echo mc_get_page_field($parent,'title'); ?>
				</a>
			</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo U('pro/index/term?id='.$term_id); ?>">
					<?php echo mc_get_page_field($term_id,'title'); ?>
				</a>
			</li>
			<li class="active hidden-xs">
				<?php echo $val['title']; ?>
			</li>
		</ol>
	</div>
	<div id="single-top">
		<div class="container">
			<div class="row">
				<div class="col-sm-6" id="pro-index-tl">
					<div id="pro-index-tlin">
					<?php $fmimg_args = mc_get_meta($val['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php foreach($fmimg_args as $fmimg) : ?>
							<?php $fmimg_num++; ?>
							<li data-target="#carousel-example-generic" data-slide-to="<?php echo $fmimg_num-1; ?>" class="<?php if($fmimg_num==1) echo 'active'; ?>"></li>
							<?php endforeach; ?>
						</ol>
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<?php $fmimg_num=0; ?>
							<?php foreach($fmimg_args as $fmimg) : ?>
							<?php $fmimg_num++; ?>
							<div class="item <?php if($fmimg_num==1) echo 'active'; ?>">
								<div class="imgshow"><img src="<?php echo $fmimg; ?>" alt="<?php echo $val['title']; ?>"></div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					</div>
				</div>
				<div class="col-sm-6" id="pro-index-tr">
					<div id="pro-index-trin">
					<h1><?php echo $val['title']; ?></h1>
					<div class="pro-par-row">
					<div class="row">
						<h4 class="col-xs-3 pro-par-list-title">定价</h4>
						<div class="col-xs-9 pro-par-price">
							<span id="price" price-data="<?php $pro_price = mc_get_meta($val['id'],'price'); echo $pro_price; ?>"><?php echo $pro_price; ?></span> 元
						</div>
					</div>
					</div>
					<form method="post" action="<?php echo U('home/perform/add_cart'); ?>" id="pro-single-form">
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : $parameter = array_reverse($parameter); foreach($parameter as $par) : ?>
					<?php $pro_parameter = mc_get_meta($val['id'],$par['id'],false,'parameter'); if($pro_parameter) : ?>
					<div class="pro-par-row">
					<div class="row">
						<h4 class="col-xs-3 pro-par-list-title"><?php echo $par['meta_value']; ?></h4>
						<ul class="col-xs-9 list-inline pro-par-list" id="par-list-<?php echo $par['id']; ?>">
						<?php $num=0; ?>
						<?php foreach($pro_parameter as $pro_par) : $num++; ?>
							<li>
								<label <?php if($num==1) echo 'class="active"'; ?> price-data="0" kucun-data="0">
									<span><?php echo $pro_par; ?></span>
									<input type="radio" name="parameter[<?php echo $par['id']; ?>]" value="<?php echo $pro_par; ?>"  <?php if($num==1) echo 'checked'; ?>>
								</label>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
					</div>
					<?php endif; endforeach; endif; $kucun_pro = mc_get_meta($val['id'],'kucun'); ?>
					<div class="form-group">
					    <div class="buy-num-container">
						<label>选择数量</label>
						<div class="row mb-20">
							<div class="col-md-6">
								<div class="input-group input-group-lg">
									<span class="input-group-addon select-number num-minus">
										-
									</span>
									<input type="text" id="buy-num-input" class="form-control text-center" value="1" name="number">
									<span class="input-group-addon select-number num-plus">
										+
									</span>
								</div>
							</div>
						</div>
						</div>
						<div class="btn-group buy-btn-1">
							<?php $user_id = mc_user_id(); if($user_id) : ?>
							<button type="submit" class="btn btn-warning add-cart" <?php if($kucun_pro<=0) : ?>style="display:none"<?php endif; ?> >
								<i class="glyphicon glyphicon-plus"></i> 加入购物车
							</button>
							<?php else : ?>
							<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#loginModal" <?php if($kucun_pro<=0) : ?>style="display:none"<?php endif; ?> >
								<i class="glyphicon glyphicon-plus"></i> 加入购物车
							</button>
							<?php endif; ?>
     						<?php if(mc_get_meta($val['id'],'tb_name') && mc_get_meta($val['id'],'tb_url')) : ?>
     						<a class="btn btn-default go-buy" target="_blank" rel="nofollow" href="<?php echo mc_get_meta($val['id'],'tb_url'); ?>">
     							<i class="glyphicon glyphicon-send"></i> 去<?php echo mc_get_meta($val['id'],'tb_name'); ?>购买
     						</a>
     						<?php endif; ?>
						</div>
					</div>
					<div class="buy-btn-1">
						<button type="submit" class="wish" <?php if($kucun_pro<=0) : ?>style="display:none"<?php endif; ?> >
							<i class="fa fa-heart-o"></i> 我想要
						</button>
						<?php
                        if(mc_user_id()) {
                            $page_id = $val['id'];
                        	$user_shoucang = M('action')->where("page_id='$page_id' AND user_id ='".$user_id."' AND action_key='perform' AND action_value ='shoucang'")->getField('id');
                        	if($user_shoucang) {
                        		$btn = '<a href="javascript:mc_remove_shoucang('.$page_id.');" id="mc_shoucang_'.$page_id.'" class="shoucang"><i class="glyphicon glyphicon-star"></i> 取消收藏<span>'.mc_shoucang_count($page_id).'</span></a>';
                        	} else {
                        		$btn = '<a href="javascript:mc_add_shoucang('.$page_id.');" id="mc_shoucang_'.$page_id.'" class="shoucang"><i class="glyphicon glyphicon-star-empty"></i> 收藏<span>'.mc_shoucang_count($page_id).'</span></a>';
                        	};
                        } else {
                        	$btn = '<a href="#" data-toggle="modal" data-target="#loginModal" id="mc_shoucang_'.$page_id.'" class="shoucang"><i class="glyphicon glyphicon-star-empty"></i> 收藏<span>'.mc_shoucang_count($page_id).'</span></a>';
                        };
                        echo $btn;
						?>
					</div>
					<?php if($kucun_pro>0) : ?>
					<script>
						$('.add-cart').hover(function(){
							$('#pro-single-form').attr('action','<?php echo U('home/perform/add_cart'); ?>');
						});
						$('.wish').hover(function(){
							$('#pro-single-form').attr('action','<?php echo U('publish/index/add_post?group='.$val['id'].'&wish=1'); ?>');
						});		
					</script>
					<?php endif; ?>
					<input type="hidden" value="<?php echo $val['id']; ?>" name="id">
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		
	<div id="pro-single">
		<div class="row">
			<div class="col-sm-12" id="single">
				<div id="entry">
					<?php echo mc_magic_out($val['content']); ?>
				</div>
				<hr>
				<div class="text-center">
					<?php if(mc_is_admin() && mc_is_bianji()) : ?>
					<a href="<?php echo U('custom/admin/edit?id='.$val['id']); ?>" class="btn btn-info">
						<i class="glyphicon glyphicon-edit"></i> 编辑
					</a>
					<button class="btn btn-default" data-toggle="modal" data-target="#myModal">
						<i class="glyphicon glyphicon-trash"></i> 删除
					</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo W("Links/showlist",array($val['id'])); ?>
	<div class="home-main">
		<div class="row mb-20">
			<div class="col-sm-12" id="post-list-default">
				<h4 class="title mb-10">
					<i class="glyphicon glyphicon-th-list"></i> 相关话题 
					<a class="pull-right" href="<?php echo U('post/group/single?id='.$val['id']); ?>">
						更多 &gt;</i>
					</a>
				</h4>
				<?php 
				
		        $args_id = M('meta')->where("meta_key='group' AND meta_value='".$val['id']."'")->getField('page_id',true);
		        if($args_id) :
		        $condition['type'] = 'publish';
		        $condition['id']  = array('in',$args_id);
			    $page_group = M('page')->where($condition)->order('date desc')->page(1,5)->select();
			    endif;
				if($page_group) :
				?>
				<ul class="list-group mb-0">
				<?php foreach($page_group as $val_group) : ?>
				<li class="list-group-item" id="mc-page-<?php echo $val_group['id']; ?>">
					<div class="row">
						<div class="col-sm-6 col-md-7 col-lg-8">
							<div class="media">
								<?php $author_group = mc_get_meta($val_group['id'],'author',true); $author_url = mc_get_url($author_group); ?>
								<a class="media-left" href="<?php echo $author_url; ?>">
									<div class="img-div">
										<img class="media-object" src="<?php echo mc_user_avatar($author_group); ?>">
									</div>
								</a>
								<div class="media-body">
									<h4 class="media-heading">
										<a href="<?php echo mc_get_url($val_group['id']); ?>"><?php echo $val_group['title']; ?></a>
									</h4>
									<p class="post-info">
										<i class="glyphicon glyphicon-user"></i><a href="<?php echo $author_url; ?>"><?php echo mc_user_display_name($author_group); ?></a>
										<i class="glyphicon glyphicon-time"></i><?php echo date('Y-m-d H:i:s',$val_group['date']); ?>
									</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-5 col-lg-4 text-right">
							<ul class="list-inline">
							<?php $comment_user = mc_last_comment_user($val_group['id']); if($comment_user) : ?>
							<li>最后：<?php echo mc_user_display_name($comment_user); ?></li>
							<?php endif; ?>
							<li>点击：<?php echo mc_views_count($val_group['id']); ?></li>
							</ul>
						</div>
					</div>
				</li>
				<?php endforeach; ?>
				</ul>
				<div class="text-center">
					<a rel="nofollow" class="btn btn-default btn-sm mt-10" href="<?php echo U('post/group/single?id='.$val['id']); ?>">发表新话题</a>
				</div>
				<?php else : ?>
				<div id="nothing">
					没有任何相关话题！<a rel="nofollow" href="<?php echo U('post/group/single?id='.$val['id']); ?>">发表新话题</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div id="pro-single">
		<h4 class="title mb-0">
			<i class="fa fa-comments"></i> 评论
		</h4>
		<div class="row">
			<div class="col-sm-12 pt-0" id="single">
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