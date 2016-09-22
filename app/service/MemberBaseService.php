<?php
/**
 * 添加 和获取 ，全部更新 、删除需要重组  而 指定更新不需要
 * @author wolf
 *
 */
class MemberBaseService {
	
	public $_baseObj;
	public $_areaObj;
	public $_walletObj;
	public function __construct() {
		$this->_baseObj = new MemberBaseModule ();
		$this->_areaObj = new MemberAreaModule ();
	}
	
	public function add($data) {
		
		$uid = $this->_baseObj->add ( $data );
		
		if ($uid < 1) {
			return false;
		}
		
		$data ['uid'] = $uid;
		//增加地区信息
		$this->_areaObj->add ( $data );
		return $uid;
	}
	
	/**
	 * 
	 * @param array $v
	 * @param int $uid
	 */
	public function saveMemberByUid($v, $uid) {
		$a = $this->_baseObj->saveCon ( $v, $uid );
		$b = $this->_areaObj->saveCon ( $v, $uid );
		return $a > 0 || $b > 0;
	}
	
	public function getMemberGroup() {
		return MemberModel::instance ()->getGroupAll ();
	}
	
	//删除用户信息
	public function removeByUid($uid) {
		
		$this->_areaObj->remove ( $uid );
		return $this->_baseObj->remove ( $uid );
	}
	
	//根据用户名查找
	public function getMemberByUsername($username) {
		return $this->_baseObj->getMemberByUsername ( $username );
	}
	
	//根据用户名查找
	public function getMemberByRealname($realname) {
		return $this->_baseObj->getMemberByRealname ( $realname );
	}
	
	//根据名称来查找
	public function getMemberByMobile($mobile) {
		return $this->_baseObj->getMemberByMobile ( $mobile );
	}
	
	public function getMemberByWhere($where) {
		return $this->_baseObj->getMemberByWhere ( $where );
	}
	
	/**
	 * 获取用户信息
	 * @param int $uid
	 * @return Array
	 */
	public function getMemberByUid($uid) {
		
		$a = $this->_baseObj->getCon ( $uid ); //基本信息
		$b = $this->_areaObj->getCon ( $uid ); //地区信息
		$rs = $a;
		
		if (empty ( $rs )) {
			return;
		}
		
		if (! empty ( $b )) {
			$rs = array_merge ( $rs, $b );
		}
		
		return $rs;
	
	}
	
	public function getMemberLikeRealName($realName) {
		
		return $this->_baseObj->getMemberLikeRealName ( $realName );
	}
}