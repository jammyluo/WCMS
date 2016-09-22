{include file="news/header.tpl"} 
<link href="./static/public/emoji/emoji.css" rel="stylesheet" type="text/css" />

{literal}
<style type="text/css">
.reply{color:#e15f63}
</style>

{/literal}

<!-- 头部// -->
<!-- start: Content -->
			<div id="content" class="span12">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->


<div class="box-content span12">



<form name="news" action="./index.php?comment/search" method="post"
	class="form-inline suoding">
	<select name="type"
	class="span1">
	<option value="real_name">{$lang['USERNAME']}</option>
	<option value="mobile_phone">{$lang['MOBILE']}</option>
</select> 
	<div class="input-append">

<input value="" type="text" class="control" name="value">
<button type="submit" class="btn"><i class="icon-search"></i>
</button>

</div>

{include file="app/emoji.tpl"}

</form>
<table class="table  table-hover ">

	<tr>
<th class="span2">留言时间</th>
		<th class="span2">{$lang['USERNAME']}</th>
		<th class="span2"></th>
		<th class="span3">{$lang['CONTENT']}</th>
		<th class="span2">操作</th>
	</tr>



	{foreach from=$rs item=l}
	<tr>
	<td>{$l.add_time|wtime}</td>
	<td><img src="{$l.face}" width="60px;"> <small>{$l.nickname}{$l.sex}</small></td>
	<td>{$l.province} {$l.city}</td>
	<td>{$l.content}<br>
	<span class="reply">{$l.reply}</span>
	</td>
	<td id="reply_{$l.id}">{if $l.reply==""}<a href="javascript:reply('{$l.openid}',{$l.id})"><span class="icon-comment"></span></a>{else}
	<span class="reply">已回复</span>
	{/if}
	</td>
	</tr>
	
    {/foreach}

</table>


<div class="pagination pagination-centered">
<ul id="pager"></ul>
</div>

</div>

<script src="./static/public/layer/layer.min.js" ></script>

<script src="./static/public/layer/extend/layer.ext.js" ></script>


{literal}


 <script type='text/javascript'>

function add(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', ($(window).height() - 50) +'px'],
	    iframe: {src: './index.php?comment/addcomment',
	        scrolling: 'no'
	         }
	}) 
	}

function reply(uid,id){

    var con="";
	var a=layer.prompt({title: '微信回复',type: 3,val:con}, function(val){
	    $.post("./index.php?weixin/reply",{msg:val,touser:uid,id:id},function(data){
      alert(data.message);
      layer.close(a);
      var con="<span class=\"reply\">已回复</span>";
     $("#reply_"+id).html(con)
		    },"json")
	});
    }

var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?weixin/listing/?p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script> {/literal} {include file="news/footer.tpl"}