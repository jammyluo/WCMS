<?php
/**
 * 权限处理器  如果继承了这个方法 那么都需要需要配置权限
 *@author wolf  [Email: 116311316@qq.com]
 *@since 2011-07-20
 *@version 1.0
 */
abstract class NodeController extends Action {
	// 用户信息统一
	protected $_user_global;
	const COOKIENAME = 'user';
	protected $_group;
	
	/**
	 * 检验权限
	 */
	public function _routeDown() {
		$controller = $this->getControllerName (); // 当前控制器
		$action = $this->getActionName (); // 当前动作
		$islogin = false;
		//如果cookie存在 那么自动生成session
		
		if (isset ( $_COOKIE [self::COOKIENAME] )) {
		    $memberCenter=new MemberCenterModule();
		    $userInfo =$memberCenter->getUserByCookie($_COOKIE[self::COOKIENAME]);
			$this->_group = self::getMemberService ()->_group;//
			$this->_user_global = $userInfo;
			$islogin = true;
			$this->view ()->assign ( 'user', $userInfo ); // 导入用户信息
		}
		
		// 排除无需权限方法  
		$allowAction = require 'authorize.php';
		
		//模块访问权限 
		

		if (! in_array ( $action, ($allowAction [$controller]) )) {
			
			if ($this->_user_global ['manager'] > 2 || ! $islogin) {
				$this->warning ( '需要管理员权限才能进入' );
			} else {
				return self::SUCEESS;
			}
		}
		
		// 游客验证 登录之后 有注册会员 实名认证 管理员 和超级管理员之分 非管理管理员 都需要操作权限检验
		

		/* 检查被访问的页面 是否需要权限 */
		if ($action == 'c' || $action == 'i' ||$action =='goods') {
			$cid = isset ( $_REQUEST ['cid'] ) ? $_REQUEST ['cid'] : 1;
			$category = CategoryModel::instance ()->getCateogryById ( $cid );
			
			if ($category ['groupid'] == 5) {
				return self::SUCEESS;
			}
			
			if (! $this->validteNode ( $this->_user_global ['manager'], $category ['groupid'] ) || ! $islogin) {
				$this->warning ( '权限不够，需要实名认证' );
			}
		}
		
		if ($action == 'v') {
			// 内容权限大于分类权限 如果为7 就是继承分类权限 分类默认是游客
			$news = NewsModel::instance ()->getNewsWhere ( array ('id' => $_REQUEST ['id'] ) );
			
			if (empty ( $news ['groupid'] )) {
				$category = CategoryModel::instance ()->getCateogryById ( $news ['cid'] );
				$news ['groupid'] = $category ['groupid'];
			}
			
			if ($news ['groupid'] == 5) {
				return self::SUCEESS;
			}
			
			if (! $this->validteNode ( $this->_user_global ['manager'], $news ['groupid'] ) || ! $islogin) {
				$this->warning ( '权限不够，需要实名认证' );
			}
		
		}
		
	}
	
	public function isLogin() {
		if (! isset ( $_COOKIE [self::COOKIENAME] )) {
			$this->warning ( '请先登录' );
		} else {
			return self::SUCEESS;
		}
	}

	

  
	// 是否实名认证
	public function isVerify() {
	    
		if ($this->_user_global ['manager'] > 3 || ! isset ( $_COOKIE [self::COOKIENAME] )) {
			$this->warning ( '你的权限不够，未实名认证' );
		}
		return self::SUCEESS;
	}
	
	
	
	protected function warning($error) {
		$this->view ()->assign ( "error", $error );
		$this->view ()->display ( "file:public/error.tpl" );
		exit ();
	}
	
	/**
	 * 
	 * @param int $manager
	 * @param int $sys
	 * @return boolean true 可以 false 不可以
	 */
	public function validteNode($manager, $sys) {
		
		return $manager <= $sys;
	
	}
	
	/**
	 * 用户服务类
	 */
	public static function getMemberService() {
		return new MemberService ();
	}
	
	public static function getNewsService() {
		return new NewsService ( $_REQUEST ['cid'], $_REQUEST ['mid'] );
	}

}