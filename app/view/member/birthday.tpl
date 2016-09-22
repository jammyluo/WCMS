<div class="form-horizontal" style="display:none;" id="birthday">
  
    <fieldset>
      
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">生日</label>
          <div class="controls">
            <input type="text" name="birth"  class="input-xlarge">
            <p class="help-block">例如1985-01-21</p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">性别</label>
          <div class="controls">
      <!-- Inline Radios -->
      <label class="radio inline">
        <input type="radio" name="sex" value="0">
        先生
      </label>
      <label class="radio inline">
        <input type="radio"  name="sex" value="1">
        女士
      </label>
  </div>
        </div>

    <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn " onclick="subbirth();">确认</button>
            <span style="color:#e15f63">登记之后，将来有惊喜哦</span>
          </div>
        </div>

    </fieldset>
  </div>
  <script src="./static/public/layer/layer.min.js" ></script>
  
   <script src="./static/public/layer/extend/layer.ext.js" ></script>
   
  {literal}
  <script>


  birthday();
function birthday(){
var b= $("input[name='birthday']").val();
if(b!==""){
return;
	
}

	var birthday=$("#birthday").html();
$.layer({
    type: 1,
    shade: [0.5,'#000'],
    shadeClose: false,
    area: ['auto', '300px'],
    title: false,
    border: [0],
    page: {dom : '#birthday'}
});
}
function subbirth(){

	var sex=$("input[name='sex']:checked").val();
	var birth=$("input[name='birth']").val();
	if(sex==undefined){
    alert("请选择性别");
    return false;
	}

	if(birth==""){
   alert("请输入出生年月日");
   return false;
	}

	if(birth.match(/^\d{4}-\d{1,2}-\d{1,2}/)==null){
    alert("日期格式不对,如下1980-01-23");
    return false;
	}


	$.post("./index.php?member/savebirthday",{birthday:birth,sex:sex},function(data){
		alert(data.message);

  location.reload();
	},"json")

	
	
}
  </script>
  {/literal}
  