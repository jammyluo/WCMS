{include file="news/header.tpl"}
{literal}

<style>
.checked{
	
	background:#ff5f19;
}
</style>
{/literal}

<!-- 头部// -->
{include file="news/top.tpl"}


{include file="news/nav.tpl"}

<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">
<table class=table>
<td >
<div class="input-append">
	<input name="name" type="text" class="input-middle" placeholder="">
<button class="btn " type="button" onclick="add()">添加</button>
<input type="hidden" name="id" value="">
</div>
</td>

<tr>

</tr>




<tr><td>分页组　　<span class="flag">
{foreach from=$group item=l}
<label class="label label-default" id="flag_{$l.id}">
{$l.name}  
<a href="javascript:remove({$l.id})">x</a>
</label>
{/foreach}</span></td></tr>



</table>


</div>
</div>
</div>
{literal}
<script>

$(function(){
	
$("label").bind("click",checked)

})



function checked(){
var obj=$(this);
	var labels=$("label");
	labels.each(function(){
$(this).removeClass("checked");
		})
		
obj.addClass("checked");
	
}

function add(){
  var name=$("input[name='name']").val();
  if(name==""){
  alert("不能为空!");
  }
var groupid=$("#groupid").val();
  $.post("./index.php?temp/addtemptype",{name:name},function(data){
if(data.status){

	var htm='<label class="label label-default" id="flag_'+data.data+'">'+name+'　<a href="javascript:remove('+data.data+')">x</a>';
  $(".flag").append(htm);
	  }else{

alert(data.message)
		  }
	  },"json")

}

function remove(id){
if(!confirm("删除标签组,同时删除该组的所有标签")){
return;
	}
$.post("./index.php?temp/removetemptype/",{id:id},function(data){
  if(data.status){
  $("#flag_"+id).remove();
	}else{
alert(data.message);
		}
},"json")


}

</script>
{/literal}
{include file="news/footer.tpl"}
