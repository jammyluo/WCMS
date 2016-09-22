<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="apple-touch-fullscreen" content="YES">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragram" content="no-cache">
<title>{$rs.title}</title> 
<meta name="Keywords" content="顶上集成吊顶,集成吊顶十大品牌,集成吊顶招商加盟,顶上官网,吊顶品牌,吊顶代理,顶上品牌好,集成吊顶生产厂家"> 
<meta name="Description" content="顶上-生活之上,专业的集成吊顶生产供应厂商!荣获集成吊顶行业十大品牌,集成吊顶招商加盟代理首选!顶上集成吊顶,最好的吊顶!求购集成吊顶,找集成吊顶报价,就选十大集成吊顶-顶上品牌.">
<script type="text/javascript" src="./static/public/jquery.js"></script>
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
{literal} 
<style>
*{margin:0;padding:0}
ul,li {list-style: none;}
body {margin:0; padding:0; font-family:'微软雅黑'}
.header {width:100%;}
.header img {width:100%;}
.reg {width: 100%;overflow: hidden;}
.reg .reg_t {height: 2.5em;line-height:2.5em;background-color: #d8d8d8;font-size:1.0em;color: #de1158;  text-align: center;}
.reg .reg_b {width: 60%;padding:1.5em 20%;background-color: #ebebeb;padding-bottom: 2.5em;}
.reg .reg_b li {margin-top: 1em;}
.btn_a {width:100%;height: 2.5em;background: #ed1158;text-align: center;line-height: 2.5em;display: block;border-radius: 5px;text-decoration: none;  color: #fff;}
.reg .reg_b input {width:98%;height: 3.5em;padding: 0 1%;text-align: center;border:1px solid #ccc;border-radius:5px;}
.content{text-align:center;min-height:300px;}
.content p img {width: 100%;display: inline-block;}
</style>
<script>
function add(){
   var mobile=$("input[name='mobile_phone']").val();
   var username=$("input[name='real_name']").val();
   var content=$("input[name='content']").val();
   if(mobile.length<10){
       
       alert("手机号码长度不符合");
       return false;
   }else{
   $.post("/comment/comment",{real_name:username,nid:35803,mobile_phone:mobile,comment:content},"json"); 
   alert("恭喜你，提交成功 我们会尽快联系您");
   loation.reload();
   }
 }
</script>
{/literal} 
</head>
<body class="w h ovh tc">
    <div class="header w">
        {if $rs.head_pic!=""}<img src="{$rs.head_pic}" alt="" style="width:100%;">
        {else}
             没有图片
        {/if}
    </div>
    <div class="reg w ovh">
        <div class="reg_t w tc">若心动，别犹豫，给足实惠！</div>
        <form id="wap_reg">
            <ul class="reg_b">
                    <input type="hidden" name="nid" value="35790">
                    <input type="hidden" name="url" value="/news/c/?cid=1123">
                      <li>
                    <input  type="text" name="real_name" placeholder="您的名字">
                </li>
                <li>
                    <input type="text" name="mobile_phone" placeholder="输入您的手机号">
                </li>
                 <li>
                    <input type="text" name="content" placeholder="小区名称">
                </li>
              
                <li>
                    <input type="button" value="{$rs.btn_name}" onclick="add()"  class="btn_a sub tc"/>
                </li>
            </ul>
        </form>
    </div>
    <div class="content tc">
        <p>
           {$rs.content}
        </p>
    </div>
    <a style="position: fixed;left:10px;bottom: 10px;width: 70px;height: 70px;background: url(/static/d_shang_new/images/img/sdk/template_func_7.png);" href="tel:{$rs.mobile_phone}"></a>
</body>
</html>
    
    
    


















