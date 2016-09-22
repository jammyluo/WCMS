{include file="news/header.tpl"}

</head>
<body>

	<!-- start: Content -->
	
			<div id="content" class="display:none;">
			
						
			<div class="row-fluid">


<div class="well"><!-- Default panel contents -->



<div class="box-content">


<div class="form-inline suoding">

<label class="checkbox">
		 




<a href="./index.php?suppliers/add" class="btn btn-success">新增</a>
		
		
	
</div>




<table class="table table-hover">
   <tr>
   <th>ID</th> <th>供应商名字</th><th>财务</th><th>操作</th>
   </tr>      
   {foreach from=$suppliers item=l}
   <tr>
   <td>{$l.id}</td>
   <td id="{$l.id}">{$l.username}</td>
   <td><a href="./index.php?suppliers/audit/?suppliers={$l.id}">账目</a></td>
   <td><a href="javascript:edit({$l.id})">编辑</a></td>
   </tr>
   {/foreach }
   </table>
                            <!-- -------------------------------- -->
             </div>
             </div></div>               
                            
                        </div>
                        <script src="./static/public/layer/layer.min.js" ></script>
                        <script src="./static/public/layer/extend/layer.ext.js" ></script>
                        
 {literal}
 <script>
 
 function edit(id){
	 var username=$("#"+id).html();
	var a= layer.prompt({title: '更改名字',val:username}, function(name){
		   $.post("./index.php?suppliers/save",{id:id,username:name},function(data){
			   //alert(data.message);
			   $("#"+id).val(name);
		   },"json")
		});
	 
 }
 
 function transfer(){
	
	 var username=$("#username").val();


	 
	 
	 $.post("./index.php?suppliers/addsuppliers",{username:username},function(data){
		 if(!data.status){
			 alert(data.message);
			 return false;
		 }else{
			 alert(data.message);
			 $("#username").val("");	 
		 }
		 
	 },"json")
	 
	 
	 
	 
 }
 
 
 </script>
 
 {/literal}