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
	<select name="groupid" class="input-small" id="groupid">
	<option value="0">-选择-</option>
	{foreach from=$group item=l}
	<option value="{$l.id}"
	{if $current==$l.id}selected{/if}
	>{$l.name}</option>
	{/foreach}
	</select>
	<input name="name" type="text" class="input-middle" placeholder="">
<button class="btn " type="button" onclick="add()">添加</button>
<button class="btn " type="button" onclick="rename()">更名</button>
<input type="hidden" name="id" value="">
</div>
</td>

<tr>

</tr>




<tr><td>标签　　<span class="flag">
{foreach from=$flag item=l}
<label class="label label-default" id="flag_{$l.id}" title="{$l.id}">
{$l.name}  
<a href="javascript:remove({$l.id})" >x</a>
</label>
{/foreach}</span></td></tr>



</table>


</div>
</div>
</div>
{literal}
<script>

$(function(){
	
$("select").bind("change",jump);
$("label").bind("click",checked)

})

function jump(){
var groupid=$(this).val();
location.href="./index.php?flag/flag/?groupid="+groupid;	
}

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
  return;
  }
var groupid=$("#groupid").val();
if(groupid==0){
alert("请选择分组");
return;
	
}
  $.post("./index.php?flag/add",{name:name,groupid:groupid},function(data){
if(data.status){

	var htm='<label class="label label-default" id="flag_'+data.data+'">'+name+'　<a href="javascript:remove('+data.data+')">x</a>';
  $(".flag").append(htm);
	  }else{

alert(data.message)
		  }
	  },"json")

}

function remove(id){
if(!confirm("确认")){
return;
	}
$.post("./index.php?flag/remove/",{id:id},function(data){
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
