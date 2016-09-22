<?php
class ExtendModel extends Db {
	/**
	 * 新增3张扩展表
	 */
	protected $_extend = 'w_extend';
	protected $_extend_int = 'w_extend_int';
	protected $_extend_decimal = 'w_extend_decimal';
	protected $_extend_varchar = 'w_extend_varchar';
	
	/**
	 * 删除多余的扩展字段
	 *
	 * @param unknown_type $type        	
	 * @param unknown_type $key        	
	 */
	public function DeleteExtendDecimal($where) {
		return $this->delete ( $this->_extend_decimal, $where );
	}
	public function DeleteExtendInt($where) {
		return $this->delete ( $this->_extend_int, $where );
	}
	public function DeleteExtendVarchar($where) {
		return $this->delete ( $this->_extend_varchar, $where );
	}
	/**
	 * 获取字段值
	 *
	 * @param unknown_type $where        	
	 */
	public function getExtendValue($where, $key = NULL) {
		
		return $this->getAll ( $this->_extend_varchar, $where, $key );
	}
	/**
	 * 增加扩展字段的值
	 *
	 * @param unknown_type $params        	
	 */
	public function addExtendValue($params) {
		$this->add ( $this->_extend_value, $params );
	}
	public function addExtendInt($params) {
		$this->add ( $this->_extend_int, $params );
	}
	public function addExtendVarchar($params) {
		$this->add ( $this->_extend_varchar, $params );
	}
	public function addExtendDecimal($params) {
		$this->add ( $this->_extend_decimal, $params );
	}
	
	public function getExtendInt($gid, $ids) {
		$sql = "SELECT * FROM $this->_extend_int a LEFT JOIN $this->_extend b ON a.eid=b.eid WHERE a.eid IN ($ids) AND gid=$gid ";
		return $this->fetchAll ( $sql );
	}
	public function getExtendVarchar($gid, $ids) {
		$sql = "SELECT * FROM $this->_extend_varchar a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE a.eid IN ($ids) AND gid=$gid ";
		return $this->fetchAll ( $sql );
	}
	public function getExtendDecimal($gid, $ids) {
		$sql = "SELECT * FROM $this->_extend_decimal a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE a.eid IN ($ids) AND gid=$gid ";
		return $this->fetchAll ( $sql );
	}
	public function getExtendIntByWhere($gid, $moduleid, $key = NULL) {
		$sql = "SELECT * FROM $this->_extend_int a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid";
		if (! empty ( $key )) {
			$sql = "SELECT * FROM $this->_extend_int a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid AND b.key='$key'";
		}
		return $this->fetchAll ( $sql );
	}
	public function getExtendVarcharByWhere($gid, $moduleid, $key = NULL) {
		$sql = "SELECT * FROM $this->_extend_varchar a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid";
		if (! empty ( $key )) {
			$sql = "SELECT * FROM $this->_extend_varchar a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid AND b.key='$key'";
		}
		return $this->fetchAll ( $sql );
	}
	public function getExtendDecimalByWhere($gid, $moduleid, $key = NULL) {
		$sql = "SELECT * FROM $this->_extend_decimal a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid ";
		if (! empty ( $key )) {
			$sql = "SELECT * FROM $this->_extend_decimal a LEFT JOIN $this->_extend b ON a.eid=b.eid  WHERE gid=$gid AND a.moduleid=$moduleid AND b.key='$key'";
		}
		return $this->fetchAll ( $sql );
	}
	/**
	 *
	 * @param unknown_type $v        	
	 * @param unknown_type $where        	
	 */
	public function saveExtendValue($v, $where) {
		$this->update ( $this->_extend_value, $v, $where );
	}
	public function saveExtendVarchar($v, $where) {
		$this->update ( $this->_extend_varchar, $v, $where );
	}
	public function saveExtendDecimal($v, $where) {
		$this->update ( $this->_extend_decimal, $v, $where );
	}
	public function saveExtendInt($v, $where) {
		$this->update ( $this->_extend_int, $v, $where );
	}
	public function increaseExtendValue($key, $gid) {
		$sql = "UPDATE w_extend_value SET `int`=`int`+1 WHERE gid=$gid and `key`='$key'";
		return $this->exec ( $sql );
	}
	
	/**
	 * 增加字段
	 * Enter description here .
	 *
	 *
	 *
	 *
	 *
	 * @param unknown_type $params        	
	 */
	public function addExtend($params) {
		$this->add ( $this->_extend, $params );
	}
	/**
	 * 获取字段名
	 *
	 * @param unknown_type $where        	
	 */
	public function getExtend($where = NULL) {
		return $this->getAll ( $this->_extend, $where );
	}
	/**
	 * 获取扩展字段的值 左外连接
	 * Enter description here .
	 *
	 *
	 *
	 * @param unknown_type $gid        	
	 */
	public function getExtendByGid($gid, $eids = null) {
		if ($eids == null) {
			$sql = "select a.status,a.type,a.name,a.key,a.num,b.id,b.varchar,b.decimal,b.int,b.modified from w_extend a left outer join w_extend_value b on a.key=b.key AND b.gid=$gid where a.module='news'";
		} else {
			$sql = "select a.status,a.type,a.name,a.key,a.num,b.id,b.varchar,b.decimal,b.int,b.modified from w_extend a left outer join w_extend_value b on a.key=b.key AND b.gid=$gid where a.module='news' AND a.eid IN ($eids)";
		}
		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * @return ExtendModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}

}