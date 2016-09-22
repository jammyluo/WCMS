{include file="news/header.tpl"}
{include file="module/edit.header.tpl"}

	<tr>
		<td>{$lang['CONTENT']}:[<a href="javascript:add();"
			><i class="icon-plus"></i></a>]</td>
		<td colspan="2" class="content">
		

			{foreach from=$news.module item=l}
			<div class="special">
			<div  class="span8 pull-left" id="image{$l.id}">
		  <div class="control-group">
		<a href="javascript:del({$l.id})">del?</a>名称 
		<input type="hidden" name="nodeid[]" value="{$l.id}">
		<input name="nodetitle[]" type="text" class="input-xlarge" value="{$l.nodetitle}">
						模型 <select name="module[]" class="input-small"><option value=1 {if $l.module==1}selected{/if}>文章</option><option value=2 {if $l.module==2}selected{/if}>图集</option></select>
		权重 <input name="weight[]" type="text" class="input-small" value="{$l.weight}">
		</div>
				  <div class="control-group">
		
		节点 <input name="newsid[]" type="text" class="input-xxlarge" value="{$l.newsid}">
		
		
		</div>
		<div class="control-group">
		介绍 <textarea name="review[]"  class="span8" rows="3">{$l.review}</textarea>
		</div>
		
		
		</div>
				<div class="span2 pull-right"><img class="img-polaroid" src="{$l.image}"><br><input name="image[]" type="file"></div>
		</div>
			{/foreach}
	
		</td>

	</tr>

	<tr>
		<td>{$lang['SUMMARY']}:</td>
		<td><textarea class="form-control" style="width: 700px;" cols="80"
			id="summary" name="summary" rows="5">{$news.summary}</textarea></td>
		<td></td>

	</tr>


	<tr>
		<td>{$lang['AUTHOR']}:</td>
		<td ><input type="text" name="author"
			class="form-control" value="{$news.author}"></td>
		<td></td>

	</tr>
		<tr>
		<td>{$lang['KEYWORD']}:</td>
		<td ><input type="text" name="keyword"
			class="input-xlarge" value="{$news.keyword}"></td>
		<td></td>

	</tr>
	<tr>
		<td>Template:</td>
		<td ><input type="text" name="template"
			class="input-xlarge" value="{$news.template}"></td>
		<td></td>

	</tr>

	<tr>
		<td></td>
		<td colspan=2 class=btnline align=center>
		<button type="submit" class="btn "><i class="icon-ok"></i>{$lang['SAVE']}
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
		<td ><input type="text" name="sort"
			value="{$news.sort}" class="input-small"></td>

		<td></td>

	</tr>
	<tr>
		<td>{$lang['VIEWS']}:</td>
		<td ><input type="text" name="views"
			value="{$news.views}" class="input-small"></td>

		<td></td>

	</tr>


	<tr>
		<td>{$lang['PREMISSION']}:</td>
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
		<td>{$lang['PUBTIME']}</td>
		<td>
		<span class="input-append date" id="form_date" data-date-format="yyyy-mm-dd hh:ii">
		
		<input type="text" name="date" value="{$news.date|date_format:'%Y-%m-%d %H:%M'}" class=" uneditable-input">
		
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
		<td class="left">{$lang['TOOL']}</td>

		<td class="right"><script type="text/plain" id="upload_ue"></script> <input
			type="text" id="picture" name="cover" /><a href="javascript:void(0);"
			onclick="upImage();">{$lang['UPLOAD']}</a>
		</div>
		</td>
		<td class="left" id="yulan"></td>
	</tr>
	<tr>
		<td><input type="hidden" name="mid" value="{$module}"></td>
		<td colspan=2 class=btnline align=center><input type="hidden"
			name="id" value="{$news.id}"> 
		<button type="submit" class="btn "><i class="icon-ok"></i>{$lang['SAVE']}
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


<div style="display:none" class="node">
			<div class="special">

	<div  class="span8 pull-left">
		  <div class="control-group">
		<a href="javascript:void(0)">del?</a>名称 <input name="nodetitle[]" type="text" class="input-xlarge">
						模型 <select name="module[]" class="input-small"><option value=1 selected>Article</option><option value=2>Image</option></select>
		权重<input name="weight[]" type="text" class="input-small">
		</div>
				  <div class="control-group">
		
		节点:<input name="newsid[]" type="text" class="input-xxlarge">
		
	
		</div>
		<div class="control-group">
		介绍 <textarea name="review[]"  cols="80" class="span6" rows="3"></textarea>
		</div>
		</div>
		<div class="span2 pull-right">
		<input name="image[]" type="file"></div>
</div>
</div>

{literal}

<script type="text/javascript">
    
 

function add(){

var html=$(".node").html();
	
$(".content").append(html);
} 
	function del(id){
$.post('/factory/delcon',{id:id,mid:3},function(data)
	{
alert(data.message);
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