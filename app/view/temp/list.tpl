{include file="news/header.tpl"}



<!-- 头部// -->
<!-- 头部// -->
{include file="news/top.tpl"}

{literal}
<style>
table th{background:#f5f5f5;}
small{border-bottom:none;}
.rs{color:blue;border-bottom:1px dashed blue;}
.icon-star{color:orange;font-weight:700;}
</style>
{/literal}
{include file="news/nav.tpl"}
	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">
  <div class="form-inline suoding">
  <div class="input-append">
<input type="text" name="name" id="name" placeholder="模板名或者备注名" >

<input type="button" value="搜索" onclick="search()" class="btn ">
</div>

<a href="javascript:add()">新建</a>
</div>
<!-- 工具栏 -->
<table class="table table-hover">



  <tr>
    <th class="span1">
    <div class="btn-group">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    类型
    <span class="caret"></span>
  </a>
     <ul class="dropdown-menu">
    <!-- dropdown menu links -->
{foreach from=$type item=l}
<li><a href="./index.php?temp/templist/?type={$l.id}">{$l.name}</a>
</li>
{/foreach}
  </ul>
  </div>
    
    </th>
    <th class="span1">模板名称</th>
     <th class="span2">备注</th>
     <th class="span2">版本</th>
     <th class="span1">操作</th>
    <th class="span1">最近更新</th>
    <th class="span1">操作人</th>
  </tr>
  {foreach from=$templist item=l name=g}
  <tr id="list{$l.id}">
  
    <td >{$l.type}</td>
    <td><a href="./index.php?temp/edittemp/?id={$l.id}">{$l.name}</a></td>
  
    <td>{$l.remark}</td>
    <td>{$l.version}</td>
    <td><a href="./index.php?temp/history/?id={$l.id}"><i class="icon-time"></i></a>
    <a href="javascript:trash({$l.id})"><i class="icon-trash"></i></a>
    </td>
         <td> <small>{$l.modified|date_format:"%m/%d %H:%M"}</small></td>
  <td>{$l.action}</td>
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
	 $("input[name='name']").keyup(function(event){
		   if(event.which==13){
	              search();
	         }
		 })
})


function add(){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', '300px'],
	    iframe: {src: './index.php?temp/add/',
	        scrolling: 'no'
	         }
	}) 
}


function search(){
	var name=$("#name").val();

	if(name==""){
    alert("请输入模板名字");
    return;
	}

	location.href='./index.php?temp/search/?tempname='+name;
	
}

function trash(id){
 if(confirm("确认删除?")){
	$.post("./index.php?temp/remove/",{id:id},function(data){
      alert(data.message);
      if(data.status==true){
       $("#list"+id).remove();
       }
	},"json")
 }
}

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return '/member/listing/?groupid={/literal}{$groupid}&verify={$verify}&{literal}&p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
