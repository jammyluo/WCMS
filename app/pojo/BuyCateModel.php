<?php
class BuyCateModel extends Db {
	
	private $_cate = 'w_news_category';
	
	
	public function getCateByFid($fid) {
		return $this->getAll ( $this->_cate, array ('fid' => $fid ), null, 'sort DESC' );
	}
	
	public function getAllCate() {
		return $this->getAll ( $this->_cate, array ('fid'=>9), null, 'sort DESC' );
	}
	
	public function getCateById($id) {
		return $this->getOne ( $this->_cate, array ('id' => $id ) );
	}
	
	/**
	 * 
	 * @return BuyCateModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}