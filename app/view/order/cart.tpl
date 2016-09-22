{include file="news/header.tpl"}
<link href="./static/public/jsorder/css/order.css" rel="stylesheet" />

{literal}
<style>

.table{font-size:12px;}

.table th{background:#f0f0f0;}
.table td{text-align:left;}
.suoding{height:30px;}
.nj{width:60px;}
.num{width:60px;}
.ps{width:60px;}
.mj{width:60px;}
.box{border-radius: 0px;}
.box-content{border: 1px #ccc solid;}
.box-content .title{font-size: 15px;
padding: 2px;
font-weight: 700;}
.shr{line-height: 25px;
padding: 10px;color:#666}
.goodslist{padding:10px;}
.info{background: #f1f1f1;
font-size: 16px;
font-weight: 700;
padding: 10px;}
.table input{height: 16px;}
.price{font-weight:700}
.add-on, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], input[type="file"], .uneditable-input{border-color: #ccc !important;
color: #000;
border-radius: 0px;height:16px;font-size:12px}
.table th{font-weight:400;}
</style>
{/literal}

<!-- 头部// -->


	<!-- start: Content -->
			<div>
			
						
			<div class="row-fluid">


<div class="box"><!-- Default panel contents -->
<div class="info">核对订单信息</div>

<div class="box box-content">
<div class="title">商品清单</div>
<div class="goodslist">
<table class="table table-hover" style="text-align:center;">
<tr class=""><th class="span3">产品名称</th><th class="span2">单价</th><th class="span4">尺寸规格</th><th class="span2">一件数量</th><th class="span2">购买数量</th><th class="span2">操作</th></tr>
{if $goods!=""}
{foreach from=$goods item=l name=g}

<tr id="s{$l.id}">
<td>
{$l.goods_name}
</td>
<td><span class="price">{$l.price*100}积分</span></td>
<td>{$l.type}
{if $l.remark!=""}
{$l.remark}
{/if}

</td>
<td>{$l.num}{$l.unit}</td>
<td>
<input type="hidden" name="id[]" value="{$l.id}">
<input type="text"  name="num[]"  id="goods_{$l.id}" class="num" onKeyup="tj({$l.id})" value="{$l.count}" >
 <input type="hidden" name="prices[]"  value="{$l.price*100*$l.num}" class="prices">
                                    </td>

<td id="cart{$l.id}">
<a href="javascript:del({$l.id})" class="">移除</a>
</tr>

{/foreach}
{/if}
</table>
</div>
</div>
<a href="javascript:history.go(-1)" class="btn ">返回继续购物</a>

<b>备注</b> <input type="text" name="remark" class="input-xxlarge" value="" placeholder="特殊说明"> 
     <b>总额</b> <span  id="totalcount" style="font-family:Verdana;color:red;font-size:16px;">{$totalcount*100}</span> 积分
      <input type="radio" class="express" id="normal" value="随货" name="express" checked>随货
      <a href="javascript:sub()" class="btn btn-danger pull-right">提交订单</a>
</div>
</div>

</div>
<div style="display:none">
<form action="/index.php?order/confirm" method="post" id="form">
<input  type="text" name="goodsinfo" id="goodsinfo">
</form>
</div>
<script type="text/javascript" src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript" src="./static/public/jsorder/js/jsorder.js"></script>
 <script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
 $(".express").bind("change",express);  
})

function express(){

	if(this.value=="快递"){

	var a=	$.layer({
		    shade: [0],
		    area: ['auto','auto'],
		    dialog: {
		        msg: '选择快递后，订单一经提交，不得修改!',
		        btns: 2,                    
		        type: 4,
		        btn: ['确认','取消'],
		    yes: function(){
		    	 layer.close(a);
	        }, no: function(){
	           $("#express").removeAttr("checked");
	           $("#normal").prop("checked",true)
	        }
		    }
		});
		
    };
}



function sub(){
	
   if(!confirm("确认提交?")){
     return false;
	}
  var express=$("input:radio[name='express']:checked").val();
	var remark=$("input[name='remark']").val();
	  if(express=="快递"){
		     remark=remark+" 发快递";
			}
	$.post('./index.php?order/add',{remark:remark},function(data){
     if(data.status==true){
       alert(data.message);
    	   location.href="./index.php?order/shop";
         
      
      }else{
      alert(data.message,8);
       }
	},"json")
}

function mx(sku){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.3, '#000'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', ($(window).height() - 50) +'px'],
	    iframe: {src: './index.php?buy/mx/?sku='+sku,
	        scrolling: 'yes'
	      }
	}) 

}

function addCart(id){

	var h="<a href='javascript:void(0)' class='label label-warning'>已经添加</a>";
	$("#cart"+id).html(h);
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
	dosubmit : function(data) {
$("#goodsinfo").val(JSON.stringify(data));
$("#form").submit();
}
};
$("body").jsorder();


function del(id){
	parseCookie(id);
	$("#s"+id).remove();
	tj(0);
}

function tj(id){
	
	var total=0;
	var i=0;
	var num=new Array();
	var leixing="";
	var prices=new Array();

	if(id!=0){
	if(event.which==8){	
        return;
    }
	}

	
	$('input').each(function(){

	if($(this).attr("class")!=leixing){
	leixing=$(this).attr("class");

	}

	
	

	if(leixing=="num"){
	if(!isNumber($(this).val())){
	$(this).val(1);
	alert("只能输入整数");

	return;
	}
	 num.push($(this).val());
	}

	if(leixing=="prices"){
	prices.push($(this).val());
	}
	});

	for(var j=0;j<num.length;j++){
	  total+=num[j]*prices[j];
	}
	$("#totalcount").html(total);

	var a=parseInt($("#goods_"+id).val());
	parseNum(id,a);

	}

	function isNumber( s )
	{
	    var regu = "^[0-9]+$";
	    var re = new RegExp(regu);
	    if (s.search(re) != - 1) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}

	  
	function  parseCookie(id){
	  var data=JSON.parse($.cookie("buy"));
	delete data[id];
	var date = new Date();
	date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
	$.cookie("buy", JSON.stringify(data), {
	    					path : '/',
							expires : date
						});
	}  



	function parseNum(id,num){
	    
	      var data=JSON.parse($.cookie("buy"));
	 data[id]['count']=num;
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

