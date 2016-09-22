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
<img src="./static/d_shang/sheep/wolf.jpg">

<table class="table">
<tr><td colspan="4">注：狼会把别人抓到的羊归你，100%能够抓到,每天最多50只狼，每人限购<b>5</b>只</td></tr>

{foreach from=$rs item=l name=g}
<tr>
<td>{if $smarty.foreach.g.iteration==1}即将出战{else}排队中{/if}</td>
<td>狼</td>
<td>来自{$l.real_name} 尊贵用户 </td>
<td>{$smarty.foreach.g.iteration}</td>
</tr>
{/foreach}
</table>