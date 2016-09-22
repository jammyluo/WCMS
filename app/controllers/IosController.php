<?php

class IosController extends Action
{

    static $service;

    /**
     * ios接口
     */
    public function login()
    {
        $rs = self::getService()->login($_POST);
        if (!empty($rs['data'])) {
            self::getLogService()->add($rs['data']['real_name'], "ios登陆");
        }
        //json
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    /**
     * ios注册
     */
    public function register(){
        $memberSer=new MemberService();
        $rs=$memberSer->onMobileRegisterUser($_POST);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    //注册时的获得验证短信
    public function getCheckMsg(){
        $rs = self::getService()->setCheckMsg($_GET['phone']);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    /**
     * 验证短信是否正确
     */
    public function isCheckMsg(){
        $rs = self::getService()->isCheckMsg($_GET);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    //获取用户信息
    public function getUserByToken()
    {
        $rs= self::getService()->getUserByToken($_GET['token']);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    //更改用户信息
    public function alterUserInfo(){
        $post = json_decode($_POST,true);
        if(!is_array($post)){
            $this->sendNotice("传值非json",'',"false");
        }
        $uid = self::getService()->getUidByToken($post['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->alterUserInfo($uid['data'],$post['data']);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    //获取货物信息
    public function getGoodsByCid(){

        $rs=self::getService()->getUserByToken($_GET['token']);

        if(!$rs['status']){
            $this->sendNotice($rs['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }

        $buySer=new BuyService();
        $rs=$buySer->getGoodsByCid($_GET['p'],$_GET['cid']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }

    //获取产品明细信息
    public function getDetailBysku(){
        $rs=self::getService()->getUserByToken($_GET['token']);
        if(!$rs['status']){
            $this->sendNotice($rs['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }

        $buySer = new BuyService();
        $rs = $buySer->getDetailBysku($_GET['sku']);
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    //获取用户订单信息
    public function getOrderByToken(){

    	$uid = self::getService()->getUidByToken($_GET['token']);
    	
    	if(!$uid['status']){
    		$this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
    	}
    	$orderService = new OrderService();
    	$rs = $orderService->getUserOrder($uid['data'], $_GET['p']);
    	$this->sendNotice($uid['message'],$rs['list'],$uid['status']);
//    	var_dump($rs);
    }

    //添加订单
    public function addOrderByToken(){
        $data = json_decode($_POST,true);

        $uid = self::getService()->getUidByToken($data['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }

        $buySer = new BuyService();
        $rs = $buySer->addMobileOrder($uid['data'], $data);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    //充值
    public function recharge(){
        $rs = self::getService()->recharge($_POST);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }

    //各种测试
    public function testIndex(){
        $this->view()->display('file:ios/index.tpl');
    }

    //获取订单信息
    public function getCouponsByToken(){
    	
        $uid = self::getService()->getUidByToken($_GET['token']);
    	
    	if(!$uid['status']){
    		$this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
    	}
    	$couponService = new CouponsService();
    	$rs = $couponService->listing($_GET['p'], array('uid' => $uid['data']));
    	$this->sendNotice($uid['message'],$rs['list'],$uid['status']);
    }

    /**
     * 头像上传
     */
    public function headUpload(){
        $uid = self::getService()->getUidByToken($_POST['token']);

        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        if(empty($_POST['file'])){
            $this->sendNotice('未能接收到图片','',false);
        }
        $rs = self::getService()->headUpload($_POST,$uid);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 根据产品名搜索
     */
    public function searchByTitle(){
        $user = self::getService()->getUserByToken($_GET['token']);
        $rs = self::getService()->searchByTitle($_GET, $user['data']['real_name']);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 1、发送推荐产品,get是相对请求端而言
     * 2、首页面轮播图
     * 3、商品分类列表
     */
    public function getRecommend(){
        $rs = self::getService()->getRecommend();
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 修改密码
     */
    public function changePwd(){
        $uid = self::getService()->getUidByToken($_POST['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->changePwd($_POST,$uid['data']);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 收货地址列表
     */
    public function addressList(){
        $uid = self::getService()->getUidByToken($_GET['token']);

        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->addressList($uid['data']);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 添加收货地址
     */
    public function addAddress(){
        $uid = self::getService()->getUidByToken($_GET['token']);
        $user= self::getService()->getUserByToken($_GET['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->addAddress($uid['data'], $user, urldecode($_GET['address']));
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    /**
     * 修改收货地址
     */
    public function alterAddress(){
        $uid = self::getService()->getUidByToken($_GET['token']);

        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->alterAddress($_GET['id'], urldecode($_GET['address']));
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    //修改性别
    public function setSex(){
        $uid = self::getService()->getUidByToken($_GET['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->setSex($_GET['sex'],$uid['data']);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }

    //确认收货
    public function confirmReceive(){
        $uid = self::getService()->getUidByToken($_GET['token']);
        if(!$uid['status']){
            $this->sendNotice($uid['message'], array(array('id'=>1,'name'=>"没有权限 no.0001")), false);
            exit();
        }
        $rs = self::getService()->confirmReceive($_GET['orderno']);
        $this->sendNotice($rs['message'], $rs['list'], $rs['status']);
    }



    public static function getService()
    {
        if (self::$service == null) {

            self::$service = new IOSService();
        }
        return self::$service;

    }

}