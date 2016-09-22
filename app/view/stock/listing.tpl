{include file="news/header.tpl"}
</head>
<body onload="loading()">

	<!-- start: Content -->
	<div id="loading"></div>  
	
			<div id="content" class="display:none;">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">


<div class="form-inline suoding">

<label class="checkbox">
		 
{$category}



	<div class="input-append">
	<input type="text" name="title" id="goods_name" placeholder="产品编号" class="input-xlarge" style="outline:medium">
							<button type="button" class="btn btn-default" onclick="search()">搜索</button>
						
</div>

		
		
	
</div>




<table class="table table-hover">
	<tr>

				<th class="col-md-2">入库时间</th>
		<th class="col-md-2">产品名称</th>
		<th class="col-md-1">SKU</th>
		<th class="col-md-1">入库数量</th>	
		<th>操作员</th>		
		<th>操作</th>
	</tr>

	{foreach from=$rs item=l}
	<tr id="{$l.id}" class="even">
	
		<td>{$l.add_time|date_format:"%Y-%m-%d"}</td>
		<td>{$l.goods_name}</td>
        <td>{$l.sku}</td>
        <td>{$l.num}</td>
        <td>{$l.action_name}</td>
        <td><a href="javascript:recycle({$l.id})">取消入库</a></td>
	</tr>
	{/foreach}

</table>

<div class="pagination pagination-centered">
<ul id="pager"></ul></div>

</div>




</div>


{literal}
<script type='text/javascript'>

function loading(){
	$("#loading").hide();
	$("#content").show();
}

  
$(document).ready(function(){
	  $("input[name='title']").keyup(function(event){
        if(event.which==13){
             search();
        }
		  })
	})
function search(){
	 var value=$("input[name='title']").val();
var src= "./index.php?stock/getstockbysku/?sku="+value;
	
    if(value.length<1){
   layer.alert("搜索内容不能为空哦",8);
 
     }else{

         location.href=src;
	
         }

	}

function recycle(id){
	if(!confirm("确认?")){
		return false;
	}
	
	$.post("./index.php?stock/removebyid",{id:id},function(data){
		if(data.status){
			$("#"+id).remove();
		}
		
	},"json")
}






var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?stock/listing/?p="+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}