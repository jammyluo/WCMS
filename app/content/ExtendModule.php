<?php
class ExtendModule extends Module {
	/* (non-PHPdoc)
	 * @see IModule::remove()
	 */
	public function remove($where) {
		ExtendModel::instance ()->DeleteExtendDecimal ( $where );
		ExtendModel::instance ()->DeleteExtendInt ( $where );
		ExtendModel::instance ()->DeleteExtendVarchar ( $where );
	}
	
	/* (non-PHPdoc)
     * @see IModule::add()
     */
	public function add($data) {
		// 增加扩展字段的值  添加一对多
		$extend = $this->addExtendArray ( $data, $data ['nid'] );
		$this->addExtend ( $extend, 1, $data ['nid'] );
	}
	
	/* (non-PHPdoc)
     * @see IModule::getCon()
     */
	public function getCon($id) {
		$rs = NewsModel::instance ()->getNewsWhere ( array ('id' => $id ) );
		/* 过滤是否属于该分类 */
		$ids = 1; //设置默认参数
		if (! empty ( $rs ['cid'] )) {
			$ids = $this->getParentCate ( $rs ['cid'] );
		}
		
		//获取绑定分类的扩展字段
		$extendCate = CategoryModel::instance ()->getCateExtend ( $ids );
		//可能为空
		if (empty ( $extendCate ))
			return;
		
		$eids = array ();
		//根据字段类型分组查询
		foreach ( $extendCate as $v ) {
			$eids [$v ['type']] .= $v ['eid'] . ",";
		}
		
		foreach ( $eids as $k => $v ) {
			$eids [$k] = substr ( $v, 0, strlen ( $v ) - 1 );
		}
		
		// 查找扩展字段 可能不存在
		if (! empty ( $eids )) {
			//查询是否获取数据
			$extend = array ();
			$extend1 = array ();
			$extend2 = array ();
			$extend3 = array ();
			if (! empty ( $eids ['varchar'] )) {
				$extend1 = ExtendModel::instance ()->getExtendVarchar ( $id, $eids ['varchar'] );
			
			}
			if (! empty ( $eids ['int'] )) {
				$extend2 = ExtendModel::instance ()->getExtendInt ( $id, $eids ['int'] );
			
			}
			if (! empty ( $eids ['decimal'] )) {
				$extend3 = ExtendModel::instance ()->getExtendDecimal ( $id, $eids ['decimal'] );
			
			}
			$extend = array_merge ( $extend1, $extend2, $extend3 );
			/**
			 * bugfix:修正多个属性 对于后创建的多值扩展字段 2013-4-23 转换相同的值
			 * 1 没有值的情况
			 * 2 有1-2个值的情况
			 * 3 后添加绑定字段 根据循环长度 这里交给前段javascript创建
			 */
			$keys = array ();
			foreach ( $extend as $k => $v ) {
				//如果是多个值
				if ($v ['status'] < 3) {
					$keys [$v ['key']] = $k;
					$extend [$k] ['value'] = $v ['value'];
					continue;
				}
				
				$extend [$keys [$v ['key']]] ['value'] [$v ['id']] = $v ['value'];
				unset ( $extend [$k] );
			}
		}
		//检查哪些值已经被赋值
		foreach ( $extendCate as $k => $v ) {
			if (isset ( $keys [$v ['key']] )) {
				continue;
			} else {
				array_push ( $extend, $v );
			}
		}
		return $extend;
	}
	/**
	 * 
	 * 返回指定分类下的所有扩展字段
	 * @param int $categoryid
	 * @return $exntend
	 */
	public function getExtendByCid($categoryid) {
		/**
		 * 基本字段+扩展字段 status=1
		 */
		/* 获取分类扩展字段 */
		
		if (! empty ( $categoryid )) {
			$ids = $this->getParentCate ( $categoryid );
		}
		//加载扩展字段
		return CategoryModel::instance ()->getCateExtend ( $ids );
	}
	
