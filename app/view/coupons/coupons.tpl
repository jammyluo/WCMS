{include file="file:anonymous/header.tpl"}          



           <table class="tc w tab_order">
		<tr>


		<th width="15%">日期</th>
		<th width="10%">名称|备注</th>
		<th width="10%">收入</th>
		<th width="10%">支出</th>
		<td width="10%">渠道</td>
		<th width="10%">状态</th>

	</tr>




	{foreach from=$mx item=l }
	<tr style="height: 40px; ">







		<td>{$l.date|date_format:"%Y-%m-%d %H:%M"}</td>
		<td>{$l.remark}</td>
		<td>{if $l.payment==0}<span class="amount_pay_in">+{$l.coupons}</span></td>
		<td></td>
		{else}
		</td>
		<td><span class="amount_pay_out">{$l.coupons}</td>
		{/if}
		<td>{$l.chargetypes}
		{if $l.chargetypes=="转账"}
		<small id="tip_{$l.id}">
		<a href="javascript:tip('{$l.orderno}',{$l.id});" style="color:blue;">明细</a></small>
		{/if}
		</td>
<td class=left width="8%">{$l.status}</td>

	</tr>
	{/foreach}

</table>

                    </div>
                    <div style="text-align:center;">
<div id="pager">
</div>
</div>
                </div>
            </div>
            <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ main off ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
        </div>
    </div>
</body>
  <script src="./static/public/layer2/layer.min.js" ></script>
                        <script src="./static/public/layer2/extend/layer.ext.js" ></script>
{literal}
<script>

function tip(orderno,id){
	$.post("./index.php?coupons/gethistorybytransfersno/?orderno="+orderno,function(data)
			{
                var d=data.data;
		var con=d.from_username+"转给"+ d.to_username;
		    showTip(con,id);
		
			},"json")
	var con="";
	
}

function showTip(con,id){
	layer.tips(con,"#tip_"+id);
}

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
</html>
