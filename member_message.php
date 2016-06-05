<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
	_alert_back('请先登录');
}
//删除
if(@$_GET['action']=='delete' &&isset($_POST['ids'])){
	$_clean['ids']=_mysql_string(implode(',', $_POST['ids']));
		//验证短信是否合法
		//危险操作要对唯一标识符进行验证
			if(!!$_rows2= _fetch_array("SELECT tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
								LIMIT 1"))
			{
			//以防cookie伪造还有比对唯一标识符
			_uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
			_query("DELETE FROM tg_message WHERE tg_id in ({$_clean['ids']})");
				if(_affected_rows()){
						_close();
						//跳转
						_location('恭喜你删除成功','member_message.php');
					}
				else{
						_close();
						//跳转
						_alert_back('此短信删除失败');
					}	
			}else{
				_alert_back("非法登录");
			}
	exit;
}
//分页模块
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_message WHERE tg_touser='{$_COOKIE['username']}'",6);//第一个参数获取总的条数 第二个参数指定每页多少条
//从数据库提取数据获取结果集
//每次重新读取结果集而不是每次重新执行sql语句
$_result = _query("SELECT 
						tg_id,tg_fromuser,tg_content,tg_date,tg_state
						FROM tg_message
						WHERE tg_touser='{$_COOKIE['username']}' 
						ORDER BY tg_date DESC 
						LIMIT $_pagenum,$_pagesize");
?>


<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>短信查看</title>
<?php 
		require ROOT_PATH.'includes/title.inc.php';
?>
	<script type="text/javascript" src="js/member_message.js"></script>
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
			<form action="?action=delete" method="POST">
				<table cellspacing="1">
					<tr>
						<th>发信人</th>
						<th>短信内容</th>
						<th>时间</th>
						<th>状态</th>
						<th>操作</th>

					</tr>
					<?php
						$_html = array();
						while(!!$_rows = _fetch_array_list($_result)){
							$_html['id']=$_rows['tg_id'];
							$_html['fromuser']=$_rows['tg_fromuser'];
							$_html['content']=$_rows['tg_content'];
							$_html['date']=$_rows['tg_date'];
							$_html[]=_html($_html);
							if(empty($_rows['tg_state'])){
								$_html['state']='<img src="images/read.gif" alt="未读" title="未读" />';
								$_html['content_html']='<strong>'._title($_html['content'],14).'</strong>';
							}else{
								$_html['state']='<img src="images/noread.gif" alt="已读" title="已读" />';
								$_html['content_html']=_title($_html['content']);
							}
							

					?>		
					<tr>
						<td><?php echo $_html['fromuser'];?></td>
						<td><a href="member_message_detail.php?id=<?php echo $_html['id'];?>" title="<?php echo $_html['content'];?>"><?php echo $_html['content_html'];?></a></td>
						<td><?php echo $_html['date'];?></td>
						<td><?php echo $_html['state'];?></td>
						<td><input name="ids[]"  value="<?php echo $_html['id'];?>" type="checkbox"></td>

					</tr>
					<?php
					//发送的应该是一个数组 
						}
						_free_result($_result);
					?>
					<tr><td colspan="4"><label for="all"><input type="checkbox" name="chkall" id="all" /><input id="del" type="submit" value="批量删除"></label></td></tr>
				</table>
			</form>
			<?php
				
				//pageing调用分页  1表示数字分页  2表示文本分页
				_paging(2);
			?>
		</div>
	</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>