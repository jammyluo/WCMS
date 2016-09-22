{include file="news/header.tpl"}


{literal}
<style>
table{font-size:12px;}
table th{background:#f5f5f5;}
.rs{color:#666;font-weight:400;}
.icon-star{color:orange;font-weight:700;}
.none td{border-bottom:none;}
.exec{color:blue;}
.genjin{color:orange;}
.selected{background-color:orange;color:#000;}
.comment{color:#e15f63}
.reply{color:#e15f63}
.face{width:80px;}
</style>
{/literal}
<!-- 头部// -->
<!-- 头部// -->
{include file="news/top.tpl"}


{include file="news/nav.tpl"}
	<!-- start: Content -->
			<div style="min-height:680px;">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->


<div class="box-content">


 状态: {foreach from=$level item=l key=key}
 <a href="./index.php?rating/admin/?level={$key}" {if $current==$key}class="selected"{/if}>{$l}</a>|
 {/foreach}

<table class="table  table-hover">
<tr><th class="span2">时间</th>
<th class="span1">订单号</th>
<th class="span2">收货人</th>
<th class="span5">评价</th>
<th class="span2">操作</th></tr>
{foreach from=$rs item=l}
<tr>
<td>{$l.add_time|wtime}</td>
<td><a href="javascript:search({$l.orderid})">{$l.orderid}</a> </td>
<td><img src="{$l.face}" class="face"><small>{$l.username}</small> </td>
<td>对 {$l.server_name} 
[<small>{$l.level}</small>]
{$l.comment}

{if $l.isreply==true}
<br>回复：<span class="comment">{$l.reply}</span>
{/if}
</td>


<td id="reply_{$l.id}">
{if $l.isreply==false}
 <span class="reply_{$l.orderid}"><a href="javascript:reply({$l.orderid},{$l.uid},{$l.id})" class="icon-comment"></a></span> 
{else}
<span class="comment">已回复</span>
{/if}
</td>
</tr>
{/foreach}


</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>
<script src="./static/public/layer/layer.min.js" ></script>
<script src="./static/public/layer/extend/layer.ext.js" ></script>


{literal}
<script type='text/javascript'>

function reply(id,suid,sid){

    var con="感谢你的评价，我们会继续努力";
	var a=layer.prompt({title: '建议回复',type: 3,val:con}, function(val){
	    $.post("./index.php?rating/reply",{comment:val,server_uid:suid,orderid:id},function(data){
      alert(data.message);
      layer.close(a);
      var con="<span class=\"comment\">已回复</span>";
     $("#reply_"+sid).html(con)
		    },"json")
	});
}


function search(value){

   location.href="./index.php?buyorder/search/?key=id&value="+value;
	
}

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?rating/admin/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
