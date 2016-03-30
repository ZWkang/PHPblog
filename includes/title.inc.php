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
//防止恶意调用
//防止非html页面调用
if (!defined('SCRIPT'))
{
	exit('SCRIPT Error !');
}
?>
<link rel="stylesheet" type="test/css" href="styles/1/basic.css"/>
<link rel="stylesheet" type="test/css" href="styles/1/<?php echo SCRIPT;?>.css"/>
<link rel="shortcuticon" href="favicon.ico"/>
