{include file="buy/header.tpl"}
{literal}
<style>
.btn-default{font-size:13px;border-radius:2px;padding:1px 9px;background-color:#F7F7F7;}

body{min-height:820px;}
.table th{background:#f5f5f5;}
.table td{text-align:left;}
.star{width: 75px;
height: 15px;
background: url(./static/bootstrap2/img/jd.png) no-repeat 0px -86px;
float: left;}
.suoding{height:30px;}
.imgbox{position:relative;width:220px;height:325px;padding:2px;float:left;text-align:left;border:1px #f1f1f1 solid;background:#fff;margin-left:10px;margin-top:10px;}
.imgbox:hover{box-shadow: 0 0 5px #666;}
.price{
	font-family: verdana;
font-size: 14px;
color: #B1191A;
font-weight:700;
}
.party{position: absolute;
top: 192px;
width: 210px;
background-color: #f40;
font-weight: 700;
height: 20px;
padding: 5px;
color: #fff;}
.view{color:#005aa0;padding-top:5px;}
.goods_name{height:45px;width:100%;font-size: 13px;}
.attribute{line-height:25px;height:30px;}
.imgbox .img{min-height:220px;}
.imgbox .type{top: 5px;right: 0px;font-size: 13px;color:#666;}
.remark{color:red;font-weight:700;}
.market_price{text-decoration:line-through;font-family: verdana;
font-size: 12px;}
</style>
{/literal}
<body onload="loading()">
	<link href="./static/public/jsorder/css/order.css" rel="stylesheet" />
	<div id="loading"></div>  


<!-- 头部// -->


	<!-- start: Content -->
			<div id="content" class="" style="display:none;padding:0px;top:0px;background:#fff">
			
						
			<div class="row-fluid">


<div class="box" style="maring-left:50px;">




<div class="box" >

{foreach from=$goods item=l name=g}

<div class="imgbox">
<div class="img">
<a href="javascript:mx('{$l.sku}')">
 {if $l.image==""}
 <img src="./static/attached/face/noimage1.jpg">
 {else}
 <img src="{$l.image}">{/if}</a>
 </div>
<div class="goods_name">
{if $user.manager==1}
<a href="javascript:edit({$l.id})"><i class="icon-edit"></i></a>
{/if}

<a href="javascript:mx('{$l.sku}')">{$l.goods_name}</a>


 <div class="type">{$l.type}
 {if $l.party!=""}
<div class="party">{$l.party} </div> 
{/if}
<span class="pull-right" title="近30天销量">{$l.sales}{$l.unit}</span>
</div>

</div>
<div class="attribute">
<span class="price">¥{$l.price}</span> <span class="market_price"></span> <span class="pull-right view" title="推荐指数{$l.view}"><i class="star"></i></span>
</div>


<div  id="cart{$l.id}" style="text-align:center;">
{if $l.status<0}
<span class="label label-default">{$l.flag}</span>

{else}
{if $l.buy==1}
<a href="javascript:void(0)" class="label label-important">已经添加</a>
{else}
<a href="javascript:addCart({$l.id})" id="{$l.id}" jsordername="{$l.goods_name}" price="{$l.price*$l.num}"  class="btn btn-default jsorderadd">加入购物车</a></td>
{/if}
{/if}

</div>
</div>
{/foreach}
</div>


<div class="pagination pagination-centered">
<ul id="pager"></ul>
</div>

</div>

</div>
<div style="display:none">
<form action="/index.php?order/confirm" method="post" id="form">
<input  type="text" name="goodsinfo" id="goodsinfo">
</form>
</div>

</body>
</html>
<script type="text/javascript" src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript" src="./static/public/jsorder/js/jsorder.js"></script>
 <script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
  <script  type="text/javascript" src="./static/public/layer/extend/layer.ext.js" ></script>
 
{literal}
<script type="text/javascript">
function loading(){
$("#loading").hide();
$("#content").show();
}

function mx(sku){


   if(sku==""){
    alert("没有宝贝详情页");
    return false;
	 }
	location.href='./index.php?buy/mx/?sku='+sku+'#content';

}

function upload(sku){	
	
   var con="非常棒的产品,推荐使用";
   //多行文本
  var a= layer.prompt({title: '感谢你的点评',type: 3,val:con}, function(val){
	    if(val.length==""){
            alert("信息不能为空");
            return false;
		}
		$.post("./index.php?buydig/dig",{sku:sku,comment:val},function(data){
			
    alert(data.message);
    if((data.status)){
      layer.close(a);
        }
			},"json")
	});



}

function edit(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.3, '#000'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['850px', '800px'],
	    iframe: {src: './index.php?buy/edit/?id='+id,
	        scrolling: 'yes'
	      }
	}) 

}

function scene(sku){

	//此处为异步请求模式，具体的json格式，请等待文档更新。或者你直接通过请求看photos.json
	var conf = {};
	$.getJSON('./index.php?buy/scene/?', {sku:sku}, function(json){
	    conf.photoJSON = json; //保存json，以便下次直接读取内存数据
	    layer.photos({
	        html: '',
	        json: json
	    });
	});
	      
	
}

function addCart(id){

	var h="<a href='javascript:void(0)' class='label label-important'>已经添加</a>";
	$("#cart"+id).html(h);
}

var options = {
		currentPage: {/literal}{$num.current}{literal},
		totalPages: {/literal}{$num.page}{literal},
		numberOfPages:5,
		bootstrapMajorVersion:3,
		pageUrl: function(type, page, current){
		    return './index.php?buy/goods/?&cid={/literal}{$cate.id}{literal}&p='+page+'#content';
		}
		}
		$('#pager').bootstrapPaginator(options);

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
$("body").jsorder();</script>
{/literal}

