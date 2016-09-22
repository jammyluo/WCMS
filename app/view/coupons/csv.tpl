{include file="news/header.tpl"}


<!-- 头部// -->



	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">
 {include file="order/top.tpl"}

<form id="addform" action="./index.php?coupons/import/?action=import" method="post"
	enctype="multipart/form-data" class="form-horizontal" role="form">
<div class="control-group"><label for="inputEmail3"
	class="col-sm-2 control-label"></label> 
			<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="file" id="fileInput" type="file"><span class="filename" style="-webkit-user-select: none; ">No file selected</span><span class="action" style="-webkit-user-select: none; ">Choose File</span></div>
	
</div>
<div class="control-group"><label for="inputEmail3"
	class="col-sm-2 control-label">备注</label> <input type="text" name="remark" value="政策返利">
</div>

<div class="control-group"><label for="inputEmail3"
	class="col-sm-2 control-label"></label> <input type="submit" class="btn" value="导入CSV">
</div>
</form>

CSV模板列名:真实姓名，积分值

</div>
</div>




</div>



{include file="news/footer.tpl"}

