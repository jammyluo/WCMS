{include file="news/header.tpl"} 
<!-- 头部// -->
{include file="news/top.tpl"} {include file="news/nav.tpl"}
<!-- start: Content -->

<div class="content"><!-- Default panel contents -->

	<h1 style="font-family:微软雅黑">{$message}</h1>
	<p>
		<div class="btn-group">
		<a href=".{$news.html}" class="btn " target="_blank">查看内容</a>|
		<a href="./index.php?factory/v/?mid={$news.mid}&id={$news.id}" class="btn">修改编辑</a>|
		<a href="./index.php?factory/c/?cid={$news.cid}" class="btn">返回列表</a>|
		</div>
	</p>
</div>
{include file="news/footer.tpl"}
