<?php
/**
 * 全局广告系统
 * Enter description here ...
 * @author Administrator
 *
 */
class AdvController extends NodeController {
	
	static $service;
	public function adv() {
		$rs = self::getService ()->getAllAdv ();
		
		$this->view ()->assign ( 'adv', $rs );
		$this->view ()->display ( "file:adv/adv.tpl" );
	}

    public function getMobileAd(){
        $rs=self::getService()->getAdvByType(6);
        var_dump($rs);
    }
	public function edit() {
		$rs = self::getService ()->getAdvById ( $_GET ['id'] );
		$type = self::getService ()->getType ();
		$this->view ()->assign ( 'type', $type );
		$this->view ()->assign ( 'adv', $rs );
		$this->view ()->display ( "file:adv/edit.tpl" );
	}
	
	public function remove() {
		echo self::getService ()->removeAdvById ( $_GET ['id'] );
	}
	
	public function setstatus() {
		$rs = self::getService ()->saveAdvStatusById ( $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], $rs ['data'], $rs ['status'] );
	}
	
	//编辑页面
	public function save() {
		$rs = self::getService ()->saveAdvById ( $_POST, $_POST ['id'] );
		echo $rs ['message'];
	}
	
	public function add() {
		$type = self::getService ()->getType ();
		$this->view ()->assign ( 'type', $type );
		$this->view ()->display ( "file:adv/add.tpl" );
	}
	
	//新增广告
	public function sub() {
		self::getService ()->addAdv ( $_POST );
	}
	
	public static function getService() {
		if (self::$service == null) {
			self::$service = new AdvService ();
		}
		return self::$service;
	}
}