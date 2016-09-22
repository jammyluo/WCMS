{include file="news/header.tpl"}


{literal}
<style>
table{font-size:12px;}
table th{background:#f5f5f5;}
small{border-bottom:none;}
.rs{color:#666;font-weight:400;}
.icon-star{color:orange;font-weight:700;}
.none td{border-bottom:none;}
.exec{color:blue;}
.genjin{color:orange;}
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
<div>{content id=35803 assign=con}{$con.content}</div>
<table class="table  table-hover">
<tr><th>留言时间</th><th>客户姓名</th><th>手机</th><th>城市</th><th>小区</th></tr>

{foreach from=$rs item=l}
<tr>
<td>{$l.date|wtime}</td>
<td>{$l.real_name}</td>
<td>{$l.mobile_phone}</td>
<td>{$l.country}</td>
<td>{$l.comment}</td>
</tr>
{/foreach}

</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>
<script src="./static/public/layer/layer.min.js" ></script>


{literal}
<script type='text/javascript'>

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?customer/info/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
