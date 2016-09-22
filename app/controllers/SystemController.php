<?php
class SystemController extends NodeController {
	static $service;
	public function config() {
		$config = self::getService ()->getConfig ();
		$this->view ()->assign ( 'config', $config );
		$ini = ini_get_all ();
		$mysqlversion = SystemModel::instance ()->getVersion ();
		$this->view ()->assign ( 'zone', $ini ['date.timezone'] ['local_value'] );
		$this->view ()->assign ( 'ini', $ini );
		$mysqlsize = SystemModel::instance ()->getDbSize ();
		$system = array ('sys' => php_uname ( "s" ), 'phpapi' => php_sapi_name (), 'phpversion' => PHP_VERSION, 'mysql' => $mysqlversion ['VERSION()'], 'mysqlsize' => $mysqlsize );
		$this->view ()->assign ( 'system', $system );
		$this->view ()->display ( "file:system/config.tpl" );
	}
	
	public function seo(){
	    
	    
	    $this->view()->display("file:system/seo.tpl");
	}
	
	public function save() {
		
		$rs = self::getService ()->batchSave ( $_GET );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	
	public function getmenu() {
		$rs = self::getService ()->getNodesByFid ( $_POST ['id'] );
		$this->sendNotice ( null, $rs, true );
	
	}
	
	public static function getService() {
		if (self::$service == null) {
			self::$service = new SysService ();
		}
		return self::$service;
	}

}
