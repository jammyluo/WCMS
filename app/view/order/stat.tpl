{include file="buy/header.tpl"}
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" media="screen">
{literal}
<style type="text/css">
.form_date {
	width: 80px;
	border: 1px #ccc solid;
}

table {
	font-size: 12px;
}

.btn {
	padding: 3px 10px;
}

.btn-default {
	background: #f5f5f5
}

form {
	margin-bottom: 0px;
}

.table th {
	background: #f9f9f9;
}

input[type="text"] {
	height: 18px;
}

.action {
	background: #f9f9f9;
	border-top: 1px #c0c0c0 solid;
	border-bottom: 1px #c0c0c0 solid;
	padding: 5px;
	line-height: 25px;
	margin-bottom: 10px;
}

.refund td {
	border-bottom: none;
}

.drawback {
	border-top: 1px #ccc dashed !important;
}

small {
	color: #999;
	border-bottom: none;
}
</style>
{/literal}	


<!-- 头部// -->

<!-- 左侧// -->


<!-- start: Content -->
			<div  class="span12">
			<div class="form-inline">下单时间 <input class="form_date" type="text" name="starttime"
	value="{$startime}"  readonly> - <input
	name="endtime" class="form_date"  type="text" value="{$endtime}"  readonly> 

 总金额 <small>{$money}</small>元   总订单数 <small>{$totalnum}</small> 单


<button type="button" onclick="stat()" class="btn btn-default">查看</button>

(每日0点至24点)
</div>
						
			<div class="row-fluid">


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<table id="datatable" class="table table-striped  table-hover">
	<thead>
		<tr>
			<th>日期</th>
			<th>单数</th>
		
			<th>销售额</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$rs item=l}
	
		<tr>
			<td  class="time">{$l.m}</td>
			
			<td> {$l.num}</td>
			<td> {$l.money}</td>
			
		</tr>
		{/foreach}
	</tbody>
</table>


	</div></div>

	<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.js"
	charset="UTF-8"></script> <script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js"
	charset="UTF-8"></script>
	<script src="./static/public/highchart/js/highcharts.js"></script>
<script src="./static/public/highchart/js/modules/data.js"></script>
<script src="./static/public/highchart/js/modules/exporting.js"></script>

{literal}

	<style type="text/css">
${demo.css}
	</style>
	<script type="text/javascript">

   function stat(){
  var start=$("input[name='starttime']").val();
  var end=$("input[name='endtime']").val();
  location.href='./index.php?buyorder/stat/?starttime='+start+'&endtime='+end;

  }
	
	$(function () {
	
		
		
		
	    $('#container').highcharts({
	        data: {
	            table: document.getElementById('datatable')
	        },
	        chart: {
	            type: 'line'
	        },
	        plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            
	        title: {
	            text: '订单日销售情况'
	        },
	      
 
	        yAxis: {
	            allowDecimals: false,
	            title: {
	                text: '单数'
	            }
	        },
	        tooltip: {
	            formatter: function() {
	                return '<b>'+ this.series.name +'</b><br/>'+
	                    this.point.y +' '+ this.point.name.toLowerCase();
	            }
	        }
	    });
	});
	 $('.form_date').datetimepicker({
	     language:  'zh-CN',
	     format:'yyyy.mm.dd',
	     weekStart: 1,
	     todayBtn:  0,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
	 });
	</script>

	{/literal}

{include file="news/footer.tpl"}

