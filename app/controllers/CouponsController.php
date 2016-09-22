<?php

class CouponsController extends NodeController
{

    static $couponsService;

    static $memberService;

    /**
     * 审计列表
     */
    public function audit ()
    {
        
        // 统计当前用户总账

        $rs = self::getCouponsService()->audit();

        // 获取审计账目 最近30条

        $audit = self::getCouponsService()->getAudit(30);

        

        $lastMoth = strtotime("-1 month");
        $this->view()->assign("time", array(
            'lastmonth' => date("Y.m.d", $lastMoth),
            'now' => date("Y.m.d", time())
        ));
        
        $this->view()->assign("now", $rs);
        $this->view()->assign('audit', $audit);
        $this->view()->display('file:coupons/audit.tpl');
    }
    
    public function getCouponsGroupByChargetypes(){
        // 统计当前用户总账
        $rs = self::getCouponsService()->getCouponsGroupByChargetypes($_GET['starttime'],$_GET['endtime']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }
    
    //转账
    public function transfer(){
       
        $this->view()->display('file:coupons/transfer.tpl');
    }
    
    
    //提交转账申请
    public function  subTransfer(){
    $rs= self::getCouponsService()->transfer($this->_user_global['uid'],$_POST['mobile'], $_POST['money'], $_POST['remark']);
    $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }
    /**
     * 提交审计
     * Enter description here .
     * ..
     */
    public function setAudit ()
    {
        $rs = self::getCouponsService()->setAudit($this->_user_global['uid']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }

    /**
     * 导出明细
     */
    public function export ()
    {
       self::getCouponsService()->export($_POST['starttime'], $_POST['endtime'], $_POST['payment']);
    }
    
    public function exportByAudit(){
        self::getCouponsService()->exportByAudit($_GET['auditId'], $_GET['payment']);
    }
    
    // 充值明细 全部的数据
    public function listing ()
    {
        // 默认设置为15条
        $rs = self::getCouponsService()->listing($_GET['p'], null);
        $this->view()->assign('num', $rs['page']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        
       
        $this->view()->assign("mx", $rs['list']);
        $this->view()->display("file:coupons/list.tpl");
    }
    /*
     * 后台用户积分明细
     */
    public function user ()
    {
        $rs = self::getCouponsService()->listing($_GET['p'], array(
            'uid' => $_GET['uid']
        ));
        $user = self::getMemberService()->getMemberByUid($_GET['uid']);
        $total = self::getCouponsService()->getSumCouponsByUid($_GET[uid]);
        $this->view()->assign("userinfo", $user);
        $this->view()->assign("num", $rs['page']);
        $this->view()->assign('total', $total['total']);
        $this->view()->assign("uid", $_GET['uid']);
        $this->view()->assign("mx", $rs['list']);
        $this->view()->display("file:coupons/mx.tpl");
    }

    /**
     * 导入代码
     * Enter description here .
     * ..
     */
    public function import ()
    {
        echo self::getCouponsService()->import(self::getMemberService(), $_POST['remark']);
    }

    
    public function charge(){
    
        $this->view()->display("file:coupons/charge.tpl");
    }
    /**
     * 增加积分
     */
    public function addCoupons ()
    {
        $uid = $_POST['uid'];
        $coupons = trim($_POST['coupons']);
        $remark = trim($_POST['remark']);

        $id=self::getMemberService()->saveCoupons($uid, $coupons, 0);
        if ($id>0){
            $sno=self::getCouponsService()->getSNO("CZ");
            $order=array('sno'=>$sno,'coupons'=>$coupons,'remark'=>$remark,'status'=>8,'chargetypes'=>$_POST['chargetypes']);
            self::getCouponsService()->addCoupons($uid, $order);
            $rs=array('status'=>true,'message'=>"充值成功!");
        }else{
            $rs= array('status'=>false,'message'=>"充值失败！");
        }
        
       $this->sendNotice($rs['message'],$rs['data'],$rs['status']);

    }
    /*
     * 导入积分
     */
    public function csv ()
    {
        $this->view()->display("file:coupons/csv.tpl");
    }

    public function verify ()
    {
        self::getCouponsService()->verify();
    }

    
    /**
     * 根据转账单号查询
     */
    public function gethistorybytransfersno(){
        
        $rs=self::getCouponsService()->getHistoryByTransferSNO($this->_user_global['uid'],$_GET['orderno']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }

    public function getAllUserCouponsByDate(){
        self::getCouponsService()->getAllUserCouponsByDate($_GET['date']);
    }

    //获取网银充值记录
    public function getBankCouponsHistorySuccessByDate(){
        self::getCouponsService()->getBankCouponsHistorySuccessByDate($_GET['start'],$_GET['end']);
    }
    /**
     * 用户前端查询
     */
    public function coupons ()
    {
        $user = $this->_user_global;
        $rs = self::getCouponsService()->listing($_GET['p'], array(
            'uid' => $user['uid']
        ));
        $this->view()->assign("mx", $rs['list']);
        $this->view()->assign('userinfo', $user);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('num', $rs['page']);
        $this->view()->display("file:coupons/coupons.tpl");
    }

    public static function getMemberService ()
    {
        if (self::$memberService == null) {
            self::$memberService = new MemberService();
        }
        return self::$memberService;
    }

    public static function getCouponsService ()
    {
        if (self::$couponsService == null) {
            self::$couponsService = new CouponsService();
        }
        return self::$couponsService;
    }
}