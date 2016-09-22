{include file="news/header.tpl"}



<!-- 头部// -->
{include file="news/top.tpl"}


{include file="news/nav.tpl"}

<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->


<div class="box-content">
<table class=table>



<form action="/attr/attr" method="post" >

<tr>
<td >字段名称</td>
<td  >
<select name="filed">
{foreach from=$attr item=l}
<option value="{$l.id}">{$l.name}[{$l.key}]</option>
{/foreach}
</select>
</td><td class=left><td ></td><td class=left></td><td ></td>
</tr>

<tr>
<td >添加值</td>
<td  ><input name="name" type="text" value="" id="remark">(长度50个字符)</td>
</td><td class=left><td ></td><td class=left></td><td ></td>
</tr>


<tr>
<td ></td>
<td  >
<input type="button" name="add"  value="添加"  onclick="return bind()" class="btn"></input></td><td class=left></td><td ></td>
<td class=left></td><td ></td>
</form>
</tr>


<tr class="title" id="ctitle"><th>序号</th><th>字段名</th><th>备注名</th><th>类型</th><th>实体</th><th>状态</th></tr>
{foreach from=$extend item=l}
<tr><td class=left>{$l.eid}</td>
<td >{$l.key}</td>
<td class=left>{$l.name}</td>
<td >{$l.type}</td>
<td class=left>{$l.module}</td>
<td >
{if $l.status==1}显示{elseif $l.status==2}图片{elseif $l.status==3}多个{else}隐藏{/if}</td>
</tr>
{/foreach}

</table>
</div>
</div>
</div>
{include file="news/footer.tpl"}
