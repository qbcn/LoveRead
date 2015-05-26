<div class="container mb-20">
	<div class="row">
		<div class="col-lg-12">
			<div id="user-header" class="media" style="background-image: url(<?php $fmimg=mc_fmimg($_GET['id']);if($fmimg) : echo $fmimg; else : echo C('APP_ASSETS_URL').'/img/user_bg.jpg'; endif; ?>);">
				<div class="media-left">
					<a class="img-div" href="<?php echo U('user/index/index?id='.$_GET['id']); ?>">
						<img class="media-object" src="<?php echo mc_user_avatar($_GET['id']); ?>" alt="<?php $user_name=mc_user_display_name($_GET['id']);echo $user_name; ?>">
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading">
						<?php echo $user_name; ?> 
						<?php echo mc_guanzhu_btn($_GET['id']); ?>
						<?php if(mc_is_admin() && !mc_is_admin($_GET['id'])) : ?>
						<button class="btn btn-default btn-sm user-delete" user-data="<?php echo $_GET['id']; ?>" data-toggle="modal" data-target="#myModal">
							<i class="glyphicon glyphicon-trash"></i> 删除
						</button>
						<button class="btn btn-default btn-sm user-ip-false" user-data="<?php echo $_GET['id']; ?>" data-toggle="modal" data-target="#myModal2">
							<i class="glyphicon glyphicon-trash"></i> 屏蔽IP并删除
						</button>
						<?php endif; ?>
					</h4>
				</div>
				<div class="clearfix"></div>
				<div id="user-header-cover"></div>
			</div>
		</div>
	</div>
</div>
<?php if(mc_is_admin()) : ?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">确认要删除这个用户吗？注意：该用户的全部主题也会被一并删除！</div>
				<div class="modal-footer">
					<form method="post" action="<?php echo U('home/perform/delete'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
					<input id="user-delete" type="hidden" name="id" value="">
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">确认要永久屏蔽这个用户的全部IP并删除该用户吗？</div>
				<div class="modal-footer">
					<form method="post" action="<?php echo U('home/perform/ip_false'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
					<input id="user-ip-false" type="hidden" name="id" value="">
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<script>
	$(function(){
		$('.user-delete').click(function(){
			var duser = $(this).attr('user-data');
			$('#user-delete').val(duser);
		});
		$('.user-ip-false').click(function(){
			var duser = $(this).attr('user-data');
			$('#user-ip-false').val(duser);
		});
	});
	</script>
<?php endif; ?>