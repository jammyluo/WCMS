{include file="news/header.tpl"}
	
{literal}
<style>
table{font-size:12px;}
</style>
{/literal}

<!-- 头部// -->
{include file="news/top.tpl"}

<!-- 左侧// -->


<!-- 头部// -->
{include file="news/nav.tpl"}


<!-- start: Content -->
<div id="content" class="">

<div style="background:#666;color:#ccc;font-size:12px;padding: 10px;"> 

<ul>

								{foreach from=$log item=l name=g}
<li>	{$l.action_time|date_format:"%Y-%m-%d %H:%M:%S"} {$l.username} {$l.event} </li> 
						{/foreach}
</ul>
</div>
<div class="pagination pagination-centered">
<ul id="pager"></ul></div>
</div>


{literal}
<script language='javascript'>

function myrefresh() 
{ 
       window.location.reload(); 
} 
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?log/listing/?p="+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
