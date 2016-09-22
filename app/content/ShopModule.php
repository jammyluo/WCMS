<?php
/**
 * 
 * 商品组件  文章和产品组合
 * @author Wolf
 *
 */
class ShopModule extends Module {
	protected $_type = 5;
	//二维数组
	

	protected $_temp = array ('add' => 'file:module/goods.add.tpl', 'edit' => 'file:module/goods.edit.tpl', 'list' => 'file:news/list.tpl' );
	
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
		GoodsModule::instance ()->save ( $data, $nid );
		ArticleModule::instance ()->save ( $data, $nid );
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
		GoodsModule::instance ()->add ( $data );
		ArticleModule::instance ()->add ( $data );
	}
	
	/* (non-PHPdoc) 可能的情况 只有一张图片的情况下 增加或减少
	 * //不需要处理 这个只跟add相关
     * @see Module::setCon()
     */
	public function setCon($data) {
	
	}
	/* (non-PHPdoc)
     * @see IModule::getCon()
     */
	public function getCon($nid) {
		
		//组合
		$module = GoodsModule::instance ()->getCon ( $nid );
		$content = ArticleModule::instance ()->getCon ( $nid );
		return array ('module' => $module, 'content' => $content );
	
	}
	
	/* (non-PHPdoc)
     * @see IModule::remove()
     */
	public function remove($where) {
		return GoodsModule::instance ()->remove ( $where );
	}
	
	/**
	 * 
	 * @return ShopModule
	 */
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}