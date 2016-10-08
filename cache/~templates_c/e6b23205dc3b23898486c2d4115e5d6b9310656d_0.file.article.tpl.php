<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:00
         compiled from "/opt/lampp/htdocs/WCMS/app/view/customer/article.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:49382995757f7bd201f7773_54839786%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6b23205dc3b23898486c2d4115e5d6b9310656d' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/customer/article.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49382995757f7bd201f7773_54839786',
  'variables' => 
  array (
    'img' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd20245948_49547084',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd20245948_49547084')) {
function content_57f7bd20245948_49547084 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '49382995757f7bd201f7773_54839786';
echo $_smarty_tpl->getSubTemplate ("news/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div style="width:600px;min-height:680px;padding:50px;margin:0 auto;text-align:center;">
<h1>恭喜你，二维码生成成功，赶紧分享下吧</h1>
<div id="output"><img src="<?php echo $_smarty_tpl->tpl_vars['img']->value;?>
"></div>
</div>

<?php }
}
?>