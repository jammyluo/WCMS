<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>快乐大转盘-顶上集成吊顶-行业第一品牌|中国集成吊顶领导品牌|集成吊顶十大品牌|顶上-生活之上</title>
<meta name="Keywords" content="顶上集成吊顶,集成吊顶十大品牌,集成吊顶招商加盟,顶上官网,吊顶品牌,吊顶代理,顶上品牌好,集成吊顶生产厂家" /> 
<meta name="Description" content="顶上-生活之上,专业的集成吊顶生产供应厂商!荣获集成吊顶行业十大品牌,集成吊顶招商加盟代理首选!顶上集成吊顶,最好的吊顶!求购集成吊顶,找集成吊顶报价,就选十大集成吊顶-顶上品牌." />
<link href="./static/d_shang/style/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="./static/d_shang/style/global.css"/>
<link rel="stylesheet" type="text/css" href="./static/bootstrap2/css/bootstrap.min.css"/>
<link rel="stylesheet" href="./static/d_shang_new/css/base.css">
     <script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="./static/public/layer/layer.min.js"></script>
       <script type="text/javascript" src="./static/public/layer/extend/layer.ext.js"></script>
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

{literal}
<style type="text/css">
.nav{margin-left:auto}
.well{border:none;background:#f9f9f9;}
.nav-tabs .active a{background:#5cb85c;color:#fff;}

small{
color: #999;
border-bottom: 1px #ccc dashed;    
}

.ly-plate{
    position:relative;
	width:480px;
	height:480px;
    margin:20px;
}
.rotate-bg{
	width:680px;
	height:680px;
	background:url(./static/zp/ly-plate.gif);
	position:absolute;
	top:0;
	left:0
}
.ly-plate div.lottery-star{
	width:320px;
	height:320px;
	position:absolute;
	top: 232px;
left: 242px;
	/*text-indent:-999em;
	overflow:hidden;
	background:url(rotate-static.png);
	-webkit-transform:rotate(0deg);*/
	outline:none
}
.ly-plate div.lottery-star #lotteryBtn{
	cursor: pointer;
	position: absolute;
	top:0;
	left:0;
	*left:-107px
}
</style>
{/literal}
</head>

<body style="height:750px;">
   <div class="main" style="height:750px;">
<div class="row">

<div class="span8 pull-left" >

<div class="alert alert-success pull-left;" style="margin:20px;">
你的状态：转盘次数<span id="num">{$wheeluser.num}</span>

</div>

<div class="ly-plate">
	<div class="rotate-bg"></div>
	<div class="lottery-star"><img src="./static/zp/rotate-static.png" id="lotteryBtn"></div>
</div>
</div>

<div style="float:left;">
中奖纪录
<ul>
{foreach from=$history item=l}
<li>{$l.add_time|wtime} {$l.remark} {$l.charge}</li>
{/foreach}
</ul>

                                              <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_5819922'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s23.cnzz.com/stat.php%3Fid%3D5819922%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
</div>

</div>
    <script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>

<script type="text/javascript" src="./static/zp/js/jQueryRotate.2.2.js"></script>
<script type="text/javascript" src="./static/zp/js/jquery.easing.min.js"></script>
{literal}
<script type="text/javascript">
$(function(){
	var timeOut = function(){  //超时函数
		$("#lotteryBtn").rotate({
			angle:0, 
			duration: 10000, 
			animateTo: 2880, //这里是设置请求超时后返回的角度，所以应该还是回到最原始的位置，2160是因为我要让它转6圈，就是360*6得来的
			callback:function(){
				alert('网络超时')
			}
		}); 
	}; 
	var rotateFunc = function(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
		$('#lotteryBtn').stopRotate();
		$("#lotteryBtn").rotate({
			angle:0, 
			duration: 5000, 
			animateTo: angle+1440, //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
			callback:function(){
				layer.alert(text,9)
			}
		}); 
	};
	
	$("#lotteryBtn").rotate({ 
	   bind: 
		 { 
			click: function(){
				$.post("./index.php?plugin/api",{filter:"single",plugin:"GeekPlugin"},function(rs){
				
				 if(rs.status==false){
				  layer.alert(rs.message,8);
				  return;
				 }
				
				  var data=rs.data.tickets;
                  $("#num").html(rs.data.num);
				  if(data==1){
						rotateFunc(1,157,'恭喜您抽中50000积分')
					}
					if(data==2){
						var angle = [112,292];
						angle = angle[Math.floor(Math.random()*angle.length)]
						rotateFunc(2,angle,'恭喜您抽中30000积分')
					}
					if(data==3){
						rotateFunc(3,247,'恭喜您抽中10000积分')
					}
					if(data==4){
						var angle = [202,337];
						angle = angle[Math.floor(Math.random()*angle.length)]
						rotateFunc(4,angle,'恭喜您抽中5000积分')
					}
					if(data==0){
						rotateFunc(0,67,'恭喜你获得精美毛巾一份')
					}
				},"json")
					
				
			}
		 } 
	   
	});
	
})
</script>	
	{/literal}
</body>
</html>