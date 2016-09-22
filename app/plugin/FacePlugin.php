<?php
/**
 * 头像随机展示
 * @author Administrator
 *
 */
class FacePlugin extends BasePlugin {
	
	protected $name = '头像插件';
	protected $type = 'login';
	protected $config = array ('num' => 12 );
	
	/* (non-PHPdoc)
	 * @see IPlugin::api()
	 */
	public function api() {
		//测试方法
		if (empty ( $_POST ['area'] )) {
			return "不能为空";
		} else {
			$v = trim ( $_POST ['area'] );
		}
		$rs = MemberModel::instance ()->setMemberByWhere ( array ('area' => $v ), array ('uid' => $this->_user_global ['uid'] ) );
		
		$this->sendNotice ( "更新成功" );
	
	}
	
	public function v() {
	}
	/* (non-PHPdoc)
	 * @see IPlugin::run()
	 */
	public function run() {
		//头像审核状态
		$status = $this->getFaceStatus ( $this->_user_global ['uid'] );
		if (empty ( $status )) {
			$status = array ('status' => 1 );
		}
		$face = $this->getRandFace ();
		$face ['status'] = $status;
				
		$this->view ()->assign ( 'face', $face );
	}
	
	public function getFaceStatus($uid) {
		return FaceModel::instance ()->getFaceByUid ( $uid );
	}
	
	public function getRandFace() {
		return FaceModel::instance ()->getRandFace ( $this->config ['num'] );
	}
}

