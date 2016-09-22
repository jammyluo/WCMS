<html>
<head>
<script src="/static/public/jquery-1.11.0.min.js" type="text/javascript"></script>
{literal}

<style type="text/css">
.egg {
	width: 750px;
	height: 500px;
	margin: 50px auto 20px auto;
	background: url(/static/egg/images/bg.jpg);
position: relative;

}

.egg ul li {
	z-index: 999;
}

.eggList {
	padding-top: 110px;
	position: relative;
	width: 660px;
}

.eggList li {
	float: left;
	background: url(/static/egg/images/egg_1.png) no-repeat bottom;
	width: 391px;
	height: 268px;
	cursor: pointer;
	position: relative;
	margin-left: 35px;
	top: 100px;
	left: 130px;
}

.eggList li span {
	position: absolute;
	width: 30px;
	height: 60px;
	left: 68px;
	top: 64px;
	color: #ff0;
	font-size: 42px;
	font-weight: bold
}

.eggList li.curr {
	background: url(/static/egg/images/egg_2.png) no-repeat bottom;
	cursor: default;
	z-index: 300;
}

.eggList li.curr sup {
position: absolute;
background: url(/static/egg/images/img-4.png) no-repeat;
width: 232px;
height: 181px;
top: -10px;
left: 65px;
z-index: 800;
}

.hammer {
	background: url(/static/egg/images/img-6.png) no-repeat;
	width: 156px;
	height: 118px;
	position: absolute;
	text-indent: -9999px;
	z-index: 150;
	left: 468px;
	top: 110px;
}

.resultTip {
	position: absolute;
	background: #ffc;
	width: 148px;
	padding: 6px;
	z-index: 500;
	top: 200px;
	left: 10px;
	color: #f60;
	text-align: center;
	overflow: hidden;
	display: none;
	z-index: 500;
}

.resultTip b {
	font-size: 14px;
	line-height: 24px;
}

.title {
	color: #fff;
font-size: 28px;
font-family: 微软雅黑;
position: absolute;
left: 100px;
width: 600px;
top: 50px;
}
.muji{
position: absolute;
top: 330px;
left: 600;
	
}
.muji a{
	font-size: 18px;
color: #fff;
}
.menu{
	margin: 0 auto;
width: 300px;
background: #f8cb9c;
height: 300px;
padding: 10px;
font-size: 12px;
text-align: left;
color: #9C5E00;
}
</style>

<script>
function  zadan(obj) { 
	
    $(obj).children("span").hide(); 
    eggClick($(obj)); 
}; 
function donghua(){
 $("#hammer").animate({top:"150px",left:"420px"},1000);
  $("#hammer").animate({top:"110px",left:"455px"},1000);

}
var dingshi=setInterval("donghua()",2000);
var dansui=1;
function eggClick(obj) { 
if(dansui<1){

	alert("蛋都碎了，请勿再敲，马上给你换一个！");
	location.reload();
	return;
}

    var _this = obj; 
    
       
		$.post("./index.php?plugin/api",{filter:"single",plugin:"GeekPlugin"},function(rs){
			if(!rs.status){
    alert(rs.message);
    return;
				}
			$("#hammer").stop(true);

			clearInterval(dingshi);
		    
	        $(".hammer").css({"top":"150px","left":"420px"});
	        
	        setTimeout(function(){
	        	   _this.addClass("curr"); //蛋碎效果 
	                _this.find("sup").show(); //金花四溅 
	                $(".hammer").hide();//隐藏锤子 
	                $('.resultTip').css({display:'block',top:'280px',left:'315px',opacity:0}).animate({top: '240px',opacity:1},300,function(){    
	                dansui=0;
	                    $("#result").html("恭喜，您中得"+rs.data.prize); 

	    })
		        },300)
    },"json")
		
            	
		
} 
</script>
{/literal}
</head>


<body>
<div class="egg"><span class="title">
砸金蛋赢折扣卡！<br>
5折、6折、7折、8折，砸开有惊喜！
</span>
<div class="muji"><img src="./static/egg/images/muji.png"><br>
<a href="javascript:location.reload()">再来一次</a>
</div>
<ul class="eggList">
	<p class="hammer" id="hammer">锤子</p>
	<p class="resultTip" id="resultTip"><b id="result"></b></p>
	<li id="jindan" onclick="zadan(this)"><span></span><sup></sup></li>
</ul>
</div>


</body>

</html>