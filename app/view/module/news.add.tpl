{include file="news/header.tpl"}
{include file="module/add.header.tpl"}

<!-- start: Content -->
<div >
	<!-- Only required for left/right tabs -->
	<div class="nav nav-tabs">
		<li><a href="javascript:history.go(-1)"><<返回</a></li>
	</div>
	<form name="news" action="./index.php?factory/add" method="post"
		enctype="multipart/form-data" class="form-inline">
		<!-- 内容// -->
		<input type="hidden" name="repeat" value="{$repeat}">
		<input type="hidden" name="author" value="{$user.username}">
		<input type="hidden" name="mid" value="1">
		<input type="hidden" name="cid" value="1">
		<table class="table">
			<tr>
				<td class="span8"><input type="text" name="title"  style="width:80%;"
					class="input rule" id="title" placeholder="标题">
			</tr>
			<tr>
				<td >
				<!-- 加载编辑器的容器 -->
			        <textarea id="container" name="content"></textarea> <!-- 编辑框 elm1为此部件ID-->
				</td>
			</tr>
			<tr>
				<td class=btnline align=center><input type="hidden" name="id"
					value="{$news.id}">
				<button type="submit" class="btn "><i class="icon-ok">创建</i>{$lang['CREATE']}
				</button>
			</tr>
		</table>
	</form>
</div>					
{include file="module/footer.tpl"}

{include file="news/footer.tpl"}
