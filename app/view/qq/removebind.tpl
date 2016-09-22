{include file="news/header.tpl"}
{literal}
<style>
.zhanghao{list-style:none;}
.zhanghao li{display:block;width:80%;height:30px;background:#f1f1f1;padding-left:10px;padding-right:10px;line-height:30px;}
.zhanghao .action{color:orange;}
</style>
{/literal}
<h3>账号绑定</h3>
<ul class="zhanghao">

<li><img src="./static/bootstrap2/img/qq-icon.png"> 绑定QQ账号    
{if $rs.qq!=""}
<span style="color:green;">已绑定</span>   <a href="javascript:remove('qq')" class="action">解绑</a>
{else}
<a href="javascript:void(0)" class="action">尚未绑定，登录时请选择QQ登录</a>
{/if}
</li>


<li><img src="./static/bootstrap2/img/weixin-icon.jpg"> 绑定微信账号    
{if $rs.weixin!=""}
<span style="color:green;">已绑定</span>   <a href="javascript:remove('weixin')" class="action">解绑</a>
{else}
<a href="javascript:void(0)" class="action">尚未绑定，登录时请选择微信扫一扫登录</a>
{/if}
</li>
</ul>



{literal}
<script>
function remove(type){

$.post("./index.php?qq/removebind",{type:type},function(data){

   alert(data.message);
	if(data.status){
location.reload();
		}
},"json")
	
}

</script>

{/literal}