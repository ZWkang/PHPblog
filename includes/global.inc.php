<?php
/**
* TestGuest Version8.0
* ================================================
* Copy 2015 kang
* Web: localhost
* ================================================
* Author: kang
* Date: 2015-11-29
*/
if (!defined('IN_TG')){
	exit('woriing');
}
//防止恶意调用

//运行时间
error_reporting(E_ALL ^ E_DEPRECATED);

/*
 * _runtime是用来获取执行耗时的
 * @access public 表示函数对外公开
 * @return 返回值float 表示返回出来的是float型
 * 
 */
function _runtime() {
		if (PHP_VERSION > 5) {
			return microtime ( true );
		} else {
			$m_time = explode ( " ", microtime () );
			return $m_time[1]+$m_time[0];
		}
}
/**
 * 判断唯一标识符是否异常
 *@param $_mysql_uniqid
 *@param $_cookie_uniqid
 */
function _uniqid($_mysql_uniqid,$_cookie_uniqid){
		if($_mysql_uniqid!=$_cookie_uniqid){
			_alert_back('唯一标识符异常');
		}
}
/**
 *_title() 标题截取函数 
 *@param $_string 字符串
 */
function _title($_string,$_strlen){
	if(mb_strlen($_string,'utf-8')>$_strlen){
		$_string=mb_substr($_string, 0,$_strlen,'utf-8').'....';
	}
	return $_string;
}




/**
 *_html函数表示对字符串进行html过滤显示，如果是数组按数组方法过滤，如果是单独的字符串按单独字符串过滤 
 *@param unknown_type $_string
 */
function _html($_string){
	if (is_array($_string)) {
		foreach($_string as $_key => $_value){
			$_string[$_key]=_html($_value);//递归调用
			// $_string[$_key]=htmlspecialchars($_value);非递归调用
		}
	}else{
		$_string =  htmlspecialchars($_string);
	}
	return $_string;
}

/**
 * _page
 *	@param $_sql要查询的sql语句
 *	@param $_size表示要显示一页博友的多少
 */
function _page($_sql,$_size){
	//页码
	//函数内的所有变量取出。外部可以访问
	global $_page,$_pagenum,$_pagesize,$_pageabsolute,$_number;
	if (isset($_GET['page'])) {
		$_page=$_GET['page'];	
		if(empty($_page)||$_page<=0 ||!is_numeric($_page)){
			$_page=1;
		}else{
			$_page=intval($_page);
		}
	}else{
		$_page=1;
	}
	$_pagesize=$_size;
	//首先要得到所有的数据之和
	$_number=_num_rows(_query($_sql));

	if($_number==0){
		$_pageabsolute=1;
	}else{
		$_pageabsolute=ceil($_number/$_pagesize);
	}
	if($_page>$_pageabsolute){
		$_page=$_pageabsolute;
	}
	$_pagenum=($_page-1)*$_pagesize;
	//首页要得到所有的数据综合
	//如果number=0

}



/**
 * _paging分页函数
 *	@param 选择分页
 *	@return 返回分页
 */
function _paging($_type){
	//函数内部定义全局变量可以调用函数外的变量，在函数执行结束的时候释放
	global $_page,$_pageabsolute,$_number;
	if($_type==1){
		echo '<div id="page_num">';
			echo '<ul>';
				for($i=0;$i<$_pageabsolute;$i++){
					if($_page==$i+1){
						echo	'<li><a href="'.SCRIPT.'.php?page='.($i+1).'"class="selected">'.($i+1).'</a></li>';
					}else{
						echo	'<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
					}
				}
			echo '</ul>';
		echo '</div>';
	}elseif($_type==2){
		echo '<div id="page_text">';
			echo '<ul>';
				echo '<li>|'.$_page.' / '.$_pageabsolute.' 页 |</li>';
				echo '<li> 共有<strong>'.$_number.'</strong>个数据 | </li>';
					if($_page==1){
						echo '<li>首页 |</li>';
						echo '<li>上一页 |</li>';
					}else{
						echo '<li><a href="'.SCRIPT.'.php?page=1">首页</a> |</li>';
						echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页</a> |</li>';
					}
					if($_page==$_pageabsolute){
						echo '<li>下一页 |</li>';
						echo '<li>尾页 |</li>';
					}else{
						echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">下一页</a> |</li>';
						echo '<li><a href="'.SCRIPT.'.php?page='.($_pageabsolute).'">尾页</a> |</li>';
					}

				
			echo '</ul>';
		echo '</div>';
	}else{
		_paging(2);
	}
}


/**_alert_back(){}表示js弹窗
 * @access public
 * @param $_info
 * @return void弹窗
 */
function _alert_back($_info){
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}
/**
 * 
 *
 *
 */
function _alert_close($_info){
	echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
	exit();
}

function _location($_info,$_url) {
	if(!empty($_info)){
	echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
	exit();}else{
		header('Location:'.$_url);
	}
}


/**
 *防止登录后还可以访问注册和登录界面
 */
function _login_state(){
	if(isset($_COOKIE['username'])){
		_alert_back('登录状态无法进行本操作');
	}
}


/*
 *_session_destroy清空session
 */
function _session_destroy(){
	if(@session_start()){
		session_unset();
		session_destroy();
	}
}

//删除cookie
function _unsetcookie(){
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	_session_destroy();
	_location(null,'index.php');
}

function _check_code($_first_code,$_end_code){
	if ($_first_code!=$_end_code) {
		_alert_back('验证码错误');
	}
}

