<?php /* Smarty version 3.1.27, created on 2016-10-07 23:20:04
         compiled from "/opt/lampp/htdocs/WCMS/app/view/module/add.header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:72580453257f7bd24c05b02_31064589%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85dc4abc73385d44a1d515050720afa3a7b7b0d7' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/module/add.header.tpl',
      1 => 1474299225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72580453257f7bd24c05b02_31064589',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd24c0eef4_53821379',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd24c0eef4_53821379')) {
function content_57f7bd24c0eef4_53821379 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '72580453257f7bd24c05b02_31064589';
?>
<?php echo '<script'; ?>
 type="text/javascript"
	src="./static/public/jquery-1.11.0.min.js"><?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 src="./static/public/jquery-ui.js" type="text/javascript"
	charset="utf-8"><?php echo '</script'; ?>
>


<!-- 编辑器源码文件 -->
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<?php echo '<script'; ?>
 src="./static/public/evol.colorpicker.min.js"
	type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
<link href="./static/public/css/evol.colorpicker.css" rel="stylesheet"
	type="text/css">
<link href="./static/public/css/jquery-ui.css" rel="stylesheet"
	type="text/css">
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" media="screen">

<?php echo '<script'; ?>
 type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.js"
	charset="UTF-8"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js"
	charset="UTF-8"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="./static/public/layer/layer.min.js"><?php echo '</script'; ?>
>




<style>
.cke_button__addpic{background: url(./static/public/ckeditor/plugins/addpic/addpic.png) no-repeat 5px 5px !important;}
.table th,.table td {
	border-top: none;
	border-bottom: 1px solid #f1f1f1;
}
</style>
<?php echo '<script'; ?>
 type='text/javascript'>
	$(document)
			.ready(
					function() {
						$('#cate')
								.change(
										function() {
											var a = $(this).children(
													'option:selected').val(); //弹出select的值
											$
													.post(
															"./index.php?factory/extend",
															{
																cid : a
															},
															function(data) {
																var str;
																var sub = $(
																		"#submit")
																		.html();
																for ( var i = 0; i < data.data.length; i++) {

																	str += "<tr><td class=\"span2\">"
																			+ data.data[i].name
																			+ "</td><td class=\"span8\"><input type=\"text\" class=\"input-xlarge\" name=\""+data.data[i].key+"\">"
																			+ data.data[i].key
																			+ "|"
																			+ data.data[i].type
																			+ " </td><td></td></tr>";

																}
																str = str
																		+ "<tr>"
																		+ sub
																		+ "</tr>";
																$("#extend")
																		.html(
																				str);
															}, "json")
										});

						$("#mycolor").colorpicker({
							color : "#ffc000",
							history : false,
							displayIndicator : false
						});
						$("#mycolor")
								.on(
										"change.color",
										function(event, color) {
											$('#title').css('color', color);
											var x = $("#b").attr("class");
											if (x == "b") {
												$("input[name='css']")
														.val(
																'color:'
																		+ color
																		+ ";font-weight:bold;");
											} else {
												$("input[name='css']").val(
														'color:' + color);
											}
										})
					});

	function checktitle() {
		var t = $("#title").val();

		$.post("./index.php?factory/search", {
			key : "title",
			value : t,
			datatype : "json"
		}, function(result) {
			if (result.status == "success") {
				$("#checktitle").addClass("alert alert-success");
			} else {
				$("#checktitle").addClass("alert alert-error");
			}
			var str = "<ul>";
			for ( var i = 0; i < result.data.length; i++) {
				str += "<li>" + result.data[i].title + "</li>";
			}
			str = str + "</ul>";
			$("#checktitle").html(str)
		}, "json")
	}

	function apd(t) {
		var htm = '<input type="text" name='+t+'[]>';
		$("#" + t).append(htm);
	}
	function jiacu() {
		var c = $("#mycolor").val();
		if (c != "#ffc000") {
			c = "color:" + c + ";";
		} else {
			c = "";
		}

		var x = $("#b").attr("class");
		if (x == "b") {
			$("#title").css("font-weight", "");
			$("#b").removeClass("b");
			$("input[name='css']").val(c);
		} else {
			$("#title").css("font-weight", "bold");
			$("#b").addClass("b");
			$("input[name='css']").val(c + "font-weight:bold;");
		}

	}
<?php echo '</script'; ?>
>
 <?php echo $_smarty_tpl->getSubTemplate ("news/top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
 <?php echo $_smarty_tpl->getSubTemplate ("news/nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>





			
<?php }
}
?>