<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
	<div class="ds-thread" data-thread-key="{$content.id}" data-title="{$content.title}" data-url="{$content.html}"></div>

{literal}
<script type="text/javascript">
var duoshuoQuery = {short_name:"{/literal}{$config.short_name}{literal}"};
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
		ds.charset = 'UTF-8';
		(document.getElementsByTagName('head')[0] 
		 || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
	</script>
	{/literal}
<!-- 多说公共JS代码 end -->