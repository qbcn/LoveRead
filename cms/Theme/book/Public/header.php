<!DOCTYPE html>
<html>
<head>
<title><?php echo mc_title(); ?></title>
<?php echo mc_seo(); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="qc:admins" content="441127777761121775636" />
<meta property="wb:webmaster" content="09bca2f9e53842a5" />
<link rel="icon" href="<?php $site_url = mc_site_url(); echo $site_url; ?>/favicon.ico" mce_href="<?php echo $site_url; ?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $site_url; ?>/favicon.ico" mce_href="<?php echo $site_url; ?>/favicon.ico" type="image/x-icon">
<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo C('LIB_ASSETS_URL'); ?>/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo C('LIB_ASSETS_URL'); ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/css/v02/style.css">
<style>
<?php $site_color = mc_option('site_color'); if($site_color!='') : ?>
a {color: <?php echo $site_color; ?>;}
a:hover {color: #3f484f;}
.btn-warning {color: #fff;}
.btn-warning,
.btn-warning:hover {background-color:<?php echo $site_color; ?>; border-color: <?php echo $site_color; ?>;}

#pro-list .thumbnail h4 a:hover,
.home-side .media-heading a:hover {color: #3f484f;}

.label-warning,
#home-top .carousel-indicators .active,
#topnav .navbar-right .count,
#topnav .navbar-right a:hover .count,
#topnav .dropdown-menu > li > a:hover,
#single-top #pro-index-tlin .carousel-indicators li.active,
#instantclick-bar,
.pro-par-list label.active,
#single .wish-bottom span,
::-webkit-scrollbar-thumb:vertical:hover {background-color: <?php echo $site_color; ?>;}

#user-nav a:hover,
#user-nav li.active > a,
#user-nav > li.active > a:hover,
#user-nav > li.active > a:focus,
.home-main h4.title > i,
#site-control,
#backtotop:hover,
#total span,
#checkout .input-group-addon,
#total-true span,
#pub-imgadd i {color: <?php echo $site_color; ?>;}

#post-list-default .list-group-item > .row {border-left-color: <?php echo $site_color; ?>;}

#group-side ul.nav-stacked li.active a,
#group-side ul.nav-stacked a:hover,
#pro-index-trin .btn-group button.add-cart,
.pagination > li > a:hover,
.pagination > .active > a,
.pagination > .active > a:hover,
.pagination > .active > a:focus,
#app-weixin-side .active {background-color: <?php echo $site_color; ?>; border-color: <?php echo $site_color; ?>; }
<?php endif; ?>

<?php $site_logo=mc_option('logo');if($site_logo) : ?>
.modal .modal-header {background-image:url(<?php echo $site_logo; ?>);}
<?php endif; ?>

.login-third-btn a {display:inline-block;margin:0 30px;width:64px;height:64px}
</style>
<link href="<?php echo C('APP_ASSETS_URL'); ?>/css/v02/media.css" rel="stylesheet">
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jquery.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/html5shiv.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/respond.min.js"></script>
<![endif]-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?3878e1df9c1738a0df56de2f654c7c0a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</head>
<body>
<a id="site-top"></a>
<nav id="topnav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-top-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a <?php if($site_logo) echo 'style="background-image:url('.$site_logo.');"'; ?> class="navbar-brand" href="<?php echo $site_url; ?>"></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-top-navbar-collapse">
			<ul class="nav navbar-nav" id="bs-top-navbar-nav">
				<li>
					<a href="<?php echo $site_url; ?>">
						首页
					</a>
				</li>
				<li>
					<a href="<?php echo U('pro/index/index'); ?>">
						儿童书库
					</a>
				</li>
				<?php $terms_article = M('page')->where('type="term_article"')->order('id desc')->select(); if($terms_article) : ?>
				<?php foreach($terms_article as $val) : ?>
				<li>
					<a href="<?php echo U('article/index/term?id='.$val['id']); ?>">
						<?php echo $val['title']; ?>
					</a>
				</li>
				<?php endforeach; else : ?>
				<li>
					<a href="<?php echo U('article/index/index'); ?>">
						文章
					</a>
				</li>
				<?php endif; ?>
				<li>
					<a href="<?php echo U('post/group/index'); ?>">
						话题
					</a>
				</li>
				<?php $nav = M('option')->where("type='nav'")->order('id asc')->select(); foreach($nav as $val) : ?>
				<li>
					<a href="<?php echo $val['meta_value']; ?>">
						<?php echo $val['meta_key']; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#" data-toggle="modal" data-target="#searchModal">
						<i class="fa fa-search"></i>
					</a>
				</li>
				<?php if(mc_user_id()) { ?>
				<li>
					<a href="<?php echo U('user/index/index?id='.mc_user_id()); ?>">
						<i class="fa fa-user"></i>
						<?php $trends=mc_user_trend_count(); if($trends) : ?><span class="count"><?php echo $trends; ?></span><?php endif; ?>
					</a>
				</li>
				<?php if(mc_is_admin()) : ?>
				<li>
					<a target="_blank" href="<?php echo U('control/index/index'); ?>">
						<i class="fa fa-cogs"></i>
					</a>
				</li>
				<?php endif; ?>
				<li class="dropdown">
					<a href="#" data-toggle="modal" data-target="#qiandaoModal">
						<i class="fa fa-money"></i>
					</a>
				</li>
				<?php if(mc_option('pro_close')!=1) : ?>
				<li>
					<a href="<?php echo U('pro/cart/index'); ?>">
						<i class="fa fa-shopping-cart"></i>
						<span class="count"><?php echo mc_cart_count(); ?></span>
					</a>
				</li>
				<?php endif; ?>
				<li>
					<a href="javascript:;" id="head-logout-btn">
						<i class="fa fa-power-off"></i>
					</a>
				</li>
				<?php } else { ?>
				<li>
					<a href="#" data-toggle="modal" data-target="#loginModal">
						登陆
					</a>
				</li>
				<li>
					<a href="#" data-toggle="modal" data-target="#registerModal">
						注册
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<span class="bg"></span>
</nav>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<form id="searchform" role="form" method="get" action="<?php echo $site_url; ?>">
					<input id="search-type" type="hidden" name="type" value="pro">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span id="search-type-text">书库</span>
									<span class="caret">
									</span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="javascript:search_type('pro','书库');">
											书库
										</a>
									</li>
									<li>
										<a href="javascript:search_type('article','文章');">
											文章
										</a>
									</li>
									<li>
										<a href="javascript:search_type('post','话题');">
											话题
										</a>
									</li>
								</ul>
							</div>
							<!-- /btn-group -->
							<input name="keyword" type="text" class="form-control input-lg" placeholder="请输入搜索内容～～">
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-search"></i>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php if(mc_user_id()) : ?>
<div class="modal fade" id="qiandaoModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div id="mycoins" class="text-center">
					<h4>我的积分：<span id="mycoinscount"><?php echo mc_coins(mc_user_id()); ?></span></h4>
					<p><a href="<?php echo U('user/index/coins?id='.mc_user_id()); ?>">查看积分记录</a></p>
					<p>每日签到最多可获得<span class="text-danger">3</span>积分！</p>
					<?php if(mc_is_qiandao()) : ?>
					<a href="javascript:;" id="qiandao" class="btn btn-warning mb-10">已签到</a>
					<?php else : ?>
					<a href="javascript:mc_qiandao();" id="qiandao" class="btn btn-warning mb-10">签到</a>
					<script>
					function mc_qiandao() {
						$.ajax({
							url: '<?php echo U('home/perform/qiandao'); ?>',
							type: 'GET',
							dataType: 'html',
							timeout: 9000,
							error: function() {
								alert('提交失败！');
							},
							success: function(html) {
								var count = $('#mycoinscount').text()*1+3;
								$('#mycoinscount').text(count);
								$('#qiandao').attr('href','javascript:;');
								$('#qiandao').text('已签到');
							}
						});
					};
					</script>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else : ?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
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
						<input type="text" name="user_name" class="form-control bb-0 input-lg" placeholder="账号" value="<?php echo cookie('user_name'); ?>">
						<input type="text" name="user_pass" class="form-control input-lg password" placeholder="密码">
						<p class="help-block">奇宝账号登录</p>
						<button type="submit" class="btn btn-warning btn-block btn-lg">立即登陆</button>
						<p class="help-block"><a href="<?php echo U('user/lostpass/index'); ?>">忘记密码？</a></p>
						<a href="<?php echo U('user/register/index'); ?>" class="btn btn-default btn-block btn-lg">注册账号</a>
					</div>
					<input type="hidden" name="comefrom" value="<?php echo mc_page_url(); ?>">
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<form role="form" method="post" action="<?php echo U('user/register/submit'); ?>">
					<div class="form-group">
						<input type="text" name="user_name" class="form-control bb-0 input-lg" placeholder="账号">
						<input type="email" name="user_email" class="form-control bb-0 input-lg" placeholder="邮箱">
						<input type="text" name="user_pass" class="form-control bb-0 input-lg password" placeholder="密码">
						<input type="text" name="user_pass2" class="form-control input-lg password" placeholder="重复密码">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-warning btn-block btn-lg">立即注册</button>
						<p class="help-block">已有账号<a href="<?php echo U('user/login/index'); ?>">请此登陆</a></p>
					</div>
					<input type="hidden" name="comefrom" value="<?php echo mc_page_url(); ?>">
					<?php 
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
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- Modal -->
<form method="post" class="inline" id="head-logout" action="<?php echo U('user/login/logout'); ?>">
	<input type="hidden" name="logout" value="ok">
</form>
<script>
$(function(){
	$('#head-logout-btn').click(function(){
		$('#head-logout').submit();
	});
});
</script>