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
<tr><th>序号</th><th>添加时间</th><th>分享标题</th><th>浏览量</th><th>状态</th><th>操作</th></tr>

{foreach from=$rs item=l name=g}
<tr>
<td>{$smarty.foreach.g.iteration}</td>
<td>{$l.add_time|wtime}</td>
<td>{$l.title}</td>
<td>+{$l.views}</td>
<td>{$l.status}</td>
<td><a href="./index.php?customer/edit/?id={$l.id}">编辑</a>|<a href="./index.php?customer/ewm/?id={$l.id}">二维码</a></td>
</tr>
      
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
    return './index.php?crm/workflow/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
