<?php mc_template_part('header'); ?>
	<link rel="stylesheet" href="<?php echo mc_site_url(); ?>/editor/summernote.css">
	<script src="<?php echo mc_site_url(); ?>/editor/summernote.min.js"></script>
	<script src="<?php echo mc_site_url(); ?>/editor/summernote-zh-CN.js"></script>
	<div class="container">
		<ol class="breadcrumb mb-20 mt-20" id="baobei-term-breadcrumb">
			<li>
				<a href="<?php echo U('home/index/index'); ?>">
					首页
				</a>
			</li>
			<li>
				<a href="<?php echo U('post/group/index'); ?>">
					群组
				</a>
			</li>
			<li>
				<a href="<?php echo U('post/group/single?id='.mc_get_meta($_GET['id'],'group')); ?>">
					<?php echo mc_get_page_field(mc_get_meta($_GET['id'],'group'),'title'); ?>
				</a>
			</li>
			<li class="active">
				编辑 - <?php echo mc_get_page_field($_GET['id'],'title'); ?>
			</li>
		</ol>
		<div class="row">
			<div class="col-sm-12">
				<form role="form" method="post" action="<?php echo U('Home/perform/edit'); ?>" onsubmit="return postForm()">
					<?php if(mc_get_page_field($_GET['group'],'type')=='pro' && mc_get_meta($_GET['id'],'number')) : ?>
					<div style="text-align:center; background-color:#e2e5e9; line-height:60px; margin-bottom:20px; ">
						<i class="fa fa-lock"></i> 心愿目标不可修改！
					</div>
					<?php endif; ?>
					<div class="row">
						<div class="col-sm-4 col-lg-3">
							<div class="form-group">
								<label>
									版块
								</label>
								<select class="form-control" name="group">
								<?php if(mc_get_page_field($_GET['group'],'type')=='pro') : ?>
									<option value="<?php echo $_GET['group']; ?>" selected><?php echo mc_get_page_field($_GET['group'],'title'); ?></option>
								<?php else : ?>
								<?php $group = M('page')->where('type="group"')->order('date desc')->select(); if($group) : foreach($group as $val) : ?>
									<option value="<?php echo $val['id']; ?>" <?php if($_GET['group']==$val['id']) echo 'selected'; ?>><?php echo $val['title']; ?></option>
								<?php endforeach; endif; ?>
								<?php endif; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-8 col-lg-9">
							<div class="form-group">
								<label>
									标题
								</label>
								<input name="title" type="text" class="form-control" placeholder="" value="<?php echo mc_get_page_field($_GET['id'],'title'); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>
							主题内容
						</label>
						<textarea name="content" class="form-control" rows="3" id="summernote"><?php echo mc_magic_out(mc_get_page_field($_GET['id'],'content')); ?></textarea>
					</div>
					<?php if(mc_get_meta($_GET['id'],'number') && mc_get_page_field($_GET['group'],'type')=='pro') : ?>
					<div class="form-group">
						<label>
							收货信息 - 心愿达成后，我们会发货到以下地址
						</label>
						<div class="row">
							<div class="col-sm-4">
								<input type="text" name="buyer_name" class="form-control" placeholder="收货人姓名" value="<?php if(mc_get_meta($_GET['id'],'buyer_name')) : echo mc_get_meta($_GET['id'],'buyer_name'); else : echo mc_get_meta(mc_user_id(),'buyer_name',true,'user'); endif; ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<?php if(mc_get_meta($_GET['id'],'buyer_province') && mc_get_meta($_GET['id'],'buyer_city')) : ?>
						<div class="row" id="repcbox">
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control" value="<?php echo mc_get_meta($_GET['id'],'buyer_province').' '.mc_get_meta($_GET['id'],'buyer_city'); ?>" disabled>
									<span class="input-group-addon" id="repc">
										<i class="glyphicon glyphicon-refresh"></i>
									</span>
									<input type="hidden" name="buyer_province" value="<?php echo mc_get_meta($_GET['id'],'buyer_province'); ?>">
									<input type="hidden" name="buyer_city" value="<?php echo mc_get_meta($_GET['id'],'buyer_city'); ?>">
								</div>
							</div>
						</div>
						<script>
							$('#repc').click(function(){
								$('#repcbox').html('<div class="col-sm-2"><select class="form-control" id="province" tabindex="4" runat="server" onchange="selectprovince(this);" name="buyer_province" datatype="*" errormsg="必须选择您所在的地区"></select></div><div class="col-sm-2"><select class="form-control" id="city" tabindex="4" disabled="disabled" runat="server" name="buyer_city"></select></div>');
								jQuery.getScript("<?php echo mc_theme_url(); ?>/js/address.js");
							});
						</script>
						<?php elseif(mc_get_meta(mc_user_id(),'buyer_province',true,'user') && mc_get_meta(mc_user_id(),'buyer_city',true,'user')) : ?>
						<div class="row" id="repcbox">
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control" value="<?php echo mc_get_meta(mc_user_id(),'buyer_province',true,'user').' '.mc_get_meta(mc_user_id(),'buyer_city',true,'user'); ?>" disabled>
									<span class="input-group-addon" id="repc">
										<i class="glyphicon glyphicon-refresh"></i>
									</span>
									<input type="hidden" name="buyer_province" value="<?php echo mc_get_meta(mc_user_id(),'buyer_province',true,'user'); ?>">
									<input type="hidden" name="buyer_city" value="<?php echo mc_get_meta(mc_user_id(),'buyer_city',true,'user'); ?>">
								</div>
							</div>
						</div>
						<script>
							$('#repc').click(function(){
								$('#repcbox').html('<div class="col-sm-2"><select class="form-control" id="province" tabindex="4" runat="server" onchange="selectprovince(this);" name="buyer_province" datatype="*" errormsg="必须选择您所在的地区"></select></div><div class="col-sm-2"><select class="form-control" id="city" tabindex="4" disabled="disabled" runat="server" name="buyer_city"></select></div>');
								jQuery.getScript("<?php echo mc_theme_url(); ?>/js/address.js");
							});
						</script>
						<?php else : ?>
						<div class="row">
							<div class="col-sm-2">
								<select class="form-control" id="province" tabindex="4" runat="server" onchange="selectprovince(this);" name="buyer_province" datatype="*" errormsg="必须选择您所在的地区"></select>
							</div>
							<div class="col-sm-2">
								<select class="form-control" id="city" tabindex="4" disabled="disabled" runat="server" name="buyer_city"></select>
							</div>
						</div>
						
						<?php endif; ?>
					</div>
					<script src="<?php echo mc_theme_url(); ?>/js/address.js"></script>
					<div class="form-group">
						<textarea class="form-control" name="buyer_address" rows="3" placeholder="区县、街道、门牌号"><?php if(mc_get_meta($_GET['id'],'buyer_address')) : echo mc_get_meta($_GET['id'],'buyer_address'); else : echo mc_get_meta(mc_user_id(),'buyer_address',true,'user'); endif; ?></textarea>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4">
								<input type="text" class="form-control" name="buyer_phone" placeholder="联系电话，非常重要" value="<?php if(mc_get_meta($_GET['id'],'buyer_phone')) : echo mc_get_meta($_GET['id'],'buyer_phone'); else : echo mc_get_meta(mc_user_id(),'buyer_phone',true,'user'); endif; ?>">
							</div>
						</div>
					</div>
					<?php endif; ?>
					<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
					<button type="submit" class="btn btn-warning btn-block">
						保存
					</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
			$(document).ready(function() {
					$('#summernote').summernote({
						height: "500px",
						lang:"zh-CN",
						toolbar: [
						    ['style', ['style']],
						    ['color', ['color']],
						    ['font', ['bold', 'underline', 'clear']],
						    ['para', ['ul', 'paragraph']],
						    ['table', ['table']],
						    ['insert', ['link', 'picture']],
						    ['misc', ['codeview', 'fullscreen']]
						]
					});
				});
				var postForm = function() {
					var content = $('textarea[name="content"]').html($('#summernote').code());
				}
				</script>
<?php mc_template_part('footer'); ?>