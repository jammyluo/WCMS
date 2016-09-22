{include file="news/header.tpl"}
<body id="main-body" style="overflow-y:hidden;">
	<div class="" style="width:100%;height:42px;overflow: hidden;">
		<!-- #####头部 开始##### -->
		{include file="news/iframetop.tpl"}
		<!-- #####头部 结束##### -->
	</div>
	<div class="" style="width:100%;height:auto;overflow: hidden;">
		<!-- #####主体左 开始##### -->
		<div class="" style="float:left;">
			{include file="news/iframenav.tpl"}
		</div>
		<!-- #####主体左 结束##### -->
		
		<!-- #####主体右 开始##### -->

		
		<iframe src="./index.php?factory/c/?mid=1" id="iframe" scrolling="true"></iframe>
			
		
		<!-- #####主体右 结束##### -->
	</div>
	<!-- start: Content -->
</body>
{literal}
<script type='text/javascript'>
$(function(){
setIframe();
$(window).resize(function(){
setIframe();
})
})
function setIframe(){
	var pwidth=$(".pull-left").width();
$("#sidebar-left").css({"width":pwidth});
$("#sidebar-left").css({"height":$(window).height()});
$("#iframe").css({"height":$(window).height()-50,"width":$(window).width()-pwidth-30});
}


function setUrl(url,obj){
	$("li").each(function(){
		$(this).removeClass("active");
		})
	$(obj).addClass("active");
	$("#iframe").attr("src",url);	
}
</script>
{/literal}
{include file="news/footer.tpl"}