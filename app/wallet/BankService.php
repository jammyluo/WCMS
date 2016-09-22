<?php

class BankService
{
    //常用银行设置
    private $_bank = array('BOCOM' => '交行', 'ICBC' => '工行', 'CCB' => '建行',
        'ABC' => '农行', 'CMB' => '招行', 'PSBC' => '邮政', 'BOCSH' => '中行',
        'CMBC' => "民生银行", 'CNCB' => "中信银行", 'CIB' => "兴业银行", 'CEB' => "光大银行",
        'GDB' => "广发银行", 'OTHERS' => "银联");
    public $_chargetypes = 5; //网银充值
    private $_orderno = 'BANK';//订单号前缀
    private $_cardType = array(0 => '借记卡', 1 => '准贷记卡', 2 => '贷记卡',
        3 => '他行银联卡');

    public function getBank()
    {
        return $this->_bank;
    }

    public function pay($uid, $order)
    {
        $bankService = new BCService();
        if (empty($order['bankId'])) {
            echo "请先选择银行";
            exit();
        }
        $memberSer=new MemberService();
        $user = $memberSer->getMemberByUid($uid);
        $order['content'] = "客户" . $user['real_name'];
        //生成订单
        $order['amount'] = $order['money1'];
        $order['money1'] = $order['amount'];
        $order['date'] = date("Ymd", time());
        $order['time'] = date("His", time());
        $order['orderno'] = $this->crateSNO();

        //创建订单
        $rs = $this->createChargeOrder($user, $order);

        if (!$rs['status']) {
            echo $rs['message'];
            exit();
        }
        $bankService->pay($uid, $order);
    }




    private function crateSNO()
    {
        $time = time();
        $sno = date("ymdHis", $time);
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $prefix = '';
        for ($i = 0; $i < 4; $i++) {
            $rand = rand(0, 33);
            $prefix .= $string{$rand};
        }
        return $this->_orderno . $sno . $prefix;

    }

    public function notify()
    {
        $bankService = new BCService();
        $rs = $bankService->notify();
        if (!$rs['status']) {
            $this->saveLog($rs['message']);
            exit();
        }
        $account = new CouponsService();

        //设置交易成功
        if ($rs['data'][9] == 1) {
            $orderno = $rs['data'][1];
            $remark = $rs['data'][8]; //交易流水号
            $cardtype = $rs['data'][11]; //银行卡类型
            $as = $account->getCouponsHistoryByOrderno($orderno);

            if($as['status']!=1){
                return;
            }

            $beizhu = $as['remark'] . "," . $remark . "," . $cardtype;

            $account->saveCouponsStatusSuccessByOrderno($beizhu,$orderno);
            //增加金额
            $memberSer=new MemberService();
            $memberSer->saveCoupons($as['uid'],$as['coupons'],0);
            exit();
        } else {
            $this->saveLog($rs['data']['1'] . "交易失败");
        }
    }

    private function saveLog($string)
    {
        $handle = fopen(ROOT . "/log/bank.log", "a+");
        $string = date("Ymd H:i:s", time()) . "#" . $string . "\r\n";
        fwrite($handle, $string);
        fclose($handle);
    }

    //生成订单
    public function createChargeOrder($user, $order)
    {

        $couponsSer=new CouponsService();

        //幸福豆和钱的比例转换
        $coupons=$order['money1']*5;
        $params=array('sno'=>$order['orderno'],'chargetypes'=>5,"payment"=>0,"status"=>1,"coupons"=>$coupons,'money'=>$order['money1'],'remark'=>$this->_bank[$order['bankId']]);
        $couponsSer->addCouponsHistory($user,$params);
        return array('status'=>true,'message'=>"成功");

    }
}