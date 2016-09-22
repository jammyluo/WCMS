<!-- 增加一个弹窗 -->
<link rel='stylesheet' href='../../static/news/style/tanchuang.css'>
<link rel='stylesheet' href='../../static/news/style/title.css'>

{literal}
<script language="javascript" type="text/javascript">
function showDiv(){
	$("#popDiv").fadeIn(500).delay(2000).fadeOut(1000);
	window.location.reload();
}
function closeDiv(){
	var cid=$("input[name='comment_id']").val();
   $("#xiugai").fadeOut(500);
   $("#"+cid).removeClass("ed");
   
}
</script>
{/literal}


<div id="popDiv" class="mydiv" style="display: none;"><div style="margin-top:30px;float:left"><img
	src="/static/news/images/saoba.png" ></div>&nbsp;&nbsp;<div id="shuoming">
</div>
	
	</div>
	
	
	<div id="xiugai" class="mydiv" style="left:40%;height:300px;display: none;"><div style="margin-top:30px;float:left"></div>&nbsp;&nbsp;<div id="shuoming">
	<input type="hidden" name="comment_id" value="">
用户名<input name="username" disabled="disabled"><br>
真实姓名<input name="real_name"><br>

联系方式<input name="mobile_phone"><br>
系统组<input type="radio" name="verify" value="1" checked>是<input type="radio" name="verify" value="0">否<br>
积分<
地址<textarea id="address" name="address"></textarea><br>
<input type="button" class="imgbutton" value="更改" onclick="savexiugai()">
	<a href="javascript:void(0)" onclick="closeDiv()">关闭</a>
	</div>
	



