{include file="anonymous/header.tpl"}
{literal}
<style>
.change{color:blue;}
</style>
{/literal}


<table class="table table-hover">
<tr><th class="span1"></th><th class="span1">联系人</th><th class="span1">省份</th><th class="span1">地级市</th class="span1"><th class="span1">县级市</th><th>街道地址</th><th>手机</th><th></th></tr>
{foreach from=$stores item=l name=g}
<tr>
<td> {$smarty.foreach.g.iteration}</td>
<td>{$l.user}</td>

<td>{$l.province}</td>
<td>{$l.city}</td>
<td>{$l.town}</td>
<td>{$l.address}</td>
<td></td>
<td><td>
<td><a href="./index.php?stores/edit/?id={$l.id}" style="color:red" >修改 </a> |<a href="javascript:remove({$l.id})">X</a></td>
</tr>
{/foreach}

</table>
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