	private function addExtend($data, $moduleid, $gid) {
		
		// 2013-4-17 修正不是扩展字段不添加
		$extendKey = ExtendModel::instance ()->getExtend ( array ('moduleid' => $moduleid ) );
		
		foreach ( $extendKey as $v ) {
			// 2013-4-18 支持数组 一对多的情况
			if (empty ( $data [$v ['key']] )) {
				continue;
			}
			$value = $data [$v ['key']];
			$pargam = array ('gid' => $gid, 'moduleid' => $moduleid, 'eid' => $v ['eid'], 'value' => $value );
			
			//分字段插入
			switch ($v ['type']) {
				case "varchar" :
					ExtendModel::instance ()->addExtendVarchar ( $pargam );
					break;
				case "int" :
					ExtendModel::instance ()->addExtendInt ( $pargam );
					break;
				case "decimal" :
					ExtendModel::instance ()->addExtendDecimal ( $pargam );
					break;
			
			}
		}
	}
	/**
	 * 判断数组中是否还有数组 进行重组
	 *
	 * @param array $arr        	
	 * @return array
	 */
	private function addExtendArray($arr, $gid) {
		foreach ( $arr as $k => $v ) {
			if (! is_array ( $v )) {
				continue;
			}
			foreach ( $v as $sonv ) {
				$new = array ($k => $sonv );
				/* 批量添加 */
				$this->addExtend ( $new, 'news', $gid );
			}
			unset ( $arr [$k] ); // 删除
		}
		return $arr;
	}
	
	/* (non-PHPdoc)
     * @see IModule::save()
     */
	public function save($arrValue, $id) {
		$extendId = 1;
		// 增加扩展字段的值
		unset ( $arrValue ['category'], $arrValue ['flag'], $arrValue ['groupid'] );
		// 增加一对多的情况 2013-4-18
		foreach ( $arrValue as $k => $v ) {
			if (! is_array ( $v )) {
				continue;
			}
			foreach ( $v as $sk => $sonv ) {
				$new = array ($k => $sonv );
				/* 批量添加 */
				$this->addExtend ( $new, $id, $sk );
			}
			unset ( $arrValue [$k] ); // 删除
		}
		$exist = $this->getCon ( $id );
		
		if (empty ( $exist )) {
			return;
		}
		$extend = array_diff_key ( $arrValue, $exist );
		/* 不是扩展字段的情况2013-4-17 */
		// 2013-4-17 修正不是扩展字段不添加
		unset ( $extend ['height'], $extend ['width'], $extend ['preid'], $extend ['p'], $extend ['same'] );
		/**
		 * bugfix #假如一开始的内容没有新增字段 那么先查找 用insert方法
		 */
		foreach ( $extend as $k => $v ) {
			$keyInfo = ExtendModel::instance ()->getExtend ( array ('key' => $k ) );
			//指定更新
			if (! empty ( $extendId )) {
				$where = array ('id' => $extendId, 'gid' => $id, 'key' => $k );
			} else {
				$where = array ('gid' => $id, 'eid' => $keyInfo [0] ['eid'] );
			}
			// 搜索记录是否存在
			

			//增加
			$params = array ('value' => $v, 'moduleid' => 1, 'eid' => $keyInfo [0] ['eid'], 'gid' => $id );
			
			$value = array ('value' => $v );
			$where = array ('eid' => $keyInfo [0] ['eid'], 'gid' => $id );
			
			switch ($keyInfo [0] ['type']) {
				case "varchar" :
					$flag = ExtendModel::instance ()->getExtendVarcharByWhere ( $id, 1, $keyInfo [0] ['key'] );
					
					if (empty ( $flag ) && ! empty ( $v )) {
						ExtendModel::instance ()->addExtendVarchar ( $params );
					} else {
						ExtendModel::instance ()->saveExtendVarchar ( $value, $where );
					}
					break;
				
				case "decimal" :
					$flag = ExtendModel::instance ()->getExtendDecimalByWhere ( $id, 1, $keyInfo [0] ['key'] );
					if (empty ( $flag ) && ! empty ( $v )) {
						ExtendModel::instance ()->addExtendDecimal ( $params );
					} else {
						ExtendModel::instance ()->saveExtendDecimal ( $value, $where );
					}
					break;
				
				case "int" :
					$flag = ExtendModel::instance ()->getExtendIntByWhere ( $id, 1, $keyInfo [0] ['key'] );
					if (empty ( $flag ) && ! empty ( $v )) {
						ExtendModel::instance ()->addExtendInt ( $params );
					} else {
						ExtendModel::instance ()->saveExtendInt ( $value, $where );
					}
					break;
			
			}
		}
	
	}
	/* (non-PHPdoc)
	 * @see IModule::setCon()
	 */
	public function setCon($data) {
	
	}
	
	/* (non-PHPdoc)
	 * @see IModule::temp()
	 */
	public function temp($type) {
	
	}
	/**
	 * 
	 * @return ExtendModule
	 */
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}