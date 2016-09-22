      <div class="form-inline" style="width: 470px;
border: 1px #ccc solid;
padding: 20px;
margin-top: 10px;
margin-bottom: 10px;
border: 5px #ffc24c solid;
">
<label class="radio">
<input type="radio" name="type" value=1 checked>机选:
</label>


<select name="num" id="num" class="input-small">
<option value="1">1注</option>
<option value="2">2注</option>
<option value="3">3注</option>
<option value="4">4注</option>
<option value="5">5注</option>
<option value="6">6注</option>
<option value="7">7注</option>
<option value="8">8注</option>
<option value="9">9注</option>
<option value="10" selected>10注</option>

</select>

<a href="./index.php?plugin/l/?filter=single&plugin=TicketsPlugin#today" target="_blank">我的彩票</a>(小投资，大回报,最高可获得10000积分！)
<br><br>
送给:<input type="text" name="mobile_phone" class="input-large" placeholder="别人的手机号码,不填就给自己买"  >

<button class="btn btn-danger" onclick="add()">出票</button>
</div>

        
         {literal}
  <script>
  function add(){
	  var num=$("#num").val();
	  var money=num*10+"积分";
	  if(!confirm("你将支付"+money+"购买"+num+"注彩票?")){
return;
	  }
	  var mobile=$("input[name='mobile_phone']").val();
	  $.post("./index.php?plugin/api/",{filter:"single",plugin:"TicketsPlugin",mobile_phone:mobile,num:num},function(data){

	     if(data.status==true){
	     alert("购买成功,请点击我的彩票查看");
	    
	  	}else{
	     alert(data.message);
	  	}

	  	},"json")

	  }
	    
    
  </script>
{/literal}