<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_message_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
	_alert_back('请先登录');
}
//删除短信
if(@$_GET['action']=='delete' && isset($_GET['id'])){
	//验证短信是否合法
	if(!!$_rows = _fetch_array("SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}'")){
		//危险操作要对唯一标识符进行验证
			if(!!$_rows2= _fetch_array("SELECT tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
								LIMIT 1"))
			{
			//以防cookie伪造还有比对唯一标识符
			_uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);

			//全部认证成功之后删除单短信
			_query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1");
				if(_affected_rows()==1){
						_close();
						//跳转
						_session_destroy();
						_location('恭喜你删除成功','member_message.php');
					}
				else{
						_close();
						//跳转
						_session_destroy();
						_alert_back('此短信删除失败');
					}	
				}
	}else{
		_alert_back('此短信不存在无法删除');
	}

}

//处理id
if(isset($_GET['id'])){
	$_rows = _fetch_array("SELECT tg_fromuser,tg_content,tg_date,tg_id,tg_state FROM tg_message WHERE tg_id='{$_GET['id']}'");
	if($_rows){
		//将它的state状态设置为1
		if(empty($_rows['tg_state'])){
			_query("UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1");
			if(!_affected_rows()){
				_alert_back("处理异常");
			}
		}

		$_html=array();
		$_html['id'] = $_rows['tg_id'];
		$_html['fromuser'] = $_rows['tg_fromuser'];
		$_html['content'] = $_rows['tg_content'];
		$_html['date'] = $_rows['tg_date'];
	}else{
		_alert_back('此短信不存在');
	}
}else{
	_alert_back('非法登录');
}
?>


<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>短信详情查看中心</title>
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
	<script type="text/javascript" src="js/member_message_detail.js"></script>
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
			<h2>短信管理中心</h2>
			<dl>
				<dd>发信人:<?php echo $_html['fromuser'];?></dd>
				<dd>内容:<strong><?php echo $_html['content'];?></strong></dd>
				<dd>发信时间:<?php echo $_html['date'];?></dd>
				<dd class="button"><input type="button" value="返回列表" id="return" /> <input type="button" name="<?php echo $_html['id'];?>"value="删除短信" id="delete"/></dd>
			</dl>
		</div>
	</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>