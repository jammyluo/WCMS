<?php /* Smarty version 3.1.27, created on 2016-10-08 22:22:14
         compiled from "/opt/lampp/htdocs/WCMS/app/view/public/error.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:36766133257f901169d5549_51286879%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2509fa058ea3c50415ecebd95e780a3391e4a596' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/public/error.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36766133257f901169d5549_51286879',
  'variables' => 
  array (
    'error' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f90116a098c9_37059861',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f90116a098c9_37059861')) {
function content_57f90116a098c9_37059861 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '36766133257f901169d5549_51286879';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8" />
	<title>WCMS 登录</title>
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link href="./static/bootstrap2/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/style-responsive.min.css" rel="stylesheet" />
	<link href="./static/bootstrap2/css/retina.css" rel="stylesheet" />
		<link href="./static/bootstrap2/css/my.less" rel="stylesheet/less" />
		<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/less.min.js" ><?php echo '</script'; ?>
>	<!-- end: CSS -->	<!-- end: CSS -->
 <body>
		
	
		
		 <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
!</h1>
        <p>当你看到这个页面，说明你没有权限进入</p>
        <p><a href="./" class="btn btn-primary btn-large">返回首页 &raquo;</a>    <a href="./index.php?anonymous/login" class="btn btn-success btn-large">登录 &raquo;</a></p>
      </div>

     

      <hr>

      <footer>
        <p>&copy; <?php echo $_smarty_tpl->tpl_vars['config']->value['copyright'];?>
</p>
      </footer>

    </div> <!-- /container -->
  </body>
</html><?php }
}
?>