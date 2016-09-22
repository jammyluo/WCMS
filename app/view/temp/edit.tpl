{include file="news/header.tpl"}
<body id="iframe-con">
{literal}
<style type="text/css">
#description{white-space:nowrap!important}
</style>

{/literal}
<!-- 头部// -->
{include file="news/nav.tpl"}
	<!-- start: Content -->
	<div class="tooltip-box-content" style="width:100%;height:40px;overflow: hidden;padding-top: 10px;background: #fff;box-shadow:5px 0px 4px #666;">
		<div class="panel-heading" style="padding-left: 8px;display: inline-block;width: 100%;">
			<a href="javascript:history.go(-1)" style="color:red;">返回</a>
			<span class="icon-file"></span>
			<strong style="font-size:16px;"> {$tempinfo.name}</strong>  
			<small>{$tempinfo.size}  </small>    
			<span  style="margin:-5px 0 0 0;display:inline-block;">最后编辑  {$tempinfo.action} <small>提交于</small>  {$tempinfo.date|date_format:"%m/%d"}  {$tempinfo.direct}</span>  
			<div style="float:right;margin-right:50px;">备注:<input type="text" name="remark"  class="control">
				<input type="button" value="保存" onclick="return save();" class="btn ">
			</div>
		</div>
	</div>
	<div id="content" class="" style="top:0px;padding:0px;">
		<!-- Default panel contents -->
		<div id="box-textarea" class="box-content" style="padding: 0px;">
			<input type="hidden" name="id" id="tempid" class="form-control" value="{$tempinfo.id}"> 
			<textarea name="description" id="c2">{$tempinfo.source}</textarea>
			<div id="description" style="top:0px;"></div>
		</div>  
	</div>
</body>
</body>
<script src="./static/public/ace/src/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="./static/public/ace/src/theme-crimson_editor.js" type="text/javascript" charset="utf-8"></script>
<script src="./static/public/ace/src/mode-html.js" type="text/javascript" charset="utf-8"></script>
{literal}

<script type="text/javascript"> 
	$(function(){
	
		setIframe();
		$(window).resize(function(){
			setIframe();
			
		})
	})
	
	function setIframe(){
		  $("#description").css({"height":$(window).height()-50,"width":$(window).width()-100});

	}

  </script>
<script>
window.onload = function() {
	var editor = ace.edit("description");
	editor.resize();
	var textarea = $('textarea[name="description"]').hide();
	editor.getSession().setValue(textarea.val());
	 editor.setTheme("ace/theme/crimson_editor");
	  // editor.getSession().setUseWrapMode(true);
	    var JavaScriptMode = require("ace/mode/html").Mode;
	    editor.getSession().setMode(new JavaScriptMode());
	editor.getSession().on('change', function(){
	  textarea.val(editor.getSession().getValue());
	});
};
function save(){

	var c=$("#c2").val();

	var d=$("#tempid").val();
	var remark=$("input[name='remark']").val();

	if(remark.length<6){
	   alert('备注小于6个字符');
	   return false;
	}

	$.post("./index.php?temp/savetemp",{source:c,id:d,remark:remark},function(result){
	
	alert(result.message);
			
	},"json")
	}
</script>
{/literal}
{include file="news/footer.tpl"}
