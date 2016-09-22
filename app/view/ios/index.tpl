<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>测试</title>
    <script type="text/javascript" src="./static/public/jquery-1.9.1.min.js"></script>
</head>
<body>
Hi~~~

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"./index.php?ios/recharge",
            type:'POST',
            dataType:'json',
            data:{
                orderno:'123456789'
            },
            success:function(data){
                console.log(data);
            },
            error:function(xmlhttprequest, status, error){
                console.log(xmlhttprequest.status);
                console.log(xmlhttprequest.readyState);
                console.log(status);
            }
        });
    });
</script>
</body>
</html>