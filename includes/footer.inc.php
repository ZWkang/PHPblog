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
	//mysql_close();
	_close();
?>
	<div id="footer">
		<p>本程序执行耗时为:<?php echo round((_runtime()-START_TIME),10);?>秒</p>
		<p>程序由<span>周文康</span>提供=3=源代码随意发布修改</p>
	</div>
