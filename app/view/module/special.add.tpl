{include file="news/header.tpl"}
{include file="module/add.header.tpl"}

	<tr>
		<td>{$lang['CONTENT']}:[<a href="javascript:void(0);"
			onclick="add();"><i class="icon-plus"></i></a>]</td>
		<td colspan="2" class="content">
		<div  class="special">
		  <div class="control-group">
		<a href="javascript:void(0)">删?</a>名称:<input name="nodetitle[]" type="text" class="input-xlarge">
						模型:<select name="module[]" class="input-small"><option value=1 selected>Article</option><option value=2>Image</option></select>
		权重:<input name="weight[]" type="text" class="input-small">
		</div>
				  <div class="control-group">
		
		节点:<input name="newsid[]" type="text" class="input-xxlarge">
		
		<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="image[]" id="fileInput" type="file"><span class="filename" style="-webkit-user-select: none; ">No file selected</span><span class="action" style="-webkit-user-select: none; ">选择封面</span></div>
		</div>
		<div class="control-group">
		介绍:<textarea name="review[]"  cols="80" class="span6" rows="3"></textarea>
		</div>
		</div>
		</td>
		<td></td>

	</tr>

	<tr>
		<td>{$lang['SUMMARY']}:</td>
		<td><textarea cols="80" id="summary" name="summary" rows="5"
			style="width: 700px;" class="form-control"></textarea></td>
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
		<button type="submit" class="btn "><i class="icon-ok"></i>{$lang['CREATE']}
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
		<td><input type="hidden" name="mid" value="{$module}"><input type="hidden" name="content" value="this is image"></td>
		<td>
		<button type="submit" class="btn "><i class="icon-ok"></i>{$lang['CREATE']}
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
</div>
</div>
</div>
</div>
</div>


<div style="display:none" class="node">

	<div  class="special">
		  <div class="control-group">
		<a href="javascript:void(0)">del?</a>名称:<input name="nodetitle[]" type="text" class="input-xlarge">
						模型:<select name="module[]" class="input-small"><option value=1 selected>Article</option><option value=2>Image</option></select>
		权重:<input name="weight[]" type="text" class="input-small">
		</div>
				  <div class="control-group">
		
		节点:<input name="newsid[]" type="text" class="input-xxlarge">
		<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="image[]" id="fileInput" type="file"><span class="filename" style="-webkit-user-select: none; ">No file selected</span><span class="action" style="-webkit-user-select: none; ">选择封面</span></div>
		</div>
		<div class="control-group">
		介绍:<textarea name="review[]"  cols="80" class="span6" rows="3"></textarea>
		</div>
		</div>
</div>


{literal}

<script type="text/javascript">
 
			function add(){
		
			var html=$(".node").html();
				
     $(".content").append(html);
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