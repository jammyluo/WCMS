{include file="news/header.tpl"}
{literal}
<style>
.score{color:#e15f63}
.name{color:#005aa0}
</style>
{/literal}

<div class="form-horizontal" style="min-height:600px;">
    <fieldset>
      <div id="legend" >
        <ul class="breadcrumb" id="myorder">
  <li><a href="/index.php?buyorder/order">我的订单</a> <span class="divider">/</span></li>
  
  <li class="active"><a href="javascript:history.go(-1)">返回</a></li>
</ul>

        
     
      </div>
      
      <div class="control-group">
      <label></label>
      <div class="controls">
      <div style="float:left;width:160px;">
                <img src="{$rs.face}" width="150px;">
      
      </div>
     <div>
    你的专属客服:<br><span class="score">{$rs.username}</span> <br>
    
<br>    近30天 好评率  <span class="score">{$rs.score}%</span><br>
     </div>
      </div>
      </div>
     
    <div class="control-group">
          <label class="control-label">服务评价</label>
          <div class="controls">
      <!-- Inline Radios -->
      <label class="radio inline">
        <input type="radio" value="-1" name="level" >
        不满意
      </label>
      <label class="radio inline">
        <input type="radio" value="0" name="level">
        满意
      </label>
      <label class="radio inline">
        <input type="radio" value="1" name="level">
        非常满意
      </label>
  </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">建议</label>
          <div class="controls">
            <div class="textarea">
                  <textarea  id="con" colspan="4"  rowspan="5" style="width:400px;height:100px;" placeholder="你的评价对我们改进服务很重要"> </textarea>
            </div>
            <span class="score">你的建议将直接反馈给公司高层领导，这对我们服务的改进非常重要。</span>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" onclick="rating()">提交</button>
          </div>
        </div>
        <input type="hidden" name="orderid" value="{$rs.orderid}">

    </fieldset>
  </div>
  
  {literal}
  <script>
  
  function rating(){

	  var level=$("input[name='level']:checked").val();

		var con=$("#con").val();

		if(level==undefined){
  alert("请你选择满意度");
  return false;
  }
		 
if(level==-1&&con.length<5){
 alert("请说明不满意的原因，我们会及时给你回复!");
 return false;
}

	  var id=$("input[name='orderid']").val();
	  $.post("./index.php?rating/save",{orderid:id,level:level,comment:con},function(data){
         alert(data.message);
          location.href='./index.php?buyorder/order';
		  },"json")
  }
  </script>
  {/literal}
  {include file="news/footer.tpl"}
  