window.onload=function(){
	var ret = document.getElementById("return");
	var del = document.getElementById("delete");
	ret.onclick=function(){
		history.back();
	};
	del.onclick =function(){
		if(window.confirm('你确定好删除短信吗?')){
			location.href='?action=delete&id='+this.name;
		}
	};
}