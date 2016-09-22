<?php

/**
 * 订单处理服务类
 * Enter description here ...
 * @author Administrator
 *
 */
class CouponsService
{

    protected $shxx = array();
    // 获取收货信息
    protected $user = array();
    // 以下三个参数对应的是积分记录 而不是订单
    private $_chargeType = array(
        "充值" => 0,
        "消费" => 1,
        "赠送" => 2,
        "转账" => 3,
        "退款" => 4,
        "网银"=>5,
    );

    private $_payment = array(
        "收入" => 0,
        "支出" => 1
    );

    private $_status = array(
        "等待付款" => 1,
        "成功" => 8,
        "关闭" => - 1
    );

    private $_num = 20;

    /**
     * 产品类型 由系统检查而不是用户提交
     *
     * @var unknown_type
     */
    private $_goodstype = array(
        "coupons",
        "money"
    );

    public function getChargeTypes()
    {
        return $this->_chargeType;
    }

    //总收入和总支出
    public function audit()
    {
        $userCoupons = MemberModel::instance()->getSumCouponsMember();
        // 获取期初余额
        $audit = CouponsAuditModel::instance()->getLastAudit();
        // 获取支出
        $startTime = empty($audit['add_time']) ? 0 : $audit['add_time'];
        $spend = CouponsModel::instance()->getSpendByTime($startTime, time());
        $income = CouponsModel::instance()->getIncomeByTime($startTime, time());
        $beginning = empty($audit['ending']) ? 0 : $audit['ending'];
        
        $ending = round(($beginning + $income['total'] + $spend['total']), 2);
        $status = round($userCoupons['total'], 2) == $ending;
        
        return array(
            'beginning' => $beginning,
            'status' => $status,
            'spend' => $spend['total'],
            'income' => $income['total'],
            'ending' => $ending
        );
    }


    public function getAllUserCouponsByDate($addTime){
        $addTime=strtotime($addTime." 23:59:59");
        $rs=CouponsModel::instance()->getAllUserCouponsByDate($addTime);
        $this->setCsvHeader(date('Y-m-d',$addTime)."为止用户余额");
        foreach($rs as $v){

            echo implode(",",$v);
            echo "\r\n";

        }
    }

    public function getCouponsGroupByChargetypes($startTime, $endTime){
        
        $startTime = strtotime(str_replace(".", "-", $startTime));
        $endTime = strtotime(str_replace(".", "-", $endTime . " 23:59:59"));
        
       $income=CouponsModel::instance()->getIncomeGroupByChargetypes($startTime, $endTime);
       $spend=CouponsModel::instance()->getSpendGroupByChargeTypes($startTime, $endTime);
       $data= array('income'=>$this->parseChargetypes($income),'spend'=>$this->parseChargetypes($spend));  
       return array('status'=>true,'message'=>"成功",'data'=>$data);  
    }
    
    
    
