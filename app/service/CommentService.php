<?php
/**
 * 评论服务类   无需和用户或者新闻进行绑定
 * 功能 评论和回复
 * @author wolf
 *
 */
class CommentService {
	private $_comment_status = array ('0' => "未审核", '1' => "已处理" );
	const SUCCESS = 'success';
	const ERROR = 'error';
	/**
	 * 新增评论
	 * @param array $arr
	 */
	public function add($param) {
		$param = $this->parseParam ( $param );
		return CommentModel::instance ()->addComment ( $param );
	}
	public function removeComment($id) {
		//匹配图片
		$comment = $this->getCommentById ( $id );
		$this->delCommentImage ( $comment ['comment'] );
		$rs = CommentModel::instance ()->delComment ( array ('id' => $id ) );
		$this->removeReplyByGid ( $id );
		return array ('status' => true, 'message' => "删除成功" );
	
	}
	private function delCommentImage($con) {
		$match = "#src=\"(.*)\"#iUs";
		preg_match_all ( $match, $con, $rs );
		if (empty ( $rs )) {
			return;
		}
		//删除内容图片
		foreach ( $rs [1] as $v ) {
			@unlink ( ROOT . $v );
		}
	}
	public function getCommentById($id) {
		return CommentModel::instance ()->getCommentById ( $id );
	}
	public function getCommentByNid($nid, $num) {
		return CommentModel::instance ()->getComment ( array ('nid' => $nid ), $num );
	}
	/**
	 * 新闻回复
	 */
	public function reply($param) {
		$rs = $this->add ( array ('reply' => 1, 'real_name' => $param ['real_name'], 'nid' => $param ['nid'], 'gid' => $param ['gid'], 'comment' => $param ['comment'] ) );
		$this->saveStatusCommentById ( 1, $param ['gid'] );
		if ($rs > 0) {
			return array ('status' => true );
		} else {
			return array ('status' => false );
		}
	}
	//更新评论状态
	public function saveStatusCommentById($status, $id) {
		return CommentModel::instance ()->saveCommentStatus ( array ('status' => $status ), array ('id' => $id ) );
	}
	
	public function removeReplyByGid($gid) {
		return CommentModel::instance ()->removeReplyByGid ( $gid );
	}
	
	//获取回复
	public function getReplyByGid($gid) {
		return CommentModel::instance ()->getCommentByGid ( $gid );
	}
	/**
	 * 对值进行处理EW
	 * Enter description here ...
	 * @param unknown_type $param
	 */
	private function parseParam($param) {
		foreach ( $param as $k => $v ) {
			// 全角字符转换
			$v = $this->semiangle ( $v );
			$param [$k] = $v;
		}
		$arrIp = $this->getIp ();
		$param ['ip'] = $arrIp ['ip'];
		$param ['country'] = $arrIp['region'] . $arrIp['city'];
		$param ['date'] = time ();
		return $param;
	}
	
	/**
	 * 获取评论列表  不再支持扩展字段
	 * Enter description here ...
	 * @param 文章的id $cid
	 * @param 分页数 $p
	 */
	public function l($cid, $p, $where = NULL) {
		if ($cid >= 0) {
			$where = $cid == 0 ? null : array ('nid' => $cid );
			$totalNum = CommentModel::instance ()->getCommentNum ( 'id', $cid );
			$page = $this->page ( $totalNum, $p, 40 );
			$rs = CommentModel::instance ()->commentPage ( $page ['start'], $page ['num'], $where );
		} else {
			$rs = CommentModel::instance ()->findCommentByWhere ( $where );
		}
		//只能精确查找
		// 增加扩展字段
		// 查找扩展字段
		foreach ( $rs as $k => $v ) {
			// 评论状态设置
			$reply = $this->getReplyByGid ( $v ['id'] );
			$rs [$k] ['reply_comment'] = $reply ['comment'];
			$rs [$k] ['reply_name'] = $reply ['real_name'];
		}
		return array ('page' => $page, 'totalnum' => $totalNum, 'list' => $rs );
	}
	/**
	 * 获得ip地址
	 *
	 * @return array $arrIp (ip country area)
	 */
	protected function getIp() {
		$ip = new IpLocation ();
		$clientIp = $ip->getIP ();
		return $ip->getlocation ( $clientIp );

	}
	/**
	 * 分页
	 *
	 * @return void
	 */
	protected function page($total, $pageid, $num) {
		$pageid = isset ( $pageid ) ? $pageid : 1;
		$rs = $pageid * $num - $total;
		$start = ($pageid - 1) * $num;
		$pagenum = ceil ( $total / $num );
		/*修正分类不包含内容 显示404错误*/
		$pagenum = $pagenum == 0 ? 1 : $pagenum;
		/*如果超过了分类页数 404错误*/
		if ($pageid > $pagenum) {
			//echo FAILED . 'The paging number out of range';
			return false;
		
		//  exit();
		// header("HTTP/1.1 404 Not Found");
		}
		$page = array ('start' => $start, 'num' => $num, 'current' => $pageid, 'page' => $pagenum );
		return $page;
	}
	protected function semiangle($str) {
		$arr = array ('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9', 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y', 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd', 'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's', 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x', 'ｙ' => 'y', 'ｚ' => 'z', '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[', '】' => ']', '〖' => '[', '〗' => ']', '“' => '[', '”' => ']', '‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<', '》' => '>', '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-', '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.', '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|', '”' => '"', '’' => '`', '‘' => '`', '｜' => '|', '〃' => '"', '　' => ' ' );
		return strtr ( $str, $arr );
	}
}