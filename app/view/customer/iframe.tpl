{include file="buy/header.tpl"}
<body id="buy-main-body" style="overflow-y: hidden;">
	<link href="./static/public/jsorder/css/order.css" rel="stylesheet" />
	<div style="overflow: hidden; width: 100%;">
		<!-- 头部// -->
		{include file="customer/top.tpl"}</div>
		<!-- start: Content -->
		<div id="content" class="" style="padding: 0px; top: 0px;">
			<div class="row-fluid">
				<div id="buy-main-body-con" class="box" style="margin: 0px;">
				<!-- Default panel contents -->
					
					<div class="" style="width: 100%; float: right; height: 100%;">
						
						<iframe src="./index.php?customer/create" id="iframe" width="100%" height="100%;"></iframe>
					</div>
				</div>
			</div>
		</div>
		<div style="display: none">
			<form action="./index.php?buy/cart" method="get" id="form"><input type="text" name="goodsinfo" id="goodsinfo"></form>
		</div>
</body>
<script type="text/javascript"
	src="./static/public/jsorder/js/cookie.js"></script>
<script type="text/javascript"
	src="./static/public/jsorder/js/jsorder.js"></script>
	 <script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
	
{literal}
<script type="text/javascript"> 
	var winWidth = 0; 
	var winHeight = 0;  
	function findDimensions() //函数：获取尺寸 
	{  
		//获取窗口宽度  
		if (window.innerWidth)
			winWidth = window.innerWidth;  
			else if ((document.body) && (document.body.clientWidth)) 
			winWidth = document.body.clientWidth; 
			//获取窗口高度  
		if (window.innerHeight)  
			winHeight = window.innerHeight;  
		else if ((document.body) && (document.body.clientHeight)) 
			winHeight = document.body.clientHeight;  
			//通过深入Document内部对body进行检测，获取窗口大小  
  if (document.documentElement  && document.documentElement.clientHeight && document.documentElement.clientWidth) 
  {
	winHeight = document.documentElement.clientHeight; 
	winWidth = document.documentElement.clientWidth; 
	}  
	//结果输出到指定ID
	document.getElementById("buy-main-body").style.width= winWidth+"px";//赋值宽度值
	document.getElementById("buy-main-body").style.height= winHeight+"px"; //赋值高度值
	document.getElementById("buy-main-body-con").style.height= winHeight-45+"px"; //赋值高度值
	document.getElementById("iframe").style.height= winHeight-45+"px"; //赋值高度值
  }  
  findDimensions(); 
  //调用函数，获取数值  
  window.onresize=findDimensions;  

function setUrl(url,obj){
	$("li").each(function(){
		$(this).removeClass("active");
		})
	$(obj).addClass("active");
	$("#iframe").attr("src",url);	
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
		  $.fn.zTree.init($("#treeDemo"), setting, zNodes);

	})
var zTree;
var setting = {
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "fid",
			rootPId: ""
		},
	},
	callback:{
		onClick: zTreeOnClick
	},
	view:{
     showIcon:false
	},
};
var zNodes ={/literal}{$category}{literal};
      		
 function zTreeOnClick(event, treeId, treeNode) {

	 $("#iframe").attr("src","./index.php?buy/goods/?cid="+treeNode.id);
 }


function search(){
	 var value=$("input[name='title']").val();
     if(value.length<1){
    layer.alert("搜索内容不能为空哦",8);
  
      }else{
 		 $("#iframe").attr("src", "./index.php?buy/search/?title="+value);

          }
	 
	}

</script>
{/literal} {include file="news/footer.tpl"}
