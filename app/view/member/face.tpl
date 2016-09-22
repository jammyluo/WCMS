{include file="news/header.tpl"}
{literal}
<script type="text/javascript">

function vaild(id,type){

$.post("./index.php?face/vaild",{id:id,type:type},function(data){

if(type=="pass"){
  $("#"+id).remove();
	
}else{

	  $("#status_"+id).html("<span  class=\"label\"><i class=\"icon-ban-circle\"></i></span>");
	  $("#stat_"+id).html("");
		
}
	
},"json");
	
}
</script>
{/literal}
<!-- 头部// -->
<!-- 头部// -->
{include file="news/top.tpl"} {include file="news/nav.tpl"}
<!-- start: Content -->
<div id="content">


<div class="row-fluid">


<div class="well"><!-- Default panel contents -->


<div class="box-content">

<table class="table  table-hover">
	<tr>
	<th class="span1">状态</th>
		<th class="span1">UID</th>
		<th class="span2">用户名</th>
		<th class="span2">头像</th>
		<th class="span4">操作</th>
	</tr>

	{foreach from=$list item=l}

	<tr id="{$l.id}">
	<td id="status_{$l.id}">{if $l.status==-1}<span  class="label"><i class="icon-ban-circle"></i></span>{elseif $l.status==1}{else}<span class="label label-warning"><i class="icon-time"></i></span>{/if}</td>
		<td>{$l.uid}</td>
		<td>{$l.username}</td>
		<td><img src="{$l.face}"  width="60px;"></td>
		<td id="stat_{$l.id}">
		{if $l.status==0}
		<input type=button name=copy class="btn "
			value="{$lang['PASS']}" onclick="vaild({$l.id},'pass');"> <input type=button
			name=copy class="btn " value="{$lang['REFUSE']}"
			onclick="vaild({$l.id},'refuse');">{/if}</td>
	</tr>
	{/foreach}

</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul>
</div>

</div>




</div>


{literal} <script type='text/javascript'>
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?member/listing/?groupid={/literal}{$groupid.id}&verify={$verify.id}&{literal}&p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script> {/literal} {include file="news/footer.tpl"}