{literal}
<style>
.brand .name{font-size:14px;font-weight:400;color:#666}
.avatar-big {
margin: -13px 10px -14px 10px;
height: 38px;
width: 38px;
-webkit-border-radius: 50em;
-moz-border-radius: 50em;
border-radius: 50em;
}
.brand{margin-left:-10px;}
.cart{
margin-top:2px;
margin-left:3px;background: #E33B3B;
color: #fff !important;
border: 1px #bd362f solid;
height: 35px;}
.navbar-inner{border-bottom:3px #E33B3B solid;}
.navbar .nav .liactive>a, .navbar .nav .liactive>a:hover{background:#E33B3B;}
.hello{color:#666}
.name{color:#666}
.liactive a{color:#f40;font-weight:700}
.navbar-inner-box{background-image: url('./static/d_shang/images/indent_header_01.jpg');
background-attachment: fixed;
background-position: top center;}
</style>
{/literal}

<div style="width:100%;height:45px;"></div>
<div class="navbar navbar-fixed-top">
	
		<div class="navbar-inner navbar-inner-box">
			<div class="container-fluid">
				<!--
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>	
				-->
				<div class="">
				
					<div class="brand">
				
											<img src="{if $user.face==''}./static/attached/face/default_01.jpg{else}{$user.face}{/if}" alt="Avatar" class="avatar-big" />
												<span class="name">{$user.username}[<a href="./index.php?anonymous/signout">退出</a>]</span>
											
							
									
				</div>
				
					<ul class="nav" style="left:50px;margin-top: 11px;">
					  			<li onclick="javascript:setNav('./index.php?customer/create',this)"  class="liactive"><a href="javascript:void(0)" >创建二维码</a></li>
					  			  				<li onclick="javascript:setNav('./index.php?customer/my',this)"><a href="javascript:void(0)" >我的二维码</a></li>
					
  				<li onclick="javascript:setNav('./index.php?customer/info',this)" ><a href="javascript:void(0)" >客户信息</a></li>
  			
  
	  				<li onclick="javascript:setNav('./index.php?customer/hot',this)" ><a href="javascript:void(0)" >最热门</a></li>
	

					 	<!-- 
		
			<li onclick="javascript:setNav('./index.php?buyaccount/performance',this)"><a href="javascript:void(0)">个人业绩</a></li>
			 	<li onclick="javascript:setNav('./index.php?buywallet/charge',this)"><a href="javascript:void(0)">账户充值</a></li>
			 	 -->
			 	
	</ul>
				</div>	
			
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
				
				
				
					<ul class="nav pull-right">
						
						<!-- start: Notifications Dropdown -->
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle"  href="./" target="_blank">
								<i class="icon-home" style="color:#f40"></i>
							</a>
							
						</li>
					
						<!-- start: User Dropdown -->
				
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
{literal}
<script>
function setNav(url,obj){
	$(".nav li").each(function(){
		$(this).removeClass("liactive");
		})
	$(obj).addClass("liactive");
	$("#iframe").attr("src",url);	
}
</script>
{/literal}
