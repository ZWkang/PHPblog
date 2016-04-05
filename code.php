<?php
/**
* TestGuest Version2.0
* ================================================
* Copy 2015 kang
* Web: localhost
* ================================================
* Author: kang
* Date: 2015-11-28
*/
//使用session前开启session的功能
session_start();
define('IN_TG', true);
require_once dirname(__FILE__).'/includes/common.inc.php';
//引入公共文件
	
	//运行验证码函数
	_code();
	//默认验证码大小是:75*25，默认个数是4个
	//四个参数，依次是宽高个数 是否要边框(true or false)
?>