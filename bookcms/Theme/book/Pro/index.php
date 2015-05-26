<?php mc_template_part('header'); ?>
<style>
.thumbnail i {position:absolute; color:#e6e6e6; font-size:50px; top:5px; right:5px; opacity:0.8; z-index:2; cursor:pointer;}
</style>
	<div class="container">
		<ol class="breadcrumb hidden-xs" id="baobei-term-breadcrumb">
			<li>
				<a href="<?php echo mc_site_url(); ?>">
					首页
				</a>
			</li>
			<?php if(MODULE_NAME=='Home') : ?>
			<li>
				书库
			</li>
			<li class="active">
				搜索 - <?php echo $_GET['keyword']; ?>
			</li>
			<?php else : ?>
			<li class="active">
				书库
			</li>
			<?php endif; ?>
		</ol>
		<button class="btn btn-success mb-10" type="button" data-toggle="modal" data-target="#termModal">分类浏览</button>
		<div class="row" id="pro-list">
			<?php foreach($page as $val) : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 col">
				<div class="thumbnail">
					<?php $fmimg_args = mc_get_meta($val['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
					<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>">
						<img src="<?php echo $fmimg_args[0]; ?>" alt="<?php echo $val['title']; ?>">
						<?php $playlink=mc_get_meta($val['id'],'link',true,'playlink'); if($playlink): ?>
						<i class="glyphicon glyphicon-play-circle"></i>
						<?php endif; ?>
					</a>
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
<!-- Modal -->
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
<div id="termModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">分类浏览</h4>
      </div>
      <div class="modal-body">
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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php mc_template_part('footer'); ?>