<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:44
         compiled from "/opt/lampp/htdocs/WCMS/app/view/module/wait.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4025299957f7bd4ca0de92_20744218%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33a3025381a2d27b66a66c1133f153b5fcaceb80' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/module/wait.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4025299957f7bd4ca0de92_20744218',
  'variables' => 
  array (
    'message' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd4ca1ab65_20946422',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd4ca1ab65_20946422')) {
function content_57f7bd4ca1ab65_20946422 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4025299957f7bd4ca0de92_20744218';
echo $_smarty_tpl->getSubTemplate ("news/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
 
<!-- 头部// -->
<?php echo $_smarty_tpl->getSubTemplate ("news/top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
 <?php echo $_smarty_tpl->getSubTemplate ("news/nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<!-- start: Content -->

<div class="content"><!-- Default panel contents -->

	<h1 style="font-family:微软雅黑"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</h1>
	<p>
		<div class="btn-group">
		<a href=".<?php echo $_smarty_tpl->tpl_vars['news']->value['html'];?>
" class="btn " target="_blank">查看内容</a>|
		<a href="./index.php?factory/v/?mid=<?php echo $_smarty_tpl->tpl_vars['news']->value['mid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['news']->value['id'];?>
" class="btn">修改编辑</a>|
		<a href="./index.php?factory/c/?cid=<?php echo $_smarty_tpl->tpl_vars['news']->value['cid'];?>
" class="btn">返回列表</a>|
		</div>
	</p>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("news/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>