    private function parseChargetypes($money){
        $rs=array();
        foreach ($money as $k=>$v){
           
            $rs[$v['chargetypes']]=$v['total'];
        }
        
        $newRs=array();
        foreach ($this->_chargeType as $v){
            $value=empty($rs[$v])?0.00:$rs[$v];
            $newRs[$v]=$value; 
        }
       
        return $newRs;  
    }
    /**
     * 转账
     */
    public function transfer($selfuid, $mobile, $money, $remark)
    {
        $memberSer = new MemberService();
        $otherUser = $memberSer->getMemberByMobile($mobile);
        $user = $memberSer->getMemberByUid($selfuid);
        
        if (empty($otherUser)) {
            return array(
                'status' => false,
                'message' => "对方账户不存在!"
            );
        } else {
            
            // 这里建立新的账户
        }
        
        if ($user['groupid'] != 11 || $user['verify'] != 1) {
            return array(
                'status' => false,
                'message' => "你没有转账权限"
            );
        }
        
        if ($otherUser['groupid'] != 12) {
            return array(
                'status' => false,
                'message' => "无法转给对方，非消费者"
            );
        }
        
        $otheruid = $otherUser['uid'];
        
        if ($selfuid == $otheruid) {
            return array(
                'status' => false,
                'message' => "不能给自己转账"
            );
        }
        
        // 减去账户的钱
        $memberSer->saveCoupons($selfuid, $money, 1);
        $selfSNO = $this->getSNO("TRANSFER");
        $otherSNO = $this->getSNO("TRANSFER");
        
        $order = array(
            'sno' => $selfSNO,
            'coupons' => - $money,
            'remark' => $remark,
            'chargetypes' => 3,
            'status' => 8
        );
        $this->reduceCoupons($selfuid, $order);
        
        // 增加钱
        $memberSer->saveCoupons($otheruid, $money, 0);
        
        $otherOrder = array(
            'sno' => $otherSNO,
            'coupons' => $money,
            'remark' => $remark,
            'chargetypes' => 3,
            'status' => 8
        );
        $this->addCoupons($otheruid, $otherOrder);

        //增加转账记录
        $transferSer=new TransferService();
        $transferSer->add(array('orderno'=>$selfSNO,'real_name'=>$user['real_name']),
            array('orderno'=>$otherSNO,'real_name'=>$otherUser['real_name']));

        return array(
            'status' => true,
            'message' => "转账成功"
        );
    }

    /**
     * 退款
     * 
     * @param string $orderno            
     */
    public function refund($orderno)
    {
        $orderSer = new OrderService();
        $order = $orderSer->getOrderByOrderno($orderno);
        $memberSer = new MemberService();
        
        $sno = $this->getSNO("REFUND");
        $backOrder = array(
            'sno' => $sno,
            'status' => 8,
            'chargetypes' => 4,
            'coupons' => $order['coupons'],
            'remark' => $order['name'],
            'transfersno' => $order['orderno']
        );
        $memberSer->saveCoupons($order['uid'], $order['coupons'], 0);
        $this->addCoupons($order['uid'], $backOrder);
    }
    
    // 积分明细列表
    public function listing($p, $where)
    {
        $totalNum = CouponsModel::instance()->countCouponsHisotry($where);
        $page = $this->page($totalNum, $p, $this->_num);
        $detail = CouponsModel::instance()->getCouponsHistoryPage($page['start'], $page['num'], $where);
        return array(
            'list' => $this->matchChargeTypes($detail),
            'page' => $page,
            'totalnum' => $totalNum
        );
    }

    //设置订单状态
    public function status($status, $orderno)
    {
        $status = $status > 0 ? 8 : - 1;
        CouponsModel::instance()->setCouponsStatus(array(
            'status' => $status
        ), array(
            'orderno' => $orderno
        ));
    }

    //获取个人账户总额
    public function getSumCouponsByUid($uid)
    {
        return CouponsModel::instance()->getSumCouponsByUid($uid);
    }

    /**
     * 处理收入还是支出
     *
     * @param unknown_type $order            
     */
    private function matchChargeTypes($order)
    {
        $chargeTypes = array_flip($this->_chargeType);
        $couponsStatus = array_flip($this->_status);
        foreach ($order as $k => $v) {
            $order[$k]['chargetypes'] = $chargeTypes[$v['chargetypes']];
            $order[$k]['status'] = $couponsStatus[$v['status']];
        }
        return $order;
    }

