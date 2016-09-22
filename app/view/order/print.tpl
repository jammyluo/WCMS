{include file="news/header.tpl"}

{include file="news/top.tpl"}

<!-- 头部// -->


<!-- start: Content -->
<div id="content" class="span12">


<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content" id="form1"><strong>订单编号：</strong>{$order.orderno}
<strong>订购时间：</strong>{$order.addtime|date_format:"%Y-%m-%d %H:%I:%S"} <strong>客户姓名：</strong>{$order.shr}
<strong>商品总数：</strong>{$order.num} <strong>总积分：</strong>{$order.coupons}


<table class="table table-bordered table-striped">
	<tr class=title>
		<th>序号</th>
		<th>订单号</th>
		<th>收件人</th>
		<th>区域</th>
		<th>商品名称</th>
		<th>数量</th>
		<th>积分</th>
		<th>总计</th>
		<th>发货方式</th>
	</tr>



	{foreach from=$order item=l}
	<tr>
		<td>{$l.id}</td>
		<td>{$l.orderno}</td>
		<td>{$l.shr}</td>
		<td>{$l.address}</td>
		<td>{$l.goods_name}</td>
		<td>{$l.num}</td>
		<td>{$l.coupons}</td>
		<td>{$l.coupons_total}</td>
		<td>{$l.remark}</td>
	</tr>
	{/foreach}
</table>

</div>
</div>



</div>