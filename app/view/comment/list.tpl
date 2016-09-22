{include file="news/header.tpl"} {literal}
<style>
.orange {
	color: orange
}
.reply{color:#e15f63}

</style>
{/literal}

<!-- 头部// -->
<!-- start: Content -->
<div id="content" class="">


<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">



<form name="news" action="./index.php?comment/search" method="post"
	class="form-inline suoding"><select name="type" class="span1">
	<option value="real_name">{$lang['USERNAME']}</option>
	<option value="mobile_phone">{$lang['MOBILE']}</option>
</select>
<div class="input-append"><input value="" type="text" class="control"
	name="value">
<button type="submit" class="btn "><i class="icon-search"></i>
</button>

</div>

	</form>
<table class="table  table-hover">

	<tr>
		<td class="span2" colspan="3">有 <b>{$totalnum}</b> 条记录</td>
		<th class="span2">{$lang['USERNAME']}</th>

		<th class="span5">{$lang['CONTENT']}</th>
		<th class="span3"></th>
		<th class="span2">来源</th>
		<th class="span1"></th>
	</tr>



	{section name=l loop=$news }
	<tr id="{$news[l].id}">
		<td id="reply_{$news[l].id}">{if $news[l].status==0} <a
			href="javascript:reply({$news[l].id},{$news[l].nid})"> <i
			class="icon-comment orange"></i></a>{/if}</td>
		<td>{$news[l].date|wtime}</td>

		<td id="{$news[l].id}_realname"><small>{$news[l].real_name}</small><br>
		{$news[l].mobile_phone}</td>
		<td>{$news[l].country}</td>
		<td><span id="{$news[l].id}_comment">{$news[l].comment}</span> {if
		$news[l].status==1} <br>
		
		<span class="reply">{$news[l].reply_name}:{$news[l].reply_comment}</span>
		{/if}</td>

		<td><a href="./index.php?comment/clist/?cid={$news[l].nid}">{$news[l].title|cntruncate:"5"}</a></td>
		<td class=left><a href="javascript:void(0)" title="回收站"
			onclick="recyle({$news[l].id})"><i class="icon-trash "></i></a>
		&nbsp;&nbsp;</td>

	</tr>
	{/section}

</table>


<div class="pagination pagination-centered">
<ul id="pager"></ul>
</div>

</div>

<script src="./static/public/layer/layer.min.js"></script> <script
	src="./static/public/layer/extend/layer.ext.js"></script> {literal} <script
	type='text/javascript'>

    function recyle(id){  
      if(!confirm("确认删除?")){
             return;
        }
  	  $.post("./index.php?comment/remove",{id:id,nid:32416},function(json){
          if(json.status){
            
       	   $("#"+id).remove();
           }else{
             alert(json.message);
              }
     },"json")
  } 
function reply(id,nid){

    var con="";
	var a=layer.prompt({title: '处理意见',type: 3,val:con}, function(val){
	    $.post("./index.php?comment/reply",{comment:val,nid:nid,gid:id},function(data){
      alert(data.message);
      layer.close(a);
      var con="<span class=\"reply\">已处理</span>";
     $("#reply_"+id).html(con)
		    },"json")
	});
    }

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?comment/clist/?p='+page+'&cid={/literal}{$nid}{literal}'
}
}
$('#pager').bootstrapPaginator(options);
</script> {/literal} {include file="news/footer.tpl"}