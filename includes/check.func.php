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
if (!defined('IN_TG')){
	exit('woriing');
}

// on  off 默认是开启的，如果想关掉必须得在php.ini关闭

if(!function_exists('_mysql_string')){
	exit('_mysql_string函数不存在请检查');
}
//防止恶意调用
header('Content-Type:text/html;charset=utf-8');
/**
 * 
 * Enter description here ...
 * @param $string
 */
if (!function_exists('_alert_back')){
			echo "<script>alert ('函数不存在请检查!');histroy.back(-1);</script>";
}
/**
 * _check_uniqid检测唯一标识符
 * Enter description here ...
 * @param $_first_uniqid session里面的唯一标识符
 * @param $_end_uniqid 用户提交隐藏input里面的唯一标识符
 * @return $_string返回转义后的用户名
 */
function _check_uniqid($_first_uniqid,$_end_uniqid){
	if ((strlen($_first_uniqid)!=40)||($_first_uniqid != $_end_uniqid)) {
		_alert_back("唯一标识符异常");
	}
	return _mysql_string($_end_uniqid);

}

/**
 * _check_form检测过滤验证用户名
 * Enter description here ...
 * @param $string输入用户名 $_string受污染的用户名
 * @param $_min_number用户名最小长度
 * @param $_max_number用户名最大长度
 * @return $_string返回转义后的用户名
 */
function _check_form($string,$_min_number,$_max_number){
	//去掉两边空格
	$_string = trim($string);
	
	//长度小于两位大于20位都不行
	$long=mb_strlen($_string,'utf-8');
	if(mb_strlen($long<$_min_number ||$long>$_max_number)){
		_alert_back('用户名长度小于'.$_min_number.'位大于'.$_max_number.'位');}
	
	//限制敏感字符
	$_char_pattern="/[<>\'\"\ ]/";
	if(preg_match($_char_pattern, $_string))
	{
		_alert_back('用户名含有敏感字符');		
	}	
	
	
	//限制敏感用户名
	$_mg[1]='周文康';
	$_mg[2]='康';
	//告诉用户有哪些不能注册
	foreach ($_mg as $value){
		@$_mg_string .= '['.$value.']\n';
		//这里有一个叠加
	}
	//绝对匹配
	if (in_array($_string, $_mg)){
		_alert_back($_mg_string.'以上敏感用户名不得注册');
	}
	return _mysql_string($_string);
	//将用户名转义输出
	//return  mysql_real_escape_string($_string);
}
	
/**
 *_check_password 验证密码的长度
 * Enter description here ...
 * @param $_first_pass 第一次输入的密码
 * @param $_end_pass  第二次确认输入的密码
 * @param $_min_number 密码最小长度
 * @return 返回一个sha1加密后的密码
 */
function _check_password($_first_pass,$_end_pass,$_min_number){
	//判断密码
	if(strlen($_first_pass)<$_min_number){
		_alert_back('密码不得小于'.$_min_number.'位');
	}
	//密码确认必须一致
	if ($_first_pass!=$_end_pass){
		_alert_back('密码与密码确认不一致');
	}
	
	//将密码返回
	return _mysql_string(sha1($_first_pass));
}

/**
 * 验证修改密码
 */
function _check_modify_password($_string,$_min_number){
	if(!empty($_string)){
		if(strlen($_string)<$_min_number){
			_alert_back('密码不得小于'.$_min_number.'位');
		}
	}else{
		return $_string=null;
	}
	//密码
	return sha1($_string);
}
function _check_sex($_string){
	return _mysql_string($_string);

}

function _check_face($_string){
	return _mysql_string($_string);

}
/**
 * _check_question检查密码问题的
 * Enter description here ...
 * @param $_string 未处理的密码问题字符串
 * @param $_min_sise 最小长度
 * @param $_max_size 最大长度
 * @return 一个转义后的$_string
 */
function _check_question($_string,$_min_sise,$_max_size){
	if(mb_strlen($_string,'utf-8')<$_min_sise||mb_strlen($_string,'utf-8')>$_max_size){
		_alert_back('密码问题长度不允许小于'.$_min_sise.'以及小于'.$_max_size);
	}
	//也要注意敏感字符的
	return _mysql_string($_string);
	//return mysql_real_escape_string($_string);
}

/**
 * $_check_answer检测密码问题回答
 * Enter description here ...
 * @param $_question 密码问题
 * @param $_answer  密码回答
 * @param $_min_size 最小长度
 * @param $_max_size 最大长度
 * @return sha1加密后的密码回答
 */
function _check_answer($_question,$_answer,$_min_size,$_max_size){
	
	$_answer=trim($_answer);
	if(mb_strlen($_answer,'utf-8')<$_min_size||mb_strlen($_answer,'utf-8')>$_max_size){
		_alert_back('密码回答长度不允许小于'.$_min_size.'以及小于'.$_max_size);
	}
	
	//密码提示与回答不能一致
	if($_question==$_answer){
		_alert_back('密码回答与问题不能一致,重新输入');
	}
	//也要注意敏感字符的
	//$_answer = mysql_real_escape_string($_answer);
	return sha1(_mysql_string($_answer));
	//加密返回
}

/**
 * _check_email检查邮箱，如果有输入则检测，没输入则不检测
 * Enter description here ...
 * @param string $_string 邮箱地址
 * @return string $_string 验证后的邮箱
 */
function _check_email($_string,$_min_num,$_max_num){
	//任意字符[a-zA-Z0-9_]=>\w
	if(empty($_string))
	{	return null; }
	else{
	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)){
		_alert_back('输入邮箱地址不正确');
	}
	
	if(strlen($_string)<$_min_num||strlen($_string)>40){
		_alert_back('email长度有误');
	}
	return _mysql_string($_string);}
}

function _check_qqNumber($_string){
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			_alert_back('QQ号码不正确！');
		}
	}
	
	return _mysql_string($_string);
}

/**
*_cleck_url 网址验证
*@access public
*@param string $_string
*@param string $_string 返回验证后的网址
*/
function _check_url($_string,$_max_size){
	if(empty($_string)||($_string=='http://')){
		return null;
	}else{
		if(!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/', $_string)){
			_alert_back('网址不正确');
		}
		if(strlen($_string)>$_max_size){
			_alert_back('超出最大长度');
		}
		
	}
	return _mysql_string($_string);
}

function _check_content($_string){
	if(mb_strlen($_string,'utf-8')<10||mb_strlen($_string,'utf-8')>200){
		_alert_back('短信内容不得小于十位或者大于200位');
	}
	return $_string;
}
?>