    /**
     * 新增结算 增加结算后的id
     */
    public function setAudit($uid)
    {
        $audit = $this->audit();
        
        if (! $audit['status']) {
            return array(
                'status' => false,
                'message' => "财务异常，无法结算!"
            );
        }
        
        $params = array(
            'beginning' => $audit['beginning'],
            'ending' => $audit['ending'],
            'income' => $audit['income'],
            'spend' => $audit['spend'],
            'add_time' => time(),
            'uid' => $uid
        );
        
        $rs = CouponsAuditModel::instance()->addAudit($params);
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "结算成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "结算失败"
            );
        }
    }
    
    // 收入
    public function addCoupons($uid, $order)
    {
        $memberSer = new MemberService();
        $user = $memberSer->getMemberByUid($uid);
        $order['payment'] = $this->_payment["收入"];
        return $this->addCouponsHistory($user, $order);
    }
    // 支出
    public function reduceCoupons($uid, $order)
    {
        $memberSer = new MemberService();
        $user = $memberSer->getMemberByUid($uid);
        $order['payment'] = $this->_payment["支出"];
        return $this->addCouponsHistory($user, $order);
    }

    /**
     *
     * 扣除用户积分
     *
     * @param unknown_type $coupons            
     * @param unknown_type $uid            
     * @param unknown_type $remark            
     */
    public function addCouponsHistory($user, $order)
    {
        return CouponsModel::instance()->addCouponsHistory($user, $order);
    }

    //更新记录
    public function saveCouponsStatusSuccessByOrderno($remark,$orderno){
        return CouponsModel::instance()->setCouponsStatus(array('status'=>8,'remark'=>$remark,'pay_time'=>time()),array('orderno'=>$orderno));
    }

    //获取网银成功的历史记录
    public function getBankCouponsHistorySuccessByDate($start,$end){
        $startTime=strtotime($start);
        $endTime=strtotime($end." 23:59:59");
        $rs=CouponsModel::instance()->getBankCouponsHistorySuccessByDate($startTime,$endTime);
        $format="%s,%s,%s,%s,%s\r\n";
        echo sprintf($format,"到账时间","客户","金额","幸福豆","备注");
        $this->setCsvHeader("bank");
        foreach ($rs as $v) {
            echo sprintf($format,date("Ymd",$v['pay_time']),$v['username'],$v['money'],$v['coupons'],$v['remark']);
        }


    }

    //订单号
    public function getCouponsHistoryByOrderno($orderno){
        return CouponsModel::instance()->getCouponsHistoryByOrderno($orderno);
    }

    // 转账交易明细接口
    public function getHistoryByTransferSNO($uid, $orderno)
    {

        //这里要做检验的
        $transferSer=new TransferService();
        $rs=$transferSer->getTansferByFromsno($orderno);

        return array(
            'status' => true,
            'data' => $rs,
            'message' => "成功"
        );
    }

    public function import(MemberService $memberService, $remark)
    {
        $filename = $_FILES['file']['tmp_name'];
        if (empty($filename)) {
            return '请选择要导入的CSV文件！';
        }
        
        $handle = fopen($filename, 'r');
        $result = $this->input_csv($handle); // 解析csv
        $len_result = count($result);
        if (! $len_result) {
            return '没有任何数据！';
        }
        $notMatchFile = "";
        $line = "";
        for ($i = 0; $i < $len_result; $i ++) { // 循环获取各字段值
            $name = iconv('GBK', 'UTF-8', $result[$i][0]); // 中文转码
            $coupons = $result[$i][1];
            $user = $memberService->getMemberByUid($name);
            // $user = $memberService->getMemberByWhere ( array ('real_name' => trim ( $name ), 'verify' => 1 ) );
            // 如果没有找到
            $format = "%s,%s,%s";
            if (empty($user)) {
                $line = sprintf($format, $result[$i][0], $coupons, "not found");
                $notMatchFile = $notMatchFile . $line . "\r\n";
                continue;
            }
            
            $memberService->saveCoupons($user['uid'], $coupons, 0);
            $sno = $this->getSNO("BTCZ");
            $order = array(
                'coupons' => $coupons,
                'remark' => $remark,
                'sno' => $sno,
                'status' => 8,
                'chargetypes' => 2
            );
            $this->addCoupons($user['uid'], $order);
        }
        $data_values = substr($data_values, 0, - 1); // 去掉最后一个逗号
        fclose($handle); // 关闭指针
        $this->createCSV($notMatchFile);
        return;
    }

    public function getSNO($prefix)
    {
        $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";
        $max = strlen($code) - 1;
        for ($i = 0; $i < 6; $i ++) {
            $rand = rand(0, $max);
            $str .= $code{$rand};
        }
        
        return $prefix . time() . $str . rand(10000, 99999);
    }

    /**
     * 获取统计帐
     */
    public function getAudit($limit = 20)
    {
        return CouponsAuditModel::instance()->getAudit($limit);
    }

    public function createCSV($content)
    {
        header("Cache-Control: public");
        header("Pragma: public");
        header("Content-type:application/vnd.ms-excel");
        $file = date("md", time());
        header("Content-Disposition:attachment;filename=$file.csv");
        echo $content;
    }

    public function export($start, $end, $payment)
    {
        $startTime = strtotime(str_replace(".", "-", $start));
        $endTime = strtotime(str_replace(".", "-", $end . " 23:59:59"));
        $this->getCouponsByPayment($startTime, $endTime, $payment);  
    }
    
    
    public function exportByAudit($auditId,$payment){
        if ($auditId>0){
        $now=CouponsAuditModel::instance()->getAuditById($auditId);
        $before=CouponsAuditModel::instance()->getLastAuditById($auditId);
        
        }else{
           $now['add_time']=time();
           $before=CouponsAuditModel::instance()->getLastAudit();
        }
        $before['add_time']=empty($before['add_time'])?0:$before['add_time'];
        $this->getCouponsByPayment($before['add_time'], $now['add_time'], $payment);
    }
    

    private function getCouponsByPayment($startTime, $endTime, $pay)
    {
        $payment = array_flip($this->_payment);
        $filename = $payment[$pay];
        $this->setCsvHeader($filename);
        $detail = CouponsModel::instance()->getCouponsByPayment($startTime, $endTime, $pay);
        $downloadtime = date("Y-m-d H:i:s", time());
        
        echo $title = "流水号,充值时间,渠道,名称,客户编号,客户名称,收入,支出,收支,状态";
        echo "\r\n";
        $foramt = "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s";
        
        $chargeType = array_flip($this->_chargeType);
        $status = array_flip($this->_status);
        foreach ($detail as $v) {
            if ($v['payment'] == 1) {
                echo sprintf($foramt, $v['id'], date("Y-m-d H:i:s", $v['date']), $chargeType[$v['chargetypes']], $v['remark'],$v['uid'], $v['username'], "", $v['coupons'], $payment[$v['payment']], $status[$v['status']]);
            } else {
                echo sprintf($foramt, $v['id'], date("Y-m-d H:i:s", $v['date']), $chargeType[$v['chargetypes']], $v['remark'],$v['uid'], $v['username'], $v['coupons'], "", $payment[$v['payment']], $status[$v['status']]);
            }
            echo "\r\n";
        }
    }

    private function setCsvHeader($filename)
    {
        header("Cache-Control: public");
        header("Pragma: public");
        header("Content-type:application/vnd.ms-excel");
        $file = $filename . date("md", time());
        header("Content-Disposition:attachment;filename=$file.csv");
    }

    private function input_csv($handle)
    {
        $out = array();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i ++) {
                $out[$n][$i] = $data[$i];
            }
            $n ++;
        }
        return $out;
    }

    /**
     * 分页
     *
     * @return Array
     */
    private function page($total, $pageid, $num)
    {
        $pageid = isset($pageid) ? $pageid : 1;
        $start = ($pageid - 1) * $num;
        $pagenum = ceil($total / $num);
        /* 修正分类不包含内容 显示404错误 */
        $pagenum = $pagenum == 0 ? 1 : $pagenum;
        /* 如果超过了分类页数 404错误 */
        
        if ($pageid > $pagenum) {
            return false;
        }
        
        $page = array(
            'start' => $start,
            'num' => $num,
            'current' => $pageid,
            'page' => $pagenum
        );
        return $page;
    }
}