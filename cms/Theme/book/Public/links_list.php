<style>
#link-list {background-color:#e3e3e3;}
#link-list .list-group-item {border:0;margin-bottom:1px;}
#link-list .media-left i {font-size:18px;}
#link-list .media-heading a {overflow:hidden;text-overflow:ellipsis;color:#3e484f;}
</style>
<?php $links = mc_get_meta($page_id,'link', false); if($links): ?>
<div class="home-main">
	<h4 class="title mb-10">
		<i class="glyphicon glyphicon-link"></i> 相关链接
	</h4>
	<ul class="list-group mb-20" id="link-list">
	<?php $links = array_reverse($links); foreach($links as $json): $link = json_decode($json, true); ?>
		<li class="list-group-item">
			<div class="media ml-10">
				<div class="media-left">
					<a href="<?php echo $link['url']; ?>">
						<?php if($link['type']=='play'): ?>
						<i class="glyphicon glyphicon-play-circle"></i>
						<?php elseif($link['type']=='buy'): ?>
						<i class="glyphicon glyphicon-shopping-cart"></i>
						<?php else: ?>
						<i class="glyphicon glyphicon-bookmark"></i>
						<?php endif; ?>
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading">
						<a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
						<a href="<?php echo $link['url']; ?>" class="pull-right">&gt;</a>
					</h4>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
