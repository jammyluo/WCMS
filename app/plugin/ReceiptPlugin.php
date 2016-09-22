<?php
class ReceiptPlugin extends BasePlugin {
	
	protected $name = '回执确认';
	protected $type = 'single';
	protected $config = array ('cid' => 4, 'mid' => 1, 'num' => 3 );
	static $receiptService;
	/* (non-PHPdoc)
	 * @see IPlugin::api()
	 */
	public function api() {
		$rs = self::getReceiptService ()->save ( $_POST ['nid'], $this->_user_global ['uid'] );
		if ($rs == self::SUCCESS) {
			self::getLogService ()->add ( $this->_user_global ['username'], "回执确认成功$_POST[nid]" );
		} else {
			self::getLogService ()->add ( $this->_user_global ['username'], "回执确认失败$_POST[nid]" );
		}
		$this->sendNotice ( $rs );
	}
	//显示页面 通过json来获取
	public function v() {
		$rs = self::getReceiptService ()->getJSONReceiptByNid ( $_POST ['nid'] );
		$this->sendNotice ( null, $rs, true );
	}
	/* 
	 * 显示通知公告
	 * @see IPlugin::run()
	 */
	public function run() {
		$user = self::getReceiptService ()->getReceiptByUid ( $this->_user_global ['uid'] );
		$sys = new SysService ();
		$config = $sys->getConfig ();
		$params = array ('cid' => $config ['receipt'], 'p' => 1, 'num' => 6 );
		$rs = self::getNewsService ()->listing ( $params );
		
		$isRead = array ();
		foreach ( $user as $uv ) {
			$isRead [] = $uv ['nid'];
		}
		
		$list = $rs ['newslist'];
		foreach ( $list as $k => $v ) {
			
			if (in_array ( $v ['id'], $isRead )) {
				$list [$k] ['read'] = 1;
			} else {
				$list [$k] ['read'] = 0;
			}
			
			$list [$k] ['readnum'] = self::getReceiptService ()->getNumByNid ( $v ['id'] );
		
		}
		
		$this->view ()->assign ( 'receipt', $list );
	}
	
	public function getNewsService() {
		return new NewsService ( $this->config ['cid'], $this->config ['mid'] );
	}
	
	public static function getReceiptService() {
		
		if (self::$receiptService == null) {
			self::$receiptService = new ReceiptService ();
		}
		return self::$receiptService;
	
	}

}



