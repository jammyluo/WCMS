<?php
/**
 * 自定义字段 已经废弃 了
 * Enter description here ...
 * @author Administrator
 *
 */
class AttrController extends NodeController {
	
	static $service;

	
	/**
	 * 多值字段
	 */
	public function moreattr() {
		$rs = ExtendModel::instance ()->getExtend ( array ('status' => 3 ) );
		$this->view ()->assign ( "attr", $rs );
		$this->view ()->display ( "file:attr/moreattr.tpl" );
	}
	/**
	 * 自定义字段
	 * Enter description here .
	 */
	public function attr() {
		if ($_POST) {
			$key = trim ( strtolower ( $_POST ['key'] ) ); //强制转化为小写
			$name = trim ( $_POST ['name'] );
			$flag = ExtendModel::instance ()->getExtend ( array ('key' => $key ) );
			if (count ( $flag ) > 0) {
				$this->sendNotice ( 'key already exsit', null, false );
			}
			$params = array ('key' => trim ( $_POST ['key'] ), 'name' => trim ( $_POST ['name'] ), 'type' => trim ( $_POST ['attribute'] ), 'status' => $_POST ['status'], 'moduleid' => $_POST ['module'] );
			ExtendModel::instance ()->addExtend ( $params );
			$this->sendNotice ( SUCCESS, null, true );
		}
		$extend = ExtendModel::instance ()->getExtend ();
		$this->view ()->assign ( 'extend', $extend );
		$this->view ()->display ( "file:attr/attr.tpl" );
	}
	
	public static function getService() {
		if (self::$service == null) {
			self::$service = new FlagService ();
		}
		return self::$service;
	
	}

}