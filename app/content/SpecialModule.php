<?php
/**
 * 
 * 特点 支持多语言
 * @author Wolf
 *
 */
class SpecialModule extends Module {
	protected $_type = 3;
	//二维数组
	protected $_keys = array ('nodeid', 'nid', 'nodetitle', 'newsid', 'review', 'module', 'quotetime', 'weight', 'image' );
	protected $_con;
	
	protected $_temp = array ('add' => 'file:module/special.add.tpl', 'edit' => 'file:module/special.edit.tpl', 'list' => 'file:news/list.tpl' );
	
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
			if (empty ( $v ['id'] )) {
				unset ( $v ['id'], $v ['nodeid'] );
				ModuleModel::instance ()->addModuleCon ( $v, $this->_type );
				continue;
			}
			
			//图片处理
			if (empty ( $v ['image'] )) {
				unset ( $v ['image'] );
			}
			
			$where = array ('id' => $v ['id'] );
			unset ( $v ['nid'], $v ['id'], $v ['nodeid'] );
			
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
			
			unset ( $v ['nodeid'], $v ['id'] );
			
			$flag = ModuleModel::instance ()->addModuleCon ( $v, $this->_type );
			if ($flag < 1) {
				throw new Exception ( "添加模型内容失败" );
			}
		}
		exit ();
	}
	
	/* (non-PHPdoc) 可能的情况 只有一张图片的情况下 增加或减少
     * @see Module::setCon()
     */
	public function setCon($data) {
		
		$uploadfile = array ();
		//空节点的情况
		foreach ( $_FILES ['image'] ['name'] as $k => $v ) {
			$uploadfile [$k] ['name'] = $v;
			$uploadfile [$k] ['type'] = $_FILES ['image'] ['type'] [$k];
			$uploadfile [$k] ['tmp_name'] = $_FILES ['image'] ['tmp_name'] [$k];
			$uploadfile [$k] ['size'] = $_FILES ['image'] ['size'] [$k];
			$uploadfile [$k] ['error'] = $_FILES ['image'] ['error'] [$k];
		}
		
		$rs = array ();
		foreach ( $data ['nodetitle'] as $k => $v ) {
			
			foreach ( $this->_keys as $kv ) {
				
				$rs [$k] [$kv] = $data [$kv] [$k];
			}
			$rs [$k] ['image'] = $this->thumb ( $uploadfile [$k] );
			$rs [$k] ['id'] = $data ['nodeid'] [$k];
			$rs [$k] ['nid'] = $data ['nid'];
		}
		
		$this->_con = $rs;
	
	}
	/* (non-PHPdoc)
     * @see IModule::getCon()
     */
	public function getCon($nid) {
		if (! empty ( $this->_con )) {
			return $this->_con;
		}
		
		$where = array ('nid' => $nid );
		//递归获取其他专题的内容
		

		return ModuleModel::instance ()->getModuleCon ( $where, $this->_type );
	
	}
	
	/* (non-PHPdoc)
     * @see IModule::remove()
     */
	public function remove($where) {
		// TODO Auto-generated method stub
		$rs = ModuleModel::instance ()->getModuleCon ( $where, $this->_type );
		
		foreach ( $rs as $v ) {
			@unlink ( ROOT . $v ['image'] );
		}
		return ModuleModel::instance ()->removeModuleCon ( $where, $this->_type );
	}
	/**
	 * 
	 * @return SpecialModule
	 */
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}