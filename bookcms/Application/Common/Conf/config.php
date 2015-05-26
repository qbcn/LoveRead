<?php
return array(
	'DB_PREFIX' => 'qb_', // 数据库表前缀
	'DB_CHARSET' => 'utf8', //数据库编码
	'DEFAULT_MODULE' => 'Home', //默认模块
	'URL_MODEL' => '2', //URL模式
	'DEFAULT_FILTER' => 'htmlspecialchars',//输入过滤
	'SESSION_AUTO_START' => true, //是否开启session
	'URL_PATHINFO_DEPR'=>'-', //更改PATHINFO参数分隔符
	'TMPL_TEMPLATE_SUFFIX' => '.php', //更改模板文件后缀
	'TMPL_ENGINE_TYPE' => 'PHP', //自定义模板引擎
	'DEFAULT_THEME' => 'default', //开支多模板支持，设置默认模板目录为default
	'TMPL_LOAD_DEFAULTTHEME' => true, //开启差异主题定义方式，当前模板无对应文件时，会自动调用默认模板文件
	'VIEW_PATH' => THINK_PATH.'../Theme/', //指定模板目录
	'TMPL_ACTION_ERROR' => THINK_PATH.'../Theme/mc_jump.php', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => THINK_PATH.'../Theme/mc_jump.php', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE' => THINK_PATH.'../Theme/mc_exception.php',// 异常页面的模板文件
	'URL_ROUTER_ON' => true, 
	'URL_ROUTE_RULES'=>array(
		'/^(\d+)$/' => 'Index/single?id=:1',
	),
	'UPLOAD_CLOUD_PATH' => '/cn-qb',
	'APP_ASSETS_URL' => 'http://cdn.qibaowu.cn/assets',
	'LIB_ASSETS_URL' => 'http://a.qibaowu.cn/lib'
);