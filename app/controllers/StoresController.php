<?php
class StoresController extends NodeController {
	static $service;
	public function stores() {
		$rs = self::getService ()->getStoresByProvince ( $_GET ['province'] );
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( 'file:stores/list.tpl' );
	}
	
	public function map() {
		$rs = self::getService ()->getMap ();
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( "file:stores/map.tpl" );
	}
	
	public function add() {
		$province = new ProvinceService ();
		$provinces = $province->getAllProvince ();
		$this->view ()->assign ( 'uid', $_GET ['uid'] );
		$this->view ()->assign ( 'provinces', $provinces );
		$this->view ()->display ( 'file:stores/add.tpl' );
	}
	public function mystore() {
		$stores = self::getService ()->getStoresByUid ( $this->_user_global ['uid'] );
		$this->view ()->assign ( 'stores', $stores );
		$this->view ()->display ( 'file:stores/mystore.tpl' );
	}
	public function getstorebyuid() {
		$stores = self::getService ()->getStoresByUid ( $_GET ['uid'] );
		$this->view ()->assign ( 'uid', $_GET ['uid'] );
		$this->view ()->assign ( 'stores', $stores );
		$this->view ()->display ( 'file:stores/stores.tpl' );
	}
	public function saveaddress() {
		self::getLogService ()->add ( $this->_user_global ['real_name'], "完善专卖店" );
		$rs = self::getService ()->saveAddressByWhere ( $_POST ['address'], $this->_user_global ['uid'], $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	public function confirm() {
		self::getLogService ()->add ( $this->_user_global ['real_name'], "确认专卖店" );
		$rs = self::getService ()->confirm ( $this->_user_global ['uid'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	public function addstores() {
		$rs = self::getService ()->add ( $_POST );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	
	}
	public function search() {
		$rs = self::getService ()->search ( $_GET ['name'] );
		$this->view ()->assign ( 'name', urldecode ( $_GET ['name'] ) );
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( 'file:stores/list.tpl' );
	}
	public function remove() {
		$rs = self::getService ()->removeById ( $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	public function edit() {
		
		$province = new ProvinceService ();
		$status = self::getService ()->getStatus ();
		$rs = self::getService ()->getStoresById ( $_GET ['id'] );
		$provinces = $province->getAllProvince ();
		
		$areas = $province->getAreasByCityId ( $rs ['city'] );
		$citys = $province->getCityByProvinceId ( $rs ['province'] );
		$this->view ()->assign ( 'provinces', $provinces );
		$this->view ()->assign ( 'areas', $areas );
		$this->view ()->assign ( 'citys', $citys );
		$this->view ()->assign ( 'status', $status );
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( 'file:stores/edit.tpl' );
	}
	public function save() {
		$rs = self::getService ()->saveCon ( $_POST, $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	
	}
	public static function getService() {
		if (self::$service == null) {
			self::$service = new MemberStoresModule ();
		}
		return self::$service;
	}
}