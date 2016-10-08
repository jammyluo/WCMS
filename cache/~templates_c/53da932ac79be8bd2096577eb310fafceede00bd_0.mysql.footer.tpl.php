<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:44
         compiled from "mysql:footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:206621276557f7bd4c9ff690_17492811%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53da932ac79be8bd2096577eb310fafceede00bd' => 
    array (
      0 => 'mysql:footer.tpl',
      1 => 1472635139,
      2 => 'mysql',
    ),
  ),
  'nocache_hash' => '206621276557f7bd4c9ff690_17492811',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd4ca02df5_59462625',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd4ca02df5_59462625')) {
function content_57f7bd4ca02df5_59462625 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '206621276557f7bd4c9ff690_17492811';
?>
    <footer id="main-footer">
    <div class="container a-fadeinL">
         <span style="color:#20558a;">
              <p>Copyright © WCMS   <a href="http://www.miibeian.gov.cn" target="_blank">ICP备案号</a>
          </p>
    </div>
    </footer>


    <div class="actGotop" id="backtop" style="display: block;">
      <a href="javascript:;" title="返回顶部"></a>
    </div>


    <?php echo '<script'; ?>
 src='./static/theme/assets/js/prettify.js'><?php echo '</script'; ?>
>
    
    <?php echo '<script'; ?>
 type='text/javascript'>
      $(document).ready(function(){
      islogin();
        $("#backtop").hide();
        $(window).scroll(function () {
          if ($(this).scrollTop() > 100) {
            $('#backtop').fadeIn();
          } else {
            $('#backtop').fadeOut();
          }
        });
        $('#backtop').click(function () {
          $('body,html').animate({
            scrollTop: 0
          }, 500);
        });
        $("pre").addClass("prettyprint");
        prettyPrint();
      });


   function islogin(){
        $(".islogin").hide();
       var cookie=$.cookie("user");   
       if(cookie==undefined){
      return;
       }else{

           $(".login").hide();
           $(".islogin").after("<li><a href='./index.php?anonymous/login'>你好,"+cookie+"</a></li>")

       }
   }
    <?php echo '</script'; ?>
>
    
  </body>
</html><?php }
}
?>