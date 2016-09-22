  
{literal}
<style>
.banner{background: #F1F1F1;height: 30px;width: 100%;}
.daohang{width:1200px;height:30px;margin:0 auto;}
.banner .right{float:right;margin-right:200px;color:#666;line-height:30px;}
.adv{width:100%;height:60px;background:#444;}
</style>
{/literal}
    <div class="banner">
		<div class="daohang">
			<div class="right">
				<a href="javascript:loginout()">退出</a>
			</div>
		</div>
    </div>
    <div class="adv"></div>
   {literal}
<script>
function loginout(){
	$.cookie("user","",{expires:-1,path:"/"});
	$.cookie("jiami","",{expires:-1,path:"/"});
    //注销
	QC.Login.signOut();
	alert("退出成功");
	location.reload();
}
</script>
{/literal}
          