
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title></title>
    <meta http-equiv="content" content="text/html" charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="/static/plane/css/main.css"/>
   <script type="text/javascript" src="/static/public/jquery-1.11.0.min.js" ></script>

</head>

<body>
<div class="sc" style="float:left;">
{foreach from=$top item=l name=g}
{$smarty.foreach.g.iteration}.{$l.real_name}  {$l.score}分<br>
{/foreach}
</div>
<!--  
<div id="contentdiv">
    <div id="startdiv">
        <button onclick="begin()">开始游戏</button>
    </div>
    <div id="maindiv">
        <div id="scorediv">
            <label>分数：</label>
            <label id="label">0</label>
        </div>
        <div id="suspenddiv">
            <button>继续</button><br/>
            <button>重新开始</button><br/>
            <button>回到主页</button>
        </div>
        <div id="enddiv">
            <p class="plantext">飞机大战分数</p>
            <p id="planscore">0</p>
            <div><button onclick="jixu()">继续</button></div>
        </div>
    </div>
</div>
-->
<script type="text/javascript" src="/static/plane/js/main.js"></script>
</body>
</html>