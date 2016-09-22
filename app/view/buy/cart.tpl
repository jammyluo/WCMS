{include file="news/header.tpl"}
<link href="./static/public/jsorder/css/order.css" rel="stylesheet" />

{literal}
<style>
.table {
	font-size: 12px;
}

.table th {
	background: #f0f0f0;
}

.table td {
	text-align: left;
}

.suoding {
	height: 30px;
}

.nj {
	width: 60px;
}

.num {
	width: 60px;
}

.ps {
	width: 60px;
}
.mg {
	width: 40px;
}

.mj {
	width: 60px;
}
.cfk {
	width: 40px;
}
.dg{width:40px}

.box {
	border-radius: 0px;
}

.box-content {
	border: 1px #ccc solid;
}

.box-content .title {
	font-size: 15px;
	padding: 2px;
	font-weight: 700;
}

.shr {
	line-height: 25px;
	padding: 10px;
	color: #666
}

.goodslist {
	padding: 10px;
}

.info {
	background: #f1f1f1;
	font-size: 16px;
	font-weight: 700;
	padding: 10px;
}

.table input {
	height: 16px;
}

.price {
	font-weight: 700
}

.add-on,textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"],input[type="file"],.uneditable-input
	{
	border-color: #ccc !important;
	color: #000;
	border-radius: 0px;
	height: 16px;
	font-size: 12px
}

.table th {
	font-weight: 400;
}

.notice {
	color: red;
	font-weight: 700;
}

.zhuyi {
	background: url(/static/bootstrap2/img/wx9jiD3ll.png) no-repeat -0px
		-32px;
	height: 15px;
	line-height: 15px;
	display: inline-block;
	width: 17px;
}
</style>
{/literal}

<!-- 头部// -->


<!-- start: Content -->
<div>


<div class="row-fluid">


<div class="box"><!-- Default panel contents -->
<div class="info"></div>

<div class="box box-content">
<div class="title">商品清单</div>
<div class="goodslist">
<table class="table table-hover" style="text-align: center;">
	<tr class="">
		<th class="span3">产品名称</th>
		<th class="span2">单价</th>
		<th class="span4">尺寸规格</th>
		<th class="span2">一件数量</th>
		<th class="span2">购买数量</th>
		<th class="span2">操作</th>
	</tr>
	{if $goods!=""} {foreach from=$goods item=l name=g} {include
	file="buy/goods/{$l.module}.tpl"} {/foreach} {/if}
	<tr>
		<td>龙骨选择</td>
		<td colspan="5">
		<div class="form-inline">
		
		
		<label class="radio"> <input type="radio"
			name="longgu" value="2.7米镀锌">2.7米镀锌 </label>
			<!--  
			 <label class="radio"> <input
			type="radio" name="longgu" value="4米镀锌">4米镀锌 </label>
			-->
			 <label
			class="radio"> <input type="radio" name="longgu" value="2.7米烤漆">2.7米烤漆
		</label>
		
		
		<!--  
		 <label class="radio"> <input type="radio" name="longgu"
			value="4米烤漆">4米烤漆 </label>
			
			
			 <label class="radio"> <input type="radio"
			name="longgu" value="不配龙骨" disabled>不配龙骨 </label>
			
			-->
			</div>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan=5><i class="zhuyi"></i><span class="notice">辅料配发福利活动 烤漆100/套送50/套，镀锌100/套送40/套</span>
		</td>
	</tr>
</table>
</div>
</div>
<a href="javascript:history.go(-1)" class="btn btn-warning">返回继续购物</a> <b>备注</b>
<input type="text" name="remark" class="input-xxlarge" value=""
	placeholder="如DIY定制画名称,灯管,LED驱动器配件"> <b>总额</b> <span id="totalcount"
	style="font-family: Verdana; color: red; font-size: 16px;">{$totalcount}</span>
元
 
<input type="radio" class="express" id="express" value="不参加赠送活动"
	name="express" >不参加赠送活动  <input type="radio" class="express" id="normal" 
	value="参加活动" name="express" >参加活动 <a href="javascript:sub()"
	class="btn btn-danger pull-right">提交订单</a></div>
</div>

</div>
<div style="display: none">
<form action="/index.php?order/confirm" method="post" id="form"><input
	type="text" name="goodsinfo" id="goodsinfo"></form>
</div>
<script type="text/javascript"
	src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript"
	src="./static/public/jsorder/js/jsorder.js"></script>
<script type="text/javascript" src="./static/public/layer/layer.min.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function () {
	$(".express").bind("change", express);
	$(".nj").bind("change", nj);
	$(".ps").bind("change", ps);
	$(".mj").bind("change", mj);
	$(".mg").bind("change", mg);
	$(".cfk").bind("change", cfk);
	$(".dg").bind("change",dg);

})

