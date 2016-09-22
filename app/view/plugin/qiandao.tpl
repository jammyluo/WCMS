    <div class="input-group" style="position:absolute;left:500px;top:20px;width: 120px;text-align: center;padding: 1px 1px;  border: 1px solid #ccc;  border-radius: 2px;">
    {if $amupper.isamupper!="error"}
        <a  class="btn btn-success pull-left"  id="am_no" style="color: green;font-weight: 700;text-align: center;margin-right: 10px;width: 80px;line-height:30px;" href="javascript:amupper()">打卡签到</a>
            <a  class="btn btn-success pull-left"    id="am_yes" style="text-align: center;margin-right: 10px;display:none;">连续<span style="color: #ff7f3e;font-size:22px;margin:0 4px;" id="am_lq">{$amupper.total}</span>天</a>

    {else}

                <a  class="btn btn-success pull-left"  href="javascript:amupper()" style="text-align: center;margin-right: 10px;">连续<span style="color: #ff7f3e;font-size:22px;margin:0 4px;" id="am_lq">{$amupper.day}</span>天</a>
    {/if}
     <br>   <span style="font-size: 12px;color: #737373;line-height:24px;width: 75px;" id="am_rank" title="今天的排名">第{$amupper.today}名</span><br>
      <!--  <span style="line-height:18px;">总签到<span style="color: #ff7f3e;margin: 0 4px;" id="am_zq">{$amupper.total}</span>天</span>-->
    </div>
	<!--
         [每日前50,送物料积分] <a href="./index.php?plugin/l/?filter=login&plugin=AmupperPlugin" ><small>签到明细</small></a>
-->
    <script src="./static/public/layer/layer.min.js" ></script>

{literal}

<script language="javascript">
function amupper(){
    
    $.post("./index.php?plugin/api",{filter:"login",plugin:"AmupperPlugin"},function(data){
     
       layer.alert(data.message,9);
          $("#am_no").hide();
           $("#am_lq").html(data.data.day);
           $("#am_rank").html("第"+data.data.today+"名");
          $("#am_zq").html(data.data.total);
          $("#am_yes").show();
     
    },"json")
    
}
</script>
{/literal}