<?php
class TempController extends NodeController {
	/**
	 * 模板编辑
	 */
	public function tempList() {
		$rs = self::getTempService ()->listing ( $_GET ['p'], $_GET ['type'] );
		// 并且显示历史版本
		$this->view ()->assign ( 'type', $rs ['type'] );
		$this->view ()->assign ( 'typeid', trim ( $_GET ['type'] ) );
		$this->view ()->assign ( 'num', $rs ['page'] );
		$this->view ()->assign ( 'totalnum', $rs ['page'] ['totalnum'] );
		$this->view ()->assign ( 'templist', $rs ['list'] );
		$this->view ()->display ( 'file:temp/list.tpl' );
	}
	
	public function add() {
		$type = self::getTempService ()->getTemplateTypes ();
		$this->view ()->assign ( 'type', $type );
		
		$this->view ()->display ( "file:temp/add.tpl" );
	}
	
	public function search() {
		$rs = self::getTempService ()->search ( $_GET ['tempname'] );
		$this->view ()->assign ( 'num', array ('num' => 20, 'current' => 1, 'page' => 1 ) );
		$this->view ()->assign ( 'templist', $rs );
		$this->view ()->display ( 'file:temp/list.tpl' );
	}
	/**
	 * 获取历史版本
	 */
	public function history() {
		if ($_GET ['id'] > 0) {
			$id = $_GET ['id'];
		}
		$rs = TempModel::instance ()->getTempHistory ( array ('temp_id' => $id ), 'id,temp_id,date,remark,action' );
		$this->view ()->assign ( 'templist', $rs );
		$this->view ()->display ( 'file:temp/history.tpl' );
	}
	
	/**
	 * 编辑模板 来源历史模板或者主模板
	 */
	public function editTemp() {
		// 从分类编辑进入
		if (isset ( $_GET ['id'] )) {
			$param = $_GET ['id'];
		}
		if ($_GET ['name']) {
			$type = 1;
			$param = $_GET ['name'];
		}
		if ($_GET ['type'] == 'history') {
			$type = 2;
		}
		//这部分代码不应该放在这里
		$tempInfo = self::getTempService ()->parseTemp ( $param, $type );
		
		$this->view ()->assign ( 'tempinfo', $tempInfo );
		$this->view ()->display ( 'file:temp/edit.tpl' );
	}
	
	/**
	 * 保存分类
	 */
	public function saveTemp() {
		$rs = self::getTempService ()->saveTemp ( $_POST, $this->_user_global ['username'] );
		$this->sendNotice ( $rs ['message'], NULL, $rs ['status'] );
	
	}
	
	public function remove() {
		$rs = self::getTempService ()->remove ( $_POST ['id'] );
		
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	
	}
	
	public function addTempType() {
		$rs = self::getTempService ()->addTempType ( $_POST );
		$this->sendNotice ( $rs ['message'], $rs['data'], $rs ['status'] );
	
	}
	
	public function type() {
		$rs = self::getTempService ()->getTemplateTypes ();
		$this->view ()->assign ( 'group', $rs );
		$this->view ()->display ( 'file:temp/type.tpl' );
	}
	
	public function removeTempType() {
		
		$rs = self::getTempService ()->removeTempTypeById ( $_POST ['id'] );
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	
	}
	/**
	 * 添加模板
	 */
	public function addTemp() {
		
		echo self::getTempService ()->add ( $_POST );
	}
	
	public static function getTempService() {
		return new TempService ();
	}

}