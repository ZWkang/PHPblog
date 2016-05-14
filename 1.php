<?php
if (isset($_GET['page'])) {
	$_page=$_GET['page'];	
	if(empty($_page)||$_page<0 ||!is_numeric($_page)){
		$_page=1;
	}else{
		$_page=intval($_page);
		echo "11";
		echo $_page;
	}
}else{
	echo $page=1;
}


?>