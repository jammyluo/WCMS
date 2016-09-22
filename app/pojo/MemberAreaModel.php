<?php
class MemberAreaModel extends Db {
	
	private $_area = 'd_buy_user';
	
	//添加信息
	public function addUser($params) {
		return $this->add ( $this->_area, $params );
	}
	
	//获取区域
	public function getAreaByUid($uid) {
		return $this->getOne ( $this->_area, array ('uid' => $uid ) );
	}
	
	//根据负责人获取
	public function getUserByMan($man) {
		$sql = "select a.uid,b.real_name,a.junqu,b.lastlogin,b.mobile_phone from d_buy_user a left join w_member_list b on a.uid=b.uid where a.man='$man' ORDER BY lastlogin DESC";
		return $this->fetchAll ( $sql );
	}
	
	public function getMemberByGroupid($groupid) {
		$sql = "SELECT real_name,mobile_phone,b.man,b.junqu,b.land FROM w_member_list a,d_buy_user b WHERE a.uid=b.uid AND verify=1 AND status=0 AND groupid=$groupid ORDER BY b.junqu ASC";
		return $this->fetchAll ( $sql );
	}
	
	//根据军区获取名单
	public function getUserByJunqu($junqu) {
		return $this->getAll ( $this->_area, array ('junqu' => $junqu ) );
	}
	
	//保存区域
	public function saveAreaByUid($v, $uid) {
		return $this->update ( $this->_area, $v, array ('uid' => $uid ) );
	}
	
	//删除余额
	public function removeByUid($uid) {
		return $this->delete ( $this->_area, array ('uid' => $uid ) );
	}
	
	/**
	 * 
	 * @return MemberAreaModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}

}