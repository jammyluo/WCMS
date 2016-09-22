{include file="news/header.tpl"} 


<!-- 头部// -->
{include file="order/top.tpl"}



	<!-- start: Content -->
			<div id="content" class="span12">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">
<form name="news" action="/member/csearch" method="post"
	class="form-inline">
<span class="glyphicon glyphicon-search"></span>  <select
	name="type" class="form-control">
	<option value="mobile_phone">手机</option>
	<option value="real_name" selected>真实姓名</option>

</select>
<input type="hidden" name="mb" value="morder.tpl">
<input type="text" value="" name="value"
	class="form-control">
<button type="submit" class="btn btn-primary"><i class="icon-search"></i></button>

</form>
<table class="table table-striped  table-hover">
	<tr>


		<th width="12%">组别</th>
		<th width="10%">真实姓名</th>
		<th width="10%">联系方式</th>
		<th width="10%">军区</th>
		<th width="10%">城市</th>
		<th width="10%">积分</th>
		<th width="10%">金额</th>
		<th width="10%">操作</th>

	</tr>




	{section name=l loop=$news }
	<tr>
		




		<td id="{$news[l].uid}_realname">{$news[l].name}</td>

	
		<td id="{$news[l].uid}_real_name">{$news[l].real_name}</td>
		<td><span id="{$news[l].uid}_sj">{$news[l].mobile_phone}</span></td>
		<td id="{$news[l].uid}_address">{$news[l].country}</td>
		<td id="{$news[l].uid}_address">{$news[l].area}</td>
		<td>{$news[l].coupons}</td>
		<td>{$news[l].money}</td>
		<td><a href="/order/charge/?uid={$news[l].uid}" target="_blank">积分</a>|金额</td>

	</tr>
	{/section}

</table>


<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>


{literal} <script type='text/javascript'>
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return '/member/listing/?mb=morder.tpl&groupid=11&p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script> {/literal}
{include file="news/footer.tpl"}
