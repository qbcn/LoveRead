<?php if(MODULE_NAME=='Home' && CONTROLLER_NAME=='Index' && ACTION_NAME=='index') : ?>
<?php else : ?>
<div class="mb-20"><?php echo mc_option('sidebar'); ?></div>
<?php endif; ?>
<style>
ul.tag-list {margin-left:0;}
ul.tag-list li {padding:0;}
.tag, .tag:link, .tag:visited {
  width: auto;
  word-break: keep-all;
  white-space: nowrap;
  background-color: #f5f5f5;
  color: #37A;
  font-size: 13px;
  padding: 2px 10px 0;
  display: inline-block;
  margin: 0 3px 5px 0;
  line-height: 20px;
}
</style>
<div class="home-side">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-th-list"></i> 热门标签
			<a class="pull-right" href="<?php echo U('pro/index/index'); ?>"><i class="fa fa-angle-right"></i></a>
		</div>
		<?php 
		$terms_id = M('page')->where("type='term_pro'")->getField('id,title');
		$terms_pid = M('meta')->where("meta_key='parent' AND type='term'")->getField('page_id,meta_value');
		$terms_map = array();
		foreach($terms_pid as $tid=>$pid){
			$terms_map[$pid][$tid] = $terms_id[$tid];
		}
		foreach($terms_map as $pid=>$sub_terms):
		?>
		<p class="mt-10 mb-0"><?php echo $terms_id[$pid]; ?></p>
		<ul class="list-inline tag-list">
			<?php foreach($sub_terms as $tid=>$title): ?>
			<li><a class="tag" href="<?php echo U('pro/index/term?id='.$tid); ?>"><?php echo $title; ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php endforeach; ?>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-th-list"></i> 最新文章
			<a class="pull-right" href="<?php echo U('article/index/index'); ?>"><i class="fa fa-angle-right"></i></a>
		</div>
		<?php $newarticle = M('page')->where("type='article'")->order('id desc')->page(1,5)->select(); if($newarticle) : ?>
		<div class="list-group">
			<?php foreach($newarticle as $val) : ?>
			<a href="<?php echo mc_get_url($val['id']); ?>" class="list-group-item">
				<?php echo $val['title']; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
		<div class="panel-body">
			暂时没有任何文章，现在就去
			<br>
			<a href="<?php echo U('article/index/index'); ?>">写下网站的第一篇文章!</a>
		</div>
		<?php endif; ?>
	</div>
	<?php if(MODULE_NAME=='Home' && CONTROLLER_NAME=='Index' && ACTION_NAME=='index') : ?>
	<div class="panel panel-default home-post">
		<div class="panel-heading">
			<i class="fa fa-comments"></i> 最新话题
			<a class="pull-right" href="<?php echo U('post/group/index'); ?>"><i class="fa fa-angle-right"></i></a>
		</div>
		<ul class="list-group">
			<?php $page_post = M('page')->where("type='publish'")->order('date desc')->page(1,3)->select(); foreach($page_post as $val) : ?>
			<li class="list-group-item" id="mc-page-<?php echo $val['id']; ?>">
				<?php $author = mc_get_meta($val['id'],'author',true); ?>
				<h4 class="media-heading">
					<a href="<?php echo mc_get_url($val['id']); ?>"><?php echo $val['title']; ?></a>
				</h4>
				<p class="post-info mb-0 wto">
					<i class="glyphicon glyphicon-user"></i><a href="<?php echo mc_get_url($author); ?>"><?php echo mc_user_display_name($author); ?></a>
					<i class="glyphicon glyphicon-home"></i><a href="<?php echo mc_get_url(mc_get_meta($val['id'],'group')); ?>"><?php echo mc_get_page_field(mc_get_meta($val['id'],'group'),'title'); ?></a>
					<span class="hidden-md"><i class="glyphicon glyphicon-time"></i><?php echo date('m月d日',mc_get_meta($val['id'],'time')); ?></span>
				</p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-th-list"></i> 网站公告
		</div>
		<div class="panel-body">
			<?php echo mc_option('gonggao'); ?>
		</div>
	</div>
	<?php endif; ?>
</div>