{include file="news/header.tpl"}
{literal}
<style>
.table th{background:#f0f0f0;}
.table td{text-align:left;}
.table{font-size:12px;}
.suoding{height:30px;}
.commentimg {max-width: 100%;max-height: 100%;}
#profile a{box-shadow: 1px 2px 3px darkkhaki;padding: 5px 0px;border-bottom: 2px dotted #ccc;margin-bottom: 5px;display: block;text-align: center;}
.code{background:#282c34;color:#c678dd;font-size:12px;}
</style>
{/literal}

<!-- 头部// -->


	<!-- start: Content -->
			<div class="">
			
						
			<div class="row-fluid">

<div class="box">
<div class="box-content"><!-- Default panel contents -->
<div class="suoding">

<a href="javascript:add()" class="btn">添加广告</a>

调用方法 在相应页面下 
<span class="code">
{literal}{foreach from=$adv item=l} {$l.url} {$l.image}{/foreach}{/literal} </span> 即可
</div>
<table class="table ">

<tr>
<th>序号</th>
<th>状态</th>
<th>位置</th>
<th>添加时间</th>
<th>广告名称</th>
<th>广告图片</th>
<th>链接网址</th>
<th>操作</th>
</tr>
<tr>

{foreach from=$adv item=l}
<tr>
<td>{$l.id}</td>
<td><a href="javascript:setStatus({$l.id})" id="status_{$l.id}">{$l.status}</a></td>
<td>{$l.type}</td>
<td>{$l.add_time|date_format:"%Y-%m-%d"}</td>
<td>{$l.title}<a href="javascript:edit({$l.id})"><i class="icon-edit"></i></a></td>
<td><img src="{$l.image}" width="120px;" height="120px;"></td>
<td><a href="{$l.url}">{$l.url}</a></td>
<td><a href="javascript:del({$l.id})">X</a></td>
</tr>
<tr>
{/foreach}


</table>
</div>
</div>
</div>
</div>
 <script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
  <script  type="text/javascript" src="./static/public/layer/extend/layer.ext.js" ></script>

<script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>
 
 {literal}
 <script>
 function edit(id){
		$.layer({
		    type: 2,
		    shadeClose: true,
		    title: false,
		    closeBtn: [0, true],
		    shade: [0.3, '#000'],
		    border: [0],
		    offset: ['20px',''],
		    area: ['850px', '480px'],
		    iframe: {src: './index.php?adv/edit/?id='+id,
		        scrolling: 'yes'
		      }
		}) 

  }
 function add(sku){	
		$.layer({
		    type: 2,
		    shadeClose: true,
		    title: false,
		    closeBtn: [0, true],
		    shade: [0.3, '#000'],
		    border: [0],
		    offset: ['20px',''],
		    area: ['850px', '480px'],
		    iframe: {src: './index.php?adv/add/',
		        scrolling: 'yes'
		      }
		}) 

}
function del(id){


	if(!confirm("确认删除?")){
return;
	}
  $.get("./index.php?adv/remove/?id="+id,function(){
  location.reload();
  });
}
 
 function setStatus(id){
  $.post("./index.php?adv/setstatus",{id:id},function(data){
       if(data.status==false){
   alert(data.message);
   return;
        }

       $("#status_"+id).html(data.data);
	  },"json")
 }
 </script>
 {/literal}