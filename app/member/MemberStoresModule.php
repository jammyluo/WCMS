<?php
class MemberStoresModule implements IMember {
	private $_status = array (- 1 => "注销", 0 => "正常", 1 => "装修", 2 => "停业" );
	private $_limit = 20;
	
	//获取专卖店状态
	public function getStatus() {
		return $this->_status;
	}
	/* (non-PHPdoc)
	 * @see IMember::add()
	 */
	public function add($params) {
		$rs = StoresModel::instance ()->addStores ( $params );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "添加成功" );
		} else {
			return array ('status' => false, 'message' => "添加失败" );
		}
	}
	
	public function confirm($uid) {
		$rs = MemberModel::instance ()->setMemberByWhere ( array ('verify1' => 1 ), array ('uid' => $uid ) );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "确认成功" );
		} else {
			return array ('status' => false, 'message' => "确认失败" );
		}
	}
	
	/* (non-PHPdoc)
	 * @see IMember::getCon()
	 */
	public function getCon($uid) {
		
		return StoresModel::instance ()->getStroesByUid ( $uid );
	
	}
	
	/* (non-PHPdoc)
	 * @see IMember::remove()
	 */
	public function remove($uid) {
		
		return StoresModel::instance ()->removeStoresByUid ( $uid );
	}
	
	public function removeById($id) {
		$rs = StoresModel::instance ()->removeStoresById ( $id );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "删除成功" );
		} else {
			return array ('status' => false, 'message' => "删除失败" );
		}
	}
	
	/* (non-PHPdoc)
	 * @see IMember::saveCon()
	 */
	public function saveCon($v, $id) {
		// TODO Auto-generated method stub
		unset ( $v ['id'] );
		$rs = StoresModel::instance ()->saveStoreById ( $v, $id );
		if ($rs > 0) {
			return array ('status' => true, 'message' => "更新成功" );
		} else {
			return array ('status' => false, 'message' => "更新失败" );
		}
	}
	
	//解决更新内容
	public function saveAddressByWhere($address, $uid, $id) {
		$rs = StoresModel::instance ()->saveAddressByWhere ( $address, array ('uid' => $uid, 'id' => $id ) );
		
		if ($rs > 0) {
			return array ('status' => true, 'message' => "更新成功" );
		} else {
			return array ('status' => false, 'message' => "更新失败" );
		}
	}
	
	public function getProvinces() {
		$province = new ProvinceService ();
		return $province->getAllProvince ();
	}
	
	//获取店面
	public function getStoresByProvince($province) {
		$provinces = $this->getProvinces ();
		$province = urldecode ( $province );
		$stores = StoresModel::instance ()->getStroesByProvice ( $province );
		$stores = $this->matchUser ( $stores );
		return array ('provinces' => $provinces, 'current' => $province, 'stores' => $stores );
	}
	
	public function getMap() {
		$provinces = $this->getProvinces ();
		$rs = array ();
		foreach ( $provinces as $k => $v ) {
			$stores = StoresModel::instance ()->getStroesByProvice ( $v ['id'] );
			$st = $this->matchUser ( $stores );
			if (empty ( $st )) {
				continue;
			}
			$rs = array_merge ( $rs, $st );
		}
		return $rs;
	}
	
	//获取指定专卖店
	public function getStoresById($id) {
		return StoresModel::instance ()->getStoresById ( $id );
	}
	
	//按照优先级进行搜索
	public function search($name) {
		$provinces = $this->getProvinces ();
		$name = urldecode ( $name );
		
		$stores = $this->getStoresByMan ( $name );
		if (empty ( $stores )) {
			$stores = $this->getStoresByCity ( $name, $this->_limit );
		}
		$stores = $this->matchUser ( $stores );
		return array ('provinces' => $provinces, 'current' => "", 'stores' => $stores );
	
	}
	
	private function getStoresByCity($city, $limit) {
		return StoresModel::instance ()->getStroesLikeCity ( $city, $limit );
	}
	private function getStoresByTown($town, $limit) {
		return StoresModel::instance ()->getStroesLikeCity ( $town, $limit );
	}
	
	private function getStoresByAddress($address, $limit) {
		return StoresModel::instance ()->getStroesLikeAddress ( $address, $limit );
	}
	
	//匹配用户
	private function matchUser($stores) {
		
		if (empty ( $stores )) {
			return;
		}
		
		$member = new MemberService ();
		$pr = new ProvinceService ();
		foreach ( $stores as $k => $v ) {
			$stores [$k] ['status'] = $this->_status [$v ['status']];
			
			if (empty ( $v ['uid'] )) {
				continue;
			}
			
			$province = $pr->getProvinceById ( $v ['province'] );
			
			$city = $pr->getCityById ( $v ['city'] );
			$area = $pr->getAreasById ( $v ['town'] );
			$stores [$k] ['province'] = $province ['name'];
			$stores [$k] ['city'] = $city ['name'];
			$stores [$k] ['town'] = $area ['name'];
			
			$user = $member->getMemberByUid ( $v ['uid'] );
			$stores [$k] ['user'] = $user ['real_name'];
			$stores [$k] ['mobile_phone'] = $user ['mobile_phone'];
		}
		
		return $stores;
	}
	
	public function getStoresByMan($man) {
		return StoresModel::instance ()->getStoresByMan ( $man );
	}
	
	public function getStoresByUid($uid) {
		$rs = StoresModel::instance ()->getStroesByUid ( $uid );
		return $this->matchUser ( $rs );
	}
}

class StoresModel extends Db {
	
	private $_stores = 'w_stores';
	
	public function addStores($params) {
		return $this->add ( $this->_stores, $params );
	}
	
	public function saveAddressByWhere($address, $where) {
		return $this->update ( $this->_stores, array ('address' => $address ), $where );
	}
	
	public function getStroesByUid($uid) {
		return $this->getAll ( $this->_stores, array ('uid' => $uid ) );
	}
	
	//根据地级市获取专卖店
	public function getStroesLikeCity($city, $limit) {
		$sql = "SELECT * FROM $this->_stores WHERE city=$city LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	//根据地级市获取专卖店
	public function getStroesLikeTown($town, $limit) {
		$sql = "SELECT * FROM $this->_stores WHERE town=$town LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	//根据地级市获取专卖店
	public function getStroesLikeAddress($address, $limit) {
		$sql = "SELECT * FROM $this->_stores WHERE address LIKE '%$address%' LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	//根据省份获取专卖店
	public function getStroesByProvice($province) {
		return $this->getAll ( $this->_stores, array ('province' => $province ), null, 'city ASC' );
	}
	
	public function getStoresById($id) {
		return $this->getOne ( $this->_stores, array ('id' => $id ) );
	}
	
	public function saveStoreById($v, $id) {
		return $this->update ( $this->_stores, $v, array ('id' => $id ) );
	}
	
	public function removeStoresById($id) {
		return $this->delete ( $this->_stores, array ('id' => $id ) );
	}
	
	public function removeStoresByUid($uid) {
		return $this->delete ( $this->_stores, array ('uid' => $uid ) );
	}
	
	/**
	 * 
	 * @return StoresModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}