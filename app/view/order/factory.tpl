{include file="news/header.tpl"}
{literal}

<style>
.content{width:1366px;margin:0 auto;}
th{background:#f5f5f5;}
.selected{color:#fff;background:red;}
.navbar{background:#545652;height:30px;width:100%;}
.logo{line-height:30px;padding-left:10px;color:#fff;}
.sm{color:green;}
</style>
{/literal}

<!-- 头部// -->
<div class="navbar">
  <span class="logo">移动幸福城发货系统 v1.0</span>
    <span class="pull-right"><a href="/">首页</a></span>
</div>

	<!-- start: Content -->
			<div class="content">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">
{include file="order/top.tpl"}
	

<form class="form-inline" method="post" action="./index.php?order/factorysearch">

<div class="input-append">
 <select name="type"
	class="input-small">
	<option value="orderno">订单号</option>
	<option value="shr"  selected>收货人</option>

</select>

<input type="hidden"  name="current" id="current" value="{$current}">
<input class="form-control" name="value"
	type="text" value="{$value}">
<button class="btn btn-default" type="submit"><i class="icon-search"></i></button>
</div>
筛选:<a
	href="./index.php?order/factory/?type=status&value=8" {if $current==8} class="selected"{/if}>等待配货</a>|
	<a href="./index.php?order/factory/?type=status&value=9" {if $current==9} class="selected"{/if}>等待发货</a>|
		<a href="./index.php?order/factory/?type=status&value=10" {if $current==10} class="selected"{/if}>已发货</a>
	<br>
	<span class="sm">使用说明：配好货之后请点击配货按钮。   发好货之后点击发货按钮。</span>
</form>
<table class="table table-hover table-bordered">
	<tr class=title>
	    <th class="span1">序号</th>
		<th class="span1">交易状态</th>
		<th class="span2">订单名</th>
		<th class="span1">买家姓名</th>
		<th class="span1">操作时间</th>
		<th class="span2">买家留言</th>
		<th class="span1">发货方式</th>
		<th class="span1">操作</th>
	</tr>




	{section name=l loop=$news }
	<tr id="zt_{$news[l].orderno}">
	   <td width="8%">{$smarty.section.l.iteration}</td>
		<td width="8%" >{$news[l].status}</td>
		<td width="15%">{$news[l].name}</td>
		<td width="8%">{$news[l].shr}</td>
		<td width="12%">{$news[l].action_time|date_format:"%Y-%m-%d %H:%M"}</td>
		<td>{$news[l].remark}</td>
		<td></td>
		<td width="12%">{if $news[l].status=="等待审核"}


		<div class="btn-group" id="{$news[l].orderno}">
		<button type="button" class="btn "
			onclick="setStatus('{$news[l].orderno}',8)">确认</button>
		<button type="button" class="btn  dropdown-toggle"
			data-toggle="dropdown"><span class="caret"></span> <span
			class="sr-only"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="javascript:setStatus('{$news[l].orderno}',-1)"><i class="icon-remove"></i>关闭</a></li>
			<li><a href="javascript:detail('{$news[l].orderno}')">明细</a></li>
		</ul>
		</div>
		
	    {elseif  $news[l].status=="等待配货"}
	    	    <a href="javascript:setStatus('{$news[l].orderno}',9)" class="btn btn-default">配货</a>
	    	    <a href="javascript:detail('{$news[l].orderno}')">明细</a>
	    {elseif  $news[l].status=="等待发货"}
	    	    <a href="javascript:setStatus('{$news[l].orderno}',10)" class="btn btn-default">发货</a>
	    	    <a href="javascript:detail('{$news[l].orderno}')">明细</a>
	    
	    {else}
	    <a href="javascript:detail('{$news[l].orderno}')">明细</a>
		{/if}</td>

	</tr>
	{/section}

</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>



<script src="./static/public/layer/layer.min.js" ></script>

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
    iframe: {src: './index.php?orderinfo/outbound/?sno='+sno,
        scrolling: 'yes'
         }
}) 
}

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?order/factory/?type=status&value={/literal}{$current}{literal}&p="+page;
}
}
$('#pager').bootstrapPaginator(options);



function setStatus(orderno,status){
	if(!confirm("确认已完成操作!")){
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
