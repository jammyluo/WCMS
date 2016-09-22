<?php
/**
 * 头像审核队列<=最大用户数
 * @author Administrator
 *
 */
class FaceModel extends Db {
	
	protected $_face_list = 'w_member_face';
	protected $_member_list = 'w_member_list';
	
	public function addFaceList($params) {
		return $this->add ( $this->_face_list, $params );
	}
	public function getFaceList() {
		return $this->getAll ( $this->_face_list,null,null,'status DESC' );
	}
	
	public function saveFaceByUid($v, $uid) {
		return $this->update ( $this->_face_list, $v, array ('uid' => $uid ) );
	
	}
	//获取
	public function getFaceByUid($uid) {
		return $this->getOne ( $this->_face_list, array ('uid' => $uid ) );
	}
	
	public function delFaceById($id) {
		return $this->delete ( $this->_face_list, array ('id' => $id ) );
	}
	//获取头像
	public function getFaceById($id) {
		return $this->getOne ( $this->_face_list, array ('id' => $id ) );
	}
	
	public function saveFaceById($v, $id) {
		return $this->update ( $this->_face_list, $v, array ('id' => $id ) );
	}
	
	/**
	 * 获取随机的用户
	 * @param int $limit
	 */
	public function getRandFace($limit) {
		$sql = "SELECT real_name,face,area FROM $this->_member_list WHERE face!='' ORDER BY rand() LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 
	 * @return FaceModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}