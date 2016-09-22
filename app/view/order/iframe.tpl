{include file="product/header.tpl"}
{literal}
<style type="text/css">
.badge{webkit-border-radius: 0px;
-moz-border-radius: 0px;
border-radius: 0px;}
.keyword:hover{color:#E33B3B;}
.label-important, .badge-important, .label-important[href], .badge-important[href] {
background: #fff;
color: #666 !important;
border: 1px solid #ccc;
font-weight:400;
}
.input-append{display: inline-block;
border: 2px solid #E33B3B;
height: 34px;}
.searchbar{margin-top: 5px;}
.search input[name="title"]{
    background:no-repeat 0 0 scroll ＃EEEEEE;
    border:none;
    outline:medium;
}
.ztree li a.curSelectedNode {
padding-top: 0px;
background-color: #E33B3B;
color: #fff;
height: 17px;
line-height: 17px;
text-align: center;
padding: 0 6px 1px;

border:none;
opacity: 1;



}
.ztree li span {
font: 14px/150% Arial,Verdana,"\5b8b\4f53";
}
#iframe{width:100%;overflow-y:none;}

*html{background-image:url(about:blank);background-attachment:fixed;}/*解决IE6下滚动抖动的问题*/
#code,#code_hover,#gotop{width:25px;height:94px;background:url(/static/d_shang/images/ds_buy_icon.png) no-repeat;position:fixed;left:14.4%;cursor:pointer;_position:absolute;_bottom:auto;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));}
#code{background-position:-276px -202px;bottom:120px;_margin-bottom:120px;}
#code_hover{background-position:-316px -202px;bottom:120px;_margin-bottom:120px;}
#gotop{background-position:-311px -129px;bottom:67px;_margin-bottom:67px;line-height:18px;color: #666;padding-left:5px;} 
#gotop:hover{background-position:-276px -129px;text-decoration: none;color: #F82800;}
#gotop b{background:url(/static/d_shang/images/ds_buy_icon.png) no-repeat;background-position:-301px -55px;width: 17px;height: 16px;display: block;}
#code_img{width:270px;height:355px;background:url(/static/d_shang/images/ds_buy_icon.png) -4px -3px no-repeat;position:fixed;left:18%;bottom:67px;cursor:pointer;display:none;_position:absolute;_bottom:auto;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));_margin-bottom:67px;}
</style>
{/literal}

<body id="buy-main-body" >
	<div style="overflow: hidden; width: 100%;">
		<!-- 头部// -->
		{include file="product/top.tpl"}
	</div>
	<!-- start: Content -->
	<div id="content" class="" style="padding: 0px; top: 0px;">
		<div class="row-fluid">
			<div id="buy-main-body-con" class="box" style="margin: 0px;">
				<!-- Default panel contents -->
				<div class="pull-left float: left;"	style="width: 16%; margin-left: 5px; height:800px; background: #f5f5f5;">
					<div style="padding:20px;font-size:12px;">
					
					<ul>
				   <li><a href="javascript:setUrl('./index.php?order/shop');" style="font-size:16px;color:#f40;">首页</a></li>
					
					<li><a href="javascript:setUrl('./index.php?order/find/?title=展架');">展架</a></li>
					{foreach from=$recommend item=l}
					<li><a href="javascript:setUrl('./index.php?order/find/?title={$l.goods_name}');">{$l.goods_name}</a></li>
					{/foreach}
					</ul>
					</div>
				</div>
				
				
				
				
				<div class="" style="width: 83%; float: right;">
				
					<div class="searchbar" style="margin-right: 2%;line-height: 40px; width: 98%; overflow: hidden;">
						<div class="input-append" style="display:inline-block;">
						
				<input type="text" name="title" id="goods_name" placeholder="请输入产品简称" class="input-xlarge" style="outline:medium">
							<button type="button" class="btn btn-danger" onclick="search()" style="border-radius: 0px;background:#E33B3B;">搜索</button>
						</div> 
						
						 						 				最近访问：
					{foreach from=$vistor item=l}
					 {$l.username}
					{/foreach}
						 <div class="pull-right" style="font-size:12px;">
						 		<a href="javascript:setUrl('./index.php?order/cart')" class="btn btn-danger">去购物车结算</a>
						 
						 </div>
					</div>
				
					
					<iframe src="./index.php?order/shop" id="iframe" style="min-height:2000px;" scrolling="no"></iframe>
					
				</div>
			</div>
		</div>
	</div>
	<div style="display: none">
		<form action="./index.php?buy/cart" method="get" id="form"><input type="text" name="goodsinfo" id="goodsinfo"></form>
	</div>
	<div class="totop">
		<!--
		<div id="code"></div>
		<div id="code_img"></div>
		-->
		<a id="gotop" href="javascript:void(0)" style="width:20px;"><b></b>返回顶部</a>
	</div>
</body>

<script src="./static/public/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript" src="./static/public/jsorder/js/jsorder.js"></script>
<script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
	
{literal}
<script type="text/javascript"> 
function SetWinHeight(obj) 
{ 
var win=obj; 
if (document.getElementById) 
{ 
if (win && !window.opera) 
{ 
if (win.contentDocument && win.contentDocument.body.offsetHeight) 
win.height = win.contentDocument.body.offsetHeight; 
else if(win.Document && win.Document.body.scrollHeight) 
win.height = win.Document.body.scrollHeight; 
} 
} 
} 

function setkeyword(){

	
}

function setUrl(url){
	$("#iframe").attr("src",url);	
}



//jsorder配置
$.fn.jsorder.defaults = {
	staticname : 'jsorder',
	jsorderclass : 'jsorder',
	savecookie : true,
	cookiename : 'jsorder',
	numpre : 'no_',
	jsorderpre : 'jsorder_',
	jsorderspanpre : 'jsorderspan_',
	pricefiled : 'price',
	namefiled : 'jsordername',
	leftdemo : '购物车',
	subbuttom : '', 
	//addbuttom : 'a.jsorderadd', 
	addbuttom : 'a.jsorderadd', 
	nomessage : '你今天的包裹是还空的',
	dosubmit : function(data) {
}
};
$("body").jsorder();



$(document).ready(function(){
	  $("input[name='title']").keyup(function(event){
          if(event.which==13){
               search();
          }
		  })
	})


function search(){
	 var value=$("input[name='title']").val();
     if(value.length<1){
    layer.alert("搜索内容不能为空哦",8);
  
      }else{
 		 $("#iframe").attr("src", "./index.php?order/find/?title="+value);

          }
	 
	}

function b(){
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('#gotop').show();
	}else{
		$('#gotop').hide();
	}
}

$(document).ready(function(e) {
	
	b();
	
	$('#gotop').click(function(){
		$(document).scrollTop(0);	
	});
	
	$('#code').hover(function(){
		$(this).attr('id','code_hover');
		$('#code_img').show();
	},function(){
		$(this).attr('id','code');
		$('#code_img').hide();
	})

});

$(window).scroll(function(e){
	b();		
});

</script>
{/literal} 
{include file="news/footer.tpl"}
