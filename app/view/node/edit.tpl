<!DOCTYPE PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<link rel='stylesheet' href='../../static/news/style/style1.css'>
<link rel='stylesheet' href='../../static/news/style/tab.css'>
<link rel='stylesheet' href='../../static/news/style/extra.css'>
<link rel='stylesheet' href='../../static/news/style/sdmenu.css'>
<script charset="utf-8" src="../../static/news/style/common.js"></script>
<script charset="utf-8" src="../../static/news/style/sdmenu.js"></script>
<script type="text/javascript" src="/static/public/jquery-1.4.3.min.js"></script>
 
    <link rel="stylesheet" href="/static/public/codemirror/lib/codemirror.css">
    <script src="/static/public/codemirror/lib/codemirror.js"></script>
    <script src="/static/public/codemirror/mode/xml/xml.js"></script>
    <script src="/static/public/codemirror/lib/util/dialog.js"></script>
    <link rel="stylesheet" href="/static/public/codemirror/lib/util/dialog.css">
    <script src="/static/public/codemirror/lib/util/searchcursor.js"></script>
    <script src="/static/public/codemirror/lib/util/search.js"></script>

   
	{literal}
	<script type='text/javascript'>
// <![CDATA[
var myMenu;
window.onload = function() { myMenu = new SDMenu('my_menu'); myMenu.init(); };
// ]]>

</script>
	<style>
  .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;width:900px;}
      dt {font-family: monospace; color: #666;}
      
.CodeMirror-scroll {
  height: 500px;
      width:800px;
  overflow-y: hidden;
  overflow-x: auto;
}
</style>

	
{/literal}


<!-- 头部// -->
{include file="news/top.tpl"}

<!-- 左侧// -->
{include file="news/nav.tpl"}
<!-- 中间// -->
<td valign="top" class="td_content">
<!-- setting title/desc -->
<div class="block titlebox">
	<h2 class="title">添加权限</h2>
   
</div>
<!-- setting title/desc -->

<table width="100%" align=center cellspacing=1 cellpadding=5 border=0 class=mytb>

<form action="/node/edit" method="post">
<input type="hidden" name="id" id="tempid" value="{$tempinfo.id}"> 

<tr><td class=left>权限:</td><td class="right">
{$node}
</td></tr>

<tr><td class=left>节点:</td><td class="right">
<input name="node" value=""> 应用程序或操作 必须英文<br>

</td></tr>

<tr><td class=left>备注:</td><td class="right">
<input name="remark" value=""> <br>

</td></tr>

<tr><td class=left></td>
<td class=right>
<input type="submit" name="add" value="添加"  class="imgbutton"></input>
<input type="submit" name="del" value="删除"  class="imgbutton"></input>
<input type="submit" name="rename" value="更新"  class="imgbutton"></input></td>
</tr>

</form>



</table>
    
    <div style='padding:5px;color:#e60000;text-align:center;'></div>
</div>

    <!-- help -->
    <div class="block">
        <h2 class="title" align=left>使用提示</h2>
        <div class="content">
			<ol class=help> <pre>
	</pre></ol>
        </div>
    </div>
	<!-- help -->

</td>
</tr>
</table>
<!-- 底部// -->
{include file="news/footer.tpl"}
