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
.input-small{width:130px;}
</style>
{/literal}

<!-- 头部// -->


	<!-- start: Content -->
			<div  class="">
			
						
			<div class="row-fluid">


<div class="box"><!-- Default panel contents -->
<div>
<table class="table">

<tr>
<td>所在地区</td>
<td><select name="province"  id="province" data="2" class="input-small">
<option value="">-省份-</option>
{foreach from=$provinces item=l}

<option value="{$l.id}">{$l.name}</option>
{/foreach}
</select>

<select name="city" id="city" data="3" class="input-small">
</select>

<select name="town" id="town" data="4" class="input-small">


</select>
</td>
</tr>

<tr>
<td>门牌地址</td>
<td><input type="text" name="address" title="详细地址" class="input-xxlarge" value=""> 如 舜都装饰市场夹板区A22号</td>
</tr>

<tr><td>
联系人
</td>
<td><input type="text" name="contact" title="门店联系人" class="input-large" value=""></td>
<td>
</td></tr>

<tr><td>
联系方式
</td>
<td><input type="text" name="tel" title="门店联系方式" class="input-large" value=""> (非常重要)</td>
<td>
</td></tr>

<tr>
<td>门店面积</td>
<td>
<input type="text" name="size"  value="" class="input-small">平方米</td>
</tr>


<tr>
<td>专卖店级别</td>
<td>
<select name="level" class="input-middle" id="level">
<option value="3">三代店</option>
<option value="4">四代店</option>
<option value="5" selected>五代店</option>
</select>
</td>
</tr>
<input type="hidden" name="uid" id="uid" value="{$uid}">

<tr>
<td></td>
<td><button type="submit" class="btn"  onclick="add()">增加</button>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
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


function add(){
var province=$("#province").val();
var city=$("#city").val();

var town=$("#town").val();
var address=$("input[name='address']").val();
var contact=$("input[name='contact']").val();
var tel=$("input[name='tel']").val();
var size=$("input[name='size']").val();
var level=$("#level").val();
var uid=$("#uid").val();
var items=$("input");
 items.each(function(){


	 if($(this).val()==""){
		 
 alert($(this).attr("title")+"不能为空");
 return false;
		 }
	 })

	$.post("./index.php?stores/addstores",{province:province,city:city,town:town,address:address,contact:contact,tel:tel,size:size,level:level,uid:uid},function(data){

   if(data.status){
     alert("添加成功!");
    location.href="./index.php?stores/mystore";
	}else{
   alert(data.message);
	}
   },"json")

}

</script>
{/literal}


<script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>

 