{include file="news/header.tpl"}
{include file="module/edit.header.tpl"}

	<tr>
		<td colspan=3>多图:[<a href="javascript:void(0);"
			onclick="upImage();"><i class="icon-plus"></i></a>]
			顺序数字越小，越靠前
			</td>
		
		</tr>
		<tr>
		<td colspan="3">
		
		<div class="span12">

		<ul class="thumbnails">
			{foreach from=$news.module item=l}
			<li id="image{$l.id}">
			<img src="{$l.image}" class="img-polaroid"  style="width:160px;height:100px;">
			<input type="hidden" name="imageid[]" value="{$l.id}"> <input
				type="hidden" name="image[]" value="{$l.image}">
			<div style="display: inline-block;line-height: 35px;">名称:<input type="text" name="remark[]" class="input-middle"
				value="{$l.remark}"><br> 顺序:<input type="text" name="weight[]" class="input-small"
				value="{$l.weight}">
				<a href="javascript:del({$l.id})">删?</a>
				
			</div>
			</li>
			{/foreach}
		</ul>
	
		</div>
		</td>

	</tr>

	<tr>
		<td>摘要:</td>
		<td><textarea class="form-control" style="width: 700px;" cols="80"
			id="summary" name="summary" rows="5">{$news.summary}</textarea></td>
		<td></td>

	</tr>


	<tr>
		<td>作者:</td>
		<td ><input type="text" name="author"
			class="form-control" value="{$news.author}"></td>
		<td></td>

	</tr>
		<tr>
		<td>关键词:</td>
		<td ><input type="text" name="keyword"
			class="input-xlarge" value="{$news.keyword}"></td>
		<td></td>

	</tr>
	<tr>
		<td>模板:</td>
		<td ><input type="text" name="template"
			class="input-xlarge" value="{$news.template}"></td>
		<td></td>

	</tr>

	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}">
		<button type="submit" class="btn "><i class="icon-ok"></i>保存
		</button>
		<input type="reset" value="{$lang['RESET']}" class=btn disabled></td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center></td>
		<td></td>
	</tr>

</table>

</div>
<div class="tab-pane" id="tab2">
<table class="table">



	<tr>
		<td class="span2">权重:</td>
		<td ><input type="text" name="sort"
			value="{$news.sort}" class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>浏览次数:</td>
		<td ><input type="text" name="views"
			value="{$news.views}" class="input-small"></td>

		<td></td>

	</tr>


	<tr>
		<td>权限:</td>
		<td>
		<div ><select name="groupid" class="form-control">
			{foreach from=$group item=l key=key}

			<option value={$key} {if $news.groupid==$key}selected{/if}>{$l}</option>
			{/foreach}


		</select></div>
		</td>
		<td></td>

	</tr>

			<tr>
		<td>发布时间</td>
		<td>
		<span class="input-append date" id="form_date" data-date-format="yyyy-mm-dd hh:ii">
		
		<input type="text" name="date" value="{$news.date|date_format:'%Y-%m-%d %H:%M'}" class=" uneditable-input">
		
    <span class="add-on"><i class="icon-calendar"></i></span></span>
		</td>

		<td></td>

	</tr>
	

	<tr>
		<td>状态:</td>
		<td ><input type="radio" name="status" value="0"
			{if $news.status==0}checked{/if}>显示 &nbsp;&nbsp;<input
			type="radio" name="status" value="1" {if $news.status==1}checked{/if}>隐藏

		</td>

		<td></td>

	</tr>
	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}"> <input type="hidden" name="views"
			value="{$news.views}" />
		<button type="submit" class="btn "><i class="icon-ok"></i>保存
		</button>
		<input type="reset" value="{$lang['RESET']}" class=btn disabled></td>
		<td></td>
	</tr>
</table>
</div>
<div class="tab-pane" id="tab3">

<table class="table" id="extend">

	{foreach from=$extend item=l}
	<tr>
		{if $l.status==3}
		<td><input type="button" class="btn" onclick="apd('{$l.key}');"
			value="增加">{$l.type}{$l.name}</td>
		<td id="{$l.key}">{foreach from=$l.value key=k item=g} <input
			type="text" name="{$l.key}[{$k}]" value={$g}> {/foreach}</td>
		<td></td>
		{else}
		<td>{$l.name}</td>
		<td><input type="text" class="form-control" name="{$l.key}"
			value={$l.value}>({$l.key} {$lang['TYPE']}{$l.type})</td>
		<td>{if $l.status==2}<img src="{$l.{$l.type}}" width=60 height=60>{/if}</td>
		{/if}
	</tr>
	{/foreach}
	<tr>
		<td class="left">工具</td>

		<td class="right">
		 <script id="upload_ue" name="content" type="text/plain">
    </script>
		 <input
			type="text" id="picture" name="cover" /><a href="javascript:void(0);"
			onclick="upImage();">{$lang['UPLOAD']}</a>
		</div>
		</td>
		<td class="left" id="yulan"></td>
	</tr>
	<tr>
		<td><input type="hidden" name="mid" value="{$module}"></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}"> <input type="hidden" name="views"
			value="{$news.views}" />
		<button type="submit" class="btn "><i class="icon-ok"></i>保存
		</button>
		<input type="reset" value="{$lang['RESET']}" class=btn disabled></td>
		<td></td>
	</tr>
	
</table>
</form>
</div>
</div>
</div>
</div>
</div>
{literal}

<script type="text/javascript"
	src="./static/public/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript"
	src="./static/public/ueditor/ueditor.all.js"></script>

<script type="text/javascript">
    
 
    
	var _editor;
	$(function() {
	    //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
	    _editor = UE.getEditor('upload_ue');
	    _editor.ready(function () {
	        //设置编辑器不可用
	      //  _editor.setDisabled();
	        //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
	        _editor.hide();
	        //侦听图片上传
	        _editor.addListener('beforeInsertImage', function (t, arg) {
	            
	        	   $.each(arg,function(){
	                    addImg(this.src,this.title);
	                           });
			        	$("#picture").attr("value", arg[0].src);
			            //图片预览
			            $("#preview").attr("src", arg[0].src);
			        })
		    });
		});   
		function addImg(src,title){

			 var html='<li><div href="#" class="thumbnail"><img src="'+src+'"></div><input type="hidden" name="image[]" value="'+src+'">';
			 var remark='<div style="display: inline-block;line-height: 35px;">remark:<br><input type="text" name="remark[]" class="input-middle" value="'+title+'"> <br><input type="text" name="weight[]" value="0" class="input-middle">删除</div></li>';
           $(".thumbnails").append(html+remark);
		}  
	function del(id){
         $.post('./index.php?factory/delcon',{id:id,mid:2},function(data)
	{
	},"json")
	$("#image"+id).remove();
	}
	//弹出图片上传的对话框
	function upImage() {
	    var myImage = _editor.getDialog("insertimage");
	    myImage.open();
	}
	//弹出文件上传的对话框
	function upFiles() {
	    var myFiles = _editor.getDialog("attachment");
	    myFiles.open();
	}
	 $('#form_date').datetimepicker({
	     language:  'zh-CN',
	     format:'yyyy-mm-dd hh:ii',
	     weekStart: 1,
	     todayBtn:  0,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
	 });
</script>
{/literal}
{include file="news/footer.tpl"}