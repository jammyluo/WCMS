{include file="news/header.tpl"}
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="{$config.qq}"  data-redirecturi="http://www.d-shang.com/qq.html" charset="utf-8" ></script>

<body>
<div class="container">
<div class="span12" style="margin:0 auto;text-align:center;">
<h1>官网账号绑定</h1>
<div class="">
<p><img src="" class="face">  <span class="username"></span></p>
<p>手机 <input type="text" name="username" id="username" value=""></p>
<p>密码 <input type="password" id="password" value=""></p>
<p>　　　　<button name="" class="btn btn-success" onclick="bind()">绑定</button></p>
<p>绑定帐号后，以后就可以实现一键QQ登录啦</p>
<input type="hidden" name="qq" id="qq" value="">
</div>

</div>
</div>

{literal}
<script>

function bind(){
var qq=$("#qq").val();
var username=$("#username").val();
var password=$("#password").val();
$.post("./index.php?qq/savebind",{qq:qq,username:username,password:password,type:"qq"},function(data){
  if(data.status){
  alert("绑定成功!");
  location.href="./index.php?anonymous/login";
   }else{
alert(data.message);
	   }
	
},"json")
	
}


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
				$(".face").attr("src",s.data.figureurl_2);
				$(".username").html(s.data.nickname);
				$("#qq").val(openId);
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
</script>

{/literal}
</body>