function express() {

	if (this.value == "加急") {

		var a = $.layer({
				shade : [0],
				area : ['auto', 'auto'],
				dialog : {
					msg : '选择加急后，订单一经提交，不得修改!',
					btns : 2,
					type : 4,
					btn : ['确认', '取消'],
					yes : function () {
						layer.close(a);
					},
					no : function () {
						$("#express").removeAttr("checked");
						$("#normal").prop("checked", true)
					}
				}
			});

	};
}

function nj() {
	var id = this.title;
	var width = $("#njwidth" + id).val();
	var length = $("#njlength" + id).val();
	var set = $("#njset" + id).val();
	if (width > 6 || length > 6) {

		alert("超过了范围，最大长度为6米");
		return false;
	}
	if (set < 1) {

		alert("1套起订");
		return false;
	}

	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	var biankuan = new Array();
	biankuan[516] = 0.164; //博古
	biankuan[521] = 0.0302; //古典雕花红
	biankuan[526] = 0.0302; //古典雕花白木
	biankuan[35564]=0.0302;//玲珑雕花 红木
	biankuan[35565]=0.0302;//玲珑雕花 柏木
	biankuan[531] = 0.166; //博爵红
	biankuan[536] = 0.166; //博爵白
	wc = biankuan[id];
	if (wc == undefined) {
		wc = 0;
	}
	if (length > 0 && width > 0 && set > 0) {
		$("#price" + id).val(price);
		//存储
		var picture = module + "宽" + width + "m,长" + length + "m," + set + "套";
		var njvalue = Math.round((parseFloat(width) + parseFloat(length) + 2 * wc) * 2 * 1000) / 1000;
		$("#goods_" + id).val(Math.round(njvalue * set*100)/100);

		snapshot(id, picture, price);
		tj(id);
	}
}
//根数 长方形计算
function mg() {
	var id = this.title;
	var width1 = $("#mglength1" + id).val();
	var width2 = $("#mglength2" + id).val();
	var nums = $("#mgnum" + id).val();
	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	if (width1 == 0 || width2 == 0) {
		bk = 0.0724;
	} else {
		bk = 0.1448;
	}

	if (nums > 0) {
		$("#price" + id).val(price);
		//存储
		var picture = width1 + "米" + nums + "根," + width2 + "米" + nums + "根";
		$("#goods_" + id).val(Math.round((parseFloat(width1) + parseFloat(width2) + bk) * nums * 10000) / 10000);

		snapshot(id, picture, price);
		tj(id);
	}
}

//单根根数
function dg() {
	var id = this.title;
	var width1 = $("#dglength1" + id).val();
	var nums = $("#dgnum" + id).val();
	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	

	if (nums > 0) {
		$("#price" + id).val(price);
		//存储
		var picture = width1 + "米" + nums + "根";
		$("#goods_" + id).val(Math.round((parseFloat(width1)) * nums * 10000) / 10000);

		snapshot(id, picture, price);
		tj(id);
	}
}

//根数 m2增加0.009米
function cfk() {
	var id = this.title;
	var width = $("#cfklength" + id).val();
	var m1 = $("#m1" + id).val();
	var m2 = $("#m2" + id).val();
	m2 = Math.round((parseFloat(m2) + 0.025) * 1000) / 1000;
	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	var d = Math.round((parseFloat(width) * 1000 + 5));

	var max = Math.round((parseFloat(width) + parseFloat(m1) + parseFloat(m2)) * 1000) / 1000;

	if (max > 3) {

		alert("总长度X不能大于3米");
		return false;
	}

	if (width > 0) {
		$("#price" + id).val(price);
		//存储
		var picture = module + "L:" + width + "米,M1:" + m1 + "米,M2:" + m2 + "米";

		$("#goods_" + id).val(max);

		snapshot(id, picture, price);
		tj(id);
	}
}

function ps() {
	var id = this.title;
	var width = $("#njwidth" + id).val();
	var length = $("#njlength" + id).val();
	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	if (length > 0 && width > 0) {
		var price = (parseFloat(width) * parseFloat(length)) * price;
		price = Math.round(price);

		$("#price" + id).val(price);
		//存储
		var picture = module + "宽为" + width + "片,高为" + length + "片";
		snapshot(id, picture, price);
		tj(id);
	}
}

function mj() {
	var id = this.title;
	var width = $("#njwidth" + id).val();
	var length = $("#njlength" + id).val();
	var module = $("#module" + id).val();
	var price = $("#unit" + id).val();
	var kuang = module == "无框" ? 0 : 0.1;
	if (length > 0 && width > 0) {
		var price = ((parseFloat(width) + kuang) * (parseFloat(length) + kuang)) * price;
		price = Math.round(price);
		$("#price" + id).val(price);
		//存储
		var picture = module + "宽为" + width + "m,高为" + length + "m";
		snapshot(id, picture, price);
		tj(id);
	}
}

