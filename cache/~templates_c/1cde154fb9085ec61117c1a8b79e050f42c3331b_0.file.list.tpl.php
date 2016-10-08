<?php /* Smarty version 3.1.27, created on 2016-10-07 23:19:54
         compiled from "/opt/lampp/htdocs/WCMS/app/view/news/list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:92685115657f7bd1a302139_21520368%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1cde154fb9085ec61117c1a8b79e050f42c3331b' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/news/list.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92685115657f7bd1a302139_21520368',
  'variables' => 
  array (
    'module' => 0,
    'news' => 0,
    'lang' => 0,
    'num' => 0,
    'currentcid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd1a354eb1_24241827',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd1a354eb1_24241827')) {
function content_57f7bd1a354eb1_24241827 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '92685115657f7bd1a302139_21520368';
echo $_smarty_tpl->getSubTemplate ("news/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<body onload="loading()">

<div class="well">				
	<div class="form-inline">
	<a href="./index.php?factory/data/?mid=<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
" class="btn btn-success">发布</a>
	</div>
	<table class="table table-striped table-bordered">
		<tr>
			<th class="col-md-1" style="width:50px">操作</th>
			<th class="col-md-1" style="width:80px">作者</th>
			<th class="col-md-1">标题</th>
		</tr>

		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['news']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
		<tr id="<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" class="even">
			<td class="center">
			<a href="./index.php?customer/article/?id=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" target="_blank"><span class="icon-qrcode"></span></a>
			<a href="javascript:void(0)"  title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['RECYCLE'];?>
"
				onclick="recyle(<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['mid'];?>
)" ><i class="icon-trash "></i></a>
			<a target="_blank" href='<?php if ($_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['html'] != '') {?>.<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['html'];
} else { ?>./index.php?news/v/?id=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];
}?>'
				 title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['PREVIOUS'];?>
"><i class="icon-globe"></i></a>
			</td>
			<td class="center"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['author'];?>
</td>
			<td class="center">
				<input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['status'];?>
">
				<a href="./index.php?factory/v/?mid=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['mid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['title'];?>
</a>
			</td>

		</tr>
		<?php endfor; endif; ?>
	</table>
</div>
</body>

<?php echo '<script'; ?>
 type='text/javascript'>

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
       window.location.href='./index.php?factory/c/?mid=<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
&cid='+a;
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
currentPage: <?php echo $_smarty_tpl->tpl_vars['num']->value['current'];?>
,
totalPages: <?php echo $_smarty_tpl->tpl_vars['num']->value['page'];?>
,
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return "./index.php?factory/c/?type=manage&cid=<?php echo $_smarty_tpl->tpl_vars['currentcid']->value;?>
&mid=<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
&p="+page;
}
}
$('#pager').bootstrapPaginator(options);
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->getSubTemplate ("news/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>