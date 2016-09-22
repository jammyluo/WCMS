<?php
/**
 * 一开始写的代码 有些混乱 暂不改造 2014-05-08  
 * 
 * 
 */
class CateController extends NodeController {
	/**
	 * json格式
	 * 默认1为展开状态
	 */
	public function ztree() {
		echo self::getCateService ()->ztree ( $_POST ['id'] );
	
	}
	/**
	 * 分类专题页面 如果没有 就用列表页面
	 */
	public function bind() {
		$rs = self::getCateService ()->bindCateTemp ( $_POST ['type'], $_POST ['name'], $_POST ['category'] );
		$this->sendNotice ( $rs, null, true );
	
	}
	
	/**
	 * 分类绑定字段
	 */
	public function bindField() {
		
		$rs = self::getCateService ()->bindField ( $_POST ['cid'], $_POST ['eid'] );
		/* 删除原有配置 */
		$this->sendNotice ( $rs );
	}
	
	/**
	 * 分类绑定字段
	 */
	public function bindFieldView() {
		$categoryid = isset ( $_GET ['cid'] ) ? $_GET ['cid'] : 0;
		$category = self::getCateService ()->getCategory ( $categoryid, null );
		$extend = self::getCateService ()->getCateField ( $categoryid );
		
		$this->view ()->assign ( 'category', $category );
		$this->view ()->assign ( 'extend', $extend );
		$this->view ()->display ( 'file:cate/extend.tpl' );
	}
	/**
	 * 获取分类信息
	 * 
	 */
	public function category() {
		$rs = self::getCateService ()->getCateById ( $_POST ['cid']);
		$this->sendNotice ( $rs );
	}
	
	// 更新新闻权限
	public function premission() {
		$rs = self::getCateService ()->authorize ( $_POST ['id'], $_POST ['groupid'], $_POST ['jicheng'] );
		$this->sendNotice ( $rs );
	}
	
	public function edit() {
		
		$this->view ()->display ( 'file:cate/edit.tpl' );
	}
	
	public function move() {
		$rs = self::getCateService ()->move ( $_POST ['id'], $_POST ['fid'] );
		$this->sendNotice ( $rs );
	}
	
	public function rename() {
		
		$rs = self::getCateService ()->rename ( $_POST ['category'], $_POST ['name'] );
		$this->sendNotice ( $rs );
	}
	
	//删除分类时，会把分类下的所有文章删除掉
	public function remove() {
		
		$num = self::getNewsService ()->getNewsByCid ( $_POST ['category'] );
		
		if ($num > 1) {
			$this->sendNotice ( "此分类下还有文章" );
		}
		
		$rs = self::getCateService ()->remove ( $_POST ['category'] );
		//还有文章的话 就无法删除
		

		if ($rs == self::SUCEESS) {
			//危险操作 暂时关闭
			self::getNewsService ()->removeByCid ( $_POST ['category'] );
		}
		
		$this->sendNotice ( $rs );
	}
	
	public function add() {
		$rs = self::getCateService ()->add ( $_POST ['category'], $_POST ['name'], $_POST ['mid'] );
		$this->sendNotice ( $rs, $rs );
	}
	
	public static function getNewsService() {
		return new NewsService ( $_REQUEST ['cid'], $_REQUEST ['mid'] );
	}
	
	public static function getCateService() {
		return new CateService ();
	}
}