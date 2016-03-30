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
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','blog');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';




?>

<!doctype html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>博友首页</title>
	<?php 
		require ROOT_PATH.'includes/title.inc.php';
	?>
	<link rel="stylesheet" href="styles/1/blog.css">
</head>
<body>
	<?php 
		require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="blog">
		<h2>博友列表</h2>
		<?php  for($i=1;$i<30;$i++){ ?>
		<dl>
			<dd class="user">周文康啊</dd>
			<dt><img src="face/m<?php if($i<10)
			{echo "0".$i;}
			else
				{echo $i;}
			?>.gif" alt="周文康啊"></dt>
			<dd>发消息</dd>
			<dd>加为好友</dd>
			<dd>写短信</dd>
			<dd>送花</dd>
		</dl>
		<?php }?>
		<div id="page">
			
		</div>
	</div>

	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>
</body>
</html>