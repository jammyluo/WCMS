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


<form action="./index.php?customer/add" enctype="multipart/form-data"  method="post" name="example_form">
		
  <tr>
				<td width="20%">转发标题：</td>
				<td width="80%"><input type="text" name="title" class="input-xxlarge" placeholder="转发后看到的标题" autocomplete="off" /></td>
			  </tr>
			  <tr>
				<td>顶部图片：</td>
				<td><input type="file" name="head_pic" id="mobile_phone" class="btinput"  autocomplete="off"/> (要求：宽度为640，高度不高于500)</td>
			  </tr>
			  
                          <tr>
				<td>按钮名称：</td>
				<td><input type="text" name="btn_name"  class="btinput"  value="提交" autocomplete="off"/></td>
			  </tr>
			  
			            <tr>
				<td>套餐介绍：</td>
				<td><textarea name="content" cols="80" id="editor1"
		rows="10"></textarea></td>
			  </tr>
	
	       <tr>
				<td>模板名称：</td>
				<td><select name="template">
				{foreach from=$temp item=l key=key}
				<option value="{$key}">{$l}</option>
				{/foreach}
				</select></td>
			  </tr>
		  
 <tr>
				<td> </td>
				<td><input type="submit" class="btn btn-warning" value="生成二维码"></td>
				
			  </tr>
			
			    
		</table>

		</form>
		</div>
		<div class="right">
		<pre>
制作步骤：
1、填写左侧的的信息，并且上传头部图片。
2、点击生成二维码。
3、打开微信，扫一扫，分享到朋友圈就可以啦。

DIY二维码优点:
1、可以自定义活动优惠内容。
2、客户可以直接打电话给你。
3、你可以看到只给你留言的客户信息。

目前优惠活动：
1、每个经销商只有1个免费创建二维码。
</pre>
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
	            [ 'FontSize','TextColor'],
	            ['JustifyLeft', 'JustifyCenter', 'JustifyRight'],
	            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList','Image', 'About']
	        ]
});

</script>
{/literal}

{include file="news/footer.tpl"}
