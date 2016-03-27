<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 kang
* Web: localhost
* ================================================
* Author: kang
* Date: 2015-11-29
*/
session_start();
//定义个常量，用来授权调用includes里面的文件
header('Content-Type:text/html;charset=utf-8');
//定义页面字符集
define('IN_TG', true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'register');
//引入公共文件
require_once dirname(__FILE__).'/includes/common.inc.php';

// mysql_query("INSERT INTO tg_user(tg_username) VALUES('kang')") or die(mysql_error());

//判断是否提交了
if (@$_GET['action']=='register'){
	//为了防止恶意注册，跨站攻击
	//判断是否有验证码的提交
	if ($_POST['code'])
	{
		_check_code($_POST['code'],$_SESSION['code']);
		//引入验证文件
		include_once ROOT_PATH.'includes/register.func.php';
		//可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
		//创建一个空数组，用来存放提交过来的合法数据
		$_clean=array();
		//可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
		//这个存放入数据库的唯一标识符还有第二个用处，就是登录cookies验证
		$_clean['uniqid']=_check_uniqid($_SESSION['uniqid'],$_POST['uniqid']);
		//active也是一个唯一标识符，用来刚注册的用户进行激活处理，方可登录。
		$_clean['active']=_sha1_uniqid();
		//active也是一个唯一标识符，用来刚注册的用户进行激活处理，方可登录。
		$_clean['username']=_check_form($_POST['username'],2,20);
		$_clean['password']=_check_password($_POST['passwd'], $_POST['notpassword'], 6);
		$_clean['question']=_check_question($_POST['question'],4,20);
		$_clean['answer']=_check_answer($_POST['question'],$_POST['answer'],4,20);
		$_clean['email']=_check_email($_POST['email'],6,40);
		$_clean['qq']=_check_qqNumber($_POST['qq']);
		$_clean['url']=_check_url($_POST['url'],40);
		$_clean['sex']=_check_sex($_POST['sex']);
		$_clean['face']=_check_face($_POST['face']);
		////		echo $_username=_strChange($_POST['username']);
		//新增前要判断是否有重复
		//$query=_query("SELECT tg_usernsssame FROM tg_user WHERE tg_username='{$_clean['username']}'");
		// if (_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'")) {
		// 	_alert_back('此用户已被注册');
		// }

		_is_repeat(
				"SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'",
				'对不起。此用户已被注册'
			);
		//新增用户
		//在双引号里，直接放变量是可以的，比如$_username,但如果是数组，就必须加上{} ，比如 {$_clean['username']}
		if (count($_clean)==11) {
				_query(
				"INSERT INTO tg_user(
							tg_uniqid,
							tg_active,
							tg_username,
							tg_password,
							tg_question,
							tg_answer,
							tg_sex,
							tg_face,
							tg_email,
							tg_qq,
							tg_url,
							tg_reg_time,
							tg_last_time,
							tg_last_ip) 
						VALUES(
							'{$_clean['uniqid']}',
							'{$_clean['active']}',
							'{$_clean['username']}',
							'{$_clean['password']}',
							'{$_clean['question']}',
							'{$_clean['answer']}',
							'{$_clean['sex']}',
							'{$_clean['face']}',
							'{$_clean['email']}',
							'{$_clean['qq']}',
							'{$_clean['url']}',
							NOW(),
							NOW(),
							'{$_SERVER["REMOTE_ADDR"]}'
							)"
		);
			if(_affected_rows()==1){
					_close();
					//跳转
					_session_destroy();
					_location('恭喜你注册成功','active.php?active='.$_clean['active']);}
			else{
					_close();
					//跳转
					_session_destroy();
					_location('很遗憾，注册失败','register.php');
				}
			//echo _affected_rows();
			//测试这个函数是否有用
		}
	}else _alert_back('请输入验证码 ');
}else{
$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}
//sha1(uniqid(rand(),true))设置唯一标识符
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言系统--注册</title>
<?php 
	require_once ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php 
	require_once ROOT_PATH.'includes/header.inc.php';
?>
	
	<div id="register" >
		<h2>会员注册咯</h2>
		<form method="post" name="register" action="register.php?action=register">
		<dl>
			<input type="hidden"  name="uniqid" value="<?php echo @$_uniqid;?>"/>
			<dt>请认真填写以下信息</dt>
			<dd><input type="hidden" name="action" value="register"/></dd>
			<dd>用 户 名:<input type="text" name="username" class="text" />(*必填,至少两位)</dd>
			<dd>密&nbsp;&nbsp;码:<input type="password" name="passwd"class="text" />(*必填,至少六位)</dd>
			<dd>确认密码:<input type="password" name="notpassword"class="text" />(*必填,同上)</dd>
			<dd>密码提示:<input type="text" name="question"class="text" />(*必填,至少两位)</dd>
			<dd>密码回答:<input type="text" name="answer"class="text" />(*必填,至少两位)</dd>
			<dd>性     别:<input type="radio" name="sex" value="男" checked="checked"/>男<input type="radio" name="sex" value="女" checked="checked"/>女</dd>
			<dd class="face"><input type="hidden" name="face" value="face/m01.gif" />
			<img src="face/m01.gif" alt="头像选择" id="faceimg"/></dd>
			<dd>电子邮件:<input type="text" name="email"class="text" />(必填)</dd>
			<dd>&nbsp;Q&nbsp;&nbsp;Q&nbsp;:<input type="text" name="qq"class="text" /></dd>
			<dd>主页地址:<input type="text" name="url"class="text" value="http://"/></dd>
			<dd>验&nbsp;证&nbsp;码:<input type="text" name="code"class="text yzm" /><img src="code.php" id="code"></img></dd>
			<dd><input type="submit" class="submit" value="注册"/></dd>
		</dl>
		</form>
	</div>


<?php
	require_once ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>