<?php 
class OrderinfoController extends NodeController{
    
    
    static $service;
    
    //销售表
    public function salesChart(){

        $lastMoth = strtotime("-1 month");
        $this->view()->assign("time", array(
            'lastmonth' => date("Y.m.d", $lastMoth),
            'now' => date("Y.m.d", time())
        ));
        
        //当前库存总数
        $buySer=new BuyService();
        $currentStock=$buySer->getStockNum();
        //销售
        $salesNum=self::getService()->getSalesNumByDate(0);
        
        //入库数量
        $stockSer=new StockService();
        $purchase=$stockSer->getStockNum(0);
        
        //产品销售总额
        $currentSales=$buySer->getSalesNum();
        
        $this->view()->assign('rs',array('currentstock'=>$currentStock,'currentsales'=>$currentSales,'salesnum'=>$salesNum,'purchase'=>$purchase));
        
        $this->view()->display("file:order/export.tpl");
    }


    //导出已经发货的订单
    public function getGoodsMxByDate(){

        self::getService()->getGoodsMXByDate($_GET['starttime'],$_GET['endtime']);

    }
    
    
    /* 获取订单详情 */
    public function mx()
    {
        $this->getOrderInfoBySNO();
        $this->view()->display('file:order/mx.tpl'); /* 产品详情页 */
    }
    
    private function getOrderInfoBySNO(){
        $goods = self::getService()->getOrderInfoBySNO($_GET['sno']);
        /* 订单明细 */
        $orderSer=new OrderService();
        $order =$orderSer->getOrderByOrderno($_GET['sno']);
        
        //操作明细
        $orderHisotrySer=new OrderHistoryService();
        $history=$orderHisotrySer->getHistoryByOrderno($_GET['sno']);
        
        $this->view()->assign('history',$history);
        $this->view()->assign('order', $order);
        $this->view()->assign('goods', $goods);
    }
    //仓库获取订单明细
    public function outbound(){
        $this->getOrderInfoBySNO();
        $this->view()->display('file:order/outbound.tpl'); /* 产品详情页 */
    }
    
    //增加打印记录
    public function p(){
        $orderHistory=new OrderHistoryService();
        $orderHistory->addHistory($_POST['orderno'], $this->_user_global['real_name'], "打印订单");
        
    }
    
    
    public function getOrderInfoByStatus(){  
        self::getService()->export($_GET['status']);
    }    
    
    public function getOrderInfoBySKU(){
        self::getService()->exportBySKU($_GET['sku']);
    }
    
    public function getGoodsByDate(){
        self::getService()->getGoodsByDate($_GET['starttime'],$_GET['endtime']);
    }

  public static function getService(){
      if (self::$service==null){
          self::$service=new OrderInfoService();
      }
      return self::$service;
  }
}

?>