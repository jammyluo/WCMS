<input type="button" class="btn btn-default" onclick="sheep()" value="抓羊">

 <script  type="text/javascript" src="./static/public/layer/layer.min.js" ></script>
  <script  type="text/javascript" src="./static/public/layer/extend/layer.ext.js" ></script>
{literal}
<script>


function rank(id){
	var goods='<img src=\'./static/d_shang/sheep/'+id+'.jpg\'>';
	layer.tips(goods, this, {
	    style: ['background-color:#FFF; color:#fff', '#78BA32'],
	    maxWidth:185,
	    time: 3,
	    closeBtn:[0, true]
	});
	
}
</script>

{/literal}
