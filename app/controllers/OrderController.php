<?php

/**
 * 订单系统  属于半独立系统，权限方面不考虑
 * 2013-2-27
 * @author wolf Email: 116311316@qq.com
 *
 */
class OrderController extends NodeController
{
    private $_pageNum = 20;
 // 分页订单显示条数
    static $orderService;
    
    // 添加订单 采用了cookie
    public function add()
    {

        $rs = self::getOrderService()->createOrder($this->_user_global['uid'],$_POST);

        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function cart()
    {

        //token
        $token=self::getOrderService()->getSNO();
        $_SESSION[$token]=true;
        $this->view()->assign('token',$token);
        // 刷新购物车
        $buy = new BuyService();
        $buy->_cookie = 'wcart';
        $rs = $buy->getCart(1);

        self::getLogService()->add($this->_user_global['real_name'], "查看购物车");
        
        $total = $rs['money1'] + $rs['money2'];
        $this->view()->assign("goods", $rs['goods']);
        $this->view()->assign("totalcount", $total);
        
        $this->view()->display("mysql:buycart.tpl");
    }


    public function statChart(){
        $rs=self::getOrderService()->tjOrderByDate();
        $this->view()->assign('rs',$rs);
        $this->view()->display('file:order/stat.tpl');
    }
    


    /**
     * 订单列表
     * Enter description here .
     * ..
     */
    public function listing()
    {
        // 默认设置为15条
        $rs = self::getOrderService()->listing($_GET['p'],$_GET['value']);
        
        $this->view()->assign('num', $rs['page']);
        
        $this->view()->assign('current',$_GET['value']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('news', $rs['list']);
        $this->view()->assign('status', $rs['status']);
        $this->view()->display('file:order/olist.tpl');
    }
    
    
    /**
     * 工厂
     */
    public function factory()
    {
        // 默认设置为15条
        $rs = self::getOrderService()->listing($_GET['p'], $_GET['value']);
    
        $this->view()->assign('num', $rs['page']);
        $this->view()->assign('current',$_GET['value']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('news', $rs['list']);
        $this->view()->assign('status', $rs['status']);
        $this->view()->display('file:order/factory.tpl');
    }

    /**
     * 修改订单状态 和积分状态 ok
     */
    public function setStatus()
    {
        $rs = self::getOrderService()->status($_POST['orderno'], $_POST['status'],$this->_user_global['real_name']);
        $this->sendNotice($rs);
    }
    
    
    public function setRemarkByOrderno(){
        $rs=self::getOrderService()->setRemarkByOrderno($_POST['remark'], $_POST['orderno'],$this->_user_global['real_name']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
        
    }

    /**
     * 前端用户订单列表
     */
    public function trade()
    {
        $rs = self::getOrderService()->getUserOrder($this->_user_global['uid'], $_GET['p']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('num', $rs['page']);
        $this->view()->assign('userinfo', $this->_user_global);
        $this->view()->assign("order", $rs['list']);
        $this->view()->display("file:order/trade.tpl");
    }
    
    // 前段产品搜索
    public function find()
    {
        $recommed = self::getOrderService()->getSalesTopGoods();
        $this->view()->assign('recommend', $recommed);
        $rs = self::getOrderService()->search($_GET['title']);
        $title = urldecode($_GET['title']);
        self::getLogService()->add($this->_user_global['real_name'], "搜索$title");
        $page = array(
            'num' => 50,
            'current' => 1,
            'page' => 1
        );
        $this->view()->assign('num', $page);
        $this->view()->assign('goods', $rs);
        $this->view()->display("file:order/img.tpl");
    }

    /**
     * 订单查询
     */
    public function search()
    {
      $this->searchOrder();
        $this->view()->display('file:order/olist.tpl');
    }

    private function searchOrder(){
        $rs = self::getOrderService()->search($_POST['type'], $_POST['value']);
        $this->view()->assign('num', array(
            'num' => 20,
            'current' => 1,
            'page' => 1
        ));
        $this->view()->assign('value',urldecode($_POST['value']));
        $this->view()->assign('totalnum', 1);
        $this->view()->assign('news', $rs);
    }
    
    /**
     * 订单查询
     */
    public function factorySearch()
    {
        $this->searchOrder();
        $this->view()->display('file:order/factory.tpl');
    }


    /**
     * 获取服务累
     * Enter description here .
     * ..
     */
    public static function getOrderService()
    {
        if (self::$orderService == null) {
            self::$orderService = new OrderService();
        }
        return self::$orderService;
    }
}