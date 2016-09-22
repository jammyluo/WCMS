{include file="news/header.tpl"}
{literal}
<style>
body{background-color:#fff;}
#content {top: 0px;padding: 5px;background:#fff;}
.table th{background:#fff;}
.table td{text-align:left;}
.suoding{height:30px;}
.commentimg {max-width: 100%;max-height: 100%;}
#profile a{box-shadow: 1px 2px 3px darkkhaki;padding: 5px 0px;border-bottom: 2px dotted #ccc;margin-bottom: 5px;display: block;text-align: center;}
.proimg{position:fixed;left:500px;top:80px;width:160px;border:1px #ccc solid;padding:2px;}
</style>
{/literal}

<div id="content">


	<div class="row-fluid">



		<div class="well">
			<!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs">
				<li><a href="javascript:history.go(-1)">« 返回</a></li>

				<li class="active"><a href="#tab1" data-toggle="tab">基本</a></li>
			

			</ul>
<div class="proimg">
<img src="{$goods.image}">
</div>
	<div class="tab-pane active" id="tab1">
<div class="box"><!-- Default panel contents -->
<form action="./index.php?buy/save/" method="post">
<table class="table">

<tr>
<td>产品名称</td>
<td><input type="text" name="goods_name"  value="{$goods.goods_name}">
<input type="hidden" name="id" value="{$goods.id}">
</td>
</tr>

<tr>
<td>规格尺寸</td>
<td><input type="text" name="type" value="{$goods.type}"></td>
</tr>
<tr>
<td>拼音</td>
<td><input type="text" name="pinyin"  value="{$goods.pinyin}">
</td>
</tr>
<tr><td>分类</td>
<td>
<select name="cid">
{foreach from=$cate item=l}
<option value="{$l.id}" {if $l.id==$goods.cid}selected{/if}>{$l.name}[{$l.remark}]</option>
{/foreach}
</select>
</td>
</tr>
<tr>
<td>SKU</td>
<td><input type="text" name="sku" value="{$goods.sku}"></td>
</tr>
<tr>
<td>价格</td>
<td><input type="text" name="price" value="{$goods.price}"></td>
</tr>
<tr>
<td>品牌</td>
<td><input type="text" name="brand" value="{$goods.brand}"></td>
</tr>
<tr>
<td>折扣</td>
<td><input type="text" name="discount" value="{$goods.discount}">最大为1</td>
</tr>
<tr>
<td>包装数量</td>
<td><input type="text" name="num" value="{$goods.num}"></td>
</tr>

<tr>
<td>备注</td>
<td><input type="text" name="remark" value="{$goods.remark}"></td>
</tr>
<tr>
<td>产品类型</td>
<td><input type="radio" name="special" value="0" {if $goods.special==0}checked{/if}>常规 <input type="radio" name="special" value="1"  {if $goods.special==1}checked{/if}>特价 </td>
</tr>
<tr>
<td>活动名称</td>
<td><input type="text" name="party" value="{$goods.party}"></td>
</tr>

<tr>
<td>单位</td>
<td><input type="text" name="unit" value="{$goods.unit}"></td>
</tr>
<tr>
<td>价格模型</td>
<td>
<select name="module">
{foreach from=$module item=l key=key}
<option value="{$key}" {if $key==$goods.module}selected{/if}>{$l}</option>
{/foreach}
</select>
</td>
</tr>
<tr>
<td>推荐</td>
<td><input type="checkbox" name="recommend" value="1" {if $goods.recommend==1}checked{/if}></td>
</tr>
<tr>
<td>状态</td>
<td><select name="status" id="status" class="span2">
{foreach from=$status key=key item=l}
<option value="{$key}"
{if $key==$goods.status}selected{/if}>{$l}</option>
{/foreach}
</select></td>
</tr>
<tr><td></td><td>
<input type="submit" class="btn btn-warning" value="保存">
</td></tr>
</table>
</div>
</div>
</form>
</div>
</div>
</div>



<script src="./static/bootstrap2/js/bootstrap.min.js" language="javascript"></script>

 