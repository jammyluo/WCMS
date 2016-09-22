{include file="news/header.tpl"}
<div style="width:600px;min-height:680px;padding:50px;margin:0 auto;text-align:center;">
<h1>恭喜你，二维码生成成功，赶紧分享下吧</h1>
<div id="output"></div>
</div>

<script type="text/javascript" src="./static/public/jquery.qrcode.min.js"></script>

{literal}
<script>
jQuery(function(){
	jQuery('#output').qrcode("{/literal}http://www.d-shang.com/index.php?customer/qr/?code={$code}{literal}");
})
</script>
{/literal}