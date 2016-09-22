{include file="news/header.tpl"}

	{literal}
	<script type='text/javascript'>

function bind(){
	var key=$("#key").val();
	var remark=$("#remark").val();
	var attribute=$("#attribute").val();
	var module=$('input[name="module"]:checked').val();
    var status=$('input[name="status"]:checked').val();
	var s=$('input[name="status"]:checked +span').text();

	$.post("./index.php?attr/attr",{key:key,name:remark,module:module,attribute:attribute,status:status},function(data){
     if(data.status==false){
alert(data.message);
         }else{
alert(data.message);
$("#ctitle").after('<tr><td ><span class="label label-warning">新</span</td><td >'+key+'</td><td >'+remark+'</td><td >'+attribute+'</td><td >'+module+'</td><td >'+s+'</td></tr>');
             }
	},"json")
	
}
	   
  </SCRIPT>

{/literal}


<!-- 头部// -->
{include file="news/top.tpl"}



{include file="news/nav.tpl"}

<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->




<div class="box-content">

<!-- 内容// -->
<table class=table>




<form action="/attr/attr" method="post" >
<tr>
<td >实体(频道)</td><td  >
<input type="radio" name="module" value="1" checked>新闻</option>
<!--  
<input type="radio" name="module" value="3" >用户</option>
<input type="radio" name="module" value="2" >收集(评论)</option>
-->
</td><td ></td><td ></td><td ></td><td ></td></tr>

<td >字段类型</td><td  >
<select  name="attribute" id="attribute">
<option value="varchar">varchar文本</option>
<option value="decimal">decimal价格</option>
<option value="int">int整数</option>

</select>
</td><td ></td><td ></td><td ></td><td ></td></tr>
<tr>
<td  >字段名称</td>
<td  >
<input name="key"  type="text"  value="" id="key">(只限英文)
</td><td ><td ></td><td ></td><td ></td>
</tr>

<tr>
<td  >备注</td>
<td  ><input name="name" type="text" value="" id="remark">(备注名-中文)</td>
</td><td ><td ></td><td ></td><td ></td>
</tr>

<tr>
<td  >赋值</td>
<td  >
<input type="radio" name="status" value="1" checked><span>单个值</span>
<input type="radio" name="status" value="3" ><span>多个值</span>


</td><td ></td><td ></td><td ></td><td ></td>
</tr>
<tr>
<td  ></td>
<td  >
<input type="button" name="add"  value="{$lang['CREATE']}"  onclick="return bind()" class="btn"></input></td><td ></td><td ></td>
<td ></td><td ></td>
</form>
</tr>


<tr  id="ctitle"><th>序号</th><th>字段名</th><th>备注名</th><th>类型</th><th>实体</th><th>状态</th></tr>
{foreach from=$extend item=l}
<tr><td >{$l.eid}</td>
<td >{$l.key}</td>
<td >{$l.name}</td>
<td >{$l.type}</td>
<td >{$l.module}</td>
<td >
{if $l.status==1}单值{elseif $l.status==3}多值{/if}</td>
</tr>
{/foreach}

</table>
</div>

</div>
</div>
{include file="file:news/footer.tpl"}