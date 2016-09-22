<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8" />
	<title>登录</title>
  <meta name="Keywords" content="WCMS"> 
        <meta name="Description" content="WCMS"> 
    
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
		<script src="./static/public/jquery-1.11.0.min.js" type="text/javascript" ></script>
	<link href="./static/bootstrap2/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/retina.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/my.less" rel="stylesheet/less" />
		<script type="text/javascript" src="./static/public/jquery.cookie.js" ></script>

		<script type="text/javascript" src="./static/public/less.min.js" ></script>
	
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="{$config.qq}"  data-redirecturi="http://{$config.website}/qq.html" charset="utf-8" ></script>
	<!-- end: CSS -->
	{literal}
	<style type="text/css"">
span{color:#999999}
p{color:#999999}
.free-regist {
position: absolute;
right: 42px;
bottom: -37px;
background: #e8e8e8;
width: 115px;
height: 32px;
text-align: center;
line-height: 32px;
-moz-border-radius: 0 0 3px 3px;
-webkit-border-radius: 0 0 3px 3px;
border-radius: 0 0 3px 3px;
padding: 0px 5px 5px;
}
.free-regist span {
text-align: center;
font-size: 14px;
background: #7cbe56;
width: 115px;
height: 32px;
display: block;
-moz-border-radius: 0 0 3px 3px;
-webkit-border-radius: 0 0 3px 3px;
border-radius: 0 0 3px 3px;
}
#footer-2013 {
padding-bottom: 30px;
text-align: center;
margin-top: 50px;
}
.free-regist a{color:#fff}
.links{height: 30px;}
.links a{
	margin: 0 10px;
color:#666;	
}
.logo{
	width: 170px;
height: 60px;
margin-top: 10px;
font-size: 30px;
font-weight: 700;
color: #c81623;
	
}
</style>
	{/literal}
<body>
<div class="dg_header_top" style="width:900px;height:100px;margin:0 auto;">

<div class="logo">你好</div>
</div>
<div style=" width: 900px; margin:0 auto; background: #fff;">
 

<div style="width: 892px;height: 360px;border-radius: 2px;padding: 6px;">
    <img src="{$adv.0.image}" style="height:360px;width:450px;float: left;">
	<!-- Main hero unit for a primary marketing message or call to action -->
    <div class="" style="position:relative;border: 1px solid #e1e1e1;width:440px;height:345px;padding-top: 15px;background:#fff;float:left;">
        <h1 style="padding-left: 90px;">用户登录</h1>
        <div class="form-inline pull-left" style="padding-left: 90px;">
			<div class="" style="margin: 15px 0 20px 0;">
				<p class="" style="margin-bottom: 2px;">手机</p>
				<span class="input-prepend input-append">
					<span class="add-on" style="height: 24px;"><i class="icon-user"></i></span>
					<input  name="mobile" id="mobile_phone" type="text" value="" placeholder="" />
				</span>
				<br>	
				<p class="" style=" margin-bottom: 2px; ">密码</p>
				<span class="input-prepend input-append">
					<span class="add-on" style="height: 24px;"><i class="icon-lock"></i></span>
					<input  name="password" id="password" type="password" value="" placeholder="" />
				</span>
				<br>
				<button class="btn btn-danger"  onclick="return logincheck()" style=" width: 245px; margin-top: 15px; ">登陆</button>
				
			</div>
			<div class="" style="color: #313131;">
				<span class="jihuotishi">
							<span id="qqLoginBtn" ></span>   <a href="./index.php?anonymous/password">找回密码</a>
			
				</span><br>
				
			</div>
		</div>
		  <div class="free-regist">
            <span><a href="./index.php?anonymous/register" clstag="passport|keycount|login|08">注册&gt;&gt;</a></span>
        </div>
    </div>
    
  
    
    </div>
</div>


<div id="footer-2013">
        <div class="links">
          <a href="./index.html">首页</a>|<a href="">关于我们</a>|<a href="">帮助中心</a>
        </div>

        <div class="copyright">© 2015 {$config.copyright}&nbsp; </div>
    </div>
   
  {literal}
  <script>
  $(document).ready(function(){

$("#mobile_phone").focus();
	  })
 
	  $(document).ready(function(){
		  $("#verifyCode").keydown(function(e){
		    if(e.which==13){
		  	  logincheck();
		    }
		  });

		  })
		  				



		  function logincheck() {
		  	var passwd= $("input[name='password']").val();
		  	var mobile = $("input[name='mobile']").val();
		  	var code= $("input[name='codeimg']").val();
		  	mobile=mobile.replace(/ /g,"");
		  	passwd=passwd.replace(/ /g,"");
		                   if(mobile.length!=11){
		                 alert("手机号码应该为11位，请检查号码是否正确");
		                return false;
		          }


		      	if (passwd.length <= 0) {
		  		alert("密码不能为空");
		  		return false;
		  	}

		      	
		      	$.ajax({
		      	   async:false,
		      	   url: "http://www.d-shang.com/index.php?ios/sync/?",
		      	   type: "GET",
		      	   dataType: 'jsonp',
		      	   jsonp: 'jsoncallback',
		      	   data: "password="+passwd+"&mobile="+mobile,
		      	   timeout: 5000,
		   
		      	   success: function (json) {
		      		 if(!json.status){
		      			 alert(json.message);
		      			 return;
		      		 }else{
		      			 var d=json.data;
		      			var date = new Date();
		      			date.setTime(date.getTime() + (10 * 60 * 60 * 1000));
		      			$.cookie("user", d.user, {
	    					path : '/',
							expires : date
						});
		      			 
		      			
		      			$.cookie("token", d.token, {
	    					path : '/',
							expires : date
						});
		      			 location.reload();
		      		 }
		      	   }
		      	  
		      	})
		      	
		  

		       //     location.reload();
		  	return false;

		  }


		  		 function fleshVerify(){
		  			//重载验证码
		  			    var timenow = new Date().getTime();
		  			    document.getElementById('verifyImg').src= './index.php?anonymous/captcha/?'+timenow;
		  			}

  </script>
  {/literal}  
    
  </body>
</html>