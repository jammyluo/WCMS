<?php
class SuppliersController extends NodeController{
    
    static $service;
    
    public function add(){
        
        $this->view()->display("file:suppliers/add.tpl");
    }
    
    
    public function save(){
        $suppliersSer=new SuppliersService();
        $rs=$suppliersSer->saveSuppliersNameById($_POST['username'], $_POST['id']);
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
        
    }
    
    
    public function export(){
        self::getService()->export($_GET['suppliers'],$_GET['add_time']);
    }
    
    public function audit(){

        $now=self::getService()->getLastFinancialBySuppliers($_GET['suppliers']);
        
       $rs= self::getService()->getFinancialBySuppliers($_GET['suppliers']);
       $this->view()->assign('now',$now);
       $this->view()->assign('rs',$rs);
       $this->view()->display("file:suppliers/audit.tpl");
    }
    
    public function subaudit(){
      $rs=  self::getService()->addFinancial($_POST,$this->_user_global['uid']);
      $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
      
    }
   
    
    public function listing(){
        $suppliersSer=new SuppliersService();
        
        $suppliers=$suppliersSer->getSuppliers();
        $this->view()->assign('suppliers',$suppliers);
        $this->view()->display('file:suppliers/list.tpl');
        
    }
    
    public function addsuppliers(){
        $suppliersSer=new SuppliersService();
       $rs= $suppliersSer->addSuppliers($_POST);
       $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }
    
    public static function getService(){
        if (self::$service==null){
            self::$service=new SuppliersService();
        }
        return self::$service;
    }
    
}