function _mysql_string($_string){
 	//get_magic_quotes_gpc(oid)如果开启状态就转义没开启就不转义
	if (@!GPC) {
		if (is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = _mysql_string($_value);   //这里采用了递归，如果不理解，那么还是用htmlspecialchars
			}
		} else {
			$_string = mysql_real_escape_string($_string);
		}
	} 
	return $_string;
}

function _sha1_uniqid(){
	return _mysql_string(sha1(uniqid(rand(),true)));
}

/**
 * 处理用户输入的字符串进行转义去空格等操作
 * Enter description here ...
 * @param $_string 用户输入的字符串
 */
function _strChange($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
/*
 *_code()是验证码函数
 *@access public
 *@param int $_width 表示验证码长度
 *@param int $_height 表示验证码高度
 *@param int $_rnd_number 表示验证码个数
 *@param bool $_flag 表示验证码是否需要边框
 *@return void 函数返回一个验证码图像
 */
function _code($_width=75,$_height=25,$_rnd_number=4,$_flag = true){
	//随机码个数
	//$_rnd_number=4;默认为四
	
	//长和高
	//$_width=75,$_height=25默认为75*25
	
	//初始化_nmsg
	$_nmsg='';
	
	//十进制转化成16进制。
	//创建随机码
	for ($i=0;$i<$_rnd_number;$i++){
		$_nmsg.=dechex(mt_rand(0, 15));
	}
	//保存到服务器上
	$_SESSION['code']=$_nmsg;
	
	//创建一张图像
	$_img=imagecreatetruecolor($_width, $_height);
	
	//绘制颜色
	$_white=imagecolorallocate($_img, 255, 255, 255);
	//填充颜色
	imagefill($_img, 0, 0, $_white);
	
	if ($_flag){
		//黑色
		$_black=imagecolorallocate($_img, 0, 0, 0);
		//边框
		imagerectangle($_img, 0, 0, $_width-1, $_height-1, $_black);
	}
	//随机画出6个线条
	for ($i=0;$i<6;$i++)
	{
		//随即色
		$_rnd_color=imagecolorallocate($_img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
		imageline($_img, mt_rand(0, $_width),mt_rand(0, $_height), mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
	}
	
	//随机雪花
	for ($i=0;$i<100;$i++)
	{
		$_rnd_color=imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
		imagestring($_img, 1, mt_rand(1, $_width-1), mt_rand(1, $_height-1), '*', $_rnd_color);
	}
	
	//输出验证码
	for ($i=0;$i<strlen($_SESSION['code']);$i++){
		$_rnd_color=imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
		imagestring($_img, mt_rand(5,8), $i*$_width/$_rnd_number+mt_rand(1, 4) , mt_rand(1, $_height/2), $_SESSION['code'][$i], $_rnd_color);
		
	}
	//$i乘以1/4的宽度。加上mt_rand(0,10)保证它验证码显示的不会一出去高度的。也是保证不会一出去。取1/2.

	//输出图像
	header('Content-type:image/png');
	imagepng($_img);
	
	//销毁图像
	imagedestroy($_img);
}

function _get_xml($_xmlfile){
	if(file_exists($_xmlfile)){
		$_xml=file_get_contents($_xmlfile);
		preg_match_all('/<vip>(.*)<\/vip>/s', $_xml, $_dom);
		foreach($_dom[1] as $value){
			preg_match_all('/<id>(.*)<\/id>/s', $_xml, $_id);
			preg_match_all('/<username>(.*)<\/username>/s', $_xml, $_username);
			preg_match_all('/<sex>(.*)<\/sex>/s', $_xml, $_sex);	
			preg_match_all('/<face>(.*)<\/face>/s', $_xml, $_face);
			preg_match_all('/<email>(.*)<\/email>/s', $_xml, $_email);
			preg_match_all('/<url>(.*)<\/url>/s', $_xml, $_url);
			$_html['id'] = $_id[1][0];
			$_html['username'] = $_username[1][0];
			$_html['sex'] = $_sex[1][0];
			$_html['face'] = $_face[1][0];
			$_html['email'] = $_email[1][0];
			$_html['url'] = $_url[1][0];
		}
	}
	else{
		echo '文件不存在';
	}
	return $_html;
}


function _set_xml($_xmlfile,$_clean){
	$_fp = @fopen($_xmlfile.'.xml', 'w');
	if(!$_fp){
		exit('系统错误，文件不存在');
	}
	flock($_fp, LOCK_EX);
	$_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string = "<vip>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string = "\t<id>{$_clean['id']}</id>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string = "\t<username>{$_clean['username']}</username>\r\n";
	fwrite($_fp, $_string,strlen($_string));
	$_string = "\t<sex>{$_clean['sex']}</sex>\r\n";
	fwrite($_fp, $_string);
	$_string = "\t<face>{$_clean['face']}</face>\r\n";
	fwrite($_fp, $_string);
	$_string = "\t<email>{$_clean['email']}</email>\r\n";
	fwrite($_fp, $_string);
	$_string = "\t<url>{$_clean['url']}</url>\r\n";
	fwrite($_fp, $_string);
	$_string = "</vip>";
	fwrite($_fp, $_string);
	flock($_fp, LOCK_UN);
	fclose($_fp);
}


/**
 * 解析ubb代码
 */
function _ubb($_string) {
	$_string = nl2br($_string);
	$_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string = preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
	$_string = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
	$_string = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$_string);
	$_string = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片" />',$_string);
	$_string = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px;" src="\1" />',$_string);
	return $_string;
}
?>