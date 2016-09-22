<script type="text/javascript"
	src="./static/public/jquery-1.11.0.min.js"></script>
<script src="./static/public/jquery-ui.js" type="text/javascript"
	charset="utf-8"></script>
<script src="./static/public/evol.colorpicker.min.js"
	type="text/javascript" charset="utf-8"></script>

<link href="./static/public/css/evol.colorpicker.css" rel="stylesheet"
	type="text/css">
<link href="./static/public/css/jquery-ui.css" rel="stylesheet"
	type="text/css">
	<link href="./static/bootstrap2/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript"
	src="./static/bootstrap2/js/bootstrap-datetimepicker.zh-CN.js"
	charset="UTF-8"></script>

    <script type="text/javascript" src="./static/public/layer/layer.min.js" ></script>

{literal}
<style>
.cke_button__addpic{background: url(./static/public/ckeditor/plugins/addpic/addpic.png) no-repeat 5px 5px !important;}

.table th, .table td {
border-top:none;
border-bottom: 1px solid #f1f1f1;
</style>
<script type='text/javascript'>

$(document).ready(function(){
  
    $("#mycolor").colorpicker({
        color: "#ffc000",     
        history: false,
        displayIndicator: false
        });
    $("#mycolor").on("change.color", function(event, color){
        $('#title').css('color', color);
        var x=$("#b").attr("class");
        if(x=="b"){
            $("input[name='css']").val('color:'+color+";font-weight:bold;");
        }else{
          	 $("input[name='css']").val('color:'+color);
        }
    })
   });

			

			function apd(t){
    var htm='<input type="text" name='+t+'[]>';
     $("#"+t).append(htm);
			}
			function show(){
             $("#kuozhan").show();
			}
			function jiacu(){
				var c=$("#mycolor").val();
				if(c!="#ffc000"){
                    c="color:"+c+";";
				}else{
                    c=""; 
				}
             
               var x=$("#b").attr("class");
               if(x=="b"){
            	   $("#title").css("font-weight","");
                   $("#b").removeClass("b");
                   $("input[name='css']").val(c);
               }else{             
               $("#title").css("font-weight","bold");
               $("#b").addClass("b");
               $("input[name='css']").val(c+"font-weight:bold;");
               }
               
			}
			function checktitle(){
				   var t=$("#title").val();
				   $.post("./index.php?factory/search",{key:"title",value:t,datatype:"json"},function(result){
					   if(result.status=="success"){
						   $("#checktitle").addClass("alert alert-success");
						   }else{
							   $("#checktitle").addClass("alert alert-error");
							   }
				var str="<ul>";
						 for(var i=0;i<result.data.length;i++){
				  str+="<li>"+result.data[i].title+"</li>";
					 }
						 str=str+"</ul>";
				    $("#checktitle").html(str)
				   },"json")
				
				}
		</script>


{/literal} 



