<?php
/**
 *
 * 发货短信脚本 定时发送
 * Created by PhpStorm.
 * User: wolf
 * Date: 16/5/4
 * Time: 上午11:24
 */

class SmsService
{

    /**
     * 需要向云盘网申请
     * @var string
     */
    private $_apiKey="";

    private $_ch;

//    public function __construct()
//    {
//
//        $this->_ch = curl_init();
//        /* 设置验证方式 */
//
//        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
//
//        /* 设置返回结果为流 */
//        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
//
//        /* 设置超时时间*/
//        curl_setopt($this->_ch, CURLOPT_TIMEOUT, 10);
//
//        /* 设置通信方式 */
//        curl_setopt($this->_ch, CURLOPT_POST, 1);
//        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
//    }


    /**
     *
     * @license 添加短信
     * @param string $info 要添加的信息
     * @param string $type 添加信息类型
     * @param string $model 信息对应的云片模板
     * @param string $tpl_id 模板id
     */
    public function add($info,$model, $tpl_id)
    {
        $sms = new SMSCenter();

        if(isset($tpl_id)){
            $sms->setTpl_id($tpl_id);
        }
        return $sms->sendMessage($info['mobile_phone'], $info['message'], $model);
    }

    //先获取未发货的数据  然后批量发送 然后更新订单状态
    function deliver(){

        $erp=new ERPService();
        $rs=$erp->getWaitSMSOrder();

        $member = new MemberService();
        $orderService=new BuyOrderService();

        foreach($rs as $k=>$v) {
            $user = $member->getMemberByUid($v['uid']);

            if (empty($user['mobile_phone'])) {
                continue;
            }

            //发送短信
            $status=$this->sendDeliver($v['name'],$user['mobile_phone']);

            $erp=$v['erp'];

            if($status) {
                $orderService->setOrderByOrderSNO(
                    array('status' => 4, 'action_time' => time(),
                        'deliver_time' => strtotime($erp['fhrq'])), $v['orderno']);
            }
        }

        curl_close($this->_ch);
    }

    /**
     * @param $tpl_id  云片网模板id
     * @param $groupid  用户组id
     */
    function notice($tpl_id,$groupid){


        if(empty($tpl_id)){
            return;
        }

        $rs= MemberModel::instance()->getMemberByWhere(array('groupid'=>$groupid,'status'=>0,'verify'=>1),null,null,5000);

        foreach($rs as $k=>$v) {

            if (empty($v['mobile_phone'])) {
                continue;
            }

            //发送短信
            $status=$this->sendNotice($tpl_id,$v['mobile_phone']);
        }

        curl_close($this->_ch);
    }


    /**
     * 通知类短信模板 无参数传递 批量
     * @param $tpl_id
     * @param $mobile
     * @return bool
     */
    private function sendNotice($tpl_id,$mobile)
    {
        $data = array('tpl_id' => $tpl_id, 'apikey' => $this->_apiKey, 'mobile' => $mobile);
        $json_data =$this->tpl_send($this->_ch, $data);
        $rs = json_decode($json_data, true);
        if ($rs['code'] === 0) {
            //发送成功
            return true;

        } else {
            //发送失败
            echo    $mobile . "####" . $rs['msg'];
            echo "\r\n";
        }
    }


    /**
     * 发送加盟信息  单条发送
     * @param $mobile
     * @param $username
     * @return bool
     */
    public function sendBusiness($mobile,$date){

        $data = array('tpl_id' => 1317957, 'tpl_value' => ('#date#') . '=' . urlencode($date), 'apikey' => $this->_apiKey, 'mobile' => $mobile);
        $json_data =$this->tpl_send($this->_ch, $data);
        $rs = json_decode($json_data, true);
        curl_close($this->_ch);

        if ($rs['code'] === 0) {

            return true;

        } else {
            $line= $mobile . "####" . $rs['msg'];
            $this->saveLog($line);
           return false;
        }

    }

    /**
     * 发货短信模板
     * @param $goods
     * @param $mobile
     * @return bool
     */
    private function sendDeliver($goods,$mobile)
    {
        $data = array('tpl_id' => 1313825, 'tpl_value' => ('#goods#') . '=' . urlencode($goods), 'apikey' => $this->_apiKey, 'mobile' => $mobile);
        $json_data =$this->tpl_send($this->_ch, $data);
        $rs = json_decode($json_data, true);
        if ($rs['code'] === 0) {
            return true;

        } else {
            $line= $mobile . "####" . $rs['msg'];
            $this->saveLog($line);

        }
    }

    private function saveLog($log){

        $file=ROOT."log".DIRECTORY_SEPARATOR."sms.log";
        $handle=fopen($file,"a");
        $log=date("Y-m-d H:i")."####".$log."\r\n";
        fwrite($handle,$log);
        fclose($handle);
    }

    function tpl_send($ch, $data)
    {
        curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return curl_exec($ch);
    }



    function __destruct()
    {

    }



}

?>