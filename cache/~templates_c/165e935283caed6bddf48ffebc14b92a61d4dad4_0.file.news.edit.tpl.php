<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:24
         compiled from "/opt/lampp/htdocs/WCMS/app/view/module/news.edit.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:37706168357f7bd38e06371_92416552%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '165e935283caed6bddf48ffebc14b92a61d4dad4' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/module/news.edit.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '37706168357f7bd38e06371_92416552',
  'variables' => 
  array (
    'p' => 0,
    'preid' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd38e419b3_06156637',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd38e419b3_06156637')) {
function content_57f7bd38e419b3_06156637 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '37706168357f7bd38e06371_92416552';
echo $_smarty_tpl->getSubTemplate ("news/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("module/edit.header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<div>
<div class="row-fluid">
  <ul class="nav nav-tabs">
    <li><a href="javascript:history.go(-1)"><<返回</a></li>
   </ul>
  <div class="tab-content" >
   <div class="tab-pane active" id="tab1">

<form action="./index.php?factory/save" method="post" enctype="multipart/form-data"
	class="form-inline">
	<input type="hidden" name="p" value="<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
"><!-- 存储上一级页数 -->
	<input type="hidden" name="preid" value="<?php echo $_smarty_tpl->tpl_vars['preid']->value;?>
"><!-- 存储上一级页数 --> <!-- 内容// -->
	<input type="hidden" name="author" value="<?php echo $_smarty_tpl->tpl_vars['news']->value['author'];?>
">
	<input type="hidden" name="mid" value="1">
	<input type="hidden" name="cid" value="1">
	<table class="table">
		<tr>	
			<td><input type="text" name="title" 
				class="input-xlarge rule" id="title" style="width:80%;" value="<?php echo $_smarty_tpl->tpl_vars['news']->value['title'];?>
" placeholder="标题">
			</td>
		</tr>
		<tr>
			<td>
				<textarea id="container" name="content"><?php echo $_smarty_tpl->tpl_vars['news']->value['content'];?>
</textarea>                 <!-- 编辑框 elm1为此部件ID-->
			</td>
		</tr>
		<tr>
			<td class=btnline align=center><input type="hidden"
				name="id" value="<?php echo $_smarty_tpl->tpl_vars['news']->value['id'];?>
"> <input type="hidden" name="views"
				value="<?php echo $_smarty_tpl->tpl_vars['news']->value['views'];?>
" />
			<button type="submit" class="btn "><i class="icon-ok"></i>保存</button>
		</tr>
	</table>
</div>
 
</form>

</div>
</div>
</div></div></div>
<?php echo $_smarty_tpl->getSubTemplate ("module/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("news/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>