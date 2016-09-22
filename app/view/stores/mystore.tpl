{include file="anonymous/header.tpl"}
{literal}
<style>
.change{color:blue;}
</style>
{/literal}
<div style="padding:14px;background: #f5f5f5;">
感谢你的使用
</div>
<table class="table">
<tr><th>地址</th><th>联系人</th><th>联系电话</th><th>操作</th></tr>
{foreach from=$stores item=l name=g}
<tr id="store_{$l.id}">
<td>{$l.province}{$l.city}{$l.town} [{$l.address}]</td>
<td>{$l.contact}</td>
<td>{$l.tel}</td>
<td><a href="./index.php?stores/edit/?id={$l.id}" class="change">更改</a>|
<a href="javascript:remove({$l.id})" class="change">删除</a></td>

</td>
</tr>
{/foreach}

</table>
<div style="margin: 0 auto;width:200px;" id="queren">
<a href="./index.php?stores/add/?uid={$user.uid}" class="btn btn-danger">增加地址</a>

</div>
<script src="./static/public/layer/layer.min.js" ></script>

<script src="./static/public/layer/extend/layer.ext.js" ></script>

{literal}
<script>
function save(id){
var con=$("#address_"+id).html();
	var a=layer.prompt({title: '详细地址',val:con,length:200}, function(name){
	    $.post("./index.php?stores/saveaddress",{id:id,address:name},function(data){
         layer.alert(data.message,9);
         if(data.status==true){
             $("#address_"+id).html(name);
             layer.close(a);
         }

	   },"json")
	});
}

function remove(id){

 $.post("./index.php?stores/remove/",{id:id},function(data){
     alert(data.message);
     if(data.status==true){
     $("#store_"+id).remove();
      }
	 },"json")	
}
function queren(){
  $.post("./index.php?stores/confirm",function(data){
    layer.alert(data.message,9);
    if(data.status==true){
        $("#queren").html("恭喜你已确认");
    }
   },"json");
}

</script>
{/literal}