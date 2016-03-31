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

//从数据库提取数据获取结果集
//每次重新读取结果集而不是每次重新执行sql语句
$_result = _query("SELECT tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_reg_time DESC");


?>

<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>博友首页</title>
<link rel="stylesheet" href="styles/1/blog.css">
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
	
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
	
	<div id="blog">
		<h2>博友列表</h2>
		<?php while(!!$_rows = _fetch_array_list($_result,MYSQL_ASSOC)){?>
	<dl>
				<dd class="user"><?php echo $_rows['tg_username'].'('.$_rows['tg_sex'].')'?></dd>
				<dt><img src="<?php echo $_rows['tg_face'];?>" alt="<?php echo $_rows['tg_username'];?>"></dt>
				<dd>发消息</dd>
				<dd>加为好友</dd>
				<dd>写短信</dd>
				<dd>送花</dd>
			</dl>
		<?php }?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>