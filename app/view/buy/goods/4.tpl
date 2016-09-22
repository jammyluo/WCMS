<tr id="s{$l.id}">
<td>
<a href="javascript:mx('{$l.sku}')">{$l.goods_name}</a>
{if $l.remark!=""}
<label class="label label-important">{$l.remark}</label>
{/if}
</td>
<td><span class="price">¥{$l.price}</span>/{$l.unit}</td>
<td>
宽片数<input class="ps" id="njwidth{$l.id}" title="{$l.id}">片*高片数<input class="ps" name="length" title="{$l.id}" id="njlength{$l.id}">片
</td>
<td>{$l.num}{$l.unit}</td>
<td>
<input type="hidden" id="module{$l.id}" value="片数">
<input type="hidden" name="id[]" value="{$l.id}">
<input type="text"  name="num[]"  id="goods_{$l.id}" class="num" style="width:60px" onKeyup="tj({$l.id})" value="{$l.count}" disabled>{$l.unit}
  <input type="hidden" id="unit{$l.id}" name="unit[]"  value="{$l.price*$l.num}" class="unit">
 
 <input type="hidden" id="price{$l.id}" name="prices[]"  value="{$l.price*$l.num}" class="prices">
                                    </td>

<td id="cart{$l.id}">
<a href="javascript:del({$l.id})" class="">移除</a>
</tr>
