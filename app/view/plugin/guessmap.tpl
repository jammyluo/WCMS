{literal}
<style>
.imgbox{min-height: 220px;width:220px;padding: 2px;border:1px #f1f1f1 solid;float:left}
.intro{position:relative;font-size:12px;color:#666;text-algin:center;padding:10px;}
.correct{font-size:15px;font-weight:700;color:red}
.error{font-size:15px;font-weight:700;color:#000}
.guess{border:4px #ecb95d solid;width:500px;margin-top:20px;height:240px;padding:5px;}
.weilan{position:absolute;right:0px;top:-10px;}
</style>
{/literal}
<div class="guess">
<div class="imgbox">
<img src="./static/d_shang/sheep/sheep.jpg" id="guessmap">
</div>
<button class="btn btn-success" onclick="sheep()">抓羊</button>
<button class="btn btn-warning" onclick="wolf()">放狼</button>

<div class="intro">
<a href="./index.php?plugin/l/?filter=login&plugin=SheepPlugin" style="color:red">羊肉交易市场</a>
|<a href="./index.php?wolf/mx" style="color:#000;font-weight:700">黑市</a><br>
规则:<b>免费抓羊赚积分</b><br>
懒羊羊:<span class="correct">+10</span>积分<br>
美羊羊:<span class="correct">+30</span>积分<br>
沸羊羊:<span class="correct">+50</span>积分<br>
喜羊羊:<span class="correct">+100</span>积分<br>
灰太狼:<span class="error">-10</span>积分<br>
每天限抓羊10次，放狼5次。
<div class="weilan">
<img src="./static/d_shang/sheep/weilan.jpg">
</div>
</div></div>


{literal}
<script>

function wolf(){

	if(!confirm("把将别人抓到的羊归你所有？1只狼将花费20积分")){
      return;
	}

	$.post("./index.php?wolf/add",function(data){
         alert(data.message);
	},"json")

}


function sheep(){

	$.post("./index.php?plugin/api",{filter:"login",plugin:"SheepPlugin"},function(data){


		
  if(data.status==false){

     alert(data.message);
     return;
	}

    if(data.data.tickets>0){

       $("#guessmap").attr("src",'./static/d_shang/sheep/'+data.data.tickets+'.jpg');
        alert(data.message);
	}else{
		fleshVerify();
		 alert(data.message);
   }
	
	},"json")
}




function fleshVerify(){
	//重载验证码
	    var timenow = new Date().getTime();
	    document.getElementById('guessmap').src= './index.php?guessmap/map/?'+timenow;
	}

</script>

{/literal}