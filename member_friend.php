<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_friend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
	_alert_back('请先登录');
}
//分页模块
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}'",6);//第一个参数获取总的条数 第二个参数指定每页多少条
//从数据库提取数据获取结果集
//每次重新读取结果集而不是每次重新执行sql语句
$_result = _query("SELECT 
						tg_id,tg_fromuser,tg_touser,tg_content,tg_date,tg_state
						FROM tg_friend
						WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}'
						ORDER BY tg_date DESC 
						LIMIT $_pagenum,$_pagesize");
?>


<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>好友列表</title>
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
			<h2>好友设置中心</h2>
			<form action="?action=delete" method="POST">
				<table cellspacing="1">
					<tr>
						<th>好友</th>
						<th>请求人</th>
						<th>时间</th>
						<th>状态</th>
						<th>操作</th>

					</tr>
					<?php
						while(!!$_rows = _fetch_array_list($_result)){
							$_html = array();
							$_html['id']=$_rows['tg_id'];
							$_html['touser']=$_rows['tg_touser'];
							$_html['fromuser']=$_rows['tg_fromuser'];
							$_html['content']=$_rows['tg_content'];
							$_html['date']=$_rows['tg_date'];
							$_html['state']=$_rows['tg_state'];
							$_html[]=_html($_html);

							if($_html['touser']==$_COOKIE['username']){
								$_html['friend']=$_html['fromuser'];
								if(empty($_html['state'])){
									$_html['state_html']='你未验证';
								}else{
									$_html['state_html']='验证通过';
								}
							}else if($_html['fromuser']==$_COOKIE['username']){
								$_html['friend']=$_html['touser'];
								if(empty($_html['state'])){
									$_html['state_html']='对方未验证';
								}else{
									$_html['state_html']='验证通过';
								}

							}

							

					?>		
					<tr>
						<td><?php echo $_html['friend'];?></td>
						<td title="<?php echo $_html['content'];?>"><?php echo _title($_html['content']);?></td>
						<td><?php echo $_html['date'];?></td>
						<td><?php echo $_html['state_html'];?></td>
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