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
	exit('Access Defined!');
}
//防止恶意调用
//数据库
// define('DB_USER', 'root');
// define('DB_PASSWORD', 'newpass');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'testguest');
// $conn = @mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or 
// 		die(' 数据库连接失败！错误信息：'.mysql_error());
// 		mysql_select_db(DB_NAME)or die('数据库找不到！错误信息:'.mysql_error());
// 		$query1=mysql_query("SET NAMES UTF8") or die('字符集设置错误');
// 		//测试

function _connect(){
	//表示全局变量将此变量在函数外部也可以访问
	global $_conn;
		if(!$_conn=@mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)){
			exit('数据库连接失败');
		}
	}
function _select_db(){
	if(!$_conn=@mysql_select_db(DB_NAME)){
			exit('数据库找不到');
		}
}
function _set_names(){
	if(!$_conn=@mysql_query("SET NAMES UTF8")){
			exit('字符集设置错误');
		}
}

function _query($_sql){
	if(!$_result = mysql_query($_sql)){
		exit('SQL执行失败'.mysql_error());
	}
	return $_result;
}

function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

function _is_repeat($_sql,$_info){
	// echo $_sql;
	//echo $_info;
	 if(_fetch_array($_sql)){
		_alert_back($_info);
	 }
}
function _close(){
	if(!mysql_close()){
		exit('关闭异常');
	}	
}
?>