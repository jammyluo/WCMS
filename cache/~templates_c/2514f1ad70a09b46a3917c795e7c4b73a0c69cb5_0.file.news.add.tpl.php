<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:04
         compiled from "/opt/lampp/htdocs/WCMS/app/view/module/news.add.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:80164806457f7bd24bc3d06_91604553%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2514f1ad70a09b46a3917c795e7c4b73a0c69cb5' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/module/news.add.tpl',
      1 => 1474562331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80164806457f7bd24bc3d06_91604553',
  'variables' => 
  array (
    'repeat' => 0,
    'user' => 0,
    'news' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd24c005c7_80424226',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd24c005c7_80424226')) {
function content_57f7bd24c005c7_80424226 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '80164806457f7bd24bc3d06_91604553';
echo $_smarty_tpl->getSubTemplate ("news/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("module/add.header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<!-- start: Content -->
<div >
	<!-- Only required for left/right tabs -->
	<div class="nav nav-tabs">
		<li><a href="javascript:history.go(-1)"><<返回</a></li>
	</div>
	<form name="news" action="./index.php?factory/add" method="post"
		enctype="multipart/form-data" class="form-inline">
		<!-- 内容// -->
		<input type="hidden" name="repeat" value="<?php echo $_smarty_tpl->tpl_vars['repeat']->value;?>
">
		<input type="hidden" name="author" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
">
		<input type="hidden" name="mid" value="1">
		<input type="hidden" name="cid" value="1">
		<table class="table">
			<tr>
				<td class="span8"><input type="text" name="title"  style="width:80%;"
					class="input rule" id="title" placeholder="标题">
			</tr>
			<tr>
				<td >
				<!-- 加载编辑器的容器 -->
			        <textarea id="container" name="content"></textarea> <!-- 编辑框 elm1为此部件ID-->
				</td>
			</tr>
			<tr>
				<td class=btnline align=center><input type="hidden" name="id"
					value="<?php echo $_smarty_tpl->tpl_vars['news']->value['id'];?>
">
				<button type="submit" class="btn "><i class="icon-ok">创建</i><?php echo $_smarty_tpl->tpl_vars['lang']->value['CREATE'];?>

				</button>
			</tr>
		</table>
	</form>
</div>					
<?php echo $_smarty_tpl->getSubTemplate ("module/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php echo $_smarty_tpl->getSubTemplate ("news/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>