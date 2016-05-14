<?php	
session_start();
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_modify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
//修改资料
if(@$_GET['action']=='modify'){
	_check_code($_POST['code'],$_SESSION['code']);
	if(!!$_rows= _fetch_array("SELECT tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
								LIMIT 1"))
		{
		//以防cookie伪造还有比对唯一标识符
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//引入验证文件
		include_once ROOT_PATH.'includes/check.func.php';
			//可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
			//创建一个空数组，用来存放提交过来的合法数据
		$_clean = array();
		$_clean['password']=_check_modify_password($_POST['password'],6);
		$_clean['email']=_check_email($_POST['email'],6,40);
		$_clean['qq']=_check_qqNumber($_POST['qq']);
		$_clean['url']=_check_url($_POST['url'],40);
		$_clean['sex']=_check_sex($_POST['sex']);
		$_clean['face']=_check_face($_POST['face']);

		//修改资料
		if(empty($_clean['password'])){
			_query("UPDATE tg_user SET 
				tg_face='{$_clean['face']}',
				tg_sex = '{$_clean['sex']}',
				tg_email='{$_clean['email']}',
				tg_qq='{$_clean['qq']}',
				tg_url='{$_clean['url']}'
			WHERE 
				tg_username='{$_COOKIE['username']}'
				");
		}else{
			_query("UPDATE tg_user SET 
				tg_password='{$_clean['password']}',
				tg_face='{$_clean['face']}',
				tg_sex = '{$_clean['sex']}',
				tg_email='{$_clean['email']}',
				tg_qq='{$_clean['qq']}',
				tg_url='{$_clean['url']}'
			WHERE 
				tg_username='{$_COOKIE['username']}'
				");
		}
	}
	//判定是否修改成功
	if(_affected_rows()==1){
					_close();
					//跳转
					_session_destroy();
					_location('恭喜你修改成功','member.php');}
				else{
					_close();
					//跳转
					_session_destroy();
					_location('so sorry . nothing chanage ','member_modify.php');
	}

}


if(isset($_COOKIE['username'])){
	//获取数据
	$_rows = _fetch_array("SELECT * FROM tg_user WHERE tg_username = '{$_COOKIE['username']}'LIMIT 1");
	if($_rows){
		$_html= array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_face'];
		$_html['qq'] = $_rows['tg_qq'];
		$_html['url'] = $_rows['tg_url'];
		$_html['reg_time'] = $_rows['tg_reg_time'];
		$_html['email'] = $_rows['tg_email'];
		$_html = _html($_html);
		//性别选择
		if($_html['sex'] =='男'){
			$_html['sex_html'] = '<input type="radio" name="sex" value="男" checked ="checked" />男 <input type="radio" name="sex" value="女"/>女';
		} elseif($_html['sex']=='女'){
			$_html['sex_html'] = '<input type="radio" name="sex" value="男"/>男 <input type="radio" name="sex" value="女" checked ="checked" />女';
		}
		//头像选择
		$_html['face_html']='<select name="face">';
		foreach (range(1, 9) as $_Number){
			$_html['face_html'].='<option value="face/m0'.$_Number.'.gif">face/m0'.$_Number.'.gif</option>';
		}
		foreach (range(10, 64) as $_Number){
			$_html['face_html'].='<option value="face/m'.$_Number.'.gif">face/m'.$_Number.'.gif</option>';
		}
		$_html['face_html'].='</select>';
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
<title>博友--个人中心</title>
<link rel="stylesheet" href="styles/1/member.css">
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/member_modify.js"></script>
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
			<form method="post" action="?action=modify">
				<dl>
					<dd>用 户 名:<?php echo $_html['username']?></dd>
					<dd>密&nbsp;&nbsp;码:<input type="password" name="password" class="text" />(留空则不修改)</dd>
					<dd>性    别:<?php echo $_html['sex_html'];?></dd>
					<dd>头    像:<?php echo $_html['face_html']?></dd>
					<dd>电子邮件:<input type="text" class="text" name= "email" value="<?php echo $_html['email']?>"/></dd>
					<dd>主    页:<input type="text" class="text" name= "url" value="<?php echo $_html['url']?>"/></dd>
					<dd>Q      Q:<input type="text" class="text" name= "qq" value="<?php echo $_html['qq']?>"/></dd>
					<dd>验证码&nbsp;:<input type="text" name="code"class="text yzm" />&nbsp;&nbsp;<img src="code.php" id="code"></img></dd>
					<dd><input type="submit" class="submit" value="修改资料"/></dd>
				</dl>
			</form>
		</div>
	</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>