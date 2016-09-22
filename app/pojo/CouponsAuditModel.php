<?php 
class CouponsAuditModel extends Db{
    
    protected $_coupons_audit = 'w_coupons_audit'; //日结算
    
    
    public function getLastAudit() {
    
        $sql = "select * from $this->_coupons_audit ORDER BY add_time DESC LIMIT 1";
        return $this->fetch ( $sql );
    }
    
    
    public function getAuditById($id){
        return $this->getOne($this->_coupons_audit,array('id'=>$id));
    }
    
    public function getLastAuditById($id) {
    
        $sql = "select * from $this->_coupons_audit WHERE id<$id ORDER BY add_time DESC LIMIT 1";
        return $this->fetch ( $sql );
    }
    
    public function getAudit($limit = 30) {
        return $this->getAll ( $this->_coupons_audit, null, null, 'id DESC', $limit );
    }
    
    /**
     * 新增结算记录
     */
    public function addAudit($params) {
        $this->add ( $this->_coupons_audit, $params );
        return $this->lastInsertId ();
    }
    
    
    /**
     * 
     * @return CouponsAuditModel
     */
    public static function instance(){
        return parent::_instance(__CLASS__);
    }
    
}

?>