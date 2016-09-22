{include file="news/header.tpl"}


{literal}
<style>
table{font-size:12px;}
table th{background:#f5f5f5;}
small{border-bottom:none;}
.rs{color:#666;font-weight:400;}
.icon-star{color:orange;font-weight:700;}
.none td{border-bottom:none;}
.exec{color:blue;}
.genjin{color:orange;}
</style>
{/literal}
<!-- 头部// -->
<!-- 头部// -->
{include file="news/top.tpl"}


{include file="news/nav.tpl"}
	<!-- start: Content -->
			<div style="min-height:680px;">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->


<div class="box-content">

<table class="table  table-hover">
<tr><th>序号</th><th>抽奖时间</th><th>客户姓名</th><th>手机</th><th>区域</th><th>中奖情况</th></tr>

{foreach from=$rs item=l name=g}
<tr>
<td>{$smarty.foreach.g.iteration}</td>
<td>{$l.add_time|wtime}</td>
<td>{$l.junqu}</td>

<td>{$l.real_name}</td>
<td>{$l.coupons}</td>
<td>{$l.remark}</td>
<td></td>
{/foreach}
</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>
<script src="./static/public/layer/layer.min.js" ></script>


{literal}
<script type='text/javascript'>

$(document).ready(function(){

	  $(".info").bind("mouseover",function(){
		    $(this).popover("show");
			   })
	  $(".info").bind("mouseout",function(){
		    $(this).popover("hide");
			   })

})


function edit(id){
$.layer({
    type: 2,
    shadeClose: true,
    title: false,
    closeBtn: [0, true],
    shade: [0.8, '#666'],
    border: [0],
    offset: ['20px',''],
    area: ['700px',  '330px'],
    iframe: {src: './index.php?crm/edit/?id='+id,
        scrolling: 'no'
         }
}) 
}


function append(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px',  '330px'],
	    iframe: {src: './index.php?crm/append/?id='+id,
	        scrolling: 'no'
	         }
	}) 
	}

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?geek/history/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
