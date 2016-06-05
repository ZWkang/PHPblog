<?php
//defined判断一个常量是否存在
//定义一个常量用来授权调用includes里面的文件
define('IN_TG', true);
/*定义一个常量用来确定本页内容
 *确定只能某些页面调用的时候使用
 */
define('SCRIPT', 'q');
//引用公共文件
require_once dirname(__FILE__).'/includes/common.inc.php';

//初始化
if (isset($_GET['num']) && isset($_GET['path'])) {
	if (!is_dir(ROOT_PATH.$_GET['path'])) {
		_alert_back('非法操作');
	}
	
} else {
	_alert_back('非法操作');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言系统--Q图选择</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<script type="text/javascript" src="js/qopener.js"></script>
<body>

<div id="q">
	<h3>选择Q图</h3>
	<dl>
		<?php foreach (range(1,$_GET['num']) as $_num) {?>
		<dd><img src="<?php echo $_GET['path'].$_num?>.gif" alt="<?php echo $_GET['path'].$_num?>.gif" title="头像<?php echo $_num?>" /></dd>
		<?php }?>
		
	</dl>
</div>
</body>
</html>