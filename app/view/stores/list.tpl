{include file="news/header.tpl"}
<!-- 头部// -->
<!-- 头部// -->
{literal}
<style>
<!--
.selected{font-weight:700;color:#f40}
.citys{line-height: 16px;
float: left;
width: 100%}
.table th{background:#f5f5f5;}
-->
</style>
{/literal}

{include file="news/top.tpl"}


{include file="news/nav.tpl"}
	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->


<div class="box-content">
 <div  class="form-inline suoding">
 
	 <div class="citys">
	<select name="province"  id="province" data="2" class="input-small">
<option value="">-省份-</option>
{foreach from=$rs.provinces item=l}

<option value="{$l.id}"  {if $rs.current==$l.id}selected{/if}>{$l.name}</option>
{/foreach}
</select>

</div>
</div>


<table class="table  table-hover">
	<tr>
	<th>序号</th>
	<th>省份</th>
	<th>地级市</th>
	<th>县级市</th>
	<th>详细地址</th>
	<th>经销商</th>
	<th>手机</th>
	<th>状态</th>
	</tr>




	{foreach from=$rs.stores item=l name=g}
	<tr id="store_{$l.id}">
	<td>{$smarty.foreach.g.iteration}</td>
		<td>{$l.province}</td>
	<td>{$l.city}</td>
	<td>{$l.town}</td>
	<td><a href="./index.php?stores/edit/?id={$l.id}"><i class="icon-edit"></i></a>&nbsp;{$l.address}</td>
	<td><a href="javascript:addarea({$l.uid})">{$l.user}</a></td>
	<td>{$l.tel}</td>
	<td>{$l.status}
	<a href="javascript:remove({$l.id})">X</a>
	</td>
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
	  $("select").bind("change",checked);

})

	function checked(){

		var type=$(this).attr("data");
		var val=$(this).val();

	  if(val==""){
	return;
		  }

		  location.href="./index.php?stores/stores/?province="+val;
	}

	function parseJson(data){
	var htm="<option value=''>-选择-</option>";
	  for(var i=0;i<data.length;i++){
	  htm=htm+"<option value='"+data[i].id+"'>"+data[i].name+"</option>";
		 }
		return htm;
	}

function remove(id){

 $.post("./index.php?stores/remove/",{id:id},function(data){
     alert(data.message);
     if(data.status==true){
     $("#store_"+id).remove();
      }
	 },"json")	
}

function search(){
	var name=$("#name").val();
	location.href='./index.php?stores/search/?name='+name;
}

function addarea(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', ($(window).height() - 150) +'px'],
	    iframe: {src: './index.php?stores/add/?uid='+id,
	        scrolling: 'no'
	         }
	}) 
	}

function edit(id){
$.layer({
    type: 2,
    shadeClose: true,
    title: false,
    closeBtn: [0, true],
    shade: [0.8, '#666'],
    border: [0],
    offset: ['20px',''],
    area: ['700px', ($(window).height() - 150) +'px'],
    iframe: {src: './index.php?stores/edit/?id='+id,
        scrolling: 'no'
         }
}) 
}
</script>
{/literal}
{include file="news/footer.tpl"}
