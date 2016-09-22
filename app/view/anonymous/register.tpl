<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8" />
	<title>注册</title>
	   <meta name="Keywords" content="WCMS"> 
        <meta name="Description" content="WCMS"> 
        <!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link href="./static/bootstrap2/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/retina.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/my.less" rel="stylesheet/less" />
		<script type="text/javascript" src="./static/public/less.min.js" ></script>	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
	
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
	<link rel="shortcut icon" href="ico/favicon.png" />
	<script src="./static/public/jquery-1.11.0.min.js" type="text/javascript" ></script>
	
	<!-- end: Favicon and Touch Icons -->	
		
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
<style type="text/css">
body{background:#f5f5f5;}
table td{height: 50px;}
.login-box{width:500px;}
</style>
{/literal}
</head>

<body>
		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
				
					<h1><i class="icon-user"></i> 用户注册</h1><hr>
		<table >
		
  <tr>
				<td style="width:20%;">手　　机</td>
				<td><input type="text" name="mobile_phone" id="mobile_phone" class="btinput"  autocomplete="off"/></td>
				<td> <span class="mobile_phone"></span>必填</td>
			  </tr>
                          <tr>
				<td>密　　码</td>
				<td><input type="password" name="password" id="password" class="btinput"  autocomplete="off"/></td>
				<td><span class="password"></span>长度至少6位</td>
			  </tr>
	
			

			  <tr>
				<td>真实姓名</td>
				<td><input type="text" name="real_name" id="real_name" class="btinput"  autocomplete="off"/></td>
				<td> <span class="real_name"></span>不公开</td>
			  </tr>

			
  <tr>
				<td>所属群体</td>
				<td colspan="2">
				<div class="form-inline">
{foreach from=$group item=l}
<label class="radio">
<input type="radio" name="groupid" value="{$l.id}" />{$l.name}
</label>
{/foreach}</div></td>
		
			  </tr>
<tr><td>验证码</td>
<td><input type="text" name="codeimg" id="codeimg" class="input-small"/><img src="./index.php?anonymous/captcha"  id="codeimgs" ><a href="javascript:void(0)" onclick="changeImg()">换一张?</a></td><td></td></tr>
			  <tr>
				<td> </td>
				<td><button  type="button" class="btn btn-danger" onclick="return register()">注册</button></td>
				<td> </td>
			  </tr>
			 
		</table>

				
					<hr />
					<p>
												 <a href="./index.php?anonymous/login">返回登陆</a>

					</p>	
				</div>
			</div><!--/row-->
			
				</div><!--/fluid-row-->
				
	</div><!--/.fluid-container-->




<script src="./static/public/layer/layer.min.js" ></script>
{literal}
<script language="javascript">

function changeImg(){
document.getElementById("codeimgs").src="./index.php?anonymous/captcha/?id="+Math.random();

}
function register(){
    var mobile=$("#mobile_phone").val();
    var password=$("#password").val();
    var real_name=$("#real_name").val();
    var codeimg=$("#codeimg").val();
    var groupid=$('input[name="groupid"]:checked').val();
    
    if(mobile.length!=11){
        layer.alert("手机号码为11位数",8);
        return;
    }
    
    if(codeimg.length!=4){
        layer.alert("验证码填写不正确",8);
        return;
    }
    
    if(password.length<5){
        layer.alert("密码至少为6位数",8);
        return;
    }
    
    if(real_name.length<2){
        layer.alert("真实姓名没有填写",8);
        return;
    }
    
    if(typeof(groupid) == "undefined"){
        layer.alert("请选择组别",8);
        return;
    }
    
    $.post("./index.php?anonymous/setregister",{mobile_phone:mobile,real_name:real_name,groupid:groupid,codeimg:codeimg,username:real_name,password:password},function(data){
    if(data.status){
        layer.alert("注册成功!",9,function(){
                location.href="./index.php?anonymous/login";

        
        });
        return;
    }
    layer.alert(data.message,8);
     changeImg();
    },"json")
    
    
}

</script>
{/literal}
</body>
</html>