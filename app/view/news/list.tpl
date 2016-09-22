{include file="news/header.tpl"}

<body onload="loading()">

<div class="well">				
	<div class="form-inline">
	<a href="./index.php?factory/data/?mid={$module}" class="btn btn-success">发布</a>
	</div>
	<table class="table table-striped table-bordered">
		<tr>
			<th class="col-md-1" style="width:50px">操作</th>
			<th class="col-md-1" style="width:80px">作者</th>
			<th class="col-md-1">标题</th>
		</tr>

		{section name=l loop=$news }
		<tr id="{$news[l].id}" class="even">
			<td class="center">
			<a href="./index.php?customer/article/?id={$news[l].id}" target="_blank"><span class="icon-qrcode"></span></a>
			<a href="javascript:void(0)"  title="{$lang['RECYCLE']}"
				onclick="recyle({$news[l].id},{$news[l].mid})" ><i class="icon-trash "></i></a>
			<a target="_blank" href='{if $news[l].html!=""}.{$news[l].html}{else}./index.php?news/v/?id={$news[l].id}{/if}'
				 title="{$lang['PREVIOUS']}"><i class="icon-globe"></i></a>
			</td>
			<td class="center">{$news[l].author}</td>
			<td class="center">
				<input type="hidden" name="status" value="{$news[l].status}">
				<a href="./index.php?factory/v/?mid={$news[l].mid}&id={$news[l].id}" >{$news[l].title}</a>
			</td>

		</tr>
		{/section}
	</table>
</div>
</body>
{literal}
<script type='text/javascript'>

function loading(){
	$("#loading").hide();
	$("#content").show();
}

$(document).ready(function() { 
	$("#chk_all").click( 
		 function(){ 
			if(this.checked){ 
			 $("input[name='chk_list']").prop('checked', true) 
			 }else{ 
					 
			$("input[name='chk_list']").removeAttr("checked");
			} 
			} 
			
			);

     $("#cate").change(function(){
  	   var a=$(this).children('option:selected').val();  //弹出select的值
       window.location.href='./index.php?factory/c/?mid={/literal}{$module}{literal}&cid='+a;
         });

	  $("input[name='value']").keyup(function(event){
            if(event.which==13){
                 search();
            }
		  })
          });   

function search(){
 var value=$("input[name='value']").val();
 var key=$("#key").val();
var types=$("#types").val();
if(types==1){
 location.href="./index.php?factory/search/?key="+key+"&value="+value;
}else{
 location.href="./index.php?factory/goods/?value="+value;
}

}

	

function act(name){

 var arrChk=$("input[name='chk_list']:checked");
	 var ids='';
	 var cid=$("input[name='category']").val(); 

if(name=='search'){
window.location.href='./index.php?factory/c/?type=manage&cid='+cid;         
return false;
}

 
 var flag=confirm('确认操作?');
 
 if(flag==false){
     return false;
 }

 $(arrChk).each(function(){
	     ids=ids+','+this.value;                        
	  }); 

	 $.post("./index.php?factory/edit",{ids:ids,cid:cid,type:name},function(data){
         alert(data.error);  
         window.location.href='./index.php?factory/c/?type=manage';
	 },"json");


}




function recyle(id,mid){
    if(confirm("确认删除")==true){
       
   	 $.post("./index.php?factory/remove/",{id:id,mid:mid},function(data){
       // alert("删除成功");
         $("#"+id).fadeOut();
	 },"json");
    }else{
      return false;
    }
}    

function visible(id){
	var status=$("input[name='status']").val();
	if(status==0){
      status=1;
      $("#statusimg"+id).html("<i class='icon-eye-close'></i>");
	}else{
      status=0;
      $("#statusimg"+id).html("<i class='icon-eye-open'></i>");
      
	}
	$("input[name='status']").val(status);
	
$.post("./index.php?factory/visible",{status:status,id:id},function(){
      
	})
}
       
function sort(id){
var s=$("#sort"+id).val();

$.post("./index.php?factory/s",{sort:s,id:id});
}    	       




var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?factory/c/?type=manage&cid={/literal}{$currentcid}&mid={$module}{literal}&p="+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}