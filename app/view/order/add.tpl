<link rel='stylesheet' href='../../static/news/style/style1.css'>
<link rel='stylesheet' href='../../static/news/style/extra.css'>
<link rel='stylesheet' href='../../static/news/style/sdmenu.css'>
<script charset="utf-8" src="../../static/news/style/common.js"></script>
<script charset="utf-8" src="../../static/news/style/sdmenu.js"></script>
<script src="/static/public/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="/static/public/page/jquery.pager.js" type="text/javascript"></script>
<link rel="stylesheet" href="/static/news/style/search.css">
{literal}
<style type="text/css">
.add {
	width: 70px;
	height: 25px;
	border: 1px solid #ccc
}

td {
	border-left: 1px #ccc solid;
	border-top: 1px #ccc solid;
}
</style>
<script type='text/javascript'>
// <![CDATA[
var myMenu;
window.onload = function() { myMenu = new SDMenu('my_menu'); myMenu.init(); };
// ]]>
function apt(){
   var goods_id=$("input[name='goods_id']").val();
   var qty=$("input[name='qty']").val();
   
   if(goods_id.length<3){
     alert('请填写产品id');
  return false;
     }
if(qty.length<1){
 alert('订购数量不能为空');
 return false;
	
}
   
   var sno=$("input[name='sno']").val();
   var dljg=$("input[name='dljg']").val();
   var type=$("input[name='type']:checked").val();
   $.post("/order/addgoods/",{orderno:sno,dljg:dljg,qty:qty,type:type,goods_id:goods_id},function(data){
     
    alert(data);
    window.location.reload();
   });
   
}
function remark(){
	   var goods_id=$("input[name='goods_id']").val();
	   var sno=$("input[name='sno']").val();
	   
       var remark=$("input[name='remark']").val();
       if(remark.length<3){
         alert('备注字数至少3个字符');
         return false;
       }
      
       
       
       $.post("/order/setremark/",{orderno:sno,remark:remark,goods_id:goods_id},function(data){
  	     
   	    alert(data);
   	    window.location.reload();
   	   });
	
}

function del(id){
   var a=confirm('确认删除?');
if(!a){
return false;
	
}
  $.get("/order/del/",{id:id},function(data){
      alert(data);
	   window.location.reload();
	  });
	
}

function printme()
{
document.body.innerHTML=$("#div1").html();
window.print();
}
function app(){

var a=$(".kuoz").html();
$("#title").after("<tr>"+a+"</tr>");
	
}
</script>


{/literal}


<!-- 头部// -->
{include file="news/top.tpl"}

<!-- 左侧// -->
{include file="news/nav.tpl"}
<!-- 中间// -->
<td valign="top" class="td_content"><!-- setting title/desc -->
<form name="news" action="/news/search" method="post">
<div class="block titlebox">
<div class="content"><a href="javascript:app();">增加产品</a>|<a
	href="javascript:printme()" target="_self">打印</a>

</div>
</div>

</form>
<!-- setting title/desc --> <!-- 内容// -->



<div id="div1">

<table width="100%" cellspacing=0 cellpadding=5 border=0 class=mytb>
	<tr class=title id="title">
		<th>序号</th>
		<th>产品编号</th>
		<th>产品名称</th>
		<th>订购数量</th>
		
		<th>单价</th>
		<th>计量单位</th>
		<th>总价</th>
		<th>备注</th>
	</tr>

<!-- 新增 -->
<tr class="kuoz">
		<td>新增</td>
		<td><input class="add" type="text"
			name="goods_id" disabled="disabled"></td>
			<td>
			
			
			<div class="gover_search">
<input type="text"  name="goods_name" class="input_search_key" id="gover_search_key"/>
<div class="search_suggest" id="gov_search_suggest">
<ul>
</ul>
</div>
</div>
			
			</td>
		<td><input class="add" type="text" name=qty></td>
				<td><input class="add" type="text" name="dljg" disabled="disabled"></td>
		
		<td><input class="add" name="cpdw" value="" disabled="disabled"></td>
		<td><input class="add" name="cpzj" value="" disabled="disabled"></td>
		<td><input type="text" name="remark"><input type=button onclick="apt()" class=imgbutton value="确认"></td>
		<td></td>
	</tr>
	<!-- 新增结束 -->
	{section name=l loop=$goods }
	<from action="">
	<tr>
		<td class=left width="1%" style="text-align: left;">{$smarty.section.l.iteration}</td>
		<td class=left width="3%"><a href="javascript:del({$goods[l].id})">[删除]</a>{$goods[l].goods_id}</td>
		<td class=right width="8%"><a
			href="/news/edit/?id={$goods[l].goods_id}" target="__blank">{$goods[l].goods_name}</a></td>
			<td class=left width="3%">{$goods[l].cpjs}</td>
	
		<td class=right width="3%">{$goods[l].dljg}</td>

		<td class=right width="3%">{$goods[l].qty}</td>

		<td class=left width="3%">{$goods[l].cpjs*$goods[l].qty}</td>
		<td class=right width="3%">{$goods[l].dljg_total}</td>
		<td class=left width=3%>{$goods[l].remark}</td>
	</tr>
	{/section}
