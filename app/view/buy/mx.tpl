{include file="buy/header.tpl"}
	<link  rel="stylesheet" href="./static/mmz/mmz.css" />

{literal}
<style>
#content {top: 0px;padding: 5px;}
.table th{background:#f0f0f0;}
.table td{text-align:left;}
.suoding{height:30px;}
.commentimg {max-width: 100%;max-height: 100%;}
#profile a{padding: 5px 0px;
border-bottom: 1px dotted #ccc;
margin-bottom: 5px;
display: block;
text-align: center;}
.base{margin-bottom:10px;height: 370px;}
.imgbox{border:1px #ccc solid;width:300px;padding:5px;float:left;margin-right:50px;}
.info{text-align:left;width:550px;line-height:30px;float:left;
color: #666;
}
.nav-tabs .active a {
border-color: #e4393c;
color: #e4393c;
}
.avatar-big {
margin: -13px 10px -14px 10px;
height: 60px;
width: 60px;
-webkit-border-radius: 50em;
-moz-border-radius: 50em;
border-radius: 50em;
}
.info .price{color: #e4393c;font-size: 18px;font-weight:700;}
.info .selected{display: inline-block;line-height: 20px;border:1px #ccc solid;padding:2px;color: #666;font-size: 13px;position: relative;top:0px;left:0px;padding:1px 5px;margin: 0 4px;text-decoration: none;}
.info .selected:hover{border: 2px solid #e4393c;}

.info .title{font-size:12px;color:#666;}
.info .checked{border: 2px solid #e4393c;}
.info .checked i{position: absolute;width: 10px;height: 10px;font-size: 0;line-height: 0;right: 0px;bottom: 0px;background: url(/static/d_shang/images/icon/sys_item_selected.gif) no-repeat right bottom;}
.info .desc{
	border: 1px solid #ddd;
height: 43px;
font-size: 12px;
padding-left: 10px;
color: #666;
width: 150px;
line-height: 16px;
margin-left:160px;
margin-top:15px;
}
.value{font: 12px/150% Arial,Verdana,"\5b8b\4f53";
color: #666;}
.info .proname{padding-bottom: 10px;
border-bottom: 1px dotted #ccc;
zoom: 1;
font: 700 16px/1.5em Arial,Verdana,"microsoft yahei"
}
.info .proname strong{
font-family: arial,"microsoft yahei";
color: #e3393c;
font-size: 14px;
line-height: 20px;
word-break: break-all;
font-weight: 400;
}
.market_price{text-decoration:line-through;font-family: verdana;}
.desc span{color:#e4393c;font-weight:700;}
.commentimg{width:400px;border:1px #ccc solid;padding:5px;}
.kuanshi{border-top:1px dotted #ccc;padding-top: 5px;}
.history td{height:60px;}
.service{line-height:20px;padding-left:10px}
.nav-tabs{border-bottom: 1px solid #ddd;
position: relative;
height: 30px;
line-height: 30px;
margin-top: 4px;
border-right: 1px solid #DEDFDE;
border-bottom: 1px solid #DEDFDE;
border-left: 1px solid #DEDFDE;
border-top: 2px solid #999;
background-color: #F7F7F7;
overflow: visible;}
.goumai{background: url(/static/bootstrap2/img/p-btns-20140611.png) 5px 5px no-repeat;
width: 150px;
height: 50px;
display: inline-block;
margin-right:10px;}
.goumai:hover{
	background: url(/static/bootstrap2/img/p-btns-20140611.png) -152px 5px no-repeat;
}
.nums{display: inline-block;
height: 16px;
line-height: 16px;
_line-height: 17px;
padding-left: 16px;
padding-right: 2px;
color:#fff;
overflow: hidden;
background-color: #6a77b6;
}
.star{
	width: 75px;
height: 15px;
background: url(./static/bootstrap2/img/jd.png) no-repeat 0px -86px;
float: left;
}
.support{background: url(./static/bootstrap2/img/xtb.png) no-repeat -360px -145px;
width: 20px;
height: 20px;
display: inline-block;
}
.sellpoint{width:100%;height:40px;
border: 1px solid #ddd;
border-top: 2px solid #999;padding:10px;}
.maidian{
float: left;
height: 21px;
line-height: 21px;
padding: 0 7px;
margin-bottom: 3px;
margin-right: 5px;
background: #fdedd2;	
}
.liwu{background: url(./static/bootstrap2/img/jd.png) 2px -46px no-repeat;
width: 20px;
height: 20px;
display: inline-block;}
.share{
background: url(./static/bootstrap2/img/xtb.png) -390px -46px no-repeat;
width: 20px;
height: 20px;
display: inline-block;
	
}
.temai{
	margin-top: 5px;
display: block;
text-align: center;
width: 500px;
color: #fff;
height: 30px;
background:#e32c30;
}
.temai em{font-style:normal;font-size:16px;font-weight:700;}
.temai small{color:#fc0;
border-bottom: none;}
</style>

{/literal}

<!-- 头部// -->


	<!-- start: Content -->
			<div id="content" class="">
			
						
			<div class="row-fluid">
<ul class="breadcrumb">
  <li><a href="/index.php?buy/center">产品库</a> <span class="divider">/</span></li>
    <li><a href="/index.php?buy/goods/?cid={$goods.info.cid}">{$goods.info.cate}</a> <span class="divider">/</span></li>
  
  <li class="active"><a href="javascript:history.go(-1)">返回</a></li>
</ul>
<div class="box"><!-- Default panel contents -->



<div class="base">
<div class="imgbox">
<div id="preview" class="">
			    <div class="jqzoom cpxx_tl">
<img src="{if $goods.base.image!=""}{$goods.base.image}{else}./static/attached/face/noimage1.jpg{/if}" width="350px" height="350px;">

</div>

</div>
<span class="title">商品编号：</span> <span class="value"> {$goods.info.sku}</span>
<span class="title"><a href="./index.php?customer/article/?id={$goods.desc.nid}" class="pull-right">扫一扫 <i class="share"></i></a></span>
</div>


<div class="info">

<div class="proname">{$goods.info.goods_name}<br>
{if $goods.info.recommend==1}
<!-- 
<img src="./static/d_shang_new/images/img/DS_shuang11_adv.jpg" title="">
 -->
{/if}
<!--




<strong>{$goods.info.remark}</strong>
-->
</div>

{if $goods.base.tm==true}
<!-- 
<span class="temai"><em>活动达人特享</em>&nbsp;&nbsp;此产品参加买一送一活动  <small>{$goods.base.tmsj|date_format:"%Y-%m-%d %H:%M"}</small></span>
 -->
{/if}
<span class="title">价　　格：</span><span class="price"> ￥{$goods.info.price}</span>{if $goods.info.discount<1}<span class="label label-important">1件立省{$goods.info.money}元</span>{/if}{if $goods.info.party!=""}<span class="label label-warning">此产品参加{$goods.info.party}</span>{/if}  &nbsp; &nbsp; &nbsp; &nbsp;市场价 <span class="market_price"> ￥{$goods.info.price*4.5}</span><br>


<span class="title" id="mmz">温馨提示：</span><span class="value">{$goods.info.type}</span><br>

<span class="title">数　　量：</span><span class="nums"> {$goods.info.num}{$goods.info.unit} /件</span> &nbsp; &nbsp;(库存数量<small>{$goods.base.stock}</small>{$goods.info.unit},总销量 <small>{$goods.info.sales_total}</small>{$goods.info.unit})<br>
<span class="title">规　　格：</span><span class="value">{$goods.info.cate}</span><br>
<div class="kuanshi">
<span class="title">款　　式：</span>
{foreach from=$goods.other item=l}
{if $l.goods_id==$goods.info.id}
 <a class="selected checked" onclick="other('{$l.sku}');" href="javascript:void(0)" value="{$l.image}"><span>{$l.goods_name}</span><i></i></a>
{else}
 <a class="selected" onclick="other('{$l.sku}');" href="javascript:void(0)" value="{$l.image}"><span>{$l.goods_name}</span><i></i></a>
{/if}
{/foreach}<br>

<div  id="cart{$goods.info.id}" style="margin-top:15px;float:left;">
{if $goods.info.status>=0}
{if $goods.info.buy==true}
<a href="javascript:void(0)" class="label label-important">已经添加</a>
{else}
<a href="javascript:addCart({$goods.info.id})" id="{$goods.info.id}" jsordername="{$goods.info.goods_name}" price="{$goods.info.price*$goods.info.num}"  class="goumai jsorderadd"></a></td>
{/if}
{else}
<span class="label label-default">无货</span>

{/if}

</div>
<div class="desc">
<i class="liwu"></i>晒卖点活动<br>
<span>送30积分,上不封顶哦</span>
</div>
</div>
</div>


</div>

<div class="sellpoint">
<span style="margin-right:20px;float:left;">产品卖点:</span>

</div>



<ul class="nav nav-tabs" id="myTab"> 
      <li class="active"><a href="#desc">宝贝描述</a></li> 

      <li><a href="#profile">实拍出样</a></li> 
    <li><a href="#history">商品评价</a></li> 
    </ul>
    
    
<div class="tab-content"> 

<div class="tab-pane active" id="desc" style="text-align: center;">

{$goods.desc.content}

</div>



 <div class="tab-pane" id="profile">
 
{foreach from=$goods.comment item=l}
<div style="background:#fafafa;color:#666">由  <span style="color:red">{$l.username}</span> [{$l.area}] <small>{$l.date|wtime}</small> 上传</div>
<img src="{$l.image}" width="400px;">
{/foreach}

</div>

 <div class="tab-pane" id="history">
 <table class="table history">
 <tr><th>评价心得</th><th>满意度</th><th>评论者</th></tr>


 </table>

</div>



</div>

 


<input type="hidden" id="sku" value="{$goods.info.sku}">
</div>

</div>
<script type="text/javascript" src="./static/mmz/highcharts.js"></script>
<script type="text/javascript" src="./static/mmz/mmz.js"></script>

<script type="text/javascript" src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript" src="./static/public/jsorder/js/jsorder.js"></script>
<script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>
  
{literal}
<script>
function other(sku){
location.href='./index.php?buy/mx/?sku='+sku;
	 
}

function good(id){
var now=$("#"+id).html();
num=parseInt(now)+1;
$.post("./index.php?buydig/flower",{id:id},function(data){

   alert(data.message);
   if(data.status){
   $("#"+id).html(num);
    }
	},"json")

	
}

function delsrc(){
  $("#profile a").each(function(){
	  $(this).attr("href","javascript:void(0)");
	 })
	
}
      $(function () { 
    $('#myTab a:first').tab('show'); // Select first tab 
        $('#myTab a').click(function (e) { 
            
          e.preventDefault();//阻止a链接的跳转行为 
          $(this).tab('show');//显示当前选中的链接及关联的content 
        }) 
      }) 
      function addCart(id){

  		var h="<a href='javascript:void(0)' class='label label-important'>已经添加</a>";
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
       </script>
      {/literal}