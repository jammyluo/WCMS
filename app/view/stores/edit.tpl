{include file="news/header.tpl"}
{literal}
<style>
body{background-color:#fff;}
#content {top: 0px;padding: 5px;background:#fff;}
.table th{background:#fff;}
.table td{text-align:left;}
.suoding{height:30px;}
.commentimg {max-width: 100%;max-height: 100%;}
#profile a{box-shadow: 1px 2px 3px darkkhaki;padding: 5px 0px;border-bottom: 2px dotted #ccc;margin-bottom: 5px;display: block;text-align: center;}
</style>
{/literal}

<!-- 头部// -->


	<!-- start: Content -->
			<div  class="">
			
						
			<div class="row-fluid">

<div class="box"><!-- Default panel contents -->
<div>
<table class="table">
<input type="hidden" name="id" value="{$rs.id}">
<tr>
<td>地址</td>
<td><select name="province"  id="province" data="2" class="input-small">
<option value="">-省份-</option>
{foreach from=$provinces item=l}

<option value="{$l.id}"{if $l.id==$rs.province}selected{/if}>{$l.name}</option>
{/foreach}
</select>

<select name="city" id="city" data="3" class="input-small">
{foreach from=$citys item=l}

<option value="{$l.id}"{if $l.id==$rs.city}selected{/if}>{$l.name}</option>
{/foreach}
</select>

<select name="town" id="town" data="4" class="input-small">
{foreach from=$areas item=l}

<option value="{$l.id}"{if $l.id==$rs.town}selected{/if}>{$l.name}</option>
{/foreach}

</select>
</td>
</tr>
<td>门牌号地址</td>
<td><input type="text" name="address" class="input-xxlarge" value="{$rs.address}"></td>
</tr>

<tr><td>
联系人
</td>
<td><input type="text" name="contact" title="门店联系人" class="input-large" value="{$rs.contact}"></td>
<td>
</td></tr>

<tr><td>
联系方式
</td>
<td><input type="text" name="tel" title="门店联系方式" class="input-large" value="{$rs.tel}"> (非常重要)</td>
<td>
</td></tr>

<tr>
<td>门店面积</td>
<td>
<input type="text" name="size"  value="{$rs.size}" class="input-small">平方米</td>
</tr>


<tr>
<td>专卖店级别</td>
<td>
<select name="level" class="input-middle" id="level">
<option value="3" {if $rs.level==3}selected{/if}>三代店</option>
<option value="4" {if $rs.level==4}selected{/if}>四代店</option>
<option value="5" {if $rs.level==5}selected{/if}>五代店</option>
</select>
</td>
</tr>


<tr>
<td>状态</td>
<td>
<select name="status" id="status">
{foreach from=$status key=key item=l}
<option value="{$key}" {if $rs.status==$key}selected{/if}>{$l}</option>
{/foreach}
</select>

</td>
</tr>

<tr><td></td><td>
<button  onclick="save()" class="btn " value="保存">保存</button> <a href="javascript:history.go(-1)" class="btn " >返回</a>

</td></tr>
</table>
</div>
</div>
</div>
</div>


<script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>

 {literal}
 <script>
 $(function(){

	  $("select").bind("change",checked);

		})
	function checked(){

		var type=$(this).attr("data");
		var val=$(this).val();

	  if(val==""){
	return;
		  }

	  $.post("./index.php?province/areas",{type:type,id:val},function(data){

	var htm=parseJson(data);
	if(type==2){
	$("#city").html(htm);
	$("#town").html("")
	}else if(type==3){
	$("#town").html(htm);
	}

	  
		  },"json")
	}

	function parseJson(data){
	var htm="<option value=''>-选择-</option>";
	  for(var i=0;i<data.length;i++){
	  htm=htm+"<option value='"+data[i].id+"'>"+data[i].name+"</option>";
		 }
		return htm;
	}
	function save(){
		var province=$("#province").val();
		var city=$("#city").val();
       var id=$("input[name='id']").val();
		var town=$("#town").val();
		var address=$("input[name='address']").val();
		var contact=$("input[name='contact']").val();
		var tel=$("input[name='tel']").val();
		var size=$("input[name='size']").val();
		var level=$("#level").val();
var status=$("#status").val();
		
			$.post("./index.php?stores/save",{id:id,province:province,city:city,town:town,address:address,contact:contact,tel:tel,size:size,level:level,status:status},function(data){

		   if(data.status){
		     alert("保存成功!");
			}else{
		   alert(data.message);
			}
		   },"json")

		}
 </script>
 
 {/literal}