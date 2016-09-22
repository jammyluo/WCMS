{include file="news/header.tpl"}

{literal}
<style>
.log{color:#ccc;font-size:12px;}
.head{width:100%;text-align:center;font-size:16px;font-weight:700;margin-top:20px;}
.table-d {border:1px solid #000;border-collapse: collapse;width:650px;}
.table-d th,td{border:1px solid #000;text-align:center;}
.title{height:30px;line-height:30px;}
.line{width:210px;float:left;}
.orderno{font-size:12px;}
</style>
{/literal}
	<!-- start: Content -->
			
						
			<div class="row-fluid">
<input type="hidden" name="orderno" id="orderno" value="{$order.orderno}">

<div class="box span12" style="margin-left:50px;"><!-- Default panel contents -->
<div class="head">移动幸福城商品出库单</div>
<a href="javascript:p()"><i class="icon-print">打印</i></a>
<div class="box-content" id="form1">
    <div class="title">
        <div class="line">
            <strong>客户姓名：</strong>{$order.shr}
        </div>
        <div class="line">

            <strong>客户编号:</strong> {$order.uid}
        </div>
        <div class="line">

            <strong>订单号：</strong> <span class="orderno">{$order.orderno}</span>
        </div>

    </div>
<table class="table-d">
	<tr class=title>
	    <th style="width:10%">序号</th>
		<th style="width:15%">商品编号</th>
		<th style="width:55%">商品名称</th>
		<th style="width:10%">单位</th>
		<th style="10%">数量</th>
	</tr>



	{foreach from=$goods item=l name=g }
	<tr>
	    <td >{$smarty.foreach.g.iteration}</td>
		<td >{$l.goods_id}</td>
		<td >{$l.goods_name}</td>
		<td>{$l.unit}</td>
				<td>{$l.num}</td>
		
	</tr>
	{/foreach}
</table>
<div class="title">
    <div class="line">
        <strong>发货人：</strong>
    </div>
    <div class="line">
        　<strong>提货人：</strong>　
    </div>
    <div class="line">
        <strong>打印日期：</strong> <span class="print_date"></span>
    </div>
</div>
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
$(function(){
    var date=new Date();
    var month=parseInt(date.getMonth())+1;
    var rq=date.getFullYear()+"/"+month+"/"+date.getDate();
    $(".print_date").html(rq);
})
function p(){
	var orderno=$("#orderno").val();
	$.post("./index.php?orderinfo/p",{orderno:orderno},function(data){

		$(".log").hide();
		$(".icon-print").hide();
		window.print();
	})
	
}

</script>
{/literal}


