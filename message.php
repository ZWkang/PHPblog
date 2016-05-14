<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
	_alert_close('请先登录');
}
//写短信
if(@$_GET['action']=='write'){
	_check_code($_POST['code'],$_SESSION['code']);
	if(!!$_rows= _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
		//以防cookie伪造还有比对唯一标识符
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		$_clean['touser']=$_POST['touser'];
		$_clean['fromuser']=$_COOKIE['username'];
		$_clean['content'] = _check_content($_POST['content']);
		$_clean=_mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_message (
										tg_touser,
										tg_fromuser,
										tg_content,
										tg_date
										) 
								VALUES(
										'{$_clean['touser']}',
										'{$_clean['fromuser']}',
										'{$_clean['content']}',
										NOW()
										)"
		);
		//判断是否新增成功
		if(_affected_rows()==1){
						_close();
						//跳转
						_session_destroy();
						_alert_close('恭喜你短信发送成功');}
				else{
						_close();
						//跳转
						_session_destroy();
						_alert_back('很遗憾，短信发送失败');
					}
	}else
		{
			_alert_close('非法登录');
		}
}
//获取数据
if(isset($_GET['id'])){
	if(!!$_rows = _fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")){
		$html = array();
		$_html['touser'] = $_rows['tg_username'];
		$_html = _html($_html);
	}else{
		_alert_close('不存在此用户');
	}
}else
{
	_alert_close('非法操作');
}
?>


<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>博客发送短信息</title>
<link rel="stylesheet" href="styles/1/blog.css">
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>

</head>
<body>

	<div id="message">
		<h3>写短信</h3>
		<form action="?action=write" method="POST">
			<input type="hidden" name="touser" value="<?php echo $_html['touser'];?>">
			<dl>
				<dd><input type="text" readonly="readonly" class="text" value="TO:<?php echo $_html['touser'];?>"/></dd>
				<dd><textarea name="content" id="" cols="30" rows="10"></textarea></dd>
				<dd>验证码 : <input type="text" name="code" class="text yzm" /><img class="code" id="code" src="code.php" alt="验证码" /><input type="submit" class="submit" value="发送短信" /></dd>
			</dl>
		</form>
	</div>
</body>
</html>