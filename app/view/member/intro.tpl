<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link  rel="stylesheet" type="text/css" href="./static/admin/css/member.css">
	<link  rel="stylesheet" type="text/css" href="./static/bootstrap2/css/my.css">
	<link rel="stylesheet" href="./static/bootstrap2/css/bootstrap.min.css">
	<link rel="stylesheet" href="./static/bootstrap2/css/bootstrap-responsive.min.css"  />
	<script type="text/javascript" src="./static/public/jquery-1.11.0.min.js"></script>
</head>

<body style="padding: 0px; margin: 0px;">
	<div class="main">
		<div class="face">
			<img src="{$user.face}">
			<a href="./index.php?face/index">修改头像</a>
		</div>

		<div class="ziliao">
			<h1>{$user.real_name}</h1>
			<h4>资料完善度：
				<span style="width:100px;height:8px;display:inline-block;border:1px #d2d2d2 solid;border-radius: 4px;">
					<span class="bar" style="width: {$percent*100}px;height: 8px;display: inline-block;background: #d62f26;border-radius: 4px;"></span>
				</span>{$percent*100}%
				<a href="./index.php?member/info">立即完善</a>
			</h4>
			<ul class="items">
				<li style="padding-left: 5px;">
					<p class="" style="font-size:16px;line-height: 32px;text-align: left;padding-top:5px;">余额</p>

					<p class="" style="line-height: 32px;text-align: left;">

              <!--<img src="./static/bootstrap2/img/bean.png">--><span class="title" style="padding-right:5px;">{$user.coupons}</span></p>

				</li>
				<li style="padding:40px 0 0 25px;">
                    <a class="btn btn-default" href="./index.php?bank/bank" target="_blank">充值</a>

                    <a class="btn btn-default" href="./index.php?coupons/transfer">转赠</a>
					<a class="btn btn-link" href="./index.php?coupons/coupons">明细</a>
				</li>
			</ul>
			<div class="mail">
				<p>手机号码 ：{$user.mobile_phone}</p>
				<p>常用地址 ：{$user.area}</p>
			</div>
		</div>
		<div class="qd">
			<a target="_blank" style="width:249px;height:234px;" href="/"><img src="/static/default/images/DS_xingfu_backHome.jpg"></a>
		</div>
	</div>
	<div class="message">
		<div class="title">消息</div>
			{include file="plugin/receipt.tpl"}
		</div>
	<div>
</body>
<html>
