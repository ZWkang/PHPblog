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
if (!defined('IN_TG')){
	exit('woriing');
}
if(!function_exists('_mysql_string')){
	exit('_mysql_string函数不存在请检查');
}

//防止恶意调用
header('Content-Type:text/html;charset=utf-8');


if (!function_exists('_alert_back')){
			echo "<script>alert ('函数不存在请检查!');histroy.back(-1);</script>";
}
/**
*设置cookie值
*
*
*/
function _setcookies($_username,$_uniqid,$_time){
	switch ($_time) {
		case '0'://浏览器进程
			setcookie('username',$_username);
			setcookie('uniqid',$_uniqid);
			break;
		case '1'://一天
			setcookie('username',$_username,time()+86400);
			setcookie('uniqid',$_uniqid,time()+86400);
			break;
		case '2'://一周
			setcookie('username',$_username,time()+86400*7);
			setcookie('uniqid',$_uniqid,time()+86400*7);
			break;
		case '3'://一月
			setcookie('username',$_username,time()+86400*30);
			setcookie('uniqid',$_uniqid,time()+86400*30);
			break;
	}
}


function _check_form($string,$_min_number,$_max_number){
	//去掉两边空格
	$_string = trim($string);
	
	//长度小于两位大于20位都不行
	$long=mb_strlen($_string,'utf-8');
	if(mb_strlen($long<$_min_number ||$long>$_max_number)){
		_alert_back('用户名长度小于'.$_min_number.'位大于'.$_max_number.'位');}
	
	return _mysql_string($_string);
	//将用户名转义输出
	//return  mysql_real_escape_string($_string);
}

function _check_password($_first_pass,$_min_number){
	//判断密码
	if(strlen($_first_pass)<$_min_number){
		_alert_back('密码不得小于'.$_min_number.'位');
	}
	
	//将密码返回
	return _mysql_string(sha1($_first_pass));
}

function _check_time($_string){
	$_time=array('0','1','2','3');
	if(!in_array($_string, $_time)){
		_alert_back('保留方式出错了');
	}
	return _mysql_string($_string);
}
?>