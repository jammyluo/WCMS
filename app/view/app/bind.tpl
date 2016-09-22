{include file="news/header.tpl"}

<div class="span12" style="text-align:center;">
<h1>官网账号绑定</h1>
<div class="">
<p><img src="" class="face">  <span class="username"></span></p>
<p>手机 <input type="text" name="username" id="username" value=""></p>
<p>密码 <input type="password" id="password" value=""></p>
<p><button name="" class="btn " onclick="bind()">绑定</button></p>
<p>绑定帐号后，可以拥有更多权限</p>
<input type="hidden" name="weixin" id="weixin" value="{$openid}">
</div>

</div>
{literal}
<script>

function bind(){
var weixin=$("#weixin").val();
var username=$("#username").val();
var password=$("#password").val();
$.post("./index.php?qq/savebind",{weixin:weixin,username:username,password:password,type:"weixin"},function(data){
  if(data.status){
  alert("绑定成功!");
  location.href="./index.php?anonymous/login";
   }else{
alert(data.message);
	   }
	
},"json")
	
}


</script>

{/literal}