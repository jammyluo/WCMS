<?php
/**
 * 
 * 特点 支持多语言
 * @author Wolf
 *
 */
class ImageModule extends Module {
	protected $_type = 2;
	//二维数组
	protected $_keys = array ('id', 'nid', 'image', 'remark', 'source', 'weight' );
	protected $_con;
	protected $_temp = array ('add' => 'file:module/image.add.tpl', 'edit' => 'file:module/image.edit.tpl', 'list' => 'file:news/list.tpl' );
	/* (non-PHPdoc)
     * @see IModule::edit()
     */
	public function edit($nid) {
	}
	/* (non-PHPdoc)
     * @see Module::listing()
     */
	public function listing($page, $cids, $order) {
		// TODO Auto-generated method stub
	}
	/* (non-PHPdoc) 可能的情况 只有一张图片的情况下 增加或减少
     * @see Module::save()
     */
	public function save($data, $nid) {
		//检查是否 与原来是否
		$this->setCon ( $data );
		$where = array ('nid' => $nid );
		$new = $this->getCon ( $nid ); //提交数据
		$this->_con = null;
		$old = $this->getCon ( $nid ); //旧数据
		//相等的
		if ($new == $old) {
			return;
		}
		//不相等 只有新增  删除方法 单独调用
		foreach ( $new as $v ) {
			//如果存在就更新 不存在就新增
			if (! isset ( $v ['id'] )) {
				//windows下 不能为空
				unset ( $v ['id'] );
				ModuleModel::instance ()->addModuleCon ( $v, $this->_type );
				continue;
			}
			$where = array ('id' => $v ['id'] );
			unset ( $v ['id'], $v ['image'], $v ['source'] );
			ModuleModel::instance ()->saveModuleCon ( $v, $where, $this->_type );
		}
		return;
	}
	/* (non-PHPdoc)
     * @see Module::temp()
     */
	public function temp($type) {
		// TODO Auto-generated method stub
		return $this->_temp [$type];
	}
	/* (non-PHPdoc)
     * @see Module::add()
     */
	public function add($data) {
		$this->setCon ( $data );
		foreach ( $this->getCon ( 0 ) as $v ) {
			ModuleModel::instance ()->addModuleCon ( $v, $this->_type );
		}
	}
	/* (non-PHPdoc) 可能的情况 只有一张图片的情况下 增加或减少
     * @see Module::setCon()
     */
	public function setCon($data) {
		if (empty ( $data ['image'] )) {
			return $this->con = array ();
		}
		$rs = array ();
		$delimiter = "../../../";
		foreach ( $data ['image'] as $k => $v ) {
			if (! strpos ( $v, $delimiter )) {
				$url = $v;
			} else {
				$pathArray = explode ( $delimiter, $v );
				$url = "/static/" . $pathArray [1];
			}
			if (isset ( $data ['imageid'] )) {
				$rs [$k] ['id'] = $data ['imageid'] [$k];
			}
			$filename = basename ( $url );
			$dirname = dirname ( $url );
			//可能缩略图不存在
			$rs [$k] ['image'] = $url;
			$rs [$k] ['source'] = $url;
			$rs [$k] ['remark'] = $data ['remark'] [$k];
			$rs [$k] ['nid'] = $data ['nid'];
			$rs [$k] ['weight'] = $data ['weight'] [$k];
		
		}
		$this->_con = $rs;
	}
	/* (non-PHPdoc)
     * @see IModule::getCon()
     */
	public function getCon($nid) {
		if (! empty ( $this->_con ))
			return $this->_con;
		$where = array ('nid' => $nid );
		return ModuleModel::instance ()->getModuleCon ( $where, $this->_type );
	}
	/* (non-PHPdoc)
     * @see IModule::remove()
     */
	public function remove($where) {
		// TODO Auto-generated method stub
		//删除图片
		$rs = ModuleModel::instance ()->getModuleCon ( $where, $this->_type );
		//多条记录
		foreach ( $rs as $v ) {
			@unlink ( ROOT . $v ['image'] );
			@unlink ( ROOT . $v ['source'] );
		}
		ModuleModel::instance ()->removeModuleCon ( $where, $this->_type );
	}
	/**
	 * @return the $_lang
	 */
	private function getLang() {
		$lang = NewsModel::instance ()->getLang ( array ('keyword' => $_COOKIE ['lang'] ) );
		return $lang [0];
	}
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}