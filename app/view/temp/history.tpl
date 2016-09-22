{include file="news/header.tpl"}
</head>

<table class="table">
  <tr>
    <th>记录时间</th>
    <th>版本号</th>
    <th>备注</th>
         <th>操作人</th>
    
    <th>操作</th>
  </tr>
  {foreach from=$templist item=l}
  <tr>
  
    <td>{$l.date|date_format:"%m/%d %H:%M"}</td>
    <td>{$l.id}</td>
    <td>{$l.remark}</td>
        <td>{$l.action}</td>
    
    <td><a href="./index.php?temp/edittemp/?type=history&id={$l.id}">view</a></td>
  </tr>
      {/foreach}
</table>

