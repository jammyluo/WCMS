<?php
/**
 * 
 * Enter description here ...
 * @author Administrator
 *
 */
class MemberModel extends Db {
	
	protected $_member_list = 'w_member_list';
	protected $_member_group = 'w_member_group';
	
	/**
	 * 更新用户
	 *
	 * @param array $v        	
	 * @param array $where        	
	 */
	public function setMemberByWhere($v, $where) {
		return $this->update ( $this->_member_list, $v, $where );
	}
	/**
	 * 统计用户总账余额
	 * 
	 */
	public function getSumCouponsMember() {
		$sql = "SELECT sum(coupons) total FROM $this->_member_list";
		return $this->fetch ( $sql );
	}
	public function getCouponsMember() {
		$sql = "SELECT uid,coupons FROM w_member_list";
		return $this->fetchAll ( $sql );
	}
	
	public function getMemberLikeRealName($realName) {
		$sql = "SELECT * FROM $this->_member_list WHERE real_name like \"%$realName%\"";
		return $this->fetchAll ( $sql );
	}
	
	public function getMemberByWhere($where, $key, $order_by, $limit) {
		return $this->getAll ( $this->_member_list, $where, $key, $order_by, $limit );
	}
	/**
	 * 增加积分
	 * @param unknown_type $coupons
	 * @param unknown_type $uid
	 */
	public function updateMemberCoupons($coupons, $uid) {
		$sql = "UPDATE $this->_member_list SET coupons=coupons+$coupons WHERE uid=$uid";
		$this->exec ( $sql );
	}
	/**
	 * 删除用户
	 *
	 * @param unknown_type $where        	
	 */
	public function delMemberByWhere($where) {
		return $this->delete ( $this->_member_list, $where );
	}
	
	/**
	 * 添加用户组
	 *
	 * @param array $arr        	
	 */
	public function addMemberGroup($arr) {
	return	$this->add ( $this->_member_group, $arr );
	}
	/**
	 * 删除用户组
	 *
	 * @param array $arr        	
	 */
	public function delMemberGroup($arr) {
	return	$this->delete ( $this->_member_group, $arr );
	}
	/**
	 * 更新用户组
	 *
	 * @param array $v        	
	 * @param array $where        	
	 */
	public function updateMemberGroup($v, $where) {
		$this->update ( $this->_member_group, $v, $where );
	}
	
	/**
	 * 获取一个用户组信息
	 *
	 * @param array $where        	
	 */
	public function getOneGroup($where) {
		return $this->getOne ( $this->_member_group, $where );
	
	}
	/**
	 * 获取所欲用户组
	 */
	public function getGroupAll() {
		return $this->getAll ( $this->_member_group );
	
	}
	/**
	 * 获取一个用户信息
	 *
	 * @param
	 * $where
	 */
	public function getOneMember($where) {
		return $this->getOne ( $this->_member_list, $where );
	
	}
	/**
	 *
	 *
	 *
	 *
	 *
	 * 添加用户
	 *
	 * @param array $arr        	
	 */
	public function addMember($arr) {
		$this->add ( $this->_member_list, $arr );
		return $this->lastInsertId ();
	
	}
	
	/**
	 * 获取用户名和所属分组
	 */
	public function getAllMemberInfo($group) {
		$sql = "SELECT a.`username`,b.`name` FROM w_member_list a LEFT JOIN w_member_group b ON a.group=b.id WHERE a.group=$group";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 获取用户信息 包含用户权限
	 * @param unknown_type $uid        	
	 */
	public function getMemberAndGroup($uid) {
		$sql = "SELECT * FROM w_member_list a LEFT JOIN w_member_group b ON a.group=b.id WHERE a.id=$uid";
		return $this->fetch ( $sql );
	}
	
	public function getMemberPages($start, $num) {
		$sql = "SELECT * FROM w_member_list a LEFT JOIN w_member_group b ON a.groupid=b.id   ORDER BY a.uid DESC LIMIT $start,$num ";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 模糊搜索
	 * @param unknown $key
	 * @param unknown $v
	 * @return multitype:
	 */
	public function getMemberByLike($key, $v) {
		$sql = "SELECT * FROM $this->_member_list a LEFT JOIN $this->_member_group b ON a.groupid=b.id WHERE $key LIKE '%$v%'";
		return $this->fetchAll ( $sql );
	}
	
	//获取用户数据
	public function getMemberNums() {
		$sql = "SELECT uid FROM $this->_member_list";
		return $this->rowCount ( $sql );
	}
	
	/**
	 * 返回MemberModel
	 *
	 * @return MemberModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}