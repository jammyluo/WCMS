{include file="news/header.tpl"}
{include file="module/add.header.tpl"}


	<tr>
		<td colspan="3">多图:[<a href="javascript:void(0);"
			onclick="upImage();"><i class="icon-plus"></i></a>]
	
		
		顺序数字越小，越靠前
		</td>

	</tr>
	<tr>
	<td colspan="3"><ul class="thumbnails">
		
		</ul></td>
	</tr>

	<tr>
		<td>摘要:</td>
		<td><textarea cols="80" id="summary" name="summary" rows="5"
			style="width: 700px;" class="form-control"></textarea></td>
		<td></td>

	</tr>



	<tr>
		<td>作者:</td>
		<td ><input type="text" name="author" value="{$user.username}"
			class="form-control"></td>
		<td></td>

	</tr>
		<tr>
		<td>关键词:</td>
		<td ><input type="text" name="keyword"
			class="input-xlarge" value=""></td>
		<td></td>

	</tr>
	<tr>
		<td>模板:</td>
		<td ><input type="text" name="template"
			class="input-xlarge" value=""></td>
		<td></td>

	</tr>
	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}"> 
		<button type="submit" class="btn"><i class="icon-ok"></i>发布
		</button>
		<input type="reset" value="重置" class=btn disabled></td>
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
		<td ><input type="text" name="sort" value="0"
			class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>浏览次数:</td>
		<td ><input type="text" name="views" value="0"
			class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>权限:</td>
		<td ><select name="groupid" class="form-control">
			{foreach from=$group item=l key=key}

			<option value={$key} {if $key==0}selected{/if}>{$l}</option>
			{/foreach}

		</select></td>
		<td></td>

	</tr>

		<tr>
		<td>发布时间：</td>
		<td>
		<span class="input-append date" id="form_date" data-date-format="yyyy-mm-dd hh:ii">
		
		<input type="text" name="date" value="{$smarty.now|date_format:'%Y-%m-%d %H:%M'}" class=" uneditable-input">
		
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
		<td><input type="hidden" name="mid" value="{$module}"><input type="hidden" name="content" value="this is image"></td>
		<td>
		<button type="submit" class="btn "><i class="icon-ok"></i>发布
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
		<td><input type="button" class="btn btn-primary"
			onclick="apd('{$l.key}');" value="增加">{$l.name}</td>

		<td id="{$l.key}">{section name=loop loop=$l.num} <input type="text"
			name="{$l.key}[]" class="form-control" value="0"> {/section} {else}
		
		
		<td>{$l.name}</td>

		<td>
		<div class="form-group col-md-5"><input type="text"
			class="form-control" name="{$l.key}">{$l.key}({$l.type})</div>
		{/if}</td>
		<td></td>

	</tr>
	

	{/foreach}
	<tr>
		<td><input type="hidden" name="mid" value="{$module}"></td>
		<td>
		<button type="submit" class="btn "><i class="icon-ok"></i>{$lang['CREATE']}
		</button>
		<input type="reset" value="{$lang['RESET']}" class=btn disabled></td>
		<td></td>

	</tr>
</table>
</div>

</form>
	<script type="text/plain" id="upload_ue"></script>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript"
	src="./static/public/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript"
	src="./static/public/ueditor/ueditor.all.js"></script>
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<script type="text/javascript"
	src="./static/public/ueditor/lang/zh-cn/zh-cn.js"></script>

{literal}
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
			            //将地址赋值给相应的input,只去第一张图片的路径
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

				 var html='<li><img src="'+src+'" class="img-polaroid" style="width:160px;height:100px;"><input type="hidden" name="image[]" value="'+src+'">';
				 var remark='<div style="display: inline-block;line-height: 35px;">名称:<input type="text" name="remark[]" class="input-middle" value="'+title+'"> <br>顺序:<input type="text" name="weight[]" value="0" class="input-small"></div></li>';
	            $(".thumbnails").append(html+remark);
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
			function del(id){
		         $.post('./index.php?factory/delcon',{id:id,mid:2},function(data)
			{
			},"json")
			$("#image"+id).remove();
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