<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:44
         compiled from "mysql:con.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7688299457f7bd4c9b5975_11679825%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df13747195fdc94ccc106d84ae968d141b8fcac7' => 
    array (
      0 => 'mysql:con.tpl',
      1 => 1472635105,
      2 => 'mysql',
    ),
  ),
  'nocache_hash' => '7688299457f7bd4c9b5975_11679825',
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd4c9ef7b4_68094968',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd4c9ef7b4_68094968')) {
function content_57f7bd4c9ef7b4_68094968 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/opt/lampp/htdocs/WCMS/lib/smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '7688299457f7bd4c9b5975_11679825';
echo $_smarty_tpl->getSubTemplate ("mysql:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

 
 <style>
 .navbar-default{background:#545652}

 </style>
 
 
 <section id="main" class="container">
    <section class="posts block a-fadeinL">
      
      <article class="post ">
        <h2 class="title">
          <?php echo $_smarty_tpl->tpl_vars['content']->value['title'];?>

        </h2>
        <div class="meta">
          <time><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['content']->value['date'],"%Y-%m-%d");?>
</time>   <span style="margin-left:30px;" id="views"> 1次浏览</span>
        </div>
        <div class="entry">
        <?php echo $_smarty_tpl->tpl_vars['content']->value['content'];?>

</div>
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_print" data-cmd="print" title="分享到打印"></a><a href="#" class="bds_linkedin" data-cmd="linkedin" title="分享到linkedin"></a><a href="#" class="bds_mshare" data-cmd="mshare" title="分享到一键分享"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a></div>

<?php echo '<script'; ?>
>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"image":{"viewList":["weixin","qzone","tsina","tqq","renren","print","linkedin","mshare","copy"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","qzone","tsina","tqq","renren","print","linkedin","mshare","copy"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];<?php echo '</script'; ?>
>
     

      </article>
    </section>
       <input type="hidden" name="contentid" value="<?php echo $_smarty_tpl->tpl_vars['content']->value['id'];?>
">
           
</div>
</section>
 
 <?php echo '<script'; ?>
>
 $(function(){
        var contentid=$("input[name='contentid']").val();
$.get("./index.php?news/views/?id="+contentid,function(data){
$("#views").html("+"+data.data+"次浏览");

},"json") 
 })
 <?php echo '</script'; ?>
>
 
<?php echo $_smarty_tpl->getSubTemplate ("mysql:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>