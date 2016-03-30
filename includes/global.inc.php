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
/**_alert_back(){}表示js弹窗
 * @access public
 * @param $_info
 * @return void弹窗
 */
function _alert_back($_info){
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
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
	session_unset();
	session_destroy();
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
 	if(@!GPC){
 		return addslashes($_string);
 	}else echo "需要转义";
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


?>