<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:04
         compiled from "/opt/lampp/htdocs/WCMS/app/view/module/footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:174344893357f7bd24c16942_78968521%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a70d01e8b5ffbd2e0d565a3225515b4a35bf97e6' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/module/footer.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174344893357f7bd24c16942_78968521',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd24c1ade8_69604852',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd24c1ade8_69604852')) {
function content_57f7bd24c1ade8_69604852 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '174344893357f7bd24c16942_78968521';
?>
<div class="show" style="padding:10px;text-align:center;display:none;">
<input id="file_upload" name="upload" type="file" class="input-large">
    <span class="help-block">图片要求宽度不大于1024x800，大小不能超过800KB,图片格式*.jpg;*.png</span>
  
    
     <div id="fileQueue"></div>
</div>


<!-- CK配置文件 -->
<!-- 
<?php echo '<script'; ?>
 src="./static/public/ckeditor/config.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./static/public/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"	src="./static/public/uploadify/jquery.uploadify-3.1.js"><?php echo '</script'; ?>
>
 -->

    <!-- UE配置文件 -->
    <?php echo '<script'; ?>
 type="text/javascript" src="./static/public/ueditor/ueditor.config.js"><?php echo '</script'; ?>
>
    <!-- 编辑器源码文件 -->
    <?php echo '<script'; ?>
 type="text/javascript" src="./static/public/ueditor/ueditor.all.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 type="text/javascript">
        //var ue = UE.getEditor('container');
    <?php echo '</script'; ?>
>

<!-- 编辑器源码文件 -->


<?php echo '<script'; ?>
 type="text/javascript">

<!-- 实例化编辑器 -->
var editor=UE.getEditor('container');


//var editor=CKEDITOR.replace( 'container', {
	// NOTE: Remember to leave 'toolbar' property with the default value (null).
//});


$(document).ready(function(){

	$("#file_upload").uploadify({
	    'swf': './static/public/uploadify/uploadify.swf',
	    'uploader': './index.php?factory/ckeditor',
	    'cancelImg': './static/public/uploadify/cancel.png',
	    'folder': 'UploadFile',
	    'queueID': 'fileQueue',
	    'fileObjName':'upload',
	    'formData':{'type':1},
	    'auto': true,
	    'fileTypeExts': '*.jpg;*.png;*.gif',//允许上传的文件类型，限制弹出文件选择框里能选择的文件
	    'multi': true,
	    'fileSizeLimit':'1MB',
	    'onUploadSuccess' : function(file,data,response) {
           
            var obj = jQuery.parseJSON(data);      

            if(obj.status==true){
           	 upimg(obj.message);
             }else{
         	    editor.insertHtml(obj.message);
             }          
	    }
            })
	   
})


function show() {
	$.layer({
	    type: 1,
	    shade: [0],
	    area: ['500', '500'],
	    title: false,
	    border: [5, 0.3, '#000'],
	    page: {dom : '.show'}
	});
}
function upimg(str) {
    if (str == "undefined" || str == "") {
        return;
    }
    str = "<img src='"+str+"'</img>";
    editor.insertHtml(str);
}



	$('#form_date').datetimepicker({
		language : 'zh-CN',
		format : 'yyyy-mm-dd hh:ii',
		weekStart : 1,
		todayBtn : 0,
		autoclose : 1,
		todayHighlight : 1,
		startView : 2,
		minView : 2,
		forceParse : 0
	});
<?php echo '</script'; ?>
>

<?php }
}
?>