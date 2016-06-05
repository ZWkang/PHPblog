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


//读取xml文件
$_html=@_html(_get_xml('new.xml'));

//读取帖子列表
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_article",10); 
$_result = _query("SELECT tg_id,tg_title,tg_type,tg_readcount,tg_commendcount 
				FROM tg_article 
				WHERE tg_reid=0
				ORDER BY tg_date DESC 
				LIMIT $_pagenum,$_pagesize");	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言系统首页</title>
<?php 
	require_once ROOT_PATH.'includes/title.inc.php';
	
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php 
	require_once ROOT_PATH.'includes/header.inc.php';
?>
	
	<div id="list">
		<h2>帖子列表</h2>
		<a href="post.php" class="post"></a>
		<ul class="article">
		<?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_result)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['type'] = $_rows['tg_type'];
				$_htmllist['readcount'] = $_rows['tg_readcount'];
				$_htmllist['commendcount'] = $_rows['tg_commendcount'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li class="icon'.$_htmllist['type'].'"><em>阅读数(<strong>'.$_htmllist['readcount'].'</strong>) 评论数(<strong>'.$_htmllist['commendcount'].'</strong>)</em> <a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
			}
			_free_result($_result);
		?>
		</ul>
		<?php _paging(2);?>
	</div>	
	<div id="user">
		<h2>新进会员</h2>
		<dl>
				<dd class="user"><?php echo @$_html['username'];?></dd>
				<dt><img src="<?php echo @$_html['face'];?>" alt="<?php echo @$_html['username'];?>"></dt>
				<dd class="message" ><a href="javascript:;" name="message" title="<?php echo @$_html['id'];?>">发消息</a></dd>
				<dd class="friend" ><a href="javascript:;" name="friend" title="<?php echo @$_html['id'];?>">加为好友</a></dd>
				<dd>写短信</dd>
				<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo @$_html['id'];?>">送花</a></dd>
				<dd class="email"><a href="mailto:<?php echo @$_html['email'];?>">邮箱:<?php echo @$_html['email'];?></a></dd>
				<dd class="url"><a href="<?php echo @$_html['url'];?>" target="_blank">网址:<?php echo @$_html['url'];?></a></dd>
			</dl>
	</div>
	<div id="pics">
		<h2>新增图片</h2>
	</div>
<?php 
	require_once ROOT_PATH.'includes/footer.inc.php';
	?>
	
</body>
</html>