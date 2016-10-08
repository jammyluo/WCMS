<?php /* Smarty version 3.1.27, created on 2016-10-07 23:19:56
         compiled from "/opt/lampp/htdocs/WCMS/app/view/news/main.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:133859474357f7bd1c635ff2_92243276%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64f65934287ce4844d330c8a4aa576d01a5e0c38' => 
    array (
      0 => '/opt/lampp/htdocs/WCMS/app/view/news/main.tpl',
      1 => 1475851293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133859474357f7bd1c635ff2_92243276',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f7bd1c66c689_67032933',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f7bd1c66c689_67032933')) {
function content_57f7bd1c66c689_67032933 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '133859474357f7bd1c635ff2_92243276';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>资讯管理系统</title>
    <!-- Bootstrap css -->
    <link href="./static/bootstrap3/css/bootstrap.min.css" rel="stylesheet" />
	<link href="./static/font-awesome-4.6.3/css/font-awesome.css" rel="stylesheet">
    <!-- 当前项目样式文件 -->
    <link href="./static/mycss/sb-admin.css" rel="stylesheet">
    <link href="./static/mycss/sb-bk-theme.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper" >
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <i class="fa fa-leaf f20 mr5"></i>
                    资讯管理系统
                </a>
            </div>
            <!-- Top Menu Items -->
	    <!--
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:qingli();"><i class="fa fa-fw fa-gear"></i> 清理缓存</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="./index.php?anonymous/signout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
                        </li>
                    </ul>
                </li>
            </ul>
	    -->
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:jumpUrl('./index.php?factory/c/?mid=1');"><i class="fa fa-fw fa-dashboard"></i> 文章管理</a>
                    </li>
                    <?php if ($_smarty_tpl->tpl_vars['user']->value['manager'] == 1) {?>
                        <li>
                         <a href="javascript:jumpUrl('./index.php?member/listing');"><i class="fa fa-fw fa-dashboard"></i> 会员列表 </a>
                        </li>
                    <?php }?>
                        <li>
                            <a href="javascript:qingli();"><i class="fa fa-fw fa-gear"></i> 清理缓存</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="./index.php?anonymous/signout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
                        </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <iframe class="panel panel-default" src="./index.php?factory/c/?mid=1" id="iframe" scrolling="true" Height=1000 width=100<?php echo '%>';?></iframe>
    </div>
    <!-- /#wrapper -->

    
    
	<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
	<?php echo '<script'; ?>
 src="http://o.bkclouds.cc/static_api/v3/assets/js/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
	<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
	<?php echo '<script'; ?>
 src="http://o.bkclouds.cc/static_api/v3/assets/bootstrap-3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>

    

<?php echo '<script'; ?>
>
$(function () {

	addmenu(75);
})

function iFrameHeight() {   
var ifm= document.getElementById("iframe");   
var subWeb = document.frames ? document.frames["iframe"].document : ifm.contentDocument;   
if(ifm != null && subWeb != null) {
   ifm.height = subWeb.body.scrollHeight;
   ifm.width = subWeb.body.scrollWidth;
}   
}   

function caidan(obj) {
	var url = $(obj).attr("data");
	$("li").each(function () {
		$(this).removeClass("active");
	})
	$(obj).addClass("active");
	$("#iframe").attr("src", url);
}

function jumpUrl(url) {
    $("#iframe").attr("src", url);
}
function addmenu(id) {
	var aArr = $(".header-nav a");
	aArr.each(function () {

		$(this).removeClass("act");
	})
	$("#dmenu_" + id).addClass("act");
	$.post("./index.php?system/getmenu", {
		id : id
	}, function (data) {
		var con = "";
		var d = data.data;
		var css;
		for (var i = 0; i < d.length; i++) {

			if (i == 0) {

				var url = './index.php?' + d[i].module + '/' + d[i].action + '/' + d[i].params;
				css = 'class="active"';
				$("#iframe").attr("src", url);
			}else{
                 css='';
			}

			con = con + '<li onclick="caidan(this)" data="./index.php?' + d[i].module + '/' + d[i].action + '/' + d[i].params + '"' + css + '><a href="javascript:void(0)">' + d[i].remark + '</a></li>';
		}
		$(".main-menu").html(con);

	}, "json")

}

function qingli() {

	$.post("./index.php?factory/cleancache", {
		type : "all"
	}, function (data) {
		alert(data.message)
	}, "json");
}
<?php echo '</script'; ?>
>



</body>

</html>
<?php }
}
?>