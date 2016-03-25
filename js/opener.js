window.onload=function(){
	var img = document.getElementsByTagName('img');
	for(i=0;i<img.length;i++){
		img[i].onclick = function(){
			_opener(this.alt);
		};
	}
	
};
function _opener(src) {
	//opener表示父窗口.document表示文档
	opener.document.getElementById('faceimg').src=src;
	//先取得父窗口的src值
	//再用子窗口得到的src值取代掉父窗口的src值
	opener.document.register.face.value = src;
}