</table>


<!-- help -->
<div>订单历史记录
<ul>
	{foreach from=$history item=l}
	<li>{$l.action_time|date_format:"%m-%d %H:%M"} {$l.action} {$l.remark}</li>
	{/foreach}
</ul>


<table class="kuozhan" style="display: none;">
	
</table>





{literal} <script type="text/javascript">

//实现搜索输入框的输入提示js类
function oSearchSuggest(searchFuc){
	var input = $('#gover_search_key');
	var suggestWrap = $('#gov_search_suggest');
	var key = "";
	var init = function(){
		input.bind('keyup',sendKeyWord);
		input.bind('blur',function(){setTimeout(hideSuggest,100);})
	}
	var hideSuggest = function(){
		suggestWrap.hide();
	}
	
	//发送请求，根据关键字到后台查询
	var sendKeyWord = function(event){
		
		//键盘选择下拉项
		if(suggestWrap.css('display')=='block'&&event.keyCode == 38||event.keyCode == 40){
			var current = suggestWrap.find('li.hover');
			if(event.keyCode == 38){
				if(current.length>0){
					var prevLi = current.removeClass('hover').prev();
					if(prevLi.length>0){
						prevLi.addClass('hover');
						input.val(prevLi.html());
					}
				}else{
					var last = suggestWrap.find('li:last');
					last.addClass('hover');
					input.val(last.html());
				}
				
			}else if(event.keyCode == 40){
				if(current.length>0){
					var nextLi = current.removeClass('hover').next();
					if(nextLi.length>0){
						nextLi.addClass('hover');
						input.val(nextLi.html());
					}
				}else{
					var first = suggestWrap.find('li:first');
					first.addClass('hover');
					input.val(first.html());
				}
			}
			
		//输入字符
		}else{ 
			var valText = $.trim(input.val());
			if(valText ==''||valText==key){
				return;
			}
			searchFuc(valText);
			key = valText;
		}			
		
	}
	//请求返回后，执行数据展示
	this.dataDisplay = function(data){
		if(data.length<=0){
            suggestWrap.hide();
			return;
		}
		
		//往搜索框下拉建议显示栏中添加条目并显示
		var li;
		var tmpFrag = document.createDocumentFragment();
		suggestWrap.find('ul').html('');
		for(var i=0; i<data.length; i++){
			li = document.createElement('LI');
			li.innerHTML = data[i];
			tmpFrag.appendChild(li);
		}
		suggestWrap.find('ul').append(tmpFrag);
		suggestWrap.show();
		
		//为下拉选项绑定鼠标事件
		suggestWrap.find('li').hover(function(){
				suggestWrap.find('li').removeClass('hover');
				$(this).addClass('hover');
		
			},function(){
				$(this).removeClass('hover');
		}).bind('click',function(){
			input.val(this.innerHTML);
			suggestWrap.hide();
		});
	}
	init();
};

//实例化输入提示的JS,参数为进行查询操作时要调用的函数名
var searchSuggest =  new oSearchSuggest(sendKeyWordToBack);

//这是一个模似函数，实现向后台发送ajax查询请求，并返回一个查询结果数据，传递给前台的JS,再由前台JS来展示数据。本函数由程序员进行修改实现查询的请求
//参数为一个字符串，是搜索输入框中当前的内容
function sendKeyWordToBack(keyword){
	     var obj = {
			    "keyword" : keyword
			 };

              $.post("/news/searchbykeyjson",{keyword:keyword},function(d){
			  
			 var aData = [];
						 for(var i=0;i<d.length;i++){
								//以下为根据输入返回搜索结果的模拟效果代码,实际数据由后台返回
							if(d[i]!=""){
								  aData.push(d[i]);
							}
						 }
						//将返回的数据传递给实现搜索输入框的输入提示js类
						 searchSuggest.dataDisplay(aData);
			  },"json")


		
}

</script> {/literal}