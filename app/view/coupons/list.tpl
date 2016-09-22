{include file="news/header.tpl"}

{literal}
    <style type="text/css">
        .form_date{width:80px;border:1px #ccc solid;}
    </style>
{/literal}
<!-- 头部// -->




	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->
 {include file="order/top.tpl"}

<<<<<<< Updated upstream
    起止日期:<input class="form_date" name="starttime" id="starttime" value="{$smarty.now|date_format:'%Y-%m-%d'}"  readonly> - <input name="endtime" class="form_date" value="{$smarty.now|date_format:'%Y-%m-%d'}"  id="endtime" readonly>
    <a href="javascript:bank()">网银成功支付明细</a>| <a href="javascript:exportUserBalanceByDate()">月末用户余额统计</a>
=======
    起止日期:<input class="form_date" name="starttime" id="starttime" value="{$smarty.now|date_format:'%Y-%m-%d'}"  readonly> - <input name="endtime" id="endtime" class="form_date" value="{$smarty.now|date_format:'%Y-%m-%d'}"  id="endtime" readonly>
    <a href="javascript:bank()">网银成功支付明细</a>| <a href="./index.php?coupons/getallusercouponsbydate/?date=2016-02-29">月末用户余额统计</a>
>>>>>>> Stashed changes



<div class="box-content">

<table class="table  table-hover">
	<tr>


		<th width="12%">流水号</th>
		<th width="15%">名称|备注</th>
		<th width="5%">账户</th>
		<th width="10%">收入</th>
		<th width="10%">支出</th>
		<th width="10%">渠道</th>
		<th width="10%">即时余额</th>
		<th width="10%">状态</th>

	</tr>




	{foreach from=$mx item=l }
	<tr>





		<td><small>{$l.id}|{$l.date|date_format:"%Y-%m-%d %H:%M:%S"}</small></td>

		<td>{$l.remark}
		<br><small>{$l.orderno}</small>
		</td>
	<td><a href="./index.php?coupons/user/?uid={$l.uid}">{$l.username}</a></td>
		<td>
		{if $l.payment==0}<span class="amount_pay_in">+{$l.coupons}</span></td><td></td>
		{else}</td><td><span class="amount_pay_out">{$l.coupons}</td>
		{/if}
		
		<td>{$l.chargetypes}</td>
		<td>{$l.balance}</td>
<td class=left width="8%">{$l.status}</td>

	</tr>
	{/foreach}

</table>


<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>


                <script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
                <script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

{literal}

 <script type='text/javascript'>


function exportUserBalanceByDate(){
	var end=$("#endtime").val();
	location.href='./index.php?coupons/getallusercouponsbydate/?date='+end;
	}
 
function bank(){

var start=$("#starttime").val();
var end=$("#endtime").val();

    location.href="./index.php?coupons/getbankcouponshistorysuccessbydate/?start="+start+"&end="+end;

}
 
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?coupons/listing/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);

$('.form_date').datetimepicker({
    language:  'zh-CN',
    format:'yyyy-mm-dd',
    weekStart: 1,
    todayBtn:  0,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
});


 </script>

{/literal}
{include file="news/footer.tpl"}
