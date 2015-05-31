<?php
return array(
	'LOAD_EXT_CONFIG' => 'db',
	'DB_PREFIX' => 'qb_', // 数据库表前缀
	'DB_CHARSET' => 'utf8', //数据库编码
	'DEFAULT_MODULE' => 'Home', //默认模块
	'URL_MODEL' => '1', //URL模式
	'DEFAULT_FILTER' => 'htmlspecialchars',//输入过滤
	'SESSION_AUTO_START' => true, //是否开启session
	'URL_PATHINFO_DEPR'=>'-', //更改PATHINFO参数分隔符
	'TMPL_TEMPLATE_SUFFIX' => '.php', //更改模板文件后缀
	'TMPL_ENGINE_TYPE' => 'PHP', //自定义模板引擎
	'APP_ASSETS_URL' => 'http://cdn.qibaowu.cn/assets',
	'LIB_ASSETS_URL' => 'http://a.qibaowu.cn/lib'
);