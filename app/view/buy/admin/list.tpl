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


{$hello}
	<div class="input-append">
		<input type="text" name="title" id="goods_name" placeholder="产品简称或首字母拼音" class="input-xlarge" style="outline:medium">
		<button type="button" class="btn btn-default" onclick="search()">搜索</button>
	</div>

<a href="./index.php?stock/addstock" class="btn btn-success">入库</a>
<a href="./index.php?buy/export" class="btn btn btn-success">导出</a>
		
		
	
</div>




<table class="table table-hover">
	<tr>
		<td class="col-md-1" colspan=2>有  <b>{$num.totalnum}</b> 条记录</td>
		<th class="col-md-1">价格</th>
		<th class="col-md-2">类目</th>
		<th class="col-md-2">型号</th>
		<th class="col-md-1">SKU</th>
		<th class="col-md-1">包装数量</th>
		<th>库存</th>
		<th class="col-md-1">状态</th>
		<th>操作</th>
	</tr>

	{foreach from=$goods item=l}
	<tr id="{$l.id}" class="even">
	
		<td class="center" colspan=2><span class="icon-file"></span> &nbsp;&nbsp;
		<a href="./index.php?buy/edit/?id={$l.id}" >{$l.goods_name}</a></td>
		<td class="center">{$l.price}</td>
		<td class="center">{$l.categoryname}</td>
		<td class="center">{$l.type}</td>
		<td class="center">{$l.sku}</td>
		<td class="center">{$l.num}{$l.unit}</td>
		<td>{$l.stock}</td>
		<td>{$l.flag}</td>
		
		<td class="center" colspan="2">
		<input type="hidden" name="status" value="{$l.status}">
		<a href="./index.php?customer/article/?id={$l.id}" target="_blank"><span class="icon-qrcode"></span></a>
		&nbsp;&nbsp;
		
		<a
			href='./index.php?buy/mx/?sku={$l.sku}'
			 title="{$lang['PREVIOUS']}"><i class="icon-globe"></i></a>
			 
			 <a href="./index.php?stock/getstockbysku/?sku={$l.sku}">入库</a>
			 
			 <a href="./index.php?orderinfo/getorderinfobysku/?sku={$l.sku}">销售</a>
		</td>

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
	 var type=$("#type").val();
var src= "./index.php?buy/search/?title="+value;
	
    if(value.length<1){
   layer.alert("搜索内容不能为空哦",8);
 
     }else{

         location.href=src;
	
         }

	}

	

function act(name){

 var arrChk=$("input[name='chk_list']:checked");
	 var ids='';
	 var cid=$("input[name='category']").val(); 

if(name=='search'){
window.location.href='./index.php?factory/c/?type=manage&cid='+cid;         
return false;
}

 
 var flag=confirm('确认操作?');
 
 if(flag==false){
     return false;
 }

 $(arrChk).each(function(){
	     ids=ids+','+this.value;                        
	  }); 

	 $.post("./index.php?factory/edit",{ids:ids,cid:cid,type:name},function(data){
         alert(data.error);  
         window.location.href='./index.php?factory/c/?type=manage';
	 },"json");


}




function recyle(id,mid){
    if(confirm("确认删除")==true){
       
   	 $.post("./index.php?factory/remove/",{id:id,mid:mid},function(data){
       // alert("删除成功");
         $("#"+id).fadeOut();
	 },"json");
    }else{
      return false;
    }
}    

function visible(id){
	var status=$("input[name='status']").val();
	if(status==0){
      status=1;
      $("#statusimg"+id).html("<i class='icon-eye-close'></i>");
	}else{
      status=0;
      $("#statusimg"+id).html("<i class='icon-eye-open'></i>");
      
	}
	$("input[name='status']").val(status);
	
$.post("./index.php?factory/visible",{status:status,id:id},function(){
      
	})
}
       
function sort(id){
var s=$("#sort"+id).val();

$.post("./index.php?factory/s",{sort:s,id:id});
}    	       




var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?buy/listing/?cid={/literal}{$currentcid}&mid={$module}{literal}&p="+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}