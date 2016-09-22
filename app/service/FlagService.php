<?php
class FlagService {
	
	public function addFlag($data) {
		$rs = FlagModel::instance ()->addFlag ( array ('name' => trim ( $data ['name'] ), 'groupid' => $data ['groupid'] ) );
		
		if ($rs > 0) {
			return array ('status' => true, 'data' => $rs, 'message' => "添加成功" );
		} else {
			return array ('status' => false, 'message' => "添加失败" );
		}
	}
	
	public function removeFlagById($id) {
		$rs = FlagModel::instance ()->removeFlagById ( $id );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "删除成功" );
		} else {
			return array ('status' => false, 'message' => "删除失败" );
		}
	}
	
	public function saveFlagNameById($name, $id) {
		$rs = FlagModel::instance ()->saveFlagById ( array ('name' => $name ), $id );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "更新成功" );
		} else {
			return array ('status' => false, 'message' => "更新失败" );
		}
	
	}
	
	public function getFlag($where) {
		return FlagModel::instance ()->getFlag ( $where );
	}
	
	public function getFlagValue($where) {
		return FlagValueModel::instance ()->getValueByWhere ( $where );
	}
	public function getFlagByGroupId($groupid) {
		return FlagModel::instance ()->getFlag ( array ('groupid' => $groupid ) );
	}
	
	public function getFlagGroup() {
		return FlagGroupModel::instance ()->getAllGroup ();
	}
	public function removeFlagByNid($nid) {
		return FlagValueModel::instance ()->removeValueByNid ( $nid );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $data
	 */
	public function bindFlagValue($flags, $nid) {
		
		if (empty ( $flags ) || ! is_array ( $flags )) {
			return;
		}
		
		foreach ( $flags as $k => $v ) {
			$this->addFlagValue ( array ('id' => $v, 'nid' => $nid ) );
		}
	}
	
	public function saveFlagValue($flags, $nid) {
		FlagValueModel::instance ()->removeValueByNid ( $nid );
		$this->bindFlagValue ( $flags, $nid );
	}
	
	public function getFlagByNid($nid) {
		return FlagValueModel::instance ()->getValueByNid ( $nid );
	}
	
	private function addFlagValue($params) {
		return FlagValueModel::instance ()->addValue ( $params );
	}
	
	public function addGroup($params) {
		$rs = FlagGroupModel::instance ()->addGroup ( $params );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "更新成功" );
		} else {
			return array ('status' => false, 'message' => "更新失败" );
		}
	}
	
	public function removeGroupById($id) {
		$rs = FlagGroupModel::instance ()->removeGroupById ( $id );
		FlagModel::instance ()->remoeFlagByGroupid ( $id );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "删除成功" );
		} else {
			return array ('status' => false, 'message' => "删除失败" );
		}
	}
}

class FlagModel extends Db {
	protected $_flag = 'w_flag';
	
	public function saveFlagById($v, $id) {
		return $this->update ( $this->_flag, $v, array ('id' => $id ) );
	}
	
	/**
	 * 添加flag
	 *
	 * @param unknown_type $params        	
	 */
	public function addFlag($params) {
		return $rs = $this->add ( $this->_flag, $params );
	
	}
	
	public function removeFlagById($id) {
		return $this->delete ( $this->_flag, array ('id' => $id ) );
	}
	
	public function remoeFlagByGroupid($groupid) {
		return $this->delete ( $this->_flag, array ('groupid' => $groupid ) );
	}
	
	/**
	 * 自定义标签
	 * Enter description here .
	 */
	public function getFlag($where) {
		return $this->getAll ( $this->_flag, $where, null, 'groupid ASC' );
	}
	
	

	/**
	 * 返回FlagModel
	 * @return FlagModel
	 */
	public static function instance() {
		return self::_instance ( __CLASS__ );
	}
}
class FlagGroupModel extends Db {
	protected $_flag_group = 'w_flag_group'; //标签组
	

	public function addGroup($params) {
		return $this->add ( $this->_flag_group, $params );
	}
	
	public function removeGroupById($id) {
		return $this->delete ( $this->_flag_group, array ('id' => $id ) );
	}
	
	public function saveGroupById($v, $id) {
		return $this->update ( $this->_flag_group, $v, array ('id' => $id ) );
	}
	
	public function getAllGroup() {
		return $this->getAll ( $this->_flag_group );
	}
	
	/**
	 * 
	 * @return FlagGroupModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}
class FlagValueModel extends Db {
	protected $_flag_value = 'w_flag_value'; //管理内容和标签
	

	public function addValue($params) {
		return $this->add ( $this->_flag_value, $params );
	}
	
	public function removeValueById($id) {
		return $this->delete ( $this->_flag_value, array ('id' => $id ) );
	}
	
	public function removeValueByNid($nid) {
		return $this->delete ( $this->_flag_value, array ('nid' => $nid ) );
	}
	
	public function saveValueById($v, $id) {
		return $this->update ( $this->_flag_value, $v, array ('id' => $id ) );
	}
	public function getValueByWhere($where) {
		return $this->getAll ( $this->_flag_value, $where );
	}
	
	public function getValueByNid($nid) {
	    $sql="SELECT a.*,b.name,b.groupid FROM $this->_flag_value a left join w_flag b ON a.id=b.id WHERE nid=$nid";
		return $this->fetchAll($sql);
	}
	
	/**
	 * 
	 * @return FlagValueModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}

}