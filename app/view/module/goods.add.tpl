{include file="news/header.tpl"}
{include file="module/add.header.tpl"}

	<tr>
		<td>{$lang['CONTENT']}:[<a href="javascript:void(0);"
			onclick="add();"><i class="icon-plus"></i></a>]</td>
		<td colspan="3" class="content">
		<div  class="form-horizontal">
		  <div class="control-group">
	SKU<input name="sku[]" type="text" class="span2">
		排序<input name="weight[]" type="text" class="span1">
		
		产品名<input name="goods_name[]" type="text" class="span3">
		
		<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="image[]" id="fileInput" type="file"><span class="filename" style="-webkit-user-select: none; ">No file selected</span><span class="action" style="-webkit-user-select: none; ">选择产品</span></div>
		</div>
	
		</div>
		</td>
		

	</tr>

	 <tr>
		<td>{$lang['DIRECT']}:</td>
		<td>	
		        <textarea id="container" name="content"></textarea>                 <!-- 编辑框 elm1为此部件ID-->
</td>
		<td></td>

	</tr>
	<tr>
		<td>{$lang['SUMMARY']}:</td>
		<td><textarea class="form-control" style="width: 700px;" cols="80"
			 name="summary" rows="5"></textarea></td>
		<td></td>

	</tr>



	<tr>
		<td>{$lang['AUTHOR']}:</td>
		<td ><input type="text" name="author" value="{$user.username}"
			class="form-control"></td>
		<td></td>

	</tr>
		<tr>
		<td>{$lang['KEYWORD']}:</td>
		<td ><input type="text" name="keyword"
			class="input-xlarge" value=""></td>
		<td></td>

	</tr>
	<tr>
		<td>Template:</td>
		<td ><input type="text" name="template"
			class="input-xlarge" value=""></td>
		<td></td>

	</tr>
	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}"> 
		<button type="submit" class="btn"><i class="icon-ok"></i>{$lang['CREATE']}
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
		<td class="span2">{$lang['WEIGHT']}:</td>
		<td ><input type="text" name="sort" value=""
			class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>{$lang['VIEWS']}:</td>
		<td ><input type="text" name="views" value=""
			class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>{$lang['PREMISSION']}:</td>
		<td ><select name="groupid" class="form-control">
			{foreach from=$group item=l key=key}

			<option value={$key} {if $key==0}selected{/if}>{$l}</option>
			{/foreach}

		</select></td>
		<td></td>

	</tr>

		<tr>
		<td>{$lang['PUBTIME']}</td>
		<td>
		<span class="input-append date" id="form_date" data-date-format="yyyy-mm-dd hh:ii">
		
		<input type="text" name="date" value="{$smarty.now|date_format:'%Y-%m-%d %H:%M'}" class=" uneditable-input">
		
    <span class="add-on"><i class="icon-calendar"></i></span></span>
		</td>

		<td></td>

	</tr>

	<tr>
		<td>{$lang['STATUS']}:</td>
		<td ><input type="radio" name="status" value="0"
			{if $news.status==0}checked{/if}>{$lang['SHOW']} &nbsp;&nbsp;<input
			type="radio" name="status" value="1" {if $news.status==1}checked{/if}>{$lang['HIDDEN']}

		</td>

		<td></td>

	</tr>




	<tr>
		<td><input type="hidden" name="mid" value="{$module}"></td>
		<td>
		<button type="submit" class="btn"><i class="icon-ok"></i>{$lang['CREATE']}
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
		<button type="submit" class="btn"><i class="icon-ok"></i>{$lang['CREATE']}
		</button>
		<input type="reset" value="{$lang['RESET']}" class=btn disabled></td>
		<td></td>

	</tr>
</table>
</div>
</form>
</div>
</div>
</div>
</div>
</div>


<div style="display:none" class="node">

	<div  class="form-horizontal">
		  <div class="control-group">
		SKU<input name="sku[]" type="text" class="span2">
		
		排序<input name="weight[]" type="text" class="span1">
		
		
		产品名<input name="goods_name[]" type="text" class="span3">
		<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="image[]" id="fileInput" type="file"><span class="filename" style="-webkit-user-select: none; ">No file selected</span><span class="action" style="-webkit-user-select: none; ">选择产品</span></div>
		</div>
		
		</div>
</div>
{literal}
<script>
function add(){

	var html=$(".node").html();
		
	$(".content").append(html);
	} 
	function del(id){
		$.post('./index.php?factory/delcon',{id:id,mid:5},function(data)
			{
		alert(data.message);
			},"json")
			$("#image"+id).remove();
			}
</script>
{/literal}

{include file="module/footer.tpl"}

{include file="news/footer.tpl"}