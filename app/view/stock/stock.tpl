     {include file="file:anonymous/header.tpl"}
    {literal}
    <style>
    p{margin:0px;}
     .zs{padding:0px;color:#ccc;}
    #username{color:green;font-size:12px;}
    #tishi{color:red;display:block;width:200px;height:20px;}
     </style>
    {/literal} 
      <div style="width:400px;height:300px;padding-left:20px;">
                            <!-- -------------------------------- -->
                            <div class="right_contBox">
                            
                                <div class="sns-nf">
                                
                                    <p id="tishi"></p>
                                    <p class="usernamebox">
                                        <label>SKU编码</label> 
                                      <input type="text" name="sku"  id="sku" value="" onblur="getgoodsname()">
                                      <span id="username"></span>
                                     </p>
                                
                                    <p class="real_namebox">
                                         <label>入库：</label>
                                         <span class="real_name">
                                         <input type="text" name="num" id="num" value="">{$goods.unit}
                                   
                                    </p>
                                   
                                   
                                      <p class="real_namebox">
                                         <label>采购单价：</label>
                                         <span class="real_name">
                                         <input type="text" name="money" id="money" value="">
                                   
                                    </p>
                                   
                                       <p class="real_namebox">
                                         <label>供应商：</label>
                                         <select name="suppliers" id="suppliers">
                                         {foreach from=$suppliers item=l}
                                         <option value="{$l.id}">{$l.username}</option>
                                         {/foreach}
                                         </select>
                                   
                                    </p>
                                   
                                     <p class="real_namebox">
                                         <label>备注：</label>
                                         <span class="real_name"><textarea id="remark" rows="3" cols="5"></textarea></span>
                                   
                                   
                                    </p>
                                   
                                   
                                    <p class="real_namebox">
                                         <label>　　　　　　　　</label>
                                         <span class="real_name"><input type="button" class="btn btn-success"  value="确认入库" onclick="transfer()">
                                         <a  href="javascript:history.go(-1)" class="btn btn-default" >返回</a>
                                         </span>
                                    </p>
                                </div>
                       
                            </div>
                            <!-- -------------------------------- -->
                        </div>
 {literal}
 <script>
 
 function getgoodsname(){
	 var sku=$("#sku").val();
	$.post("./index.php?buy/getgoodsbysku/?sku="+sku,function(data){
		$("#username").html(data.data.goods_name);
		$("#money").val(data.data.price);
	},"json")
	 
 }
 
 function transfer(){
	
	 var sku=$("#sku").val();
	 var num=$("#num").val();
	 var suppliers=$("#suppliers").val();
	 var remark=$("#remark").val();
	 var money=$("#money").val();
	 if(parseInt(num)<1){
		 alert("入库数量不能少于1");
		 return;
	 }
	 
	 if(sku==""){
		 alert("产品编码不能为空");
		 return;
	 }
	 
	 
	 $.post("./index.php?stock/substock",{sku:sku,num:num,remark:remark,money:money,suppliers:suppliers},function(data){
		 if(!data.status){
			 alert(data.message);
			 return false;
		 }else{
			 alert(data.message);
			 $("#sku").val("");
			 $("#num").val("");
			 $("#money").val("");
			 
		 }
		 
	 },"json")
	 
	 
	 
	 
 }
 
 
 </script>
 
 {/literal}