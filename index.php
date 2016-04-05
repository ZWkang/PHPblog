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
//defined判断一个常量是否存在
//定义一个常量用来授权调用includes里面的文件
define('IN_TG', true);
/*定义一个常量用来确定本页内容
 *确定只能某些页面调用的时候使用
 */
define('SCRIPT', 'index');
//引用公共文件
require_once dirname(__FILE__).'/includes/common.inc.php';

//先导入这个含有常量的文件才能得到ROOT_PATH这个常量
//转换成硬路径速度更快
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言系统首页</title>
<?php 
	require_once ROOT_PATH.'includes/title.inc.php';
	
?>
</head>
<body>
<?php 
	require_once ROOT_PATH.'includes/header.inc.php';
?>
	
	<div id="list">
		<h2>帖子列表</h2>
	</div>	
	<div id="user">
		<h2>新进会员</h2>
	</div>
	<div id="pics">
		<h2>新增图片</h2>
	</div>
<?php 
	require_once ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>