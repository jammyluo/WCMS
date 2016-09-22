<?php
class FlagController extends NodeController {
	
	static $service;
	
	public function group() {
		$group = self::getService ()->getFlagGroup ();
		$this->view ()->assign ( 'group', $group );
		
		$this->view ()->display ( "file:flag/group.tpl" );
	}
	
	public function addGroup() {
		$rs = self::getService ()->addGroup ( $_POST );
		$this->sendNotice ( $rs ['message'], $rs ['data'], $rs ['status'] );
	
	}
	
	public function removeGroup() {
		$rs = self::getService ()->removeGroupById ( $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], $rs ['data'], $rs ['status'] );
	
	}
	
	/**
	 * 自定义标签
	 * Enter description here .
	 */
	public function flag() {
		$flag = self::getService ()->getFlagByGroupId ( $_GET ['groupid'] );
		$group = self::getService ()->getFlagGroup ();
		$this->view ()->assign ( 'current', $_GET ['groupid'] );
		$this->view ()->assign ( 'group', $group );
		$this->view ()->assign ( 'flag', $flag );
		$this->view ()->display ( 'file:flag/flag.tpl' );
	}
	
	public function add() {
		$rs = self::getService ()->addFlag ( $_POST );
		$this->sendNotice ( $rs ['message'], $rs ['data'], $rs ['status'] );
	}
	//通过flag标签搜索
	public function sflag() {
	
	}
	
	public function remove() {
		$rs = self::getService ()->removeFlagById ( $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	
	public static function getService() {
		if (self::$service == null) {
			self::$service = new FlagService ();
		}
		return self::$service;
	}
}