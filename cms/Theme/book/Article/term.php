<?php mc_template_part('header'); ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<ol class="breadcrumb hidden-xs" id="baobei-term-breadcrumb">
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
					<?php if(ACTION_NAME=='term') : ?>
					<li class="active">
						<?php echo mc_get_page_field($id,'title'); ?>
					</li>
					<?php elseif(ACTION_NAME=='tag') : ?>
					<li class="active">
						<?php echo $_GET['tag']; ?>
					</li>
					<?php endif; ?>
				</ol>
				<div id="article-list">
					<?php foreach($page as $val) : ?>
							<div class="thumbnail">
								<a href="<?php $page_url=mc_get_url($val['id']);echo $page_url; ?>" class="img-div"><img src="<?php echo mc_fmimg($val['id']); ?>" alt="<?php echo $val['title']; ?>"></a>
								<div class="caption">
									<h3>
										<a href="<?php echo $page_url; ?>"><?php echo $val['title']; ?></a>
									</h3>
									<p>
										<?php echo mc_cut_str(strip_tags(mc_magic_out($val['content'])),200); ?>
									</p>
									<ul class="list-inline">
										<li><i class="glyphicon glyphicon-star-empty"></i> <?php echo mc_shoucang_count($val['id']); ?></li>
										<li><i class="glyphicon glyphicon-time"></i> <?php echo date('Y-m-d',$val['date']); ?></li>
									</ul>
								</div>
							</div>
					<?php endforeach; ?>
				</div>
				<?php echo mc_pagenavi($count,$page_now); ?>
			</div>
		</div>
	</div>
<?php mc_template_part('footer'); ?>