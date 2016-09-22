<?php

class SuppliersService
{

    public function addSuppliers($params)
    {
        $rs = SuppliersModel::instance()->addSuppliers($params);
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "添加成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "添加失败"
            );
        }
    }

    public function saveSuppliersNameById($username, $id)
    {
        $rs = SuppliersModel::instance()->saveSuppliersById(array(
            'username' => $username
        ), $id);
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "更新成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "更新失败"
            );
        }
    }

    public function getSuppliersById($id)
    {
        return SuppliersModel::instance()->getSuppliersById($id);
    }

    
    public function getSuppliers()
    {
        return SuppliersModel::instance()->getSuppliers();
    }
    
    
    public function getFinancialBySuppliers($suppliersId){
        return SuppliersFinancialModel::instance()->getFinancialBySuppliers($suppliersId);
    }
    
    /**
     *  最新的结算
     */
    public function getLastFinancialBySuppliers($suppliersId){
        $stockSer=new StockService();
      
        $financial=$this->getLastFinancial($suppliersId,time());
        $add_time=empty($financial['add_time'])?0:$financial['add_time']; 
        
        $rs=  $stockSer->getMoneyBySuppliers($suppliersId, $add_time, time());
        $ret=array();
        $ret['purchase_num']=$rs['num'];
        $ret['beginning']=empty($financial['ending'])?0:$financial['ending'];
        $ret['begin_num']=empty($financial['end_num'])?0:$financial['end_num'];
        $ret['purchase']=$rs['total'];
        $ret['suppliers']=$suppliersId;
        return $ret;
        
    }
    
    
    public function export($suppliersId,$add_time){
        $stockSer=new StockService();
        $financial=$this->getLastFinancial($suppliersId,$add_time);
        $start=empty($financial['add_time'])?0:$financial['add_time'];
        $stockSer->exportBySuppliers($suppliersId, $start, $add_time);
    }
   
    
    /**
     * 添加财务结算记录
     */
    public function addFinancial($params,$uid){
        $params['add_time']=time();
        $params['ending']=$params['beginning']+$params['purchase']-$params['payment'];
       $params['uid']=$uid;
     $rs=SuppliersFinancialModel::instance()->addFinancial($params);
    if ($rs>0){
        return array('status'=>true,'message'=>"结算成功");
    }else{
        return array('status'=>false,'message'=>"结算失败");
    }
    }
    
    /**
     * 获取最后一次结算时间
     */
    private function getLastFinancial($suppliersId,$add_time){
        return SuppliersFinancialModel::instance()->getLastFinancialBySuppliers($suppliersId,$add_time);
    }
    
}



class SuppliersFinancialModel extends Db{
    
     private $_table='w_suppliers_financial';
     
     public function getFinancialBySuppliers($suppliers){
         return $this->getAll($this->_table,array('suppliers'=>$suppliers));
     }
     
     public function getLastFinancialBySuppliers($suppliers,$add_time){
         $sql="SELECT * FROM $this->_table WHERE suppliers=$suppliers AND add_time<$add_time ORDER BY add_time DESC LIMIT 1";
         return $this->fetch($sql);
     }
    
     public function addFinancial($params){
         return $this->add($this->_table, $params);
     }
     
     /**
      * 
      * @return SuppliersFinancialModel
      */
     public static function instance(){
         return SuppliersFinancialModel::_instance(__CLASS__);
     }
}


class SuppliersModel extends Db
{

    private $_table = 'w_suppliers';


    
    public function saveSuppliersById($v, $id)
    {
        return $this->update($this->_table, $v, array(
            'id' => $id
        ));
    }

    public function addSuppliers($params)
    {
        return $this->add($this->_table, $params);
    }

    public function getSuppliersById($id)
    {
        return $this->getOne($this->_table, array(
            'id' => $id
        ));
    }

    public function getSuppliers()
    {
        return $this->getAll($this->_table);
    }

    /**
     *
     * @return SuppliersModel
     */
    public static function instance()
    {
        return parent::_instance(__CLASS__);
    }
}