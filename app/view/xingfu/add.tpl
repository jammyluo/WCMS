{include file="news/header.tpl"}
   
{include file="news/top.tpl"}



{include file="news/nav.tpl"}

<!-- start: Content -->
			<div>
			
						
			<div class="row-fluid">




				<div class="well">
				
					<div class="box-content">
<table class="table">


<form action="./index.php?member/adduser" method="post" name="example_form">
		
  <tr>
				<td class="span2">真实姓名：</td>
				<td><input type="text" name="real_name" id="real_name" class="btinput"  autocomplete="off" /></td>
			  </tr>
                          <tr>
				<td>设置密码：</td>
				<td><input type="text" name="password" id="password" class="btinput"  value="" autocomplete="off"/>至少6位数</td>
			  </tr>
	
			



			  <tr>
				<td>手　　机：</td>
				<td><input type="text" name="mobile_phone" id="mobile_phone" class="btinput"  autocomplete="off"/></td>
			  </tr>

<input type="hidden" name="groupid" id="groupid" value="12" />

</td>
			  </tr>
<tr><td>验证码：</td>
<td><input type="text" name="codeimg" id="codeimg" class="btinput" style="width:80px;marign-right:10px;"/><img src="./index.php?anonymous/captcha"  id="codeimgs"  style="margin-left:20px;"/><a href="javascript:void(0)" onclick="changeImg()">换一张?</a></td></tr>
			  <tr>
				<td> </td>
				<td><a href="javascript:register()" class="btn btn-success">创建</a>
                    <a href="javascript:history.go(-1)" class="btn btn-default">返回</a>
                </td>
				
			  </tr>
		</table>

		</form>






</table>
</div></div>
</div>
{literal}
<script language="javascript">

function register(){
    var mobile=$("#mobile_phone").val();
    var password=$("#password").val();
    var real_name=$("#real_name").val();
    var codeimg=$("#codeimg").val();
    var groupid=$('#groupid').val();
    var username=real_name;


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
        var con="恭喜你，注册成功，账号为:"+mobile+" <a href=\"javascript:history.go(-1)\">点击返回转账页面</a>";
        $(".box-content").html(con);
       // location.reload();
    }else{
    alert(data.message);
        changeImg();
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
