 {literal}
<style>
.div {
	border: 1px #ccc solid;
}
</style>
{/literal}
<div style="width: 400px; height: auto; text-align: center;">订单信息
============================= No.:0010280749 13-02-25 17:45
=============================
<table>
	<tr>
		<td>名称</td>
		<td>数量</td>
		<td>价格</td>
		{foreach from=$goods item=l}
	
	
	<tr>
		<td>{$l.name}</td>
		<td>{$l.qty}</td>
		<td>{$l.price}</td>
		{/foreach} =============================
	
	
	<tr>
		<td>应付总额 {$tj.total}</td>
		<td>操作员:0001</td>
		<td></td>
	</tr>
</table>

收货信息<br>
<form action="/order/add" method="post">{foreach from=$goods item=l} <input
	type="hidden" name="jcartItemId[]" value="{$l.id}"> <input
	type="hidden" name="jcartItemName[]" value="{$l.name}"> <input
	type="hidden" name="jcartItemPrice[]" value="{$l.price}"> <input
	type="hidden" name="jcartItemQty[]" value="{$l.qty}"> {/foreach} 收货地址<input
	type="text" name="address"><br>
收货人<input type="text" name="shr"><br>
联系电话<input type="text" name="mobile"><br>
<input type="submit" value="确认订单"></form>


</div>