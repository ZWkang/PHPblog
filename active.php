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
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','active');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//开始激活处理
if(!isset($_GET['active'])){
	_alert_back('非法操作');
}
if(isset($_GET['action'])&& isset($_GET['active'])&& $_GET['action']=='ok'){
	$_active=_mysql_string($_GET['active']);
	if(_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")){
		//将active设置成空
		_query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if(_affected_rows()==1){
					_close();
					//跳转
					_location('账户激活成功跳转登录页面','login.php');
			}else {
				_close();
					//跳转注册页面
					_location('账户激活失败跳转注册界面','register.php');
			}


	}else{
		_alert_back('非法操作');

	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>激活</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
	<style>
		
	</style>
	<link rel="stylesheet" href="styles/1/active.css" type="text/css">
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
	<div id="active">
		<h2>激活账户</h2>
		<p>本页面是为了模拟您邮件的功能点击以下超链接激活您的账户</p>
		<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active'];?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']?>?action=ok&amp;active=<?php echo $_GET['active'];?></a></p>
	</div>




<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


