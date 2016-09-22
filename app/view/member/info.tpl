{include file="anonymous/header.tpl"}
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" media="screen">
<div  id="express" style="position:relative;background:#fff;width: 510px;margin-left: 5px;padding:10px;line-height:25px;font-family:微软雅黑;border:1px #ccc solid;">
   
<p>     真实姓名 <input type="text" name="username" value="{$user.real_name}" disabled></p>
  <p> 手　　机  <input type="text"  name="mobile_phone"  value="{$user.mobile_phone}" disabled>  </p> 
   <p> 性　　别    　　<input type="radio" name="sex" value="0" {if $user.sex==0}checked{/if}>男   　　<input type="radio" name="sex" value="1"
   {if $user.sex==1}checked{/if}
   >女</p> 
  <p>生　　日  <select name="year" id="year" data="{$user.birthday|date_format:'%Y'}" class="input-small">
  <option value="">-年-</option>
  </select>
  
   <select name="month" id="month" data="{$user.birthday|date_format:'%m'}" class="input-small">
  <option value="">-月-</option>
  
  </select>
  
    <select name="day" id="day" data="{$user.birthday|date_format:'%d'}" class="input-small">
  <option value="">-日-</option>
  </select>
  </p> 
  <p>邮　　箱 <input type="text" name="mail" id="email" value="{$user.email}"></p> 
 <p> Q　　Q <input type="text" name="qq" id="qq" value="{$user.qq}"></p> 
 
 <p>
所在地区 
<select name="province"  id="province" data="2" class="input-small dz">
<option value="">-省份-</option>
{foreach from=$provinces item=l}

<option value="{$l.id}" {if $user.province==$l.id}selected{/if}>{$l.name}</option>
{/foreach}
</select>

<select name="city" id="city" data="3" class="input-small dz">
{foreach from=$citys item=l}

<option value="{$l.id}" {if $user.city==$l.id}selected{/if}>{$l.name}</option>
{/foreach}
</select>

<select name="town" id="town" data="4" class="input-small dz">

{foreach from=$areas item=l}

<option value="{$l.id}"  {if $user.town==$l.id}selected{/if}>{$l.name}</option>
{/foreach}
</select>
</p>
 
 <p>门牌地址 <input type="text" class="input-xlarge" id="area" value="{$user.area}"></p>
 
 <p>　　　　　　　　<button class="btn " onclick="save()">保存</button>  　<a class="btn " href="javascript:history.go(-1)">返回</a></p>
        </div>
        <script type="text/javascript" src="./static/bootstrap2/js/bootstrap.min.js" charset="UTF-8"></script>
<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.js"
	charset="UTF-8"></script> <script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js"
	charset="UTF-8"></script>
        
        {literal}
        <script language="javascript">

$(function(){
$("#year").html(getYear());
$("#month").html(getMonth());
$("#day").html(getDay());
$(".dz").bind("change",checked);

$("#month").bind("change",getDay);
$("#year").bind("change",getDay);

})
function getYear(){
	
 var year=$("#year").attr("data");
	var con="<option value=''>-年-</option>";
	 for(var i=2005;i>1930;i--){

		 if(i==year){
			  con=con+"<option value='"+i+"' selected>"+i+"</option>";
			   
			 }else{
	  con=con+"<option value='"+i+"'>"+i+"</option>";
			 }
		 }
	 return con;
}

function getMonth(){
	 var month=$("#month").attr("data");
	var con="<option value=''>-月-</option>";
	 for(var i=1;i<=12;i++){
		 if(i==month){
			  con=con+"<option value='"+i+"' selected>"+i+"</option>";
			   
			 }else{
	  con=con+"<option value='"+i+"'>"+i+"</option>";
			 }
     }
	 return con;
	
}

function getDay(){

	var year=$("#year").val();
	var month=$("#month").val();
	 var day=$("#day").attr("data");

	if(year==""||month==""){
return;
		}
	  var  max = new Date(year,month,0).getDate(); 
	  //获取天数：

	var con="<option value=''>-日-</option>";
	 for(var i=1;i<=max;i++){
		 if(i==day){
			  con=con+"<option value='"+i+"' selected>"+i+"</option>";
			   
			 }else{
	  con=con+"<option value='"+i+"'>"+i+"</option>";
			 }
   }
	$("#day").html(con);	
}


	function checked(){

		var type=$(this).attr("data");
		var val=$(this).val();

	  if(val==""){
	return;
		  }

	  $.post("./index.php?province/areas",{type:type,id:val},function(data){

	var htm=parseJson(data);
	if(type==2){
	$("#city").html(htm);
	$("#town").html("")
	}else if(type==3){
	$("#town").html(htm);
	}

	  
		  },"json")
	}

	function parseJson(data){
	var htm="<option value=''>-选择-</option>";
	  for(var i=0;i<data.length;i++){
	  htm=htm+"<option value='"+data[i].id+"'>"+data[i].name+"</option>";
		 }
		return htm;
	}
        
        function save(){
           var sex=$("input[name='sex']:checked").val();
           var birthday=$("#year").val()+"-"+$("#month").val()+"-"+$("#day").val();
           var province=$("#province").val();
           var city=$("#city").val();
           var town=$("#town").val();
           var area=$("#area").val();
           var qq=$("#qq").val();
           var email=$("#email").val();

          
           
           $.post("./index.php?member/savearea",{sex:sex,birthday:birthday,province:province,city:city,town:town,area:area,qq:qq,email:email},function(data){
             alert(data.message);
           },"json")
            
        }

        $('.form_date').datetimepicker({
      	     language:  'zh-CN',
      	     format:'yyyy.mm.dd',
      	     weekStart: 1,
      	     todayBtn:  0,
      			autoclose: 1,
      			todayHighlight: 1,
      			startView: 2,
      			minView: 2,
      			forceParse: 0
      	 });
        </script>
 {/literal}