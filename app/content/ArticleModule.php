<?php
/**
 * 
 * 特点 支持多语言
 * @author Wolf
 *
 */
class ArticleModule extends Module {
	protected $_type = 1;
	
	protected $_keys = array ('nid', 'content', 'lang', 'title' );
	protected $_con;
	
	protected $_temp = array ('add' => 'file:module/news.add.tpl', 'edit' => 'file:module/news.edit.tpl', 'list' => 'file:news/list.tpl' );
	
	/**
	 * 
	 * @see Module::save()
	 */
	public function save($data, $nid) {
		// TODO Auto-generated method stub
		$this->setCon ( $data );
		$lang = $this->getLang ();
		$where = array ('nid' => $nid, 'lang' => $lang ['id'] );
		$v = $this->getCon ( $nid );
		
		//图片处理
		$this->delMorePic($nid, $v['content']);
		ModuleModel::instance ()->saveModuleCon ( $v, $where, $this->_type );
	
	}
	/**
	 * 新内容与旧的内容进行比较，如果发现图片不存在了，就删除
	 */
	private function delMorePic($nid, $content) {
		$con = ModuleModel::instance ()->getModuleCon ( array ('nid' => $nid ), $this->_type );
		$match = "#src=\"(.*)\"#iUs";
		preg_match_all ( $match, $con [0] ['content'], $old );
		preg_match_all ( $match, $content, $news );
		
		
		if (empty ( $old[1] )) {
			return;
		}
		
		$flag = false;
		//删除内容图片
		foreach ( $old[1] as $ov ) {
			$flag = false;
			foreach ( $news[1] as $nv ) {
				if ($ov == $nv) {
					$flag = true;
				}
			
			}
			
			if (! $flag) {
				@unlink ( ROOT . $ov );
			}
		}
	}
	/* (non-PHPdoc)
     * @see Module::remove()
     */
	public function remove($where) {
		$con = ModuleModel::instance ()->getModuleCon ( $where, $this->_type );
		$match = "#src=\"(.*)\"#iUs";
		preg_match_all ( $match, $con [0] ['content'], $rs );
		
		//删除内容图片
		foreach ( $rs [1] as $v ) {
			@unlink ( ROOT . $v );
		}
		ModuleModel::instance ()->removeModuleCon ( $where, $this->_type );
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
		
		ModuleModel::instance ()->addModuleCon ( $this->getCon ( 0 ), $this->_type );
	}
	
	/* (non-PHPdoc)
     * @see Module::setCon()
     */
	public function setCon($data) {
		$lang = $this->getLang ();
		
		foreach ( $this->_keys as $v ) {
			//检查是否转义
			if (get_magic_quotes_gpc ()) {
				
				$this->_con [$v] = stripslashes ( $data [$v] );
			} else {
				$this->_con [$v] = $data [$v];
			}
		}
		$this->_con ['lang'] = $lang ['id'];
	
	}
	/* (non-PHPdoc)
     * @see IModule::getCon()
     *  返回值的类型要一致
     */
	public function getCon($nid) {
		if (! empty ( $this->_con )) {
			//提交的时候返回值
			return $this->_con;
		}
		
		// TODO Auto-generated method stub
		$lang = $this->getLang ();
		$where = array ('nid' => $nid, 'lang' => $lang ['id'] );
		
		$rs = ModuleModel::instance ()->getModuleCon ( $where );
		
		if (empty ( $rs )) {
			$rs [0] = array ('title' => 'nothing', 'content' => "nothing!" );
		}
		return $rs [0];
	
	}
	
	/**
	 * @return the $_lang
	 */
	private function getLang() {
		//默认是cn
		$lang = NewsModel::instance ()->getLang ( array ('keyword' =>'cn' ) );
		return $lang [0];
	
	}
	
	/**
	 * 
	 * @return ArticleModule
	 */
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}