{include file="news/header.tpl"}
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
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


<div class="box-content">

<form name="news" class="form-inline" action="./index.php?coupons/export/" method="post"
	class="form-inline"> 起止日期:<input class="form_date" name="starttime" value="{$smarty.now|date_format:'%Y.%m.%d'}"  readonly> - <input name="endtime" class="form_date" value="{$smarty.now|date_format:'%Y.%m.%d'}"  readonly> 
	<input type="hidden" name="uid" value="{$userinfo.uid}">
	<button type="submit" class="btn ">
  <span class="icon-upload-alt">导出</span> 
</button>


   

   用户 {$userinfo.real_name}  账户余额 {$userinfo.coupons} {if $userinfo.coupons!=$total}<span class="label label-important">警告</span>[{$total}]{else}<span class="label label-success">安全</span>{/if}余额 {$userinfo.money}
</form>



<table class="table table-striped  table-hover">
	<tr>


		<th width="6%">流水号</th>
		<th width="15%">日期</th>
		<th width="15%">订单号</th>
		<th width="10%">名称|备注</th>
        <th>账号</th>
		<th width="10%">收入</th>
		<th width="10%">支出</th>
		<th width="10%">渠道</th>
		<th width="10%">状态</th>

	</tr>




	{foreach from=$mx item=l }
	<tr>
		<td>{$l.id}</td>
		<td>{$l.date|date_format:"%Y-%m-%d %H:%M:%S"}</td>
		<td>{$l.orderno}</td>
		<td>{$l.remark}</td>
        <td>{$l.username}</td>
		<td>{if $l.payment==0}<span class="amount_pay_in">+{$l.coupons}</span></td>
		<td></td>
		{else}
		</td>
		<td><span class="amount_pay_out">{$l.coupons}</td>
		{/if}
		<td>{$l.chargetypes}</td>
<td class=left width="8%">{if $l.status=="等待审核"}<span class="label label-warning">{$l.status}</span>{else if $l.status=="关闭"}<span class="label label-default">{$l.status}</span>{else}<span class="label label-success">{$l.status}</span>{/if}</td>

	</tr>
	{/foreach}
</table>
<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>


{literal}
<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
 <script type='text/javascript'>

	
 
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
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?coupons/user/?uid={/literal}{$uid}{literal}&p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
