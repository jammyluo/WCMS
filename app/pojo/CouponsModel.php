<?php
class CouponsModel extends Db {
	private  $_coupons_history = 'w_coupons_history'; // 操作记录

	/**
	 * 
	 * 更新积分值
	 * @param $user
	 * @param $order
	 */
	public function addCouponsHistory($user,$order) {
	     
		return $this->add ( $this->_coupons_history, array ('uid' => $user['uid'], 'username' => $user['real_name'], 'coupons' => $order['coupons'],'money'=>$order['money'], 'date' => time (), 'payment' => $order['payment'], 'chargetypes' => $order['chargetypes'], 'remark' => $order['remark'], 'orderno' => $order['sno'], 'status' => $order['status'] ,'balance'=>$user['coupons']) );
	}

    //获取成功的网银记录
    public function getBankCouponsHistorySuccessByDate($startTime,$endTime){
$sql="SELECT * FROM $this->_coupons_history WHERE chargetypes=5 AND payment=0 AND status=8 and date>$startTime AND date<$endTime";
        return $this->fetchAll($sql);

    }

	//统计个人总额
	public function getSumCouponsByUid($uid) {
		$sql = "SELECT sum(coupons) total FROM w_coupons_history WHERE uid=$uid AND status=8";
		return $this->fetch ( $sql );
	}

    public function getAllUserCouponsByDate($addTime){
        $sql="select a.username,b.real_name,a.uid,sum(a.coupons) coupons from w_coupons_history a left join w_member_list b on a.uid=b.uid where a.date<=$addTime group by a.uid";
        return $this->fetchAll($sql);
    }

	/**
	 * 更新记录
	 * */
	public function setCouponsStatus($v, $where) {
		return $this->update ( $this->_coupons_history, $v, $where );
	}

	/**
	 * 指定时间支出总额
	 */
	public function getSpendByTime($starttime, $endtime) {
		$sql = "select sum(coupons) total from $this->_coupons_history WHERE payment=1 AND  `date`>=$starttime and `date`<=$endtime AND status=8";
		return $this->fetch ( $sql );
	}
	
	//指定时间收入总额
	public function getIncomeByTime($starttime,$endtime) {
		$sql = "select sum(coupons) total from $this->_coupons_history  WHERE  payment=0 AND `date`>=$starttime AND `date`<=$endtime AND status=8";
		return $this->fetch ( $sql );
	}

	public function getCouponsHistoryPage($start, $num, $where) {
	  return $this->getPage($start, $num, $this->_coupons_history,null,$where,'id DESC');
	}
	
	public function getIncomeGroupByChargetypes($starttime,$endtime){
	    $sql = "select chargetypes,sum(coupons) total from $this->_coupons_history  WHERE  payment=0 AND `date`>=$starttime AND `date`<=$endtime AND status=8 GROUP BY chargetypes";
	    return $this->fetchAll ( $sql );
	}
	
	public function getSpendGroupByChargeTypes($starttime,$endtime){
	    $sql = "select chargetypes,sum(coupons) total from $this->_coupons_history  WHERE  payment=1 AND `date`>=$starttime AND `date`<=$endtime AND status=8 GROUP BY chargetypes";
	    return $this->fetchAll ( $sql );
	}
	
	//统计条数
	public function countCouponsHisotry($where)
    {  
    return    $this->getNum($this->_coupons_history, 'id',$where);
    }

	
	public function getLastSpend($id, $status) {
		$sql = "SELECT sum(coupons) spend FROM $this->_coupons_history WHERE payment=1 AND status=$status AND id>$id";
		return $this->fetch ( $sql );
	}
	
	/**
	 * 获取指定时间交易成功的订单
	 */
	public function getCouponsByPayment($startTime, $endTime, $payment) {
		$sql="SELECT * FROM $this->_coupons_history WHERE payment=$payment AND `date`>$startTime AND `date`<$endTime AND status=8";
		return $this->fetchAll ( $sql );
	}
	
	public function getCouponsHistory($where){
	    return $this->getAll($this->_coupons_history,$where);
	}

    public function getCouponsHistoryByOrderno($orderno){
        return $this->getOne($this->_coupons_history,array('orderno'=>$orderno));
    }
	/**
	 * 返回CouponsModel
	 * @return CouponsModel
	 */
	public static function instance() {
		return self::_instance ( __CLASS__ );
	}
}