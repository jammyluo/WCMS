<!DOCTYPE html>
<html>
<head>
<title>顶上集成吊顶</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="./static/public/jquery-1.11.0.min.js" ></script>
 {literal}
<style>
body {
	background: #2e3132;
}

#yaoyiyaoyes {
	background: url(/static/yaoyiyao/yaoyiyao.jpg) no-repeat;
	width: 200px;
	height: 204px;
	margin: 35% auto;
}
</style>
{/literal}

<div id="yaoyiyaono"
	style="font-size: 20px; margin: 10px; line-height: 35px; display: none;">
	感谢你参与本次摇奖活动</br>
</div>
<input type="hidden" name="openid" id="openid" value="{$openid}">
<div id="yaoyiyaoyes" style="display: none;"></div>
<div id="yaoyiyaoresult"
	style="text-align: center; font-size: 2em; margin: 10px; line-height: 50px; color: #fff;"></div>
{literal}
<script>
// 首先在页面上要监听运动传感事件 
function init(){
　　if (window.DeviceMotionEvent) {
　　　　// 移动浏览器支持运动传感事件
　　　　window.addEventListener('devicemotion', deviceMotionHandler, false);
　　　　$("#yaoyiyaoyes").show();
　　} else{
　　　　// 移动浏览器不支持运动传感事件
　　　　$("#yaoyiyaono").show();
　　} 
}

// 首先，定义一个摇动的阀值
var SHAKE_THRESHOLD = 3000;
// 定义一个变量保存上次更新的时间
var last_update = 0;
// 紧接着定义x、y、z记录三个轴的数据以及上一次出发的时间
var x;
var y;
var z;
var last_x;
var last_y;
var last_z;

// 为了增加这个例子的一点无聊趣味性，增加一个计数器
var count = 0;

function deviceMotionHandler(eventData) {
　　// 获取含重力的加速度
　　var acceleration = eventData.accelerationIncludingGravity; 

　　// 获取当前时间
　　var curTime = new Date().getTime(); 
　　var diffTime = curTime -last_update;
　　// 固定时间段
　　if (diffTime > 100) {
　　　　last_update = curTime; 

　　　　x = acceleration.x; 
　　　　y = acceleration.y; 
　　　　z = acceleration.z; 

　　　　var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000; 

　　　　if (speed > SHAKE_THRESHOLD&&!isloading) { 
　　　　　　// TODO:在此处可以实现摇一摇之后所要进行的数据逻辑操作
      
　　　　　 yao();
　　　　　
　　　　}

　　　　last_x = x; 
　　　　last_y = y; 
　　　　last_z = z; 
　　} 
} 
var isloading=false;
var count=1;
function yao(){
    isloading=true;

	var id=$("#openid").val();
　$.post("./index.php?yao/yao",{openid:id},function(data){
	isloading=false;
　　　　　　$("#yaoyiyaoresult").show();
　　　　　　$("#yaoyiyaoresult").html("加油吧，成功摇动"+count);
count++;

},"json")
}

$(document).ready(function(){
init();
});
</script>
{/literal}
