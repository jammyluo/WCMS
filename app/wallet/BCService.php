<?php

/**
 * Class BCService
 * @author wolf
 * @description 对交行的接口进行封装
 */
class BCService
{
    private $_socketUrl = "tcp://127.0.0.1:8891";
    private $_interfaceVersion = '1.0.0.0';
    //商家编号 证书下载后就马上更改
    private $_merID = '301330459999501';

    private $_tranType = 0; //0:B2C
    //交易币种
    private $_curType = 'CNY';
    //通知方式 0：不通知 1：通知
    private $_notifyType = 1;
    //通知url
    private $_merURL = 'http://www.xingfu10086.com/bank.php';
    //跳转时间
    private $_jumpSeconds = 3;

    private $_netType = 0;
    private $_goodsURL = 'http://www.xingfu10086.com/index.php?bank/notify';

    /* (non-PHPdoc)
     * @see IBank::pay()
     */
    public function pay($uid, $order)
    {

        $amount = $order ['amount'];
        $orderContent = "";
        $orderMono = "";
        $phdFlag = "";
        $goodsURL = "";
        $payBatchNo = "";
        $proxyMerName = "";
        $proxyMerType = "";
        $proxyMerCredentials = "";
        $issBankNo = $order ['bankId'];
        $tranCode = "cb2200_sign";
        $orderDate = $order ['date'];
        $orderTime = $order ['time'];
        $orderid = $order ['orderno'];
        $source = "";

        //连接字符串
        $source = $this->_interfaceVersion . "|" . $this->_merID . "|" . $orderid . "|" . $orderDate . "|" . $orderTime . "|" . $this->_tranType . "|" . $amount . "|" . $this->_curType . "|" . $orderContent . "|" . $orderMono . "|" . $phdFlag . "|" . $this->_notifyType . "|" . $this->_merURL . "|" . $this->_goodsURL . "|" . $this->_jumpSeconds . "|" . $payBatchNo . "|" . $proxyMerName . "|" . $proxyMerType . "|" . $proxyMerCredentials . "|" . $this->_netType;

        $sign = $this->getSign($tranCode, $source);
        if (empty ($sign)) {
            echo "error";
            exit ();
        }
        $params = array('merID' => $sign ['merID'], 'orderContent' => $orderContent, 'goodsURL' => $this->_goodsURL, 'interfaceVersion' => $this->_interfaceVersion, 'orderid' => $orderid, 'orderDate' => $orderDate, 'orderTime' => $orderTime, 'tranType' => $this->_tranType, 'amount' => $amount, 'curType' => $this->_curType, 'merURL' => $this->_merURL, 'issBankNo' => $issBankNo, 'notifyType' => $this->_notifyType, 'netType' => $this->_netType, 'jumpSeconds' => $this->_jumpSeconds, 'signMsg_value' => $sign ['signMsg_value'], 'orderUrl_value' => $sign ['orderUrl_value']);

        View::getInstance()->assign('order', $params);
        View::getInstance()->display('file:wallet/BC.tpl');

    }

    private function getSign($tranCode, $source)
    {
        $fp = stream_socket_client($this->_socketUrl, $errno, $errstr, 30);
        $retMsg = "";

        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $in = "<?xml version='1.0' encoding='UTF-8'?>";
            $in .= "<Message>";
            $in .= "<TranCode>" . $tranCode . "</TranCode>";
            $in .= "<MsgContent>" . $source . "</MsgContent>";
            $in .= "</Message>";
            fwrite($fp, $in);
            while (!feof($fp)) {
                $retMsg = $retMsg . fgets($fp, 1024);

            }
            fclose($fp);
        }
        $dom = new DOMDocument ();
        $dom->loadXML($retMsg);

        $retCode = $dom->getElementsByTagName('retCode');
        $retCode_value = $retCode->item(0)->nodeValue;

        $errMsg = $dom->getElementsByTagName('errMsg');
        $errMsg_value = $errMsg->item(0)->nodeValue;

        $signMsg = $dom->getElementsByTagName('signMsg');
        $signMsg_value = $signMsg->item(0)->nodeValue;

        $orderUrl = $dom->getElementsByTagName('orderUrl');
        $orderUrl_value = $orderUrl->item(0)->nodeValue;

        $MerchID = $dom->getElementsByTagName('MerchID');
        $merID = $MerchID->item(0)->nodeValue;

        if ($retCode_value != "0") {
            echo "交易返回码" . $retCode_value . "<br>";
            echo "交易错误信息" . $errMsg_value . "<br>";
            exit ();
        }

        return array('merID' => $merID, 'signMsg_value' => $signMsg_value, 'orderUrl_value' => $orderUrl_value);
    }

    public function notify()
    {
        $tranCode = "cb2200_verify";
        $notifyMsg = $_REQUEST ["notifyMsg"];
        $lastIndex = strripos($notifyMsg, "|");
        $signMsg = substr($notifyMsg, $lastIndex + 1); //签名信息
        $srcMsg = substr($notifyMsg, 0, $lastIndex + 1); //原文


        //连接地址
        $fp = stream_socket_client($this->_socketUrl, $errno, $errstr, 30);
        $retMsg = "";

        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $in = "<?xml version='1.0' encoding='UTF-8'?>";
            $in .= "<Message>";
            $in .= "<TranCode>" . $tranCode . "</TranCode>";
            $in .= "<merchantID>" . $this->_merID . "</merchantID>";
            $in .= "<MsgContent>" . $notifyMsg . "</MsgContent>";
            $in .= "</Message>";
            fwrite($fp, $in);
            while (!feof($fp)) {
                $retMsg = $retMsg . fgets($fp, 1024);

            }
            fclose($fp);
        }

        //解析返回xml
        $dom = new DOMDocument ();
        $dom->loadXML($retMsg);

        $retCode = $dom->getElementsByTagName('retCode');
        $retCode_value = $retCode->item(0)->nodeValue;

        $errMsg = $dom->getElementsByTagName('errMsg');
        $errMsg_value = $errMsg->item(0)->nodeValue;

        if ($retCode_value != '0') {
            $message = "retcode：" . $retCode_value . "msg：" . $errMsg_value;

            return array('status' => false, 'message' => $message);
        } else {
            $arr = preg_split("/\|{1,}/", $srcMsg);
            return array('status' => true, 'data' => $arr);
        }

    }

}