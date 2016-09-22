{include file="news/header.tpl"}

{literal}
<style>
.log{color:#ccc;font-size:12px;}
</style>
{/literal}
	<!-- start: Content -->
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->


<div class="box-content" id="form1">

<strong>订单编号：</strong>{$order.orderno} <strong>订购时间：</strong>{$order.addtime|date_format:"%Y-%m-%d %H:%I:%S"} <strong>客户姓名：</strong>{$order.shr} 

<a href="javascript:p()" class="btn  pull-right"><i class="icon-print">打印</i></a>

<table class="table table-border">
	<tr class=title>
		<th>商品编号</th>
		<th>商品名称</th>
		<th>数量</th>
		<th>幸福豆</th>
		<th>小计</th>
	</tr>



	{section name=l loop=$goods }
	<tr>
		<td class=left width="3%">{$goods[l].goods_id}</td>
		<td class=right width="8%">{$goods[l].goods_name}</td>
		<td class=right width="3%">{$goods[l].num}</td>
		<td class=left width="3%">{$goods[l].coupons}</td>
		<td class=right width="3%">{$goods[l].coupons_total}</td>
	</tr>
	{/section}
	<tr>
	<td>总计</td>
	<td></td>
	<td>{$order.num}</td>
	<td></td>
	<td>{$order.coupons}</td>
	</tr>
</table>

</div>
</div>


<div class="log">
<ul>
{foreach from=$history item=l}
<li>{$l.action_time|date_format:"%Y-%m-%d %H:%M"}  {$l.action_name}  {$l.remark}</li>
{/foreach}
</ul>
</div>


</div>

{literal}
<script>
function p(){
	
	$(".log").hide();
	$(".btn").hide();
	window.print();
}

</script>
{/literal}


