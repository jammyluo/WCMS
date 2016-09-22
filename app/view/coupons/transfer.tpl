     {include file="file:anonymous/header.tpl"}
    {literal}
    <style>
    p{margin:0px;}
     .zs{padding:0px;color:#ccc;}
    #username{color:green;}
    #tishi{color:red;display:block;width:200px;height:20px;}
     </style>
    {/literal} 
      <div style="width:400px;height:300px;padding-left:20px;">
                            <!-- -------------------------------- -->
                            <div class="right_contBox">
                            
                                <div class="sns-nf">
                                
                                    <p id="tishi"></p>
                                    <p class="usernamebox">
                                        <label>对方账号：</label>
                                         <span class="username"><input id="mobile" name="mobile" type="text"  class="input" onblur="getUser()" placeholder="手机号码"><em>*</em>
                                         <a href="./index.php?xingfu/add" class="btn btn-warning">创建账户</a>
                                         </span>
                                    <p class="zs" id="username"></p>
                                    </p>
                                
                                    <p class="real_namebox">
                                         <label>幸福：</label>
                                         <span class="real_name"><input id="money" name="money" type="text"class="input" placeholder="0.00" onblur="checkMoney()" ><em></em></span>
                                    <p class="zs">最多可转{$user.coupons}</p>
                                    <input type="hidden" name="maxmoney" id="maxmoney" value="{$user.coupons}" >
                                     <input type="hidden" name="ziji" id="ziji" value="{$user.mobile_phone}">
                                   
                                    </p>
                                   
                                     <p class="real_namebox">
                                         <label>备注：</label>
                                         <span class="real_name"><textarea id="remark" rows="3" cols="5"></textarea></span>
                                   
                                   
                                    </p>
                                   
                                   
                                    <p class="real_namebox">
                                         <label>　　　　　　　　</label>
                                         <span class="real_name"><input type="button" class="btn btn-success"  value="确认转账" onclick="transfer()">
                                         <a  href="javascript:history.go(-1)" class="btn btn-default" >返回</a>
                                         </span>
                                    </p>
                                </div>
                       
                            </div>
                            <!-- -------------------------------- -->
                        </div>
 {literal}
 <script>
 
 
 function getUser(){
	 var ziji=$("#ziji").val();

	 var mobile=$("#mobile").val();
	 var mobilereg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	 
	 if(ziji==mobile){
		 $("#tishi").html("手机号码不能填写自己");
	      return false; 
	 }
	 
	 if (!mobilereg.test(mobile)) {
	      $("#tishi").html("手机号码错误");
	      return false;
	 }else{
		 $("#tishi").html("");
	 }
	 $.get("./index.php?member/getusernamebymobile/?mobile="+mobile,function(data){
		 
		 $("#username").html(data.message);
	 },"json")
	 return true;
 }
 
 function  checkMoney(){
	 var money=$("#money").val();
	
	 var maxmoney=$("#maxmoney").val();

	 if(Math.round(money*100)/100>maxmoney){
		 $("#tishi").html("超过你的最大转账金额");
		 return false;
	 }
	 
	 var isNumber=false;
	 if(parseInt(money)==money)
	 {
	  isNumber=true;
	 }
	 moneyreg=/^([1-9]\d*|0|)\.\d{1,2}$/;
	 if(!moneyreg.test(money)&&!isNumber){
		 
		  $("#tishi").html("金额格式错误");
		 return false;
	 }else{
		 isNumber=true;
	 }
	 if(!isNumber){
		  $("#tishi").html("金额格式错误");
		  return false;
	 }
	return true;
 }
 
 function transfer(){
	 var mobile=$("#mobile").val();
	 var money=$("#money").val();
	 var remark=$("#remark").val();
	 mobile=mobile.replace(/ /g,"");
	 money=money.replace(/ /g,"");
	
	 if(!getUser()){
		 return false;
	 }
	
	 if(!checkMoney()){
		 return false;
	 }
	 
	 $.post("./index.php?coupons/subtransfer",{mobile:mobile,money:money,remark:remark},function(data){
		 if(!data.status){
			 alert(data.message);
			 return false;
		 }else{
			 
			 alert(data.message);
			 location.href="./index.php?coupons/coupons";

		 }
		 
	 },"json")
	 
	 
	 
	 
 }
 
 
 </script>
 
 {/literal}