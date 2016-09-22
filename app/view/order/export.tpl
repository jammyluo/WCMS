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



<div name="news"  class="form-inline">
		<span class="icon-eye-open">
	
	 发货日期:<input class="form_date" name="starttime" id="starttime" value="{$time.lastmonth}"  readonly> - <input name="endtime" class="form_date" value="{$time.now}"  id="endtime" readonly>

  <a  href="javascript:getGoodsByDate()">产品数量销售明细</a>  |

    <a  href="javascript:getGoodsMXByDate()">订单销售明细</a>

</div>
	<table class="table table-bordered">
	<tr><th>当前库存</th><th>当前销售总额</th><th>销售表</th><th>采购数量</th><th>库存状态</th></tr>
	<tr><td>{$rs.currentstock}</td><td>{$rs.currentsales}</td><td>{$rs.salesnum}</td><td>{$rs.purchase}</td>
	<td>{$rs.currentstock+$rs.currentsales-$rs.purchase}</td></tr>
	</table>
	

<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
	{literal}
	<script>
 function getGoodsByDate(){
     var start=$("#starttime").val();
     var end=$("#endtime").val();
     location.href='./index.php?orderinfo/getgoodsbydate/?starttime='+start+"&endtime="+end;
 }

 function getGoodsMXByDate(){
     var start=$("#starttime").val();
     var end=$("#endtime").val();
     location.href='./index.php?orderinfo/getgoodsmxbydate/?starttime='+start+"&endtime="+end;
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
 </script>
 {/literal}