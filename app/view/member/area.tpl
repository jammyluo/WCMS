{include file="buy/header.tpl"}
<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" media="screen">
{literal}
<style>
input[type="text"] {
	height: 18px;
	width:100px;
}
.btn {
	padding: 3px 10px;
}

</style>
{/literal}
	<script type="text/javascript" language="javascript" src="./static/public/datatables/media/js/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="./static/public/datatables/media/css/jquery.dataTables.css">
	<script type="text/javascript" language="javascript" src="./static/public/datatables/media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="./static/public/datatables/media/js/jquery.dataTables.js"></script>



<!-- 头部// -->

<!-- 左侧// -->


<!-- start: Content -->
<div  class="suoding">
	

</div>

<div class="row-fluid">



<table id="datatable">
	<thead>
		<tr>
			<th>用户</th>
			<th>手机</th>
			<th>区域</th>
			<th>业务经理</th>
			<th>军区</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$member item=l}

		<tr>
			<td>{$l.real_name}</td>
			<td>{$l.mobile_phone}</td>
			<td>{$l.junqu}</td>
		    <td>{$l.man}</td>
			<td>{$l.land}</td>
		</tr>
		{/foreach}
	</tbody>
</table>


</div>
</div>

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
  location.href='./index.php?buyorder/area/?starttime='+start+'&endtime='+end;

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


<script>
$(document).ready(function() {
     $('#datatable').dataTable();
});
</script>
{/literal}


