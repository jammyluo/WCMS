<?php
/**
 * 插件抽象接口
 * Member Login News Single目前就3个
 * @author Wolf
 *
 */
class BasePlugin implements IPlugin {
	
	protected $name; //插件名
	protected $type; //插件类型
	protected $_user_global; //用户名
	protected $_group;
	public $contentParams; //cid和id
	static $memberService;
	const COOKIENAME = 'user'; //和登录器中的要一致
	const SUCCESS = 'success';
	const ERROR = 'error';
	/* (non-PHPdoc)
	 * @see IPlugin::api()
	 */
	public function api() {
		// TODO Auto-generated method stub
	

	}
	
	/* (non-PHPdoc)
	 * @see IPlugin::run()
	 */
	public function run() {
		// TODO Auto-generated method stub
	

	}
	
	/* (non-PHPdoc)
	 * @see IPlugin::v()
	 */
	public function v() {
		// TODO Auto-generated method stub
	

	}
	
	public function __construct() {
		//如果cookie存在 那么自动生成session
		if (isset ( $_COOKIE [self::COOKIENAME] )) {
			$userInfo = self::getMemberService ()->getMemberByUsername ( $_COOKIE [self::COOKIENAME] );
			$this->_group = self::getMemberService ()->_group;
			$this->_user_global = $userInfo;
		}
	}
	public static function getLogService() {
		return new LogService ();
	}
	public static function getMemberService() {
		if (self::$memberService == null) {
			self::$memberService = new MemberService ();
		}
		return self::$memberService;
	}
	
	protected function view() {
		return View::getInstance (); //每次都需要初始化
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getType() {
		return $this->type;
	}
	
	/**
	 * 返回json格式
	 *
	 * @param unknown_type $error        	
	 * @param unknown_type $data        	
	 * @param unknown_type $status        	
	 */
	protected function sendNotice($error, $data = NULL, $status = FALSE) {
		$res = array ('status' => $status, 'message' => $error, 'data' => $data );
		echo json_encode ( $res );
		exit ();
	}

}