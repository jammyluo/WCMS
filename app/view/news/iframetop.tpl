		<!-- start: Header -->
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<div class="pull-left" style="width:12%">
				<a class="logo" href="javascript:setUrl('./index.php?system/config')">WCMS v10.0</a>
				</div>		
				<div class="nav-no-collapse header-nav">
				 
					{foreach from=$nodes item=l}
							<a class="dmenu" id="dmenu_{$l.id}"href="javascript:addmenu({$l.id})"> {$l.remark}</a>
						


					{/foreach}
					<a class="dmenu" style="width:40px;"></a>
					<div class="caidan pull-right">
			<a  href="./index.html" target="_blank">
								首页 |
							</a>	<a  href="javascript:qingli()">
								缓存
							</a>|
			<a href="./index.php?anonymous/signout">退出</a>
			<br>你好,{$user.username}
			</div>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->

{literal}
<script>
$(function () {

	addmenu(75);
})

function caidan(obj) {
	var url = $(obj).attr("data");
	$("li").each(function () {
		$(this).removeClass("active");
	})
	$(obj).addClass("active");
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

</script>
{/literal}
