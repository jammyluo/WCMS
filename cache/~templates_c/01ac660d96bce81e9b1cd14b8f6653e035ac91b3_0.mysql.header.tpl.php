<?php /* Smarty version 3.1.27, created on 2016-10-08 00:40:19
         compiled from "mysql:header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5855589657f7cff3b0c026_70136257%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01ac660d96bce81e9b1cd14b8f6653e035ac91b3' => 
    array (
      0 => 'mysql:header.tpl',
      1 => 1475858399,
      2 => 'mysql',
    ),
  ),
  'nocache_hash' => '5855589657f7cff3b0c026_70136257',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7cff3b3af32_20472882',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7cff3b3af32_20472882')) {
function content_57f7cff3b3af32_20472882 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5855589657f7cff3b0c026_70136257';
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title><?php echo $_smarty_tpl->tpl_vars['config']->value['website_name'];?>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['config']->value['keywords'];?>
">
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['config']->value['description'];?>
">
    <?php echo '<script'; ?>
 src="./static/theme/assets/js/jquery.js"><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="./static/public/jquery.cookie.js"><?php echo '</script'; ?>
>

    <link rel="stylesheet" href="./static/theme/assets/style.css">
    <link rel="stylesheet" href="./static/theme/assets/animation.css">
    <link rel="stylesheet" href="./static/theme/assets/main.css">

  </head>
  <body>
  <div class="navbar navbar-default">
        <div class="container">
              <div class="navbar-header">
                <a class="navbar-brand" title="$config.website_name}">
                  <span class="logo">
                  <?php echo $_smarty_tpl->tpl_vars['config']->value['website_name'];?>

                  </span>
                </a>
              </div>
        </div>
</div><?php }
}
?>