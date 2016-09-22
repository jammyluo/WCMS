<?php
class CategoryModel extends Db {
	
	/**
	 * 新闻分类表
	 *
	 * @var string
	 */
	protected $_news_category = 'w_news_category';
	protected $_cate_extend = 'w_category_extend';
	
	/**
	 * 获取子类
	 * @param int $fid
	 * @return Array
	 */
	public function getCategoryByFid($fid = 0, $num = 100) {
		$sql = "SELECT * FROM $this->_news_category WHERE `fid`=$fid   ORDER BY sort ASC LIMIT $num";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 获取分类
	 * Enter description here ...
	 * @param unknown_type $where
	 */
	public function getCateByWhere($where = null) {
		return $this->getAll ( $this->_news_category, $where );
	}
	
	/**
	 * 获取当前类
	 * @param unknown_type $id        	
	 */
	public function getCateogryById($id) {
		return $this->getOne ( $this->_news_category, array ('id' => $id ) );
	}
	
	/**
	 * 添加分类
	 *
	 * @param array $arr        	
	 */
	public function addCategory($arr) {
		$this->add ( $this->_news_category, $arr );
		return $this->lastInsertId ();
	}
	/**
	 * 删除分类
	 * @param array $arr        	
	 */
	public function deleteCategoryById($id) {
		$this->delete ( $this->_news_category, array ('id' => $id ) );
	}
	/**
	 * 分类更名
	 *
	 * @param array $v        	
	 * @param array $where        	
	 */
	public function renameCategory($v, $where) {
		$this->update ( $this->_news_category, $v, $where );
	}
	
	/**
	 * 
	 *更新分类
	 * @param unknown_type $v        	
	 * @param unknown_type $where        	
	 */
	public function save($v, $where) {
		return $this->update ( $this->_news_category, $v, $where );
	}
	
	public function setSonIdNull() {
		$sql = "UPDATE $this->_news_category SET sonid=''";
		return $this->exec ( $sql );
	}
	
	/**
	 * 获取分类扩展字段
	 *
	 * @return array
	 */
	public function getCateExtendByCid($cid) {
		return $this->getAll ( $this->_cate_extend, array ('cid' => $cid ) );
	}
	/**
	 * 生成新的配置
	 *
	 * @param unknown_type $params        	
	 */
	public function addCateExtend($params) {
		$this->add ( $this->_cate_extend, $params );
	}
	/**
	 * 删除原有配置 重新生成
	 *
	 * @param unknown_type $cid        	
	 */
	public function delCateExtend($cid) {
		$this->delete ( $this->_cate_extend, array ('cid' => $cid ) );
	}
	
	/**
	 * 获取分类扩展字段
	 *
	 * @param
	 * int id
	 * @return array
	 */
	public function getCateExtend($cateid) {
		$sql = "select * from w_extend a LEFT JOIN w_category_extend b ON a.eid=b.eid WHERE b.cid IN ($cateid) group by a.eid";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 返回CategoryModel
	 *
	 * @return CategoryModel
	 */
	public static function instance() {
		return self::_instance ( __CLASS__ );
	}
} 