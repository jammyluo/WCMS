<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>美图WEB开放平台</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script type="text/javascript">
window.onload=function(){
	var url="http://{$config.website}";
       /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	xiuxiu.embedSWF("altContent",5,"100%","100%");
       //修改为您自己的图片上传接口
	xiuxiu.setUploadURL(url+"/index.php?face/setface");
        xiuxiu.setUploadType(2);
        xiuxiu.setUploadDataFieldName("upload_file");
	xiuxiu.onInit = function ()
	{
		xiuxiu.loadPhoto(url+"/static/attached/face/face.jpg");
	}	
	xiuxiu.onUploadResponse = function (data)
	{
		alert(data);
		location.href='./index.php?member/intro';
	}
}
</script>
<style type="text/css">
	html, body { height:600px; overflow:hidden; }
	body { margin:0; }
</style>
</head>
<body>
<div id="altContent">
	<h1>美图秀秀</h1>
</div>
</body>
</html>