<?php
class ModuleModel extends Db {
	protected $_news_list = 'w_news_list'; //基本信息
	protected $_news_content = 'w_news_content'; //文章
	protected $_news_image = 'w_news_image'; //图集
	protected $_news_special = 'w_news_special'; //专题
	protected $_news_goods = 'w_news_goods'; //产品
	//查找基本信息
	public function getModuleBase($where, $limit) {
		return $this->getAll ( $this->_news_list, $where, null, null, $limit );
	}
	//添加基本模型
	public function addModuleBase($params) {
		$this->add ( $this->_news_list, $params );
		return $this->lastInsertId ();
	}
	//删除基本模型
	public function removeModuleBase($where) {
		$this->delete ( $this->_news_list, $where );
	}

	/**
	 * 
	 * 添加内容模型
	 * @param unknown_type $params
	 * @param unknown_type $type
	 * @reutrn int 返回id
	 */
	public function addModuleCon($params, $type = 1) {
		switch ($type) {
			case 1 :
				$lastInsertId = $this->add ( $this->_news_content, $params );
				break;
			case 2 :
				$lastInsertId = $this->add ( $this->_news_image, $params );
				break;
			case 3 :
				$lastInsertId = $this->add ( $this->_news_special, $params );
				break;
			case 4 :
				$lastInsertId = $this->add ( $this->_news_goods, $params );
				break;
		}
		return $lastInsertId;
	}
	//获取模型内容
	public function getModuleCon($where, $type = 1) {
		switch ($type) {
			case 1 :
				$rs = $this->getAll ( $this->_news_content, $where );
				break;
			case 2 :
				$rs = $this->getAll ( $this->_news_image, $where, null, 'weight ASC' );
				break;
			case 3 :
				$rs = $this->getAll ( $this->_news_special, $where );
				break;
			case 4 :
				$rs = $this->getAll ( $this->_news_goods, $where, null, 'weight ASC' );
				break;
		}

		return $rs;
	}
	//保存内容模型
	public function saveModuleCon($v, $where, $type = 1) {
		switch ($type) {
			case 1 :
				$rs = $this->update ( $this->_news_content, $v, $where );
				break;
			case 2 :
				$rs = $this->update ( $this->_news_image, $v, $where );
				break;
			case 3 :
				$rs = $this->update ( $this->_news_special, $v, $where );
			case 4 :
				$rs = $this->update ( $this->_news_goods, $v, $where );
				break;
		}
		return $rs;
	}
	//删除内容模型
	public function removeModuleCon($where, $type = 1) {
		switch ($type) {
			case 1 :
				$rs = $this->delete ( $this->_news_content, $where );
				break;
			case 2 :
				$rs = $this->delete ( $this->_news_image, $where );
				break;
			case 3 :
				$rs = $this->delete ( $this->_news_special, $where );
				break;
			case 4 :
				$rs = $this->delete ( $this->_news_goods, $where );
				break;
		}
		return $rs;
	}
	/**
	 * 返回ModuleModel
	 * @return ModuleModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}