<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8" />
	<title>WCMS 登录</title>
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link href="./static/bootstrap2/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/retina.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/my.css" rel="stylesheet" />
	<!-- end: CSS -->
 <body>


</head>

<body style="background:#FFF;">
<div class="container span6" style="margin-left:400px;margin-top:50px;">
<div class="progress progress-success progress-striped span6 active" id="process">
  <div class="bar" id="bar" style="width: 100%;"></div>

</div>
<div class="span6">
<span id="status">&nbsp;</span>
<span id="percent">100%</span>
</div>
</div>


{literal}
<script> 
    function updateProgress(sMsg, iWidth,percent) 
    {  
        document.getElementById("status").innerHTML = sMsg; 
        document.getElementById("bar").style.width = percent + "%"; 
        document.getElementById("percent").innerHTML = percent + "%"; 
     } 
   
</script>

{/literal}