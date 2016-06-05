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
//分页模块
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user",4);//第一个参数获取总的条数 第二个参数指定每页多少条
// //页码
// if (isset($_GET['page'])) {
// 	$_page=$_GET['page'];	
// 	if(empty($_page)||$_page<0 ||!is_numeric($_page)){
// 		$_page=1;
// 	}else{
// 		$_page=intval($_page);
// 	}
// }else{
// 	$_page=1;
// }

// $_pagesize=3;
// //首先要得到所有的数据之和
// $_number=_num_rows(_query("SELECT tg_id FROM tg_user"));

// if($_number==0){
// 	$_pageabsolute=1;
// }else{
// 	$_pageabsolute=ceil($_number/$_pagesize);
// }
// if($_page>$_pageabsolute){
// 	$_page=$_pageabsolute;
// }
// $_pagenum=($_page-1)*$_pagesize;
// //首页要得到所有的数据综合
// //如果number=0

//从数据库提取数据获取结果集
//每次重新读取结果集而不是每次重新执行sql语句
$_result = _query("SELECT 
							tg_username,tg_sex,tg_face,tg_id 
						FROM tg_user 
						ORDER BY tg_reg_time DESC 
						LIMIT $_pagenum,$_pagesize");

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
<script type="text/javascript" src="js/<?php echo SCRIPT.'.js';?>"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
	
	<div id="blog">
		<h2>博友列表</h2>
		<?php 
			$_html = array();
			while(!!$_rows = _fetch_array_list($_result,MYSQL_ASSOC)){
				$_html['id']=$_rows['tg_id'];
				$_html['username']=$_rows['tg_username'];
				$_html['face']=$_rows['tg_face'];
				$_html['sex']=$_rows['tg_sex'];
				$_html=_html($_html);
		?>
	<dl>
				<dd class="user"><?php echo $_html['username'].'('.$_html['sex'].')'?></dd>
				<dt><img src="<?php echo $_html['face'];?>" alt="<?php echo $_html['username'];?>"></dt>
				<dd class="message" ><a href="javascript:;" name="message" title="<?php echo $_html['id']?>">发消息</a></dd>
				<dd class="friend" ><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>">加为好友</a></dd>
				<dd>写短信</dd>
				<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>">送花</a></dd>
			</dl>
		<?php ?>
	<?php
		}
		_free_result($_result);
	//pageing调用分页  1表示数字分页  2表示文本分页
		_paging(2);

	?>
</div>
<!-- page=1就是第一页。表示1-10条数据  limit 0,10-->
<!-- page=2就是第二页。表示11-20条数据 limit 10,10-->
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>