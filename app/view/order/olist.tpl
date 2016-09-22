{include file="news/header.tpl"}

{literal}
<style>
.selected{color:red}
</style>
{/literal}
<!-- 头部// -->


	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">
{include file="order/top.tpl"}

<form class="form-inline" method="post" action="./index.php?order/search"><span
	class="glyphicon glyphicon-search"></span> <select name="type"
	class="input-small">
	<option value="orderno">订单号</option>
	<option value="shr"  selected>收货人</option>

</select>

<input type="hidden"  name="current" id="current" value="{$current}">
<input class="form-control" name="value"
	type="text">
<button class="btn btn-warning" type="submit"><i class="icon-search"></i></button>
筛选:{foreach from=$status key=key item=l}<a
	href="./index.php?order/listing/?type=status&value={$l}"
	{if $current==$l}class="selected"{/if}
	>{$key}</a>|{/foreach}
	<a href="javascript:daochu()" class="icon-print"> 导出</a>

</form>
<table class="table table-hover">
	<tr class=title>
		<th>交易状态</th>
		<th>宝贝名称</th>
		<th>买家姓名</th>
		<th>成交时间</th>
		<th>买家留言</th>
		<th>幸福豆</th>
		<th>操作</th>
		<th></th>
	</tr>




	{section name=l loop=$news }
	<tr id="zt_{$news[l].orderno}">
		<td width="8%" >{$news[l].status}</td>
		<td width="15%">{$news[l].name}</td>
		<td width="8%"><a href="./index.php?coupons/user/?uid={$news[l].uid}" target="_blank">{$news[l].shr}</a></td>
		<td width="12%">{$news[l].addtime|date_format:"%Y-%m-%d %H:%M"}</td>
		<td><a href="javascript:edit('{$news[l].orderno}')" class="icon-pencil"></a><span class="remark_{$news[l].orderno}">{$news[l].remark}</span></td>
		<td width="12%"><a href="#">{$news[l].coupons}</td>
		<td width="12%">{if $news[l].status=="等待审核"}


		<div class="btn-group" id="{$news[l].orderno}">
		<button type="button" class="btn "
			onclick="setStatus('{$news[l].orderno}',8)">确认</button>
		<button type="button" class="btn  dropdown-toggle"
			data-toggle="dropdown"><span class="caret"></span> <span
			class="sr-only"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="javascript:setStatus('{$news[l].orderno}',-1)"><i class="icon-remove"></i>关闭</a></li>
		
		</ul>
		</div>
				<a href="javascript:detail('{$news[l].orderno}')">明细</a>
		
	
	    {else}
	    <a href="javascript:detail('{$news[l].orderno}')">明细</a>
		{/if}</td>
		<td width="5%"></td>

	</tr>
	{/section}

</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>



<script src="./static/public/layer/layer.min.js" ></script>
                        <script src="./static/public/layer/extend/layer.ext.js" ></script>

{literal}
<script type='text/javascript'>

function detail(sno){
$.layer({
    type: 2,
    shadeClose: true,
    title: false,
    closeBtn: [0, true],
    shade: [0.8, '#000'],
    border: [0],
    offset: ['20px',''],
    area: ['820px', ($(window).height() - 50) +'px'],
    iframe: {src: './index.php?orderinfo/mx/?sno='+sno,
        scrolling: 'yes'
         }
}) 
}


function daochu(){
	var current=$("#current").val();
	location.href="./index.php?orderinfo/getorderinfobystatus/?status="+current;
}

function edit(orderno){
var remark=$(".remark_"+orderno).html();
var a=layer.prompt({title:'订单备注',type:3,val:remark},function(val){
	
	$.post("./index.php?order/setremarkbyorderno",{remark:val,orderno:orderno},function(data){
		if(!data.status){
			alert(data.message);
			return;
		}
		$(".remark_"+orderno).html(val);
		layer.close(a);
	},"json")
});
	
}


var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?order/listing/?type=status&value={/literal}{$current}{literal}&p="+page;
}
}
$('#pager').bootstrapPaginator(options);



function setStatus(orderno,status){
	if(!confirm("确认？")){
		return false;
	}
	
$.post("./index.php?order/setstatus",{orderno:orderno,status:status},function(data){

	if(data.message!="success"){
alert(data.message);
return;
	}
$("#"+orderno).hide();

$("#zt_"+orderno).remove();


},"json")
}

</script>
{/literal}

{include file="news/footer.tpl"}
