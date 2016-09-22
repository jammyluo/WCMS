<?php
class FaceController extends NodeController {

	/**
	 * 头像上传入口
	 */
	public function index() {
		$message = $this->isLogin ();
		if ($message != self::SUCEESS) {
			$this->authorizeTemp ( $message );
			return;
		}
		$sys=new SysService();

		$config=$sys->getConfig();
		$this->view()->assign('config',$config);

		$this->view ()->display ( "file:face/index.tpl" );
	}
	/**
	 * 头像审核列表
	 */
	public function faceList() {
		$rs = self::getFaceService ()->getVaildFaceList ();
		$this->view ()->assign ( 'list', $rs );
		$this->view ()->display ( 'file:member/face.tpl' );
	}

	//审核通过，修改图片名称，防止覆盖掉
	public function vaild() {
		$rs = self::getFaceService ()->validFace ( $_POST ['id'], $_POST ['type'] );

		if ($_POST ['type'] == 'pass') {
			$message = self::getMemberService ()->saveMemberByUid ( array ('face' => $rs ['face'] ), $rs ['uid'] );
		} else {
			$message = self::getMemberService ()->saveMemberByUid ( array ('face' => "" ), $rs ['uid'] );
		}

		$this->sendNotice ( $message );
	}

	/**
	 * 上传头像原始大小
	 */
	public function setFace() {
		self::getLogService ()->add ( $this->_user_global ['real_name'], "更改头像" );
		echo self::getFaceService ()->upload ( $this->_user_global );

	}

	public static function getFaceService() {
		return new FaceService ();
	}

}
