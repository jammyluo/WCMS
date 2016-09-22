{include file="news/header.tpl"}

	{literal}
	<script type='text/javascript'>
 $(document).ready(function(){
	 $('#cate').change(function(){
       var a=$(this).children('option:selected').val();  //弹出select的值
       window.location.href='./index.php?cate/bindfieldview/?cid='+a;
    });
   });
   
</script>
	

{/literal}

<!-- 头部// -->
{include file="news/top.tpl"}



{include file="news/nav.tpl"}

<!-- start: Content -->
			<div id="content" class="span10">
			
						
			<div class="row-fluid">


<div class="box span12"><!-- Default panel contents -->



<div class="box-content">
<table class="table">

<!--分类绑定字段//-->


<tr>
<td  class="span2">分类</td>
<td  >
{$category}
</td>
</tr>



<tr>
<td  colspan="2">
{foreach from=$extend item=l}
<label class="checkbox pull-left">
<input type="checkbox" 
{if $l.checked=='checked'}checked{/if} id="chk_id" name="eid" value="{$l.eid}">{$l.name}
</label>{/foreach}</td>
</tr>

<tr>
<td  ></td>
<td ><input type="button" value="绑定"  class="btn" onclick="jqchk()"></td>

</tr>

</table>
</div>
</div>
</div>
{literal}
<script language="javascript">
function jqchk(){
	   var cid=$("#cate").val();
	    var str=new Array();    
	    var r=document.getElementsByName("eid");
	    for(var i=0;i<r.length;i++){
	         if(r[i].checked){
	         str.push(r[i].value);

	         }
	    }

		$.post("./index.php?cate/bindfield",{cid:cid,eid:str},function(data){
               alert(data.message);
			},"json")
	     
	
	  
	
}

</script>

{/literal}
{include file="file:news/footer.tpl"}
