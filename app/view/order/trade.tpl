       {include file="anonymous/header.tpl"}
 
       
       <table class="tc w tab_order">
                            <tbody>
                                <tr >
                                    <th width="57%">商品</th>
                                    <th width="10%">单价</th>
                                    <th width="10%">数量</th>
                                    <!--<th width="12%">单品总价</th>-->
                                    <th width="13%">订单总价</th>
                                    <th width="10%">状态</th>
                                </tr>
                                {foreach from=$order item=l}
                                <tr>
                        	    <th colspan="5" align="left" class=" pl_15" style="background:#f9f9f9;">订单编号：{$l.orderno} {$l.addtime|date_format:"%Y-%m-%d %H:%M"}</th>
                                </tr>
                                {foreach from=$l.goodslist item=g name=k}
                                <tr>
                                    <td><p class="gds clearfix"><img src="{$g.thumb}" width=30 height=30>{$g.goods_name} </p></td>
                                    <td align="center">{$g.coupons}</td>
                                    <td align="center">{$g.num}</td>
                                    <!--<td align="center">{$g.coupons_total}</td>-->
                                    {if $smarty.foreach.k.iteration==1}
                                    <td align="center" rowspan = "{$l.goodsnum}" > {$l.coupons}</td>
                                    {else}{/if}
                                    {if $smarty.foreach.k.iteration==1}
                                    <td align="center" rowspan = "{$l.goodsnum}" >{$l.status}</td>
                                    {else}{/if}
                                </tr>
                                {/foreach}
                                {/foreach}
                                <tr>
                        	    <th colspan="5"><div id="pager" class="pager floatR"></div></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
               <div style="text-align:center;">
<div id="pager">
</div>
            {literal}
            <script>
var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:2,
pageUrl: function(type, page, current){
    return "./index.php?coupons/coupons/?p="+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
            
            