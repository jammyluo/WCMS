<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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
		<link href="./static/bootstrap3/css/bootstrap.min.css" rel="stylesheet" />
		<link href="./static/mycss/login.css" rel="stylesheet" />
		<script type="text/javascript" src="./static/public/less.min.js" ></script>
	<!-- end: CSS -->

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    
<body>
	<!-- Main hero unit for a primary marketing message or call to action -->
<!--
      <form class="form-signin">
        <h2 class="form-signin-heading">用户登录</h2>
        <input type="text" class="input-block-level" id="mobile_phone" name="mobile" placeholder="手机号"  required autofocus>
        <input type="password" class="input-block-level" id="password" name="password" placeholder="密码">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
-->
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header">
                    <h1 class="text-center text-primary">用户登录</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group-lg"  id="accountDiv">
                        <div class="input-group">
	                        <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
	                        <input class="form-control"  id="mobile_phone" name="mobile" type="text" placeholder="手机号" required autofocus>
                        </div>
                    </div>
                    <br>
                    <div class="form-group-lg" id="pwdDiv">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                            <input class="form-control" id="password" name="password" type="password" placeholder="密码" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group-lg" id="verifyCodeDiv">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></div>
                            <input class="form-control" style="width: 50%" id="verifyCode" name="codeimg" type="text" placeholder="验证码" required>
                            <a href="javascript:fleshVerify()" id="cap_resend" ><img src="index.php?anonymous/captcha" id="verifyImg" /></a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group-lg" id="btn_div">

                        <button class="btn btn-default btn-lg col-md-6" id="btn_register"  type="submit" onclick="return onRegister()">    注册    </button>
                        <button class="btn btn-primary btn-lg col-md-6" id="btn_login"     type="button" onclick="return logincheck()">    登录    </button>
                        <!-- <a href="./index.php?anonymous/password">找回密码</a> -->
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
    		</div>
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
		  				


 QC.Login({
  btnId : "qqLoginBtn",//插入按钮的html标签id
  size : "A_M",//按钮尺寸
  scope : "get_user_info",//展示授权，全部可用授权可填 all
  display : "pc"//应用场景，可选
 });

//从页面收集OpenAPI必要的参数。get_user_info不需要输入参数，因此paras中没有参数
  var paras = {};

  //用JS SDK调用OpenAPI
  QC.api("get_user_info", paras)
  	//指定接口访问成功的接收函数，s为成功返回Response对象
  	.success(function(s){
  		//成功回调，通过s.data获取OpenAPI的返回数据
  		if(QC.Login.check()){//如果已登录
  			QC.Login.getMe(function(openId, accessToken){
  				//alert(["当前登录用户的", "openId为："+openId, "accessToken为："+accessToken].join("\n"));
  				$.post("./index.php?qq/qq",{qq:openId},function(data){

                     if(data.status){
                     location.reload();
                         }else{

                     location.href="./index.php?qq/bind";
                             }
  	  				},"json")
  			});
  			//这里可以调用自己的保存接口
  			//...
  		}
  	})
  	//指定接口访问失败的接收函数，f为失败返回Response对象
  	.error(function(f){
  		//失败回调
  		alert("获取用户信息失败！");
  	})
  	//指定接口完成请求后的接收函数，c为完成请求返回Response对象
  	.complete(function(c){
  		//完成请求回调
  		//alert("获取用户信息完成！");
  	});


		 function onRegister() {
		 	window.open("./index.php?anonymous/register");
		 }
		 
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

		  	if(code.length!=4){
		  	  alert("验证码填写错误");
		  	  return false;
		  	}

		  	$.post("./index.php?anonymous/setlogin", {
		  		password: passwd,
		  		mobile_phone: mobile,
		  		codeimg:code
		  	}, function(data) {

		                    if(data.message!="success"){
		  		alert(data.message);
		  		fleshVerify();
		                      return false;
		                    }else{
		                        location.reload();
		                    }
		  	}, "json");
		  	
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