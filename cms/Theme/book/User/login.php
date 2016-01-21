<!DOCTYPE html>
<html>
<head>
<title><?php echo mc_title(); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo C('LIB_ASSETS_URL'); ?>/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/css/style.css" type="text/css" media="screen" />
<style>
<?php $site_color = mc_option('site_color'); if($site_color!='') : ?>
a {color: <?php echo $site_color; ?>;}
a:hover {color: #3f484f;}
.btn-warning {color: #fff;}
.btn-warning,
.btn-warning:hover {background-color:<?php echo $site_color; ?>; border-color: <?php echo $site_color; ?>;}
<?php endif; ?>

body{padding-top:0;}
#login .login-head {padding:15px;border-bottom:1px solid #e5e5e5;}
.login-box {width:300px;padding:15px;}
.login-third-btn a {display:inline-block;margin:0 30px;width:64px;height:64px}
</style>
<link href="<?php echo C('APP_ASSETS_URL'); ?>/css/media.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/html5shiv.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container" id="login">
	<div class="row">
		<div class="text-center login-head">
			<a href="<?php $site_url=mc_site_url();echo $site_url; ?>"><img src="<?php $site_logo=mc_option('logo');if($site_logo) echo $site_logo; else echo C('APP_ASSETS_URL').'/img/logo-s.png'; ?>"></a>
		</div>
		<div class="login-box center-block">
			<?php 
				$qqlogin = mc_option('loginqq');
				$wblogin = mc_option('loginweibo');
				if($qqlogin==2 || $wblogin==2):
			?>
			<div class="login-third">
				<div class="login-third-btn text-center">
					<?php if($qqlogin==2): ?>
					<a href="<?php echo $site_url; ?>/connect-qq/oauth/index.php"><img src="<?php echo C('APP_ASSETS_URL'); ?>/img/qqlogin.png"></a>
					<?php endif; if($wblogin==2): ?>
					<a href="<?php echo $site_url; ?>/connect-weibo/oauth/index.php"><img src="<?php echo C('APP_ASSETS_URL'); ?>/img/wblogin.png"></a>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			<form role="form" method="post" action="<?php echo U('user/login/submit'); ?>">
				<div class="form-group mt-10">
					<input type="text" name="user_name" class="form-control bb-0 input-lg" placeholder="账号">
					<input type="text" name="user_pass" class="form-control input-lg password" placeholder="密码">
					<p class="help-block">奇宝账号登录</p>
					<button type="submit" class="btn btn-warning btn-block btn-lg">立即登陆</button>
					<p class="help-block"><a href="<?php echo U('user/lostpass/index'); ?>">忘记密码？</a></p>
					<a href="<?php echo U('user/register/index'); ?>" class="btn btn-default btn-block btn-lg">注册账号</a>
				</div>
			</form>
		</div>
	</div>
	<div class="text-center login-foot">
		<p>Copyright <?php echo date('Y'); ?> <?php echo mc_option('site_name'); ?></p>
	</div>
</div>
</body>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jquery.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/placeholder.js"></script>
<script>
$(function() {
	$('input, textarea').placeholder();
});
</script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/cat.js"></script>
</html>