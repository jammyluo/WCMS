{include file="news/header.tpl"}

</head>
<body>

	<!-- start: Content -->
	
			<div id="content" class="display:none;">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">


<div class="form-inline suoding">

<label class="checkbox">
		 




<a href="javascript:history.go(-1)" >返回</a>
		
		
	
</div>




<table class="table table-hover table-bordered">
   <tr>
   <th>结算时间</th> <th>期初数量</th><th>期初余额</th><th>本期数量</th><th>本期进货</th><th>本期支付</th><th>期末数量</th><th>期末余额</th><th>操作</th>
    <tr>
   <td></td>
   <td id="begin_num">{$now.begin_num}</td>
   <td id="beginning" >{$now.beginning}</td>
   <td id="purchase_num">{$now.purchase_num}</td>
   <td id="purchase">{$now.purchase}</td>
   <td><input type="text" class="input-small" placehoder="0.00" name="payment" id="payment"></td>
    <input type="hidden" name="suppliers" id="suppliers" value="{$now.suppliers}">
   <td></td>
   <td></td>
   <td><a href="javascript:audit()" class="btn btn-default">结算</a>  
   <a href="./index.php?suppliers/export/?suppliers={$now.suppliers}&add_time={$smarty.now}">明细</a>
   </td>
   </tr>
   </tr>      
   {foreach from=$rs item=l}
   <tr>
   <td>{$l.add_time|date_format:"%Y-%m-%d"}</td>
   <td>{$l.begin_num}</td>
   <td>{$l.beginning}</td>
    <td>{$l.purchase_num}</td>
   <td>{$l.purchase}</td>
   <td>{$l.payment}</td>
    <td>{$l.end_num}</td>
   <td>{$l.ending}</td>
   <td>  
   <a href="./index.php?suppliers/export/?suppliers={$l.suppliers}&add_time={$l.add_time}">明细</a>
   </td>
   </tr>
   {/foreach }
   </table>
                            <!-- -------------------------------- -->
             </div>
             </div></div>               
                            
                        </div>
                        <script src="./static/public/layer/layer.min.js" ></script>
                        <script src="./static/public/layer/extend/layer.ext.js" ></script>
                        
 {literal}
 <script>
 
 function edit(id){
	 var username=$("#"+id).val();
	var a= layer.prompt({title: '更改名字',val:username}, function(name){
		   $.post("./index.php?suppliers/save",{id:id,username:name},function(data){
			   //alert(data.message);
			   $("#"+id).val(name);
		   },"json")
		});
	 
 }
 
 function audit(){
	
	 var payment=$("#payment").val();
	 var beginning=$("#beginning").html();
var  purchase=$("#purchase").html();
var suppliers=$("#suppliers").val();
var begin_num=$("#begin_num").html();
var purchase_num=$("#purchase_num").html();

var end_num=parseInt(begin_num)+parseInt(purchase_num);
	 
	 
	 $.post("./index.php?suppliers/subaudit",{begin_num:begin_num,purchase_num:purchase_num,beginning:beginning,payment:payment,purchase:purchase,suppliers:suppliers,end_num:end_num},function(data){
		 if(!data.status){
			 alert(data.message);
			 return false;
		 }else{
			 alert("结算成功");
			 location.reload();
		 }
		 
	 },"json")
	 
	 
	 
	 
 }
 
 
 </script>
 
 {/literal}