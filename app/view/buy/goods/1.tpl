<tr id="s{$l.id}">
<td>
<a href="./index.php?buy/mx/?sku={$l.sku}">{$l.goods_name}</a>
</td>
<td><span class="price">¥{$l.price}</span>/{$l.unit}</td>
<td>{$l.type}


</td>
<td>{$l.num}{$l.unit}</td>
<td>
<input type="hidden" name="id[]" value="{$l.id}">
<input type="text"  name="num[]"  id="goods_{$l.id}" class="num" onKeyup="tj({$l.id})" value="{$l.count}" >
 <input type="hidden" name="prices[]"  value="{$l.price*$l.num}" class="prices">
                                    </td>

<td id="cart{$l.id}">
<a href="javascript:del({$l.id})" class="">移除</a>
</tr>