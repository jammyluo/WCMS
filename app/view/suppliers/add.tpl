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
                                        <label>供应商名字</label> 
                                      <input type="text" name="username"  id="username" value="" >
                                      <span id="username"></span>
                                     </p>
                                
                                   
                                    <p class="real_namebox">
                                         <label>　　　　　　　　</label>
                                         <span class="real_name"><input type="button" class="btn btn-success"  value="新增" onclick="transfer()">
                                         <a  href="javascript:history.go(-1)" class="btn btn-default" >返回</a>
                                         </span>
                                    </p>
                                </div>
                       
                            </div>
                            <!-- -------------------------------- -->
                        </div>
 {literal}
 <script>
 
 
 function transfer(){
	
	 var username=$("#username").val();


	 
	 
	 $.post("./index.php?suppliers/addsuppliers",{username:username},function(data){
		 if(!data.status){
			 alert(data.message);
			 return false;
		 }else{
			 alert(data.message);
			 $("#username").val("");	 
		 }
		 
	 },"json")
	 
	 
	 
	 
 }
 
 
 </script>
 
 {/literal}