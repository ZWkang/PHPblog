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
header('Content-Type: text/html; charset=utf-8');
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//登录状态
_login_state(); 
//开始处理登录状态
if (@$_GET['action'] == 'login') {
	//验证码的验证
	_check_code($_POST['code'],$_SESSION['code']);
	include_once ROOT_PATH.'includes/login.func.php';
	//接受数据
	$_clean = array();
	$_clean['username']=_check_form($_POST['username'],2,20);
	$_clean['password']=_check_password($_POST['password'],6);
	$_clean['time']=_check_time($_POST['time']);
	//数据库验证
	if(!!$_rows = _fetch_array("SELECT tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")){
		_close();
		_session_destroy();
		_setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time']);
		_location(null,'index.php');
	}else{
		_close();
		_session_destroy();
		_location('用户名密码不正确或者未激活','login.php');
	}
}

?>
<!doctype html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
	<link rel="stylesheet" href="styles/1/login.css" type="text/css">
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

	<div id="login">
		<h2>登录</h2>
		<form  method="post" name="login" action="login.php?action=login">
			<div style="text-algin:center;">
			<dl>
				<dt>请填写用户名密码</dt>
				<dd>用户名: <input type="text" name="username" class="text"></dd>
				<dd>密&nbsp;码: <input type="password" name="password" class="text"></dd>
				<dd>保&nbsp;留:<input type="radio" name="time" value="0" checked="checked">不保留 
							<input type="radio" name="time" value="1" >一天 
							<input type="radio" name="time" value="2" >一周 
							<input type="radio" name="time" value="0" >一月 
				</dd>
				<div id="code1">
				<dd>验证码: <input type="text" name="code" class="text code" />&nbsp;&nbsp;&nbsp;<img src="code.php" id="code"></img></dd>
				</div>
				<dd><input type="submit" class="button" value="登录"><input type="submit" class="button" id="location" value="注册" class="button location" style="margin:0 0 0 10px;"></dd>
			</dl>
			</div>
		</form>
	</div>




<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


