<?php
/**
 * 回执功能
 * @author wolf
 * @since 2015-06-06
 *
 */
class ReceiptService {
	const SUCCESS = 'success';
	const ERROR = 'error';
	private $_num = 500;
	private $_status = array (0 => '未操作', 1 => '赞成', 2 => "反对" );
	/*添加回执状态*/
	public function save($nid, $uid) {
		if (! $this->checkIsExsit ( $uid, $nid )) {
			return "已经确认过了";
		}
		$rs = ReceiptModel::instance ()->addReceipt ( array ('nid' => $nid, 'uid' => $uid, 'add_time' => time () ) );
		return $rs > 0 ? self::SUCCESS : self::ERROR;
	}
	public function getNumByNid($nid) {
		$num = ReceiptModel::instance ()->getNumByNid ( $nid );
		return $num ['num'];
	}
	public function getJSONReceiptByNid($nid) {
		return ReceiptModel::instance ()->getReceiptByNid ( $nid, $this->_num );
	}
	/**
	 * 
	 * @param int $uid
	 * @param int $nid
	 * @return Boolean true 不存在 false 存在
	 */
	public function checkIsExsit($uid, $nid) {
		$rs = ReceiptModel::instance ()->getReceiptByWhere ( array ('uid' => $uid, 'nid' => $nid ) );
		return empty ( $rs );
	}
	public function getReceiptByNid($nid) {
		return ReceiptModel::instance ()->getReceiptByWhere ( array ('nid' => $nid ) );
	}
	/**
	 *获取已确认的名单分页 
	 */
	public function getReceiptPage($p, $nid) {
		$total = $this->getNumByNid ( $nid );
		$page = $this->page ( $total, $p, $this->_num );
		$rs = ReceiptModel::instance ()->getReceiptPage ( $page ['start'], $this->_num, $nid );
		$member = new MemberService ();
		$oa = new OAService ();
		foreach ( $rs as $k => $v ) {
			$user = $member->getMemberByUid ( $v ['uid'] );
			$rs [$k] ['real_name'] = $user ['real_name'];
			$erpuser = $oa->ERPUserAPI ( $user ['real_name'] );
			if (! $erpuser ['status']) {
				unset ( $rs [$k] );
				continue;
			}
			$rs [$k] ['junqu'] = $erpuser ['junqu'];
			$rs [$k] ['area'] = $erpuser ['area'];
		}
		return array ('page' => $page, 'data' => $rs );
	}
	public function getReceiptByUid($uid) {
		return ReceiptModel::instance ()->getReceiptByWhere ( array ('uid' => $uid ) );
	}
	private function getReceiptByWhere($where) {
		return ReceiptModel::instance ()->getReceiptByWhere ( $where );
	}
	/**
	 * 分页
	 *
	 * @return Array
	 */
	private function page($total, $pageid, $num) {
		$pageid = isset ( $pageid ) ? $pageid : 1;
		$start = ($pageid - 1) * $num;
		$pagenum = ceil ( $total / $num );
		/*修正分类不包含内容 显示404错误*/
		$pagenum = $pagenum == 0 ? 1 : $pagenum;
		/*如果超过了分类页数 404错误*/
		if ($pageid > $pagenum) {
			return false;
		}
		$page = array ('start' => $start, 'num' => $num, 'current' => $pageid, 'page' => $pagenum );
		return $page;
	}
}
class ReceiptModel extends Db {
	private $_receipt = 'd_receipt';
	public function addReceipt($params) {
		return $this->add ( $this->_receipt, $params );
	}
	public function getReceiptByWhere($where) {
		return $this->getAll ( $this->_receipt, $where );
	}
	public function getReceiptPage($start, $num, $nid) {
		return $this->getPage ( $start, $num, $this->_receipt, null, array ('nid' => $nid ) );
	}
	public function getNumByNid($nid) {
		$sql = "SELECT count(id) num FROM $this->_receipt WHERE nid=$nid";
		return $this->fetch ( $sql );
	}
	/**
	 * 查看哪些人已经确认了
	 * @param unknown_type $nid
	 * @param unknown_type $limit
	 */
	public function getReceiptByNid($nid, $limit) {
		$sql = "select a.*,b.real_name,b.face,b.area from d_receipt a left join w_member_list b on a.uid=b.uid where a.nid=$nid LIMIT $limit";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * @return ReceiptModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}