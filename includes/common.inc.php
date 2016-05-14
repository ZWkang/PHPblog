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
//设置字符集编码
header('Content-Type: text/html; charset=utf-8');
//防止恶意调用
//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//创建一个自动转义状态的常量
define('GPC', get_magic_quotes_gpc());

//拒绝php低版本
if (PHP_VERSION<'4.1.0')
{
	exit('low');
}
//引入核心函数库
require_once ROOT_PATH.'includes/'.'global.inc.php';
require_once ROOT_PATH.'includes/'.'mysql.func.php';


//执行耗时
define('START_TIME',_runtime());
//$GLOBALS['start-time']=_runtime();

//数据库
define('DB_USER', 'root');
define('DB_PASSWORD', 'newpass');
define('DB_HOST', 'localhost');
define('DB_NAME', 'testguest');
//初始化数据库
_connect();   //连接MYSQL数据库
_select_db();   //选择指定的数据库
_set_names();   //设置字符集




//短信提醒
//count取得字段的总和
@$_message=_fetch_array("SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_touser='{$_COOKIE['username']}' AND tg_state=0");
if(empty($_message['count'])){
	$_message_html='<strong class="noread"><a href="member_message.php">(0)</a></strong>';
}
else{
	$_message_html='<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}





?>