{include file="news/header.tpl"}

<body onload="loading()">

<div class="well">		

{literal}
<script type="text/javascript" language="javascript">
        $(document).ready(function() {
        	$("#chk_all").click(
       			 function(){
 					if(this.checked){
 					 $("input[name='chk_list']").prop('checked', true)
 					 }else{

 					$("input[name='chk_list']").removeAttr("checked");
 					}
 					}

 					);
                  });





            function del(id){
              if(!confirm("确认删除?")){
                  return;
                 }
          	  $.post("./index.php?member/remove",{uid:id},function(data){

           	     if(data.message!="success"){
           	    	alert(data.message);
           	    	return;
           	     }else{
            		  $("#member"+id).fadeOut();

               	     }
             },"json")
          }


    </script>

{/literal}

	<div class="form-inline">
	<a href="./index.php?member/add" class="btn btn-success">新增会员</a>
	</div>
	<table class="table table-striped table-bordered">
		<tr>
		<th>UID</th>
		<th >姓名</th>
		<th >手机</th>
		<th >登录</th>
		<th >管理</th>
		</tr>

		{section name=l loop=$news }
		<tr id="member{$news[l].uid}">
		<td>{$news[l].uid}</td>
		<td>{$news[l].real_name}</td>
		<td><span id="{$news[l].uid}_sj">{$news[l].mobile_phone}</span></td>
		<td><small>{$news[l].lastlogin|wtime}</small></td>
		<td> <a href="javascript:del({$news[l].uid})">删除</a></td>
		</tr>
		{/section}

	</table>

	<div class="pagination pagination-centered">
	<ul id="pager"></ul>
	</div>

</div>	
</body>

	


<script src="./static/public/layer/layer.min.js" ></script>


{literal}
<script type='text/javascript'>



$(document).ready(function(){

	  $(".info").bind("mouseover",function(){
		    $(this).popover("show");
			   })
	  $(".info").bind("mouseout",function(){
		    $(this).popover("hide");
			   })
  $("input[name='value']").keyup(function(event){
            if(event.which==13){
                 sub();
            }
		  })
})


function sub(){
    var type=$("#type").val();
    var value=$("#value").val();
	location.href='./index.php?member/csearch/?type='+type+"&value="+value;
}

function edit(id){
$.layer({
    type: 2,
    shadeClose: true,
    title: false,
    closeBtn: [0, true],
    shade: [0.8, '#666'],
    border: [0],
    offset: ['20px',''],
    area: ['700px', ($(window).height() - 50) +'px'],
    iframe: {src: './index.php?member/edit/?id='+id,
        scrolling: 'no'
         }
})
}

function addarea(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', ($(window).height() - 150) +'px'],
	    iframe: {src: './index.php?stores/add/?uid='+id,
	        scrolling: 'no'
	         }
	})
	}
function stores(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['800px', '650px'],
	    iframe: {src: './index.php?stores/getstorebyuid/?uid='+id,
	        scrolling: 'no'
	         }
	})
	}

function add(id){
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#666'],
	    border: [0],
	    offset: ['20px',''],
	    area: ['700px', ($(window).height() - 50) +'px'],
	    iframe: {src: './index.php?member/add',
	        scrolling: 'no'
	         }
	})
	}



var options = {
currentPage: {/literal}{$num.current}{literal},
totalPages: {/literal}{$num.page}{literal},
numberOfPages:5,
bootstrapMajorVersion:3,
pageUrl: function(type, page, current){
    return './index.php?member/listing/?groupid={/literal}{$groupid.id}&verify={$verify.id}&{literal}&p='+page;
}
}
$('#pager').bootstrapPaginator(options);
</script>
{/literal}
{include file="news/footer.tpl"}
