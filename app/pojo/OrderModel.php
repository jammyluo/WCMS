<?php
class OrderModel extends Db {
	protected $_order_list = 'w_order_list'; /*订单列表*/
	protected $_order_info = 'w_order_info'; /*订单信息*/
	
	
	/**
	 * 获取产品信息
	 * @param unknown_type $orderno
	 */
	public function getGoodsInfo($orderno) {
		$sql = "select a.*,b.image thumb from w_order_info a LEFT JOIN w_news_goods b ON a.goods_id=b.sku WHERE a.orderno='$orderno'";
		return $this->fetchAll ( $sql );
	}
	
	
	public function tjOrderByDate($limit){
	    $sql="select count(id) num,sum(coupons) money,from_unixtime(addtime,\"%Y-%m-%d\") m from w_order_list where status>0  group by m order by m desc limit $limit";
	    return $this->fetchAll($sql);
	}
	
	public function getOrderLikeOrderno($orderno){
	    $sql="SELECT * FROM $this->_order_list WHERE orderno like '%$orderno%' LIMIT 20";
	    return $this->fetchAll($sql);
	}
	
	public function getOrderLikeShr($shr){
	    $sql="SELECT * FROM $this->_order_list WHERE shr like '%$shr%' LIMIT 20";
	    return $this->fetchAll($sql);
	}


	/**
	 * 修改订单状态
	 * Enter description here ...
	 * @param unknown_type $v
	 * @param unknown_type $where
	 */
	public function saveOrderByOrderno($v,$orderno) {
		return $this->update ( $this->_order_list, $v, array('orderno'=>$orderno) );
	}

	/**
	 * 订单列表
	 *
	 * @param array $where
	 * contentId
	 */
	public function getOrderPageByUid($start,$num,$uid) {
		return $this->getPage($start, $num, $this->_order_list,null,array('uid'=>$uid),'id DESC');
	}
	
	public function getOrderPageByStatus($start,$num,$status){
	    return $this->getPage($start, $num, $this->_order_list,null,array('status'=>$status),'action_time ASC');     
	}
	/*单号*/
	public function getOrderByWhere($where) {
		return $this->getAll ( $this->_order_list, $where,null,'id DESC' );
	}
	/**
	 * 获取订单数量
	 * Enter description here ...
	 * @param unknown_type $key
	 * @param unknown_type $where
	 */
	public function getOrderTotalNum($where) {
	    return $this->getNum($this->_order_list, 'id',$where);
	}
	/**
	 * 添加订单
	 *
	 * @param unknown_type $params
	 */
	public function addOrder($params) {
		$this->add ( $this->_order_list, $params );
		return $this->lastInsertId ();
	}
	/**
	 * 添加订单详情
	 * @param unknown_type $params
	 */
	public function addGoods($params) {
		return $this->add ( $this->_order_info, $params );
	}
	/**
	 * 删除产品
	 * Enter description here ...
	 * @param unknown_type $where
	 */
	public function removeGoods($where) {
		return $this->delete ( $this->_order_info, $where );
	}
	/**
	 * 获取订单中某个产品信息
	 * Enter description here ...
	 * @param unknown_type $where
	 */
	public function getOrderInfo($where) {
		return $this->getOne ( $this->_order_info, $where );
	}
	/**
	 * 统计订单格式
	 */
	public function countOrder($where) {
	return $this->getNum($this->_order_list, 'id',$where);
	}
	/**
	 * 返回OrderModel
	 * @return OrderModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}