<?php
class TempModel extends Db {
	
	protected $_templates = 'w_templates';
	protected $_templates_type = "w_templates_type";
	protected $_templates_history = 'w_templates_history';
	
	/**
	 * 获取主题模板
	 * Enter description here ...
	 * @param unknown_type $where
	 */
	public function getTemplatesType($where = NULL) {
		return $this->getAll ( $this->_templates_type, $where );
	}
	
	public function getTypeById($id) {
		return $this->getOne ( $this->_templates_type, array ('id' => $id ) );
	}
	
	public function addTempType($params) {
		return $this->add ( $this->_templates_type, $params );
	}
	
	public function removeTempTypeById($id) {
		return $this->delete ( $this->_templates_type, array ('id' => $id ) );
	}
	
	/**
	 * 添加模板
	 *
	 * @param unknown_type $params        	
	 */
	public function addTemp($params) {
		return $this->add ( $this->_templates, $params );
	}
	/**
	 * 添加模板历史记录
	 *
	 * @param unknown_type $params        	
	 */
	public function addTempHistory($params) {
		return $this->add ( $this->_templates_history, $params );
	}
	/**
	 * 保存模板
	 *
	 * @param unknown_type $source        	
	 * @param unknown_type $id        	
	 */
	public function saveTempSource($source, $id, $username, $direct) {
		$sql = "UPDATE $this->_templates SET source='$source',version=version+1,action='$username',direct='$direct' WHERE `id`='$id'";
		return $this->exec ( $sql );
	}
	/**
	 *
	 * @param unknown_type $name        	
	 */
	public function getTemplateByName($name) {
		return $this->getOne ( $this->_templates, array ('name' => $name ) );
	}
	
	public function getTempLikeName($name, $limit) {
		// 考虑下属分类的情况
		$sql = "SELECT * FROM $this->_templates WHERE `name` like '%$name%' LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	public function getTempLikeRemark($remark, $limit) {
		$sql = "SELECT * FROM $this->_templates WHERE `remark` like '%$remark%' LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	public function getAllTemp($where, $key, $limit) {
		return $this->getAll ( $this->_templates, $where, $key, "id DESC", $limit );
	}
	/**
	 * 设置模板状态
	 *
	 * @param int $id        	
	 * @param int $status        	
	 */
	public function setTempldateStatus($id, $v) {
		return $this->update ( $this->_templates, $v, array ('id' => $id ) );
	}
	/**
	 * 获取制定模板
	 *
	 * @param unknown_type $name        	
	 */
	public function getTemplateList($start, $num, $key = null, $where = null) {
		return $this->getPage ( $start, $num, $this->_templates, $key, $where );
	}
	public function getTempHistory($where, $key, $limit = 20) {
		return $this->getAll ( $this->_templates_history, $where, $key, 'id DESC', $limit );
	
	}
	public function deleteTempHistory($temp_id, $id) {
		$sql = "DELETE FROM $this->_templates_history WHERE temp_id=$temp_id AND id<$id";
		$this->exec ( $sql );
	}
	/**
	 * 根据id 获取模板内容
	 *
	 * @param int $id        	
	 */
	public function getTemplateById($id) {
		return $this->getOne ( $this->_templates, array ('id' => $id ) );
	}
	
	public function delTempById($id) {
		return $this->delete ( $this->_templates, array ('id' => $id ) );
	}
	
	public function delTempByType($type) {
		return $this->delete ( $this->_templates, array ('type' => $type ) );
	}
	/**
	 * 
	 * @return TempModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}

}