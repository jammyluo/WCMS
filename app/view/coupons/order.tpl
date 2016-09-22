{include file="anonymous/header.tpl"}
{literal}
<style>
</style>
<script type="text/javascript" language="javascript">  
       $(document).ready(function() {  
            $(".pager").pager({ pagenumber:{/literal}{$num.current}, pagecount: {$num.page}{literal}, buttonClickCallback: PageClick });  
           	 $("#chk_all").click(function(){
                 $("input[name='chk_list']").attr("checked",$(this).attr("checked"));
            });
                  });   
            
        PageClick = function(pageclickednumber) {  
            $("#pager").pager({ pagenumber: pageclickednumber, pagecount: {/literal}{$num.page}{literal}, buttonClickCallback: PageClick });  
           // $("#result").html("Clicked Page " + pageclickednumber);     
  window.location.href='/order/trade/{/literal}{$category.id}{literal}p'+pageclickednumber+'.html';          
        }    
  </script>
{/literal}
</head>
          
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
            <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ main off ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
        </div>
    </div>
    {include file="mysql:footer.tpl"}
</body>
</html>


