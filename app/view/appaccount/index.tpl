<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="./static/bootstrap3/css/bootstrap.css">
<title>账号签名</title>
</head>
<body>
	<div class="container">
		<ul class="nav nav-pills">
			<li class="active"><a href="./index.php?appaccount/showindex">注册</a></li>
			<li><a href="./index.php?appaccount/showsearch">查询</a></li>
			<li><a href="./index.php?appaccount/showview">查看</a></li>
		</ul>
		<form action="./index.php?appaccount/add" class="form-inline" role="form" method="post">
			<div class="form-group">
		      	<input type="text" class="form-control" name="name" placeholder="请输入名称">
  			</div>
  			<button type="submit" class="btn btn-default">注册</button>
		</form>
		<label>{$success}</label>
	</div>
	
	
<script type="text/javascript" src="./static/public/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="./static/bootstrap3/js/bootstrap.js"></script>
	
</body>
</html>