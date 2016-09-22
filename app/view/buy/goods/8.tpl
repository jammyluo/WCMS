<tr id="s{$l.id}">
<td>
<a href="./index.php?buy/mx/?sku={$l.sku}">{$l.goods_name}</a>
{if $l.remark!=""}
<label class="label label-important">{$l.remark}</label>
{/if}
</td>
<td><span class="price">¥{$l.price}</span>/{$l.unit}</td>
<td>
出风口长度L<select class="cfk" id="cfklength{$l.id}" style="width:80px"name="width" title="{$l.id}">
<option value="0">无出风口</option>
<option value="0.590">0.590</option>
<option value="0.675">0.675</option>
<option value="0.760">0.760</option>
<option value="0.845" selected>0.845</option>
<option value="0.930">0.930</option>
<option value="1.015">1.015</option>
<option value="1.610">1.610</option>
<option value="1.695">1.695</option>


</select>
米 + M1<input class="cfk" name="length" title="{$l.id}" id="m1{$l.id}" >米
+M2<input class="cfk" name="length" title="{$l.id}" id="m2{$l.id}" >米

</td>
<td>{$l.num}{$l.unit}</td>
<td>
<input type="hidden" id="module{$l.id}" value="出风口公式">
<input type="hidden" name="id[]" value="{$l.id}">
<input type="text"  name="num[]"  id="goods_{$l.id}" class="num" style="width:60px" onKeyup="tj({$l.id})" value="{$l.count}" disabled>{$l.unit}
  <input type="hidden" id="unit{$l.id}" name="unit[]"  value="{$l.price*$l.num}" class="unit">
 
 <input type="hidden" id="price{$l.id}" name="prices[]"  value="{$l.price*$l.num}" class="prices">
                                    </td>

<td id="cart{$l.id}">
<a href="javascript:del({$l.id})" class="">移除</a>
</tr>
