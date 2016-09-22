<script type="text/javascript"
	src="./static/public/jquery-1.11.0.min.js"></script>


<script src="./static/public/jquery-ui.js" type="text/javascript"
	charset="utf-8"></script>


<!-- 编辑器源码文件 -->
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<script src="./static/public/evol.colorpicker.min.js"
	type="text/javascript" charset="utf-8"></script>
<link href="./static/public/css/evol.colorpicker.css" rel="stylesheet"
	type="text/css">
<link href="./static/public/css/jquery-ui.css" rel="stylesheet"
	type="text/css">
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" media="screen">

<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.js"
	charset="UTF-8"></script>
<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js"
	charset="UTF-8"></script>
<script type="text/javascript" src="./static/public/layer/layer.min.js"></script>



{literal}
<style>
.cke_button__addpic{background: url(./static/public/ckeditor/plugins/addpic/addpic.png) no-repeat 5px 5px !important;}
.table th,.table td {
	border-top: none;
	border-bottom: 1px solid #f1f1f1;
}
</style>
<script type='text/javascript'>
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
</script>
{/literal} {include file="news/top.tpl"} {include file="news/nav.tpl"}




			
