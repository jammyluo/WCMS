{include file="news/header.tpl"}
<link rel="stylesheet"
	href="./static/public/ztree/css/zTreeStyle/zTreeStyle.css"
	type="text/css">




<!-- 头部// -->
{include file="news/top.tpl"} {include file="news/nav.tpl"}
<!-- start: Content -->
<div id="content" class="span10">


	<div class="row-fluid">


		<div class="well">
			<!-- Default panel contents -->

			<div class="form-inline suoding">
				<div class="btn-group">
					<a href="javascript:iframe(1,1)" class="btn ">生成首页</a> <a href="javascript:void(0)"
						id="add" class="btn ">生成内容</a> <a href="javascript:void(0)" id="view" class="btn ">查看内容</a>|<a
						id="temp" href="javascrit:void(0)" class="btn " target="_blank">预览</a>
				</div>
			</div>

			<div class="box-content">
				权限:<span id="authorize"></span>
				专题:<span id="index_temp"></span>
				列表:<span id="list_temp"></span>
				内容:<span id="content_temp"></span>

				<table class="table">
					<form action="#" method="post">
						<tr>
							<td class="span4"><input type="hidden" name="category"
								value="{$category.id}"> <input id="dicKey" type="text"
								class="input-middle" name="cate"
								value="{$category.name}{$category.id}"
								onkeydown="changeColor('treeDemo','name',this.value)">

								<div id="menuContent" class="menuContent"
									style="position: absolute; max-height: 500px; overflow-y: scroll">
									<ul id="treeDemo" class="ztree"
										style="margin-top: 0; background-color: #FFF; border: 1px solid #f0f0f0"></ul>
								</div></td>
							<td class="span7"></td>

						</tr>

						<tr>
							<td></td>
							<td>
								<div class="form-inline">
									<span class="label">新增</span> <select name="module" id="module"
										class="input-small">
										<option value=1 selected>文章</option>
										<option value=2>图片</option>

										<option value=3>专题</option>
										<option value=5>产品</option>
										<option value=8>系统</option>

									</select> <span class="input-append"> <input type=text name=name
										id="catename"> <input type="hidden" class="category"
										name="category" id="category" value=""> <input
										type="button" name="add" value="保存" class="btn"
										onclick="return addCate(this)">
									</span>
								</div>
							</td>
						</tr>

					</form>




					<tr>
						<td></td>
						<td>
							<div class="form-inline">
								<span class="label">模板</span> <select name="type" id="type"
									class="input-small">
									<option value="temp_index">专题</option>
									<option value="temp_list" selected>列表</option>
									<option value="temp_content">内容</option>
								</select> <span class="input-append"> <input type="text"
									name="temp_name" /> <input type="hidden" name="category"
									class="category" value=""> <input type="button"
									name="bind" value="绑定" onclick="bind('bind')"
									class="btn"></span>
							</div>
						</td>

					</tr>





					<tr>

						<td></td>
						<td>
							<div class="form-inline">
								<span class="label">授权</span> <select name="groupid"
									id="groupid" class="input-small">
									<option value=1>站长</option>
									<option value=2>管理员</option>
									<option value=3>验证用户</option>
									<option value=4>注册用户</option>
									<option value=5 selected>游客</option>
								</select> <label class="checkbox"><input type="checkbox"
									name="jicheng" value="1">授权</label> <input
									type="button" name="add" value="继承"
									onclick="shouquan()" class="btn">
							</div>
						</td>
					</tr>


				</table>
				<div class="progress" style="display: none;">
					<div class="bar" style="width: 0%;">10</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript"
		src="./static/public/ztree/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript"
		src="./static/public/ztree/jquery.ztree.excheck-3.5.js"></script>

	<script type="text/javascript"
		src="./static/public/ztree/jquery.ztree.exedit-3.5.js"></script>

	{literal}
	<SCRIPT LANGUAGE="JavaScript">
		var zTreeObj;
		// zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
		var setting = {
			async : {
				enable : true,
				url : "./index.php?cate/ztree",
				dataType : "json",
				autoParam : [ "id" ],
				otherParam : {
					"otherParam" : "zTreeAsyncTest"
				},
			},
			data : {
				simpleData : {
					enable : true,
					idKey : "id",
					pIdKey : "fid",
					rootPId : null
				}
			},
			edit : {
				enable : true,
				showRemoveBtn : true,
				showRenameBtn : true,
				drag : {
					isCopy : false,
					isMove : true,
					pre : true,
					next : true,
					inner : true,
					autoExpandTrigger : true

				}
			},
			callback : {
				onClick : onClick,
				onDblClick : cc,
				beforeRemove : zTreeBeforeRemove,
				onRename : zTreeOnRename,
				beforeRename : zTreeBeforeRename,
				beforeDrop : zTreeBeforeDrop
			},
			view : {
				showIcon : true,
				fontCss : getFontCss
			}
		};
		// zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）

		$(document).ready(function() {
			zTreeObj = $.fn.zTree.init($("#treeDemo"), setting);
			$("button").bind('click', addCate);

			showMenu();
		});

		var cids = "";
		var index = 1;
		var pagenums = 0;
		function iframe(type, id) {
			//列表静态
			if (type == 1) {
				$.post("./index.php?news/htmlindex", function(data) {
					alert(data);
				});
			}
			//内容静态
			if (type == 2) {

				$.post("./index.php?news/cids", {
					cid : id
				}, function(data) {

					if (!data.status) {
						alert(data.message);
						return;
					} else {
						$(".progress").show();
						cids = data.data.cids;
						pagenums = data.data.pagenum;
						html();
					}

				}, "json");
			}

		}

		function html() {

			if (index > pagenums) {
				setTimeout(function() {

					$(".progress").hide();
					$(".bar").css("width", "0%");
					$(".bar").html("0%");
					index = 1;
				}, 3000);
				return false;
			}

			$
					.post("./index.php?news/batch", {
						id : cids,
						p : index
					},
							function(data) {
								$(".bar").css(
										"width",
										Math.round(index * 100 / pagenums)
												+ "%");
								$(".bar").html(
										Math.round(index * 100 / pagenums)
												+ "%");
								index += 1;
								html();
							}, "json")

		}

		function showMenu() {
			var cityObj = $("#citySel");
			var cityOffset = $("#citySel").offset();
			$("#menuContent").slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			//$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn"
					|| event.target.id == "menuContent" || $(event.target)
					.parents("#menuContent").length > 0)) {
				//hideMenu();
			}
		}
		function zTreeBeforeRename(treeId, treeNode, newName, isCancel) {
			if (newName.match(/\d+/g)) {
				alert("分类名不允许有数字");
				return false;
			}

			if (newName.length < 4) {
				alert("分类名不少于4个字符");
				return false;
			}
			return true;
		}

		function zTreeBeforeDrop(treeId, treeNodes, targetNode, moveType) {

			$.post("./index.php?cate/move", {
				id : treeNodes[0].id,
				fid : targetNode.id
			}, function(data) {

			}, "json");
		}

		function zTreeBeforeRemove(treeId, treeNode) {

			if (!confirm("确认删除?")) {
				return false;
			}

			$.ajax({
				url : "./index.php?cate/remove",
				async : false, // 注意此处需要同步，因为返回完数据后，下面才能让结果的第一条selected  
				type : "POST",
				data : "category=" + treeNode.id,
				dataType : "json",
				success : function(data) {
					if (data.message != "success") {
						alert(data.message);

					} else {
						zTreeObj.removeNode(treeNode);

					}
				}
			});

			return false;
		}

		function zTreeOnRename(event, treeId, treeNode, isCancel) {
			var newName = treeNode.name;

			$.post("./index.php?cate/rename", {
				name : newName,
				category : treeNode.id
			}, function(data) {
				if (data.message != "success") {
					alert(data.message);
				} else {

				}

			}, "json");

		}

		function cc(event, treeId, treeNode, clickFlag) {
			var cid = treeNode.id;
			window.location.href = './index.php?factory/data/?mid=1&cid=' + cid;
			setTimeOut(2000);
		}
		function onClick(event, treeId, treeNode, clickFlag) {

			$(".category").val(treeNode.id);
			$.post("./index.php?cate/category", {
				cid : treeNode.id
			}, function(data) {
				json = data.message;
				$("#parent").html("parent:" + json.name);
				$("#cate_name").html(json.name);
				$("#index_temp").html(
						'<a href="./index.php?temp/edittemp/?name='
								+ json.temp_index + '" >' + json.temp_index
								+ '</a>');
				$("#list_temp").html(
						'<a href="./index.php?temp/edittemp/?name='
								+ json.temp_list + '" >' + json.temp_list
								+ '</a>');
				$("#content_temp").html(
						'<a href="./index.php?temp/edittemp/?name='
								+ json.temp_content + '" >' + json.temp_content
								+ '</a>');
				$("#authorize").html(json.groupname);
				$("#zilei").attr('href',
						'javascript:iframe(3,' + treeNode.id + ')');
				$("#fenlei").attr('href',
						'javascript:iframe(1,' + treeNode.id + ')');

				$("#add").attr('href',
						'javascript:iframe(2,' + treeNode.id + ')');
				$("#view").attr('href',
						'./index.php?factory/c/?mid=1&cid=' + treeNode.id);
				$("#temp").attr('href',
						'./index.php?news/c/?cid=' + treeNode.id);
				$("#static").attr('href', './a/c/' + treeNode.id + '.html');

			}, "json");
			ccl();

			Nodes = treeNode;

		}
		function ccl() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"), nodes = zTree
					.getSelectedNodes(), v = "";
			nodes.sort(function compare(a, b) {
				return a.id - b.id;
			});
			for ( var i = 0, l = nodes.length; i < l; i++) {
				v += nodes[i].name + ",";
			}
			if (v.length > 0)
				v = v.substring(0, v.length - 1);
			var cityObj = $("#citySel");

			var id = v.match(/\d+/g);
			$("input[name='category']").val(id);
			cityObj.attr("value", v);
			//hideMenu();
		}
		var Nodes;
		function addCate(obj, treeNode) {
			var type = obj.name;
			var name = $("#catename").val();
			var category = $("#category").val();
			var module = $("#module").val();
			if (category.length > 13) {
				alert("分类字数太多，请删减无法提交");
				return false;
			}

			if (type == "add") {

				if (name.match(/\d+$/g)) {
					alert("分类名不允许有数字");
					return;
				}

				$.post("./index.php?cate/add", {
					type : type,
					name : name,
					mid : module,
					category : category
				}, function(data) {
					if (data.message == "error") {
						alert(data.message);
						return;
					} else {
						var newid = parseInt(data.data);
						var newname = name + newid;
						zTreeObj.addNodes(Nodes, {
							id : newid,
							fid : category,
							name : newname
						});
					}

				}, "json");

			}

		};

		function bind(types) {

			var name = $("input[name='temp_name']").val();
			var t = $("#type").val();
			var categoryid = $("#category").val();
			$.post("./index.php?cate/bind", {
				name : name,
				type : t,
				model : types,
				category : categoryid
			}, function(json) {

				if (json.status == true) {
					alert(json.message);

				}
			}, "json");
		}
		function shouquan() {

			var id = $("input[name='category']").val();
			var g = $("#groupid").val();
			var k = $("input[name='jicheng']").attr("checked");

			$.post("./index.php?cate/premission", {
				id : id,
				groupid : g,
				jicheng : k
			}, function(json) {
				alert(json.message);
			}, "json");
		}

		//使用搜索数据 加高亮显示功能，需要2步
		//1.在tree的setting 的view 设置里面加上 fontCss: getFontCss 设置
		//2.在ztree容器上方，添加一个文本框，并添加onkeyup事件，该事件调用固定方法  changeColor(id,key,value）
		//	id指ztree容器的id，一般为ul，key是指按ztree节点的数据的哪个属性为条件来过滤,value是指过滤条件，该过滤为模糊过滤
		var lastValue = "", nodeList = [], fontCss = {};
		function changeColor(id, key, value) {

			if (event.keyCode != 13) {
				return;
			}

			treeId = id;
			updateNodes(false);
			if (value != "") {
				var treeObj = $.fn.zTree.getZTreeObj(treeId);
				nodeList = treeObj.getNodesByParamFuzzy(key, value);
				if (nodeList && nodeList.length > 0) {

					updateNodes(true);
				}
			}
		}
		function updateNodes(highlight) {
			var treeObj = $.fn.zTree.getZTreeObj(treeId);
			for ( var i = 0; i < nodeList.length; i++) {
				treeObj.expandNode(nodeList[i], true, true, true);

				nodeList[i].highlight = highlight;
				treeObj.updateNode(nodeList[i]);
			}
		}

		function getFontCss(treeId, treeNode) {
			return (!!treeNode.highlight) ? {
				color : "#ff5454",
				"font-weight" : "bold"
			} : {
				color : "#333",
				"font-weight" : "normal"
			};
		}
	</SCRIPT>

	{/literal} {include file="news/footer.tpl"}