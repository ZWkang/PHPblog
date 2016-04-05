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
	//选择数据库
function _select_db(){
	if(!$_conn=@mysql_select_db(DB_NAME)){
			exit('数据库找不到');
		}
}
//设置字符集
function _set_names(){
	if(!$_conn=@mysql_query("SET NAMES UTF8")){
			exit('字符集设置错误');
		}
}
//执行sql语句返回结果集
function _query($_sql){
	if(!$_result = mysql_query($_sql)){
		exit('SQL执行失败'.mysql_error());
	}
	return $_result;
}
/**
 * _fetch_array只能获取一条数据组
 */
function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

/**
 * _fetch_array_list使用结果集而不是sql语句来使用取得返回结果集
 * 用于循环，可以返回结果集里面的所有数据
 * {data()};
 */
function _fetch_array_list($_result){
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}
/**
 * _free_result() 销毁大量的结果集
 * @param $_result()要销毁的结果集
 */
function _free_result($_result){
	return mysql_free_result($_result);

}

/**
*_affected_rows表示影响的记录条数
*
*/
function _affected_rows(){
	return mysql_affected_rows();
}
/**
 * _num_rows返回查询结果集的行数
 */
function _num_rows($_result){
	return mysql_num_rows($_result);
}
/**
 * _is_repeat 用于查询数据库语句，如果有匹配则输出一句话
 * @param $_sql sql语句
 * @param $_info 一句话
 */
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