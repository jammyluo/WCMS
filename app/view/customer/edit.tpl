{include file="news/header.tpl"}
<script src="./static/public/ckeditor/config.js"></script>

<script src="./static/public/ckeditor/ckeditor.js"></script>
<!-- start: Content -->
{literal}
<style>
.left{width:900px;float:left;}
.right{width:250px;height:800px;float:left;padding:20px;}
</style>
{/literal}
			
						
			<div class="row-fluid">




				<div class="well">
				
					<div class="box-content">
					<div class="left">
<table class="table">


<form action="./index.php?customer/save" enctype="multipart/form-data"  method="post" name="example_form">
		
  <tr>
				<td width="20%">转发标题：</td>
				<td width="80%"><input type="text" name="title" class="input-xxlarge" value="{$rs.title}" autocomplete="off" /></td>
			  </tr>
			  <tr>
				<td>顶部图片：</td>
				<td><input type="file" name="head_pic" id="mobile_phone" class="btinput"  autocomplete="off"/> (要求：宽度为640，高度不高于500)</td>
			  </tr>
			  
                          <tr>
				<td>按钮名称：</td>
				<td><input type="text" name="btn_name"  class="btinput" value="{$rs.btn_name}"  autocomplete="off"/></td>
			  </tr>
			  
			            <tr>
				<td>套餐介绍：</td>
				<td><textarea name="content" cols="80" id="editor1"
		rows="10">{$rs.content}</textarea></td>
			  </tr>
		  
 <tr>
				<td><input type="hidden" name="id" value="{$rs.id}"> </td>
				<td><input type="submit" class="btn btn-warning" value="生成二维码"></td>
				
			  </tr>
			
		</table>

		</form>
		</div>
		<div class="right">
	<img src="{$rs.head_pic}">
		</div>







</div></div>
</div>
<!--表单验证//-->
{literal}
<script type="text/javascript">
var editor=CKEDITOR.replace( 'editor1', {
	// NOTE: Remember to leave 'toolbar' property with the default value (null).
	 width:800,
	 toolbar :
	        [
	            [ 'Source','FontSize','TextColor'],
	            ['JustifyLeft', 'JustifyCenter', 'JustifyRight'],
	            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', 'Image','About']
	        ]
});

</script>
{/literal}

{include file="news/footer.tpl"}
