{include file="news/header.tpl"}
{include file="module/edit.header.tpl"}

<div>
<div class="row-fluid">
  <ul class="nav nav-tabs">
    <li><a href="javascript:history.go(-1)"><<返回</a></li>
   </ul>
  <div class="tab-content" >
   <div class="tab-pane active" id="tab1">

<form action="./index.php?factory/save" method="post" enctype="multipart/form-data"
	class="form-inline">
	<input type="hidden" name="p" value="{$p}"><!-- 存储上一级页数 -->
	<input type="hidden" name="preid" value="{$preid}"><!-- 存储上一级页数 --> <!-- 内容// -->
	<input type="hidden" name="author" value="{$news.author}">
	<input type="hidden" name="mid" value="1">
	<input type="hidden" name="cid" value="1">
	<table class="table">
		<tr>	
			<td><input type="text" name="title" 
				class="input-xlarge rule" id="title" style="width:80%;" value="{$news.title}" placeholder="标题">
			</td>
		</tr>
		<tr>
			<td>
				<textarea id="container" name="content">{$news.content}</textarea>                 <!-- 编辑框 elm1为此部件ID-->
			</td>
		</tr>
		<tr>
			<td class=btnline align=center><input type="hidden"
				name="id" value="{$news.id}"> <input type="hidden" name="views"
				value="{$news.views}" />
			<button type="submit" class="btn "><i class="icon-ok"></i>保存</button>
		</tr>
	</table>
</div>
 
</form>

</div>
</div>
</div></div></div>
{include file="module/footer.tpl"}
{include file="news/footer.tpl"}