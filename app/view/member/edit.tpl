{include file="news/header.tpl"}




	<div class="well"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">基本</a></li>
              <li><a href="#tab4" data-toggle="tab">权限</a></li>

              <li><a href="#tab5" data-toggle="tab">管理记录</a></li>
                   <li><a href="#tab6" data-toggle="tab">用户记录</a></li>

  </ul>
  <div class="tab-content" style="min-height:0;">
   <div class="tab-pane active" id="tab1">

<form action="./index.php?member/save" method="post" id="memberinfo" enctype="multipart/form-data" >


<table class="table">

<tr><td class="col-md-2">账号</td><td class="col-md-3">
<input name="username" type="text" class="form-control"  value="{$rs.username}" >
</td><td class=right rowspan=4 colspan="2"><img src="
{if $rs.face==''}./static/attached/face/default_01.jpg{else}
{$rs.face}{/if}"  class="thumbnail" width="130px" height="130px">&nbsp;&nbsp;&nbsp;&nbsp;
<br>
<a href="javascript:parent.location.href='./index.php?coupons/user/?uid={$rs.uid}'" target="_blank" class="btn btn-link">{$rs.coupons}幸福豆</a>

</tr>
<tr><td >密码</td><td class="col-md-3">
<input name="password" type="text"  class="form-control" value="{$password}" >
</td></tr>




<tr><td >邮箱</td><td class="col-md-3">
<input name="email" type="text" class="form-control"  value="{$rs.email}">
</td></tr>

<!-- 真实信息 -->


   <tr><td >姓名</td><td class="col-md-3">
<input name="real_name" type="text" class="form-control" value="{$rs.real_name}">
</td></tr>

<tr><td >手机</td><td class="col-md-3">
<input name="mobile_phone" type="text" class="form-control" value="{$rs.mobile_phone}">
</td></tr>

<tr><td >所在地区</td><td class="col-md-3" colspan="2">

<select name="province"  id="province" data="2" class="input-small">
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
<input type="text" class="input-middle" name="area" value="{$rs.area}">
</td></tr>





<tr><td >用户组</td><td class="col-md-3">
<select name="groupid" class="form-control input-middle">
{section name=l loop=$group}
<option value="{$group[l].id}"  {if $rs.groupid==$group[l].id}selected{/if}>{$group[l].name}</option>
{/section}
</select>

</td></tr>





<tr><td >注册信息</td><td colspan="3">
 {$rs.area}  <small>{$rs.add_time|date_format:"%Y/%m/%d %H:%M"} </small>


</td>
 </tr>

<tr>
<td></td>
<td>
<input type="hidden" name="uid" value="{$rs.uid}">
<input  type="submit"  name="" value="{$lang['SAVE']}"  class="btn btn-warning"></input>
</tr>

</table>
</div>


   <!-- 验证信息 -->
     <div class="tab-pane " id="tab4">
   <table class="table">


   <tr><td >账号状态</td><td >
<input type="radio" name="status"  value="0" {if $rs.status==0}checked{/if}>活跃
<input type="radio" name="status" value="1" {if $rs.status==1}checked{/if}>临时禁用
<input type="radio" name="status" value="2" {if $rs.status==2}checked{/if}>离职


</td></tr>


<tr><td >权限组</td><td >
<select name="manager">
{foreach from=$systemgroup key=key item=l}
<option value={$key} {if $rs.manager==$key}selected{/if}>{$l}</option>
{/foreach}
</select>

</td></tr>



<tr><td></td><td><a href="./index.php?stores/getstorebyuid/?uid={$rs.uid}" target="_parent">地址库</a>|<a href="./index.php?stores/add/?uid={$rs.uid}" target="_parent">增加地址</a></td></tr>
   <tr>
<td></td>
<td>
<input type="submit"  name="" value="{$lang['SAVE']}"  class="btn btn-warning"></input>
</tr>
   </table> </div>

       <div class="tab-pane " id="tab5">


      <div style="background:#666;color:#ccc;font-size:12px;padding: 10px;height:430px; overflow:auto;">

    <ul>
    {foreach from=$adminlog item=l}
    <li># {$l.action_time|date_format:"Y-m-d H:i"} {$l.event} </li>
    {/foreach}
    </ul>

   </div>
</div>

    <div class="tab-pane " id="tab6">


      <div style="background:#666;color:#ccc;font-size:12px;padding: 10px;height:430px; overflow:auto;">

    <ul>
    {foreach from=$ownlog item=l}
    <li># {$l.action_time|date_format:"Y-m-d H:i"} {$l.event} </li>
    {/foreach}
    </ul>

   </div>
</div>



</div>
</form>

</div>
<script src="./static/public/layer/layer.min.js" ></script>
<script src="./static/public/layer/extend/layer.ext.js" ></script>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	  $("select").bind("change",checked);

  $("input[name='status']").bind("change",st);

})

function authorize(uid){

	$.post("./index.php?buyauthorize/add",{uid:uid},function(data){

  alert(data.message);
		},"json");
}
function st(){

	var uid=$("input[name='uid']").val();
	var status= $("input[name='status']:checked").val();
	var username=$("input[name='real_name']").val();
  $.post("./index.php?member/setstatus",{uid:uid,status:status,username:username},function(data){
    alert(data.message);
    if(data.status){
    	self.close();
     }

	  },"json")
}

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

</script>
{/literal}

{include file="news/footer.tpl"}
