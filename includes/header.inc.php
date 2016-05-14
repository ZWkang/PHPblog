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
global $_message_html;
//防止恶意调用
?>
	<div id="header">
		<h1><a href="index.php">wenkangwenkang</a></h1>
		<ul>
			<li><a href="index.php">首页</a></li>
			<?php
				if(isset($_COOKIE['username'])){
					echo '<li><a href="member.php">'.$_COOKIE['username'].':个人中心</a>'.$_message_html.'</li>';
					echo "\n";
					echo '<li><a href="blog.php">博友</a></li>';
				}else{
					echo '<li><a href="register.php">注册</a></li>';
					echo "\n";
					echo "\t\t\t";
					echo '<li><a href="login.php">登录</a></li>';
					echo "\n";
				}
			?>
			<li>管理</li>
			
			<li>风格</li>
			<?php
				if(isset($_COOKIE['username'])){
					echo '<li><a href="logout.php">退出</a></li>';
				}
			?>

		</ul>
	</div>	