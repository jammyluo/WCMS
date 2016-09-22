<?php
//订单操作历史记录 
class OrderHistoryService{
    
    
    public function getHistoryByOrderno($orderno){
        return OrderHistoryModel::instance()->getHistoryByOrderno($orderno);
    }
    
    public function addHistory($orderno,$actionName,$remark){
        $params=array('orderno'=>$orderno,'action_name'=>$actionName,'remark'=>$remark,'action_time'=>time());
        return OrderHistoryModel::instance()->addHistory($params);
    }
    
    
}

class OrderHistoryModel extends Db{
    
    protected $_order_history = 'w_order_history'; /*操作历史记录*/
    
    
    /**
     * 获取历史记录
     * @param unknown_type $where
     */
    public function getHistoryByOrderno($orderno) {
        return $this->getAll ( $this->_order_history, array('orderno'=>$orderno) ,null,'id DESC');
    }
   
    /**
     * 添加历史记录
     * Enter description here ...
     * @param unknown_type $params
     */
    public function addHistory($params) {
     return $this->add($this->_order_history, $params);
    }
    
    
    
    /**
     * 
     * @return OrderHistoryModel
     */
    public static function instance(){
        return parent::_instance(__CLASS__);
    }
}
?>