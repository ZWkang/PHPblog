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

//定义一个常量用来授权调用includes里面的文件
define('IN_TG', true);
/*定义一个常量用来确定本页内容
 *确定只能某些页面调用的时候使用
 */
define('SCRIPT', 'face');
//引用公共文件
require_once dirname(__FILE__).'/includes/common.inc.php';

//print_r(range(1, 10));
/*1-10循环
*foreach (range(1, 9) as $Number){
*	echo $Number;
*}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头像选择</title>
<?php 
	require_once ROOT_PATH.'includes/title.inc.php';
	
?>
<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>
	<div id="face">
		<h3>选择头像</h3>
		<dl>
		<?php 
			foreach (range(1, 9) as $Number){?>
			
			<dd><img src="face/m0<?php echo $Number;?>.gif" alt="face/m0<?php echo $Number;?>.gif"title="头像<?php echo $Number?>" /></dd>
		<?php }?>
		<?php 
			foreach (range(10, 64) as $Number){?>
			
			<dd><img src="face/m<?php echo $Number;?>.gif" alt="face/m<?php echo $Number;?>.gif"title="头像<?php echo $Number?>" /></dd>
		<?php }?>
		
		</dl>
	</div>











	



</body>
</html>