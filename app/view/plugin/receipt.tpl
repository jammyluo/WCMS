<div  style="width: 520px;height: 135px;margin-left: -20px;">
 <ul class="list-group">
 {foreach from=$receipt item=l}
{if $l.read==0}
<li class="list-group-item">  <a href="javascript:receipt({$l.id})" id="confirm_{$l.id}" class="label  label-success">回执确认</a>  <a href="{$l.html}"  target="_blank">{$l.title}</a> <small> {$l.date|wtime}</small> <span class="badge sr-only" id="renshu{$l.id}"  title="已确认人数">{$l.readnum}</span></li>
{else}
<li class="list-group-item">  <a href="{$l.html}" target="_blank">{$l.title}</a> <small> {$l.date|wtime}</small> <span class="badge" title="已确认人数">{$l.readnum}</span> </li>

{/if}
{/foreach}

</ul>
</div>
{literal}
<script language="javascript">
function receipt(nid){
   $.post("./index.php?plugin/api",{nid:nid,filter:"login",plugin:"ReceiptPlugin"},function(data){
       
      if(data.message=="success"){
      var renshu=$("#reshu_"+nid).html();
      var rs=parseInt(renshu)+1;
      $("#reshu"+nid).html(rs);
      $("#reshu_"+nid).removeClass("sr-only");
          alert("感谢你的回执");
          $("#new_"+nid).remove();
          $("#confirm_"+nid).remove();
      }else{
         alert(data.message); 
      }
       
       
   },"json")
    
}
</script>
{/literal}