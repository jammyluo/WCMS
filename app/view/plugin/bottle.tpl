<html>
  <head>
    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <title>捞捞看</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/static/public/jquery-1.11.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/static/bottle/bottle.css" />

  </head>
  <body>
    <div class="beach">
      <div class="sun"></div>
      <div class="crab"></div>
      <div class="land"></div>
      <div class="left"></div>
      <img src="/static/bottle/image/salvage.png" class="salvage" />
      <div class="water"></div>
      <div class="sea">
   
      </div>
         <div class="shayu"></div>
	  <div class="shuoming">
	 
	  游戏规则<br>
	  啤酒价值50积分<br>
	  海星价值500积分<br>
	  龙虾价值800积分<br>
	  螃蟹价值1000积分<br>
	  章鱼价值1500积分<br>
	  鲨鱼价值2000积分<br>
	 
	  </div>
      <div class="prize">
        <img id="prize" src="/static/bottle/image/salvage_2.png" />
      </div>
      <div class="tools">
      <span id="blcs">{$wheeluser.num}</span>
        <a href="javascript:void(0)" class="net"></a>
      </div>
    </div>
    
    <div class="menu">
你的捕捞情况  总价值<span class="money">
{$history.0*50+$history.1*500+$history.2*800+$history.3*1000+$history.4*1500+$history.5*2000}
</span> 积分<br>
啤酒： <span class="zj_0">{$history.0}</span> 瓶  <br>
海星:　<span class="zj_1">{$history.1}</span> 个 <br>
龙虾： <span class="zj_2">{$history.2}</span> 只 <br>
螃蟹： <span class="zj_3">{$history.3}</span> 只 <br>
章鱼： <span class="zj_4">{$history.4}</span> 条 <br>
鲨鱼： <span class="zj_5">{$history.5}</span> 条 <br>

</div>
	<script type="text/javascript" src="/static/bottle/bottle.js"></script>
{literal}
	<script>
	
	$(function(){
		
		$(".net").click(reset);
		
	})
	setInterval("shayu()",20000);
	function shayu(){
	$(".shayu").css({left:"1000px",top:"220px"});
	 $(".shayu").animate({left:"700px",top:"190px"},4000,function(){
	 $(".shayu").animate({left:"500px",top:"260px"},4000);
	 });
	
	}
	</script>
	{/literal}
  </body>
</html>
