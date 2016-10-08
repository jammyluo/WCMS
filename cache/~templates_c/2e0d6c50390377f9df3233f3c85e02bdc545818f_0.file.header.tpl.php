<?php /* Smarty version 3.1.27, created on 2016-10-07 23:19:54
         compiled from "/opt/lampp/htdocs/WCMS/app/view/news/header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:141678381557f7bd1a35b346_19178400%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e0d6c50390377f9df3233f3c85e02bdc545818f' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/news/header.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '141678381557f7bd1a35b346_19178400',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd1a3644b2_58634917',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd1a3644b2_58634917')) {
function content_57f7bd1a3644b2_58634917 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '141678381557f7bd1a35b346_19178400';
?>
<!DOCTYPE html>
<html>
<head>
<title>WCMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<link rel="stylesheet" href="./static/bootstrap2/css/bootstrap.min.css">
	<link rel="stylesheet" href="./static/bootstrap2/css/style.min.css"  />
	<link rel="stylesheet/less" href="./static/bootstrap2/css/my.less"  />
	<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/jquery-1.11.0.min.js" ><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/page/bootstrap-paginator.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/less.min.js" ><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/jquery.upload.js" ><?php echo '</script'; ?>
>

	
</head>	
<?php echo '<script'; ?>
>
less.modifyVars({
	  '@banner-color': '<?php echo $_smarty_tpl->tpl_vars['config']->value['banner_color'];?>
',
	  '@leftbg-color': '<?php echo $_smarty_tpl->tpl_vars['config']->value['leftbg_color'];?>
',
	  '@left-selected-color': '<?php echo $_smarty_tpl->tpl_vars['config']->value['left_selected_color'];?>
',
	  '@btn-color':'<?php echo $_smarty_tpl->tpl_vars['config']->value['btn_color'];?>
',
	  '@btn-selected':'<?php echo $_smarty_tpl->tpl_vars['config']->value['btn_selected'];?>
'
	});
<?php echo '</script'; ?>
>
<?php }
}
?>