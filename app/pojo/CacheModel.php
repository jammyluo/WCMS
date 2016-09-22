<?php
class CacheModel extends Db {
	protected $_cache = 'w_news_cache';
	/**
	 *
	 *
	 *
	 *
	 * 有目录
	 *
	 * @param array $params        	
	 */
	public function addCache($params) {
		return $this->add ( $this->_cache, $params );
	}
	/**
	 * 获取字段
	 * Enter description here .
	 *
	 *
	 *
	 *
	 * @param unknown_type $where        	
	 */
	public function getCacheByCid($where) {
		return $this->getOne ( $this->_cache, $where );
	}
	/**
	 * 清空统计结果
	 * Enter description here .
	 *
	 *
	 *
	 *
	 * ..
	 */
	public function clearNumCache() {
		$sql = "TRUNCATE $this->_cache";
		$this->exec ( $sql );
	}
	/**
	 * 
	 * @return CacheModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}

}