<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="./static/bootstrap3/css/bootstrap.min.css">
<title>账号签名</title>
</head>
<body>
	<div class="container">
		<ul class="nav nav-pills">
			<li><a href="./index.php?appaccount/showindex">注册</a></li>
			<li><a href="./index.php?appaccount/showsearch">查询</a></li>
			<li class="active"><a href="./index.php?appaccount/showview">查看</a></li>
		</ul>
<!--		<form action="./index.php?appaccount/getall" class="form-inline" role="form" method="post">-->
<!--			<button type="submit" class="btn btn-default">导出</button>-->
<!--		</form>-->
		<table class="table-hover table">
			<tr>
				<th>时间</th>
				<th>记录ID</th>
				<th>姓名</th>
				<th>账号</th>
				<th>密码</th>
				<th>账号状态</th>
			</tr>
			{foreach from=$arr item=value}
			<tr>
				<td>{$value.add_time|date_format:"%Y-%m-%d %H:%M:%S"}</td>
				<td>{$value.Id}</td>
				<td>{$value.remark}</td>
				<td>{$value.app_key}</td>
				<td>{$value.app_secrect}</td>
				<td>{$value.status}</td>
			</tr>
			{/foreach}
		</table>
	</div>
	
	<script type="text/javascript" src="./static/public/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="./static/bootstrap3/js/bootstrap.min.js"></script>
</body>
</html>