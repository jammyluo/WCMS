
{include file="file:anonymous/header.tpl"}
                        <div style="width:400px;height:300px;padding-left:20px;">
                            <!-- -------------------------------- -->
                            <div class="right_contBox">
                            
                                <div class="sns-nf">
                                    <p class="usernamebox">
                                        <label>旧的登录密码：</label>
                                         <span class="username"><input id="password" name="password" type="text"  class="input"><em>*</em></span>
                                    </p>
                                
                                    <p class="real_namebox">
                                         <label>新的登录密码：</label>
                                         <span class="real_name"><input id="newPassword" name="newPassword" type="text"class="input" ><em>至少6位数</em></span>
                                    </p>
                                   
                                    <p class="real_namebox">
                                         <label>　　　　　　　　</label>
                                         <span class="real_name"><input type="button" class="btn "  value="修改" onclick="password()"></span>
                                    </p>
                                </div>
                       
                            </div>
                            <!-- -------------------------------- -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ main off ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
        </div>
    </div>
    {literal}
    <script language="javascript">
    function password(){
    var password=$("#password").val();
    var newPassword=$("#newPassword").val();
    
    if(password.length<5||newPassword.length<5){
        alert("密码至少4位");
        return;
    }
    $.post("./index.php?member/setpassword",{password:password,newPassword:newPassword},function(data){
     alert(data.message);
    
    },"json")
    }
    </script>
    
    {/literal}
</body>
</html>

