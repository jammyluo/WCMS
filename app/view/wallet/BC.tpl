<html>
<head>
    <title>商户订单测试</title>
    <meta http-equiv="Content-Type" content="text/html;charset=GBK">
</head>

<body bgcolor="#FFFFFF" text="#000000" onload="form1.submit()">
<form name="form1" target="_blank" method="post" action="{$order.orderUrl_value}">
    <input type="hidden" name="interfaceVersion" value="{$order.interfaceVersion}">
    <input type="hidden" name="merID" value="{$order.merID}">
    <input type="hidden" name="orderid" value="{$order.orderid}">
    <input type="hidden" name="orderDate" value="{$order.orderDate}">
    <input type="hidden" name="orderTime" value="{$order.orderTime}">
    <input type="hidden" name="tranType" value="{$order.tranType}">
    <input type="hidden" name="amount" value="{$order.amount}">
    <input type="hidden" name="curType" value="{$order.curType}">
    <input type="hidden" name="orderContent" value="{$order.orderContent}">
    <input type="hidden" name="orderMono" value="{$order.orderMono}">
    <input type="hidden" name="phdFlag" value="{$order.phdFlag}">
    <input type="hidden" name="notifyType" value="{$order.notifyType}">
    <input type="hidden" name="merURL" value="{$order.merURL}">
    <input type="hidden" name="goodsURL" value="{$order.goodsURL}">
    <input type="hidden" name="jumpSeconds" value="{$order.jumpSeconds}">
    <input type="hidden" name="payBatchNo" value="{$order.payBatchNo}">
    <input type="hidden" name="proxyMerName" value="{$order.proxyMerName}">
    <input type="hidden" name="proxyMerType" value="{$order.proxyMerType}">
    <input type="hidden" name="proxyMerCredentials" value="{$order.proxyMerCredentials}">
    <input type="hidden" name="netType" value="{$order.netType}">
    <input type="hidden" name="merSignMsg" value="{$order.signMsg_value}">
    <input type="hidden" name="issBankNo" value="{$order.issBankNo}">
</form>
</body>

</html>