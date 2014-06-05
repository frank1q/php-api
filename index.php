<?php

	define('APP_NAME', 'index');
	define('APP_PATH', './index/');

	define('APP_DEBUG', true);

	define('CONF_PATH', './Conf/');

	header("Content-type: text/html; charset=utf-8"); 

	// tp的核心文件
	require './ThinkPHP/ThinkPHP.php';

?>