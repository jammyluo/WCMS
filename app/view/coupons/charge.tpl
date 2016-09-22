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
                                        <label>手机号码：</label>
                                         <span class="username"><input id="mobile" name="mobile" type="text"  class="input" onblur="getUser()" placeholder="手机号码"><em>*</em></span>
                                    <p class="zs" id="username"></p>
                                    </p>
                                
                                
                                   <p class="usernamebox">
                                        <label> 幸福：</label>
                                         <span class="username"> <input type="text" id="coupons" placeholder="0.00"><em>*</em></span>
                                    </p>
                                
  
  <p class="usernamebox">
                                        <label>类型：</label>
                                         <span class="username">    <select name="chargetypes" id="chargetypes">
       
         <option value="0">充值</option>
        <option value="2">赠送</option>
         </select></span>
                                    </p>
                                
  
  
                                 <p class="real_namebox">
                                         <label>备注：</label>
                                         <span class="real_name"><textarea id="remark" rows="3" cols="5"></textarea></span>
                                   
                                   
                                    </p>
  
   
      
            <input type="hidden" id="uid" name="uid" value="0"><button class="btn" onclick="charge()">充值</button>

            </div>
            </div>
            
            
{literal}
<script>
function getUser(){

	 var mobile=$("#mobile").val();
	 var mobilereg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	 
	 if (!mobilereg.test(mobile)) {
	      $("#tishi").html("手机号码错误");
	      return false;
	 }else{
		 $("#tishi").html("");
	 }
	 $.get("./index.php?member/getusernamebymobile/?mobile="+mobile,function(data){
		 $("#uid").val(data.data.uid);
		 $("#username").html(data.message);
	 },"json")
	 return true;
}



function charge(){
	var remark=$("#remark").val();
			var coupons=$("#coupons").val();
			var uid=$("#uid").val();
			var chargetypes=$("#chargetypes").val();
			if(uid==0){
				alert("手机号码不正确!");
				return false;
			}
			if(coupons<1){
		alert("积分必须大于0");
		return false;
		     }
		    
			$.post("./index.php?coupons/addcoupons",{uid:uid,coupons:coupons,remark:remark,chargetypes:chargetypes},function(data){
				alert(data.message);
				$("#mobile").val("");
				$("#uid").val("");
			},"json")
			
}

</script>

{/literal}