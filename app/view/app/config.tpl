{include file="news/header.tpl"}
<!-- 头部// -->
<!-- start: Content -->
<div id="content" class="">


<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">




    
    
<div class="tab-content"> 
<form> <div class="control-group">

          <!-- Textarea -->
          <div class="controls">
          
           <p>
                               第一次验证 　　　　　　<input type="text" class="input-middle" name="valid" value="{$rs.valid}"> 0尚未验证  1已验证
           </p>
          
          <p>
               APPID(应用ID) 　　　　<input type="text" class="input-middle" name="appid" value="{$rs.appid}">
               </p>
               
          <p>
               APPSECRET(应用密钥)　<input type="text" class="input-middle" name="appsecret" value="{$rs.appsecret}">
             </p>  
          <p>
               TOKEN(令牌)　　　　　<input type="text" class="input-middle"  name="token" value="{$rs.token}">
        　　 </p>  
   


   <p> 欢迎词　

                  <textarea id="welcomecon" style="width:400px;height:100px;" name="welcome">{$rs.welcome} </textarea>
         </p>
  <p>
   人工客服
                  <textarea id="server" style="width:400px;height:100px;" name="server">{$rs.server} </textarea>
           </p>
          <p>
          按钮代码
         
                  <textarea id="button" style="width:400px;height:300px;" name="button">
                  {$rs.button}
                   </textarea>
          </p>
       
 
              <p>
            <a class="btn " href="javascript:save()">保存</a>
        </p>
</div></div></div>
</div>
</div>	
	
  </form> 

       
     
  </div>
  {literal}
  <script>
  function save(){

		var data=$("form").serialize();
	$.get("./index.php?weixin/saveconfig/?"+data,function(data){
		 alert(data.message);
		},"json")
	}



  </script>
  {/literal}
  
  {include file="news/footer.tpl"}