function checkempty() {
	var a = $(".nj");
	var b = (".ps");
	var c = (".mj");
	var flag = true;

	$(a).each(function () {
		if (this.value == "") {
			flag = false;
			return false;
		}
	})
	$(b).each(function () {
		if (this.value == "") {
			flag = false;
			return false;
		}
	})
	$(c).each(function () {
		if (this.value == "") {
			flag = false;
			return false;
		}
	})
	return flag;

}

function sub() {

	if (checkempty() == false) {

		layer.alert("请输入尺寸", 8);
		return;

	}

	var lg = $("input[name='longgu']:checked").val();
	if (lg == undefined) {
		layer.alert("请选择龙骨", 8);
		return;
	}

	
	var express = $("input:radio[name='express']:checked").val();
	if (express ==undefined) {
		layer.alert("请选择是否参加活动", 8);
		return;
	}else{
		
		lg=lg+"  "+express;
	}
	
	/*
	if (!confirm("当天满3000元即可审核，确认提交?")) {
		return false;
	}
	*/
	var remark = $("input[name='remark']").val();

	
	remark = remark + lg;
	$.post('./index.php?buyorder/add', {
		remark : remark
	}, function (data) {
		if (data.status == true) {
			layer.alert('提交成功！', 9, function () {
				location.href='./index.php?buyorder/order';
			});

		} else {
			layer.alert(data.message, 8);
		}
	}, "json")
}

function mx(sku) {
	$.layer({
		type : 2,
		shadeClose : true,
		title : false,
		closeBtn : [0, true],
		shade : [0.3, '#000'],
		border : [0],
		offset : ['20px', ''],
		area : ['700px', ($(window).height() - 50) + 'px'],
		iframe : {
			src : './index.php?buy/mx/?sku=' + sku,
			scrolling : 'yes'
		}
	})

}

function addCart(id) {

	var h = "<a href='javascript:void(0)' class='label label-warning'>已经添加</a>";
	$("#cart" + id).html(h);
}

//jsorder配置
$.fn.jsorder.defaults = {
	staticname : 'jsorder',
	jsorderclass : 'jsorder',
	savecookie : true,
	cookiename : 'buy',
	numpre : 'no_',
	jsorderpre : 'jsorder_',
	jsorderspanpre : 'jsorderspan_',
	pricefiled : 'price',
	namefiled : 'jsordername',
	leftdemo : '购物车',
	subbuttom : 'cart',
	//addbuttom : 'a.jsorderadd',
	addbuttom : 'a.jsorderadd',
	nomessage : '你今天的包裹是还空的',
	dosubmit : function (data) {
		$("#goodsinfo").val(JSON.stringify(data));
		$("#form").submit();
	}
};
$("body").jsorder();

function del(id) {
	parseCookie(id);
	$("#s" + id).remove();
	tj(0);
}

function tj(id) {

	var total = 0;
	var i = 0;
	var num = new Array();
	var leixing = "";
	var prices = new Array();

	if (id != 0) {
		if (event.which == 8) {
			return;
		}
	}

	$('input').each(function () {

		if ($(this).attr("class") != leixing) {
			leixing = $(this).attr("class");

		}

		if (leixing == "num") {
			num.push($(this).val());
		}

		if (leixing == "prices") {
			prices.push($(this).val());
		}
	});

	for (var j = 0; j < num.length; j++) {
		total += num[j] * prices[j];
	}
	$("#totalcount").html(Math.round(total * 100) / 100);
	//更新项目
	var a = parseFloat($("#goods_" + id).val());
	parseNum(id, a);
}

function isNumber(s) {
	var regu = "^[0-9]+$";
	var re = new RegExp(regu);
	if (s.search(re) !=  - 1) {
		return true;
	} else {
		return false;
	}
}

//初始化购物车
function snapshot(id, snapshot, price) {
	var data = JSON.parse($.cookie("buy"));
	data[id]['snapshot'] = snapshot;
	data[id]['price'] = price;
	var date = new Date();
	date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
	$.cookie("buy", JSON.stringify(data), {
		path : '/',
		expires : date
	});
}

function parseCookie(id) {
	var data = JSON.parse($.cookie("buy"));
	delete data[id];
	var date = new Date();
	date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
	$.cookie("buy", JSON.stringify(data), {
		path : '/',
		expires : date
	});
}

function parseNum(id, num) {
	var data = JSON.parse($.cookie("buy"));
	data[id]['count'] = num;
	var date = new Date();
	date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
	$.cookie("buy", JSON.stringify(data), {
		path : '/',
		expires : date
	});
	console.log($.cookie("buy"));

}


</script>
{/literal}

