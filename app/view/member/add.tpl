{include file="news/header.tpl"}
   
{include file="news/top.tpl"}



{include file="news/nav.tpl"}

<!-- start: Content -->

<div class="row-fluid">
<div class="well">		
<div class="nav nav-tabs">
	<li><a href="javascript:history.go(-1)"><<返回</a></li>
</div>
	
<table class="table">


<form action="./index.php?member/adduser" method="post" name="example_form">	
 	 <tr>
				<td class="span2">账　　号：</td>
				<td><input type="text" name="username" id="username" class="btinput"  autocomplete="off" /></td>
	 </tr>
                          <tr>
				<td>设置密码：</td>
				<td><input type="text" name="password" id="password" class="btinput"  value="{$password}" autocomplete="off"/></td>
			  	</tr>
			  	<tr>
				<td>真实姓名：</td>
				<td><input type="text" name="real_name" id="real_name" class="btinput"  autocomplete="off"/></td>
			  	</tr>
			  	<tr>
				<td>手　　机：</td>
				<td><input type="text" name="mobile_phone" id="mobile_phone" class="btinput"  autocomplete="off"/></td>
			  	</tr>
			  	<!--
  				<tr>
					<td>用  户  组：</td>
					<td>
					{foreach from=$group item=l}
					<label class="radio pull-left"> 
					<input type="radio" name="groupid" value="{$l.id}" />{$l.name}
					</label>
					{/foreach}
					</td>
			  	</tr>
			  	-->
<tr><td>验证码：</td>
<td><input type="text" name="codeimg" id="codeimg" class="btinput" style="width:80px;marign-right:10px;"/><img src="./index.php?anonymous/captcha"  id="codeimgs"  style="margin-left:20px;"/><a href="javascript:void(0)" onclick="changeImg()">换一张?</a></td></tr>
			  <tr>
				<td> </td>
				<td><a href="javascript:register()" class="btn btn-warning">创建</a></td>
				
			  </tr>
		</table>

		</form>
</table>
</div>
</div>

{literal}
<script language="javascript">

function register(){
    var mobile=$("#mobile_phone").val();
    var password=$("#password").val();
    var username=$("#username").val();
    var real_name=$("#real_name").val();
    var codeimg=$("#codeimg").val();
    var groupid=$('input[name="groupid"]:checked').val();
    
    if(mobile.length!=11){
        alert("手机号码为11位数");
        return;
    }
    
    if(codeimg.length!=4){
        alert("验证码填写不正确");
        return;
    }
    
    if(password.length<5){
        alert("密码至少为6位数");
        return;
    }
    
    if(real_name.length<2){
        alert("真实姓名没有填写");
        return;
    }
    
    $.post("./index.php?member/adduser",{mobile_phone:mobile,real_name:real_name,groupid:groupid,codeimg:codeimg,password:password,username:username,password:password},function(data){
    if(data.status){
        alert(data.message);
       // location.reload();
    }else{
    alert(data.message);
    }
    },"json")
    
    
}

function changeImg(){
	document.getElementById("codeimgs").src="./index.php?anonymous/captcha/?id="+Math.random();

	}
</script>
{/literal}
<!--表单验证//-->
{include file="news/footer.tpl"}
