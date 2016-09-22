<?php
class StockController extends NodeController{
    
    static $service;
    
    public function addStock(){
        
        $buySer=new BuyService();
        $suppliersSer=new SuppliersService();
        $suppliers=$suppliersSer->getSuppliers();
        
        $goods= $buySer->getGoodsBySKU($_GET['sku']);
        $this->view()->assign('suppliers',$suppliers);
        $this->view()->assign('goods',$goods);
        $this->view()->display("file:stock/stock.tpl");
    }
 
    //采购列表
    public function listing(){
       $rs= self::getService()->getStockByPage($_GET['p']);
       $this->view()->assign('rs',$rs['data']);
       $this->view()->assign('num',$rs['page']);
       $this->view()->display('file:stock/listing.tpl');
    }
    
    public function getStockBySKU(){
        $rs= self::getService()->getStockBySKU($_GET['p'], $_GET['sku']);
       
        $this->view()->assign('rs',$rs['data']);
        $this->view()->assign('num',$rs['page']);
        $this->view()->display('file:stock/listing.tpl');
    }
    
    public function removeById(){
       $rs=self::getService()->removeStockById($_POST['id'],$this->_user_global['real_name']);   
       $this->sendNotice($rs['message'],null,$rs['status']); 
      }
    
    public function subStock(){

       $stockSer=new StockService();
       $rs= $stockSer->addStock($_POST, $this->_user_global['uid']);
       $this->sendNotice($rs['message'],null,$rs['status']); 
    }
    
    public static function getService(){
        if (self::$service==null){
            self::$service=new StockService();
        }
        return self::$service;
    }
    
}