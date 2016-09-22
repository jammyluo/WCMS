{include file="news/header.tpl"}
    <link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

{literal}
<style type="text/css">
.form_date{width:80px;border:1px #ccc solid;}
</style>
{/literal}

<!-- start: Content -->
<div id="content" class="">


<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">



<form name="news" action="./index.php?coupons/export" method="post"
	class="form-inline">
		<span class="icon-eye-open">实时监控</span>：{if $now.status==false}<span class="label label-important">警告</span>{else}<span class="label label-success">安全</span>{/if} 
	
	
	 起止日期:<input class="form_date" name="starttime" id="starttime" value="{$time.lastmonth}"  readonly> - <input name="endtime" class="form_date" value="{$time.now}"  id="endtime" readonly> 资金流向:<input type="radio"
	name="payment" value="0">收入 <input type="radio" name="payment"
	value="1" checked>支出  <span
	class=""></span> 
	
	<button type="submit" class="btn">
  <span class="icon-upload-alt">导出</span> 
  
</button>
	</form>



  
<table class="table  table-hover table-bordered">
	<tr>
		
		<th colspan=4>收入</th>
		<th colspan=2>支出</th>
		
	</tr>
	
<tr>
<td>充值</td>
<td>赠送</td>
<td>转账</td>
<td>退款</td>
<td>消费</td>
<td>转账</td>


</tr>
    
    <tr>
		<td class="income_0"></td>
		<td class="income_2"></td>
		<td class="income_3"></td>
		<td class="income_4"></td>
		<td class="spend_1"></td>
		<td class="spend_3"></td>
		
	</tr>


  </table>
  
  <h2>历史结算</h2>
<table class="table  table-hover table-bordered">
	<tr>
		<th>结算日期</th>
		<th>期初金额</th>
		<th>本期收入</th>
		<th>本期支出</th>
		<th>期末金额</th>
	</tr>
	 <tr>
		<td><button type="button" onclick="audit()" class="btn btn-sm"><span
	class="icon-shopping-cart"> 结算</span></button></td>
		<td id="beginning">{$now.beginning}</td>
		<td id="income">
		<a href="./index.php?coupons/exportbyaudit/?auditId=0&payment=0">{$now.income}</a>
		</td>
		<td id="spend">
		<a href="./index.php?coupons/exportbyaudit/?auditId=0&payment=1">{$now.spend}</a></td>
		<td id="ending">{$now.ending}</td>
	</tr>


	{foreach from=$audit item=l }
	<tr>

		<td>{$l.add_time|date_format:"%Y-%m-%d"}</td>
		<td>{$l.beginning}</td>
		<td><a href="./index.php?coupons/exportbyaudit/?auditId={$l.id}&payment=0">{$l.income}</a></td>
		<td><a href="./index.php?coupons/exportbyaudit/?auditId={$l.id}&payment=1">{$l.spend}</a></td>		
		<td>{$l.ending}</td>

	</tr>
	{/foreach}

</table>


<div class="pagination pagination-centered">
<ul id="pager"></ul>
</div>

</div>




</div>

<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

{literal}

 <script type='text/javascript'>

 $(document).ready(function(){
	 $(".form_date").bind("change",getAuditMx);
	 getAuditMx();
 })
 

function getAuditMx(){
	var start=$("#starttime").val();
	var end=$("#endtime").val();
	$.get("./index.php?coupons/getcouponsgroupbychargetypes/?starttime="+start+"&endtime="+end,function(data){
		var income=data.data.income;
		var spend=data.data.spend;
	
		$(".income_0").html(income[0]);
		$(".income_2").html(income[2]);
		$(".income_3").html(income[3]);
		$(".income_4").html(income[4]);
		$(".spend_1").html(spend[1]);
		$(".spend_3").html(spend[3]);
		
	},"json")
	
}
 

 $('.form_date').datetimepicker({
     language:  'zh-CN',
     format:'yyyy.mm.dd',
     weekStart: 1,
     todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
 });

 
	function audit(){
	$.post("./index.php?coupons/setaudit",function(data){
       alert(data.message);
       location.reload();
   },"json")
	}




</script> {/literal} {include file="news/footer.tpl"}