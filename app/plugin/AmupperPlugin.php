<?php
class AmupperPlugin extends BasePlugin {
	protected $name = '签到插件';
	protected $type = 'login';
	
	static $amupperService;
	/* (non-PHPdoc)
	 * @see IPlugin::api()
	 */
	public function api() {
		$rs = self::getAmupperService ()->addUser ( $this->_user_global ['uid'], $this->_user_global ['real_name'] );
		//排名
		$rank = self::getAmupperService ()->getDayRank ( $this->_user_global ['uid'] );
		$user = self::getAmupperService ()->getUser ( $this->_user_global ['uid'] );
		$user ['dayrank'] = $rank;
		
		$user['today']=self::getAmupperService()->getTodayRankByUid($this->_user_global ['uid']);
		//增加日志
		

		self::getLogService ()->add ( $this->_user_global ['username'], "签到" );
		
		$this->sendNotice ( $rs, $user );
	}
	
	/* 是否已经签到过了
	 * @see IPlugin::run()
	 */
	public function run() {
		$rs = self::getAmupperService ()->checkToday ( $this->_user_global ['uid'] );
		$rs = ! $rs ? self::ERROR : self::SUCCESS;
		$user = self::getAmupperService ()->getUser ( $this->_user_global ['uid'] );
		$rank = self::getAmupperService ()->getDayRank ( $this->_user_global ['uid'] );
				$user['today']=self::getAmupperService()->getTodayRankByUid($this->_user_global ['uid']);

		$user ['dayrank'] = $rank;
		$user ['isamupper'] = $rs;
		$this->view ()->assign ( 'amupper', $user );
	}
	
	/**
	 * 查看列表 一次性加载3天的数据
	 * */
	public function v() {
		
		for($i = 1; $i <= 5; $i ++) {
			$rank [$i] = self::getAmupperService ()->getUserByTotal ( $i );
		}
		$rs = self::getAmupperService ()->getListByDays ( 1 );
		
		//增加排名
		$money = self::getAmupperService ()->getMoneyTop ();
		
		$this->view ()->assign ( 'money', $money );
		$this->view ()->assign ( 'rank', $rank );
		
		$this->view ()->assign ( 'user', $this->_user_global );
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( "mysql:amupper.tpl" );
	}
	
	public static function getAmupperService() {
		if (self::$amupperService == null) {
			self::$amupperService = new AmupperService ();
		}
		return self::$amupperService;
	}

}

//签到
class AmupperService {
	const SUCCESS = 'success';
	const ERROR = 'error';
	private $_coupons = 10; //赠送的积分值
	private $_limit = 50; //前几名
	private $_rankReward = array ('30' => 50, '60' => 0 ); //登记奖励
	

	public function addUser($uid, $username) {
		if (! $this->checkToday ( $uid )) {
			return "你已经签到过了哦!";
		}
		$this->always ( $uid );
		$rs = AmupperModel::instance ()->save ( array ('uid' => $uid, 'add_time' => time (), 'days' => date ( "Ymd", time () ) ) );
		
		if ($rs < 1) {
			return self::ERROR;
		}
		//增加积分
		$rs = $this->addCoupons ( $uid, $username );
		
		//增加转盘次数
		$user = $this->getUser ( $uid );
		if ($user ['total'] >= 60) {
			//$this->addWheelNum ( $uid );
		}
		return $rs;
	
	}
	
	public function setData() {
		return AmupperModel::instance ()->getUserNumByDay ( 7 );
	}
	
	public function getTodayRank($uid) {
		AmupperModel::instance ()->getUserByWhere ();
	}
	
	/**
	 * 判断是否连续签到 和签到总天数
	 * 新人签到
	 */
	private function always($uid) {
		$days = AmupperModel::instance ()->getUserLastAmupper ( $uid );
		$sys = date ( "Ymd", strtotime ( "-1 day" ) );
		$user = AmupperModel::instance ()->getUserByUid ( $uid );
		
		//第一次签到
		if (empty ( $user )) {
			$rs = AmupperModel::instance ()->addUser ( array ('uid' => $uid, 'day' => 1, 'total' => 1 ) );
			return $rs > 0 ? self::SUCCESS : self::ERROR;
		}
		
		$days = empty ( $days ) ? "20140101" : $days ['days'];
		$total = $user ['total'] + 1;
		
		if ($sys == $days) {
			//增加
			$day = $user ['day'] + 1;
		} else {
			//重新开始 1
			$day = 1;
		}
		$rs = AmupperModel::instance ()->saveUser ( array ('day' => $day, 'total' => $total ), $uid );
		return $rs > 0 ? self::SUCCESS : self::ERROR;
	}
	public function getUser($uid) {
		$rs = AmupperModel::instance ()->getUserByUid ( $uid );
		$rs ['vip'] = $this->matchVip ( $rs ['total'] );
		return $rs;
	}
	
	//增加转盘次数
	private function addWheelNum($uid) {
		require 'WheelPlugin.php';
		$wheel = new WheelService ();
		$source = date ( "md", time () ) . '黄金会员每日赠送';
		$wheel->addWheelNum ( $uid, 1, 1, $source );
	}
	
	/**
	 * 连续签到排名
	 * @return int 排名
	 */
	public function getDayRank($uid) {
		$rs = AmupperModel::instance ()->getRankByDay ();
		foreach ( $rs as $k => $v ) {
			
			if ($v ['uid'] == $uid) {
				$k = $k + 1;
				return $k;
			}
		}
		return ">1000";
	
	}
	
	/**
	 * 获取排名
	 * @param unknown_type $rank
	 */
	public function getUserByTotal($rank) {
		switch ($rank) {
			case 1 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 0, 10, 200 );
				break;
			case 2 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 10, 30 );
				break;
			case 3 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 30, 60 );
				break;
			case 4 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 60, 100 );
				break;
			case 5 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 100, 500 );
                break;
            case 6 :
				$rs = AmupperModel::instance ()->getListGroupByTotal ( 500, 1000 );
				break;
		}
		//检查昨天有无签到 今天有无签到
		foreach ( $rs as $k => $v ) {
			$yesterday = $this->checkYesTerday ( $v ['uid'] );
			
			$today = $this->checkToday ( $v ['uid'] );
			$rs [$k] ['status'] = ! $today ? '↑' : '-';
			
			if ($yesterday && $today) {
				$rs [$k] ['status'] = '↓';
			}
		
		}
		return $rs;
	}
	/**
	 * 增加积分值
	 * @param unknown_type $uid
	 * @param unknown_type $username
	 */
	private function addCoupons($uid, $username) {
		
		$member = new MemberService ();
		$user = $member->getMemberByUid ( $uid );
		//过滤用户
		if (! $this->filterUser ( $user )) {
			return "签到成功";
		}
		//创建充值系统
		$couponsService = new CouponsService ();
		
		//等级奖励
		$reward = $this->getUserRankReward ( $uid );
		$notice = '';
		
		if ($reward ['coupons'] > 0) {
			$remark = "连续签到" . $reward ['rank'] . "天奖励";
			$rewardrs = $couponsService->addCoupons ( $uid, $username, $reward ['coupons'], $remark );
			
			if ($rewardrs < 1) {
				return "等级奖励充值失败";
			}
			
			$member->saveCoupons ( $uid, $reward ['coupons'], 0 );
			$notice = "+等级积分" . $reward ['coupons'];
		}
		
		
		//今天的
		if (! $this->checkTopFifty ( $uid )) {
			return "签到成功,今天的积分已送完,早起的鸟儿有虫吃,请明天加油！" . $notice;
		}
		
		//增加历史记录
		$remark = date ( "md", time () ) . '签到积分';
		//前50名的记录
		$rs = $couponsService->addCoupons ( $uid, $username, $this->_coupons, $remark );
		
		//是否有记录
		if ($rs < 1) {
			return "签到成功，但充值失败了";
		}
		
		//修改用户积分额度
		$member->saveCoupons ( $uid, $this->_coupons, 0 );
		
		return "签到成功！恭喜你，获得" . $this->_coupons . " 积分" . $notice;
	}
	
	/**
	 * 过滤用户
	 * @param unknown_type $user
	 * @return boolean true 不过滤 false 过滤
	 */
	private function filterUser($user) {
		
		return $user['verify']==1;
	}
	
	//检查是否是前50名
	private function checkTopFifty($uid) {
		$rs = $this->getListByDays ( 1 );
		foreach ( $rs as $k => $v ) {
			if ($v ['uid'] == $uid) {
				$rank = $k + 1;
				break;
			}
		}
		//是否进入前50名
		if ($rank > $this->_limit) {
			return false;
		}
		
		return true;
	}
	
		//今天排名
	public function getTodayRankByUid($uid) {
		$rs = $this->getListByDays ( 1 );
		foreach ( $rs as $k => $v ) {
			if ($v ['uid'] == $uid) {
				$rank = $k + 1;
				break;
			}
		}
	
		
		return $rank;
	}
	
	/**
	 * 等级奖励
	 * @param int $uid
	 */
	public function getUserRankReward($uid) {
		$user = AmupperModel::instance ()->getUserByUid ( $uid );
		
		switch ($user ['total']) {
			case 30 :
				$coupons = $this->_rankReward [30];
				break;
			case 60 :
				$coupons = $this->_rankReward [60];
				break;
			default :
				$coupons = 0;
		
		}
		
		return array ('rank' => $user ['total'], 'coupons' => $coupons );
	}
	
	//最小
	public function getMoneyTop() {
		
		return AmupperModel::instance ()->getMoneyTop ( 50 );
	}
	
	/**
	 * 
	 * @param int $day 1今天 2昨天
	 * @return Array
	 */
	public function getListByDays($day) {
		
		switch ($day) {
			case 1 :
				$time = date ( "Ymd", time () );
				break;
			case 2 :
				$time = date ( "Ymd", strtotime ( '-1 day' ) );
				break;
			case 3 :
				$time = date ( "Ymd", strtotime ( '-2 day' ) );
				break;
			default :
				$time = date ( "Ymd", time () );
				break;
		}
		
		$rs = AmupperModel::instance ()->getListByDays ( $time );
		foreach ( $rs as $k => $v ) {
			$info = AmupperModel::instance ()->getUserByUid ( $v ['uid'] );
			$rs [$k] ['total'] = $info ['total'];
			$rs [$k] ['day'] = $info ['day'];
			$rs[$k]['medal']=$info['medal'];
			//导入vip机制
			$rs [$k] ['vip'] = $this->matchVip ( $info ['total'] );
		}
		return $rs;
	}
	//vip算法
	private function matchVip($value) {
		switch ($value) {
			case $value < 10 :
				return 0;
				break;
			case $value < 30 && $value >= 10 :
				return 1;
				break;
			case $value < 60 && $value >= 30 :
				return 2;
				break;
			case $value < 100 && $value >= 60 :
				return 3;
				break;
			case $value >= 100 :
				return 4;
				break;
			default :
				return 0;
				break;
		}
	}
	/**
	 * 检查是否已经打过卡
	 * @return boolean true 没有 false 已经打过卡
	 */
	public function checkToday($uid) {
		$rs = AmupperModel::instance ()->getUserByWhere ( array ('days' => date ( "Ymd", time () ), 'uid' => $uid ) );
		return empty ( $rs );
	}
	
	public function checkYesTerday($uid) {
		$rs = AmupperModel::instance ()->getUserByWhere ( array ('days' => date ( "Ymd", strtotime ( "-1 day" ) ), 'uid' => $uid ) );
		return empty ( $rs );
	}

}

class AmupperModel extends MemberModel {
	
	private $_amupper = 'd_amupper'; //签到明细
	private $_amupper_user = 'd_amupper_user'; //判断是否连续签到
	

	public function getUserByUid($uid) {
		return $this->getOne ( $this->_amupper_user, array ('uid' => $uid ) );
	}
	
	public function getRankByDay() {
		return $this->getAll ( $this->_amupper_user, null, 'uid', 'total desc' );
	}
	
	//更新签到用户信息
	public function saveUser($v, $uid) {
		return $this->update ( $this->_amupper_user, $v, array ('uid' => $uid ) );
	}
	//新增签到用户
	public function addUser($params) {
		return $this->add ( $this->_amupper_user, $params );
	}
	
	public function save($params) {
		return $this->add ( $this->_amupper, $params );
	}
	
	public function getUserByWhere($where) {
		return $this->getOne ( $this->_amupper, $where );
	}
	
	public function getUserLastAmupper($uid) {
		$sql = "SELECT `days` FROM $this->_amupper WHERE uid=$uid ORDER BY id DESC LIMIT 1";
		return $this->fetch ( $sql );
	}
	
	public function getUserNumByDay($limit) {
		$sql = "SELECT count(uid) num,days,add_time from d_amupper  group by days ORDER BY days DESC LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 返回时间
	 * Enter description here ...
	 * @param unknown_type $days
	 */
	public function getListByDays($days) {
		$sql = "SELECT a.*,b.username,b.real_name,b.face,b.area,b.groupid FROM $this->_amupper a LEFT JOIN $this->_member_list b ON a.uid=b.uid WHERE a.days='$days' order by id ASC";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 根据总签到进行排名
	 * @param unknown_type $days
	 */
	public function getListGroupByTotal($min, $max, $limit = 200) {
		$sql = "SELECT a.*,b.username,b.real_name,b.face,b.area,b.groupid FROM $this->_amupper_user a LEFT JOIN $this->_member_list b ON a.uid=b.uid WHERE total>=$min and total<$max order by total DESC,day DESC LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	
	//上升比较快的队员
	public function getMoneyTop($limit) {
		$sql = "select sum(a.coupons) money,count(a.uid) fifty,b.real_name,b.face,b.area,b.groupid,b.lastlogin from w_coupons_history a LEFT JOIN w_member_list b ON a.uid=b.uid where a.remark like \"%签到%\" group by a.uid order by money DESC LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * @return AmupperModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}