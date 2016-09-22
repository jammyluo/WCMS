{include file="buy/header.tpl"}
{literal}
<style>
.imgbox{min-height: 220px;width:220px;padding: 2px;border:1px #f1f1f1 solid;}
.table{font-size:12px;}
.table th{background:#fff;}
.correct{font-size:15px;font-weight:700;color:red}
.error{font-size:15px;font-weight:700;color:#000}

</style>
{/literal}
<img src="./static/d_shang/sheep/market.jpg">

<table class="table">
<tr><th>卖羊时间</th><th>猎人</th><th>出售羊种</th><th>收购地区</th></tr>

{foreach from=$history item=l}
<tr>
<td>{$l.add_time|wtime}</td>
<td><a href="">{$l.real_name}</a></td>

<td>{$l.result} {$l.action}<span class="correct">+{$l.coupons}</span>积分</td>
<td>{$l.area|cntruncate:6}</td>

</tr>
{/foreach}
</table>