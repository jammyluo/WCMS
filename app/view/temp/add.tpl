{include file="news/header.tpl"}



<!-- 头部// -->
<!-- 头部// -->
{include file="news/top.tpl"}


{include file="news/nav.tpl"} 
<div style="padding:20px;line-height:30px;">
 <form action="./index.php?temp/addtemp" method="post" class="form-horizontal">
 
 
 <div class="control-group">
    <label class="control-label" for="inputEmail">类型</label>
    <div class="controls">
     <select name="type" id="type" class="input-small">
{foreach from=$type item=l}
<option value="{$l.id}">{$l.name}</option>
{/foreach}
</select>
    </div>
  </div>


<div class="control-group">
    <label class="control-label" for="inputEmail">模板名</label>
    <div class="controls">
     <input type="text" name="name" id="name" placeholder="模板名,英文" >

    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="inputEmail">中文备注</label>
    <div class="controls">
     <input type="text" name="remark" id="remark" placeholder="中文备注">


    </div>
  </div>


<div class="control-group">
    <label class="control-label" for="inputEmail"></label>
    <div class="controls">
   <input type="submit" value="添加" class="btn ">


    </div>
  </div>






</form>
</div>
