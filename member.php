<?php	
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
if(isset($_COOKIE['username'])){
	//获取数据
	$_rows = _fetch_array("SELECT * FROM tg_user WHERE tg_username = '{$_COOKIE['username']}'");
	if($_rows){
		$_html= array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_face'];
		$_html['qq'] = $_rows['tg_qq'];
		$_html['url'] = $_rows['tg_url'];
		$_html['reg_time'] = $_rows['tg_reg_time'];
		$_html['email'] = $_rows['tg_email'];
		$_html['level'] = $_rows['tg_level'];
		switch ($_html['level']) {
			case '0':
				$_html['level']='普通会员';
				break;
			case '1':
				$_html['level']='管理员';
				break;
			default:
				$_html['level']='出错了';
				break;
		}
		$_html = _html($_html);
	}
	else{
		echo "此用户不存在";
	}
}else{
	_alert_back('非法登陆');

}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>博友首页</title>
<link rel="stylesheet" href="styles/1/member.css">
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
	
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
	echo "\n";
?>
	<div id="member"><?php
	require_once ROOT_PATH.'includes/member.inc.php';
	?>
		<div id="member-main">
			<h2>会员管理中心</h2>
			<dl>
				<dd>用 户 名:<?php echo $_html['username'];?></dd>
				<dd>性    别:<?php echo $_html['sex'];?></dd>
				<dd>头    像:<?php echo $_html['face']?></dd>
				<dd>电子邮件:<?php echo $_html['email']?></dd>
				<dd>主    页:<?php echo $_html['url']?></dd>
				<dd>Q      Q:<?php echo $_html['qq']?></dd>
				<dd>注册时间:<?php echo $_html['reg_time']?></dd>
				<dd>身    份:<?php echo $_html['level']?></dd>
			</dl>
		</div>
	</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>