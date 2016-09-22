<?php
class CommentModel extends Db {
	/**
	 * 新闻分类表
	 *
	 * @var string
	 */
	protected $_news_category = 'w_news_category';
	/**
	 * 新闻列表
	 *
	 * @var string
	 */
	protected $_news_list = 'w_news_list';
	/**
	 * 新闻评论表
	 *
	 * @var table
	 */
	protected $_news_comment = 'w_news_comment';
	/**
	 * 查看评论
	 *
	 * @param array $where
	 * contentId
	 */
	public function getComment($where = NULL, $num = NULL) {
		if (empty ( $where )) {
			$sql = "SELECT a.title,b.* FROM $this->_news_list a ,$this->_news_comment b WHERE a.id=b.nid  ORDER BY b.id DESC";
			return $rs = $this->fetchAll ( $sql );
		} else {
			return $rs = $this->getAll ( $this->_news_comment, $where, null, 'id DESC', $num );
		}
	}
	/**
	 * 查看评论
	 *
	 * @param array $where
	 * contentId
	 */
	public function getNewComment($ids, $num) {
		$sql = "SELECT a.title,b.* FROM $this->_news_list a ,$this->_news_comment b WHERE a.id=b.nid AND b.status=1 ORDER BY b.id DESC LIMIT $num";
		return $rs = $this->fetchAll ( $sql );
	}
	/**
	 * 添加评论
	 *
	 * @param array $arr
	 * 内容
	 */
	public function addComment($arr) {
		$this->add ( $this->_news_comment, $arr );
		return $this->lastInsertId ();
	}
	/**
	 * 获取评论总数
	 *
	 * @param unknown_type $key        	
	 * @param unknown_type $where        	
	 */
	public function getCommentNum($key, $cid = '') {
		if (empty ( $cid )) {
			$sql = "SELECT count(id) num FROM $this->_news_comment";
		} else {
			$sql = "SELECT count(id) num FROM $this->_news_comment WHERE `nid`=$cid";
		}
		$num = $this->fetch ( $sql );
		return $num ['num'];
	}
	/**
	 * 删除评论
	 *
	 * @param array $where        	
	 */
	public function delComment($where) {
		return $this->delete ( $this->_news_comment, $where );
	}
	/**
	 * 更新评论
	 * Enter description here .
	 *
	 *
	 * ..
	 *
	 * @param unknown_type $v        	
	 * @param unknown_type $where        	
	 */
	public function saveCommentStatus($v, $where) {
		return $this->update ( $this->_news_comment, $v, $where );
	}
	/**
	 * 查找评论状态
	 * @param unknown_type $type        	
	 * @param unknown_type $where        	
	 */
	public function findCommentByWhere($where, $num = 20) {
		return $this->getAll ( $this->_news_comment, $where, null, "id DESC", $num );
	}
	//获取指定评论
	public function getCommentById($id) {
		return $this->getOne ( $this->_news_comment, array ('id' => $id ) );
	}
	public function getCommentByGid($gid) {
		return $this->getOne ( $this->_news_comment, array ('gid' => $gid ) );
	}
	
	public function removeReplyByGid($gid) {
		return $this->delete ( $this->_news_comment, array ('gid' => $gid ) );
	}
	/**
	 * 查看评论
	 *
	 * @param array $where
	 * contentId
	 */
	public function commentPage($start, $end, $where) {
		if (empty ( $where )) {
			$sql = "SELECT a.title,b.* FROM $this->_news_list a ,$this->_news_comment b WHERE a.id=b.nid AND reply=0 ORDER BY b.id DESC LIMIT $start,$end";
		} else {
			$sql = "SELECT a.title,b.* FROM $this->_news_list a ,$this->_news_comment b WHERE a.id=b.nid AND b.nid=$where[nid]  AND reply=0 ORDER BY b.id DESC LIMIT $start,$end";
		}
		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * @return CommentModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}