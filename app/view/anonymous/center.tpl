{include file="anonymous/header.tpl"}

<body id="My_account"> 
	{include file="anonymous/top.tpl"}
	
    <div class="bodyBg2">
        <d0iv style="width:98px; height:20px;"></div>
        <div class="main">
            <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ main on  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
            <div class="messageBox1">
                <input type="hidden" name="ids" value="{$user.id}"> 
                <div class="contBox1">
                    <div class="m_left fl">
                        <dl class="left_user" style="margin-bottom:0px;">
                            <dt class="left_username"></dt>
                            <dt class="left_usercoupons pl_25 titleGr2"><a href="javascript:setNav('./index.php?factory/c/?type=manage&mid=1',this)">我的文章</a></dt>
                        </dl>
                        <dl class="left_user" style="margin-bottom:0px;">
                            <dt class="left_username"></dt>
                            <dt class="left_usercoupons pl_25 titleGr2"><a href="javascript:setNav('./index.php?member/repassword',this)">更改密码</a></dt>
                        </dl>
                        {if $user.manager==1}
                            <dl class="left_user" style="margin-bottom:0px;">
                            	<dt class="left_usercoupons pl_25 titleGr2"><a href="./index.php?factory/iframe">后台管理</a></dt>
                            </dl>
                        {/if}
                    </div>
					
					<div class="m_right fr">
						<iframe src="./index.php?factory/c/?type=manage&mid=1" id="iframe" style="width:100%;border:none;overflow-y:none;min-height:900px;"></iframe>
					</div>
				</div>
			</div>
			<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ main off ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->        
		</div>
	</div>
	{include file="anonymous/footer.tpl"}
</body>
</html>
{literal}
<script> 

$(function(){
	
	setIframe();
	$(window).resize(function(){
	setIframe();
	})
	})
	function setIframe(){
	$("#iframe").css({"height":$(document).height()-150});
	}
	
function setNav(url,obj){
	$("dd").each(function(){
		$(this).removeClass("click");
		})
	$(obj).addClass("click");
	
	
	$("#iframe").attr("src",url);	
}
</script> 
<style type="text/css">
#iframe{width:100%;}
.liactive{color:red}
body{}
</style>
{/literal}


