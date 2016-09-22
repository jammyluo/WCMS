<?php
/**
 * 
 * 评论独立  这里不涉及用户或者新闻关联操作
 * @author wolf
 *
 */
class CommentController extends NodeController {
	static $commentService;
	/**
	 * 评论 增加多字段处理 支持跳转位置
	 */
	public function comment() {
		// 查看该ip一天提交了几次
		if (isset ( $_POST )) {
			$lastInsertId = self::getCommentService ()->add ( $_POST );
			if ($lastInsertId > 0) {
				$this->sendNotice ( "提交成功", $lastInsertId, true );
			} else {
				$this->sendNotice ( "提交失败", null, false );
			}
		}
	}
	public function remove() {
		$rs = self::getCommentService ()->removeComment ( $_POST ['id'] );
		
		$this->sendNotice ( $rs ['message'], null, $rs ['status'] );
	}
	/**
	 * 回复
	 */
	public function reply() {
		$_POST ['real_name'] = $this->_user_global ['real_name'];
		$lastInsertId = self::getCommentService ()->reply ( $_POST );
		if ($lastInsertId > 0) {
			$this->sendNotice ( "提交成功", null, true );
		} else {
			$this->sendNotice ( "提交失败", null, false );
		}
	}
	
	/**
	 * 评论搜索
	 * Enter description here ...
	 */
	public function search() {
		$type = $_REQUEST ['type'];
		$value = trim ( $_REQUEST ['value'] );
		$where = array ($type => $value );
		$list = self::getCommentService ()->l ( - 1, 1, $where );
		$this->view ()->assign ( 'num', $list ['page'] );
		$this->view ()->assign ( 'totalnum', $list ['totalnum'] );
		$this->view ()->assign ( 'news', $list ['list'] );
		// 在线导出功能
		// 增加指定模板
		$cate = require './config/base.php'; // 引入常用分类
		$this->view ()->assign ( 'cate', $cate ['comment'] );
		$this->view ()->display ( 'file:comment/list.tpl' );
	}
	/**
	 * 用户列表页 后台显示
	 * @前后短支持 前端为clist.tpl 固定模板 和search.tpl类似
	 */
	public function clist() {
		$cid = isset ( $_GET ['cid'] ) ? $_GET ['cid'] : 0;
		$p = isset ( $_GET ['p'] ) ? $_GET ['p'] : 1;
		// 2013-10-15 新增加根据不同的内容id 对应不同的模板 相同的肯定大于不同的原则  文件型模板
		// 默认设置为15条
		if (isset ( $_GET ['num'] )) {
			$num = trim ( $_GET ['num'] );
		} else {
			$sys = new SysService ();
			$newsConfig = $sys->getConfig ();
			$num = $newsConfig ['pagenum'];
		}
		
		$list = self::getCommentService ()->l ( $cid, $p, NULL );
		$this->view ()->assign ( 'nid', $cid );
		$this->view ()->assign ( 'num', $list ['page'] );
		$this->view ()->assign ( 'totalnum', $list ['totalnum'] );
		$this->view ()->assign ( 'news', $list ['list'] );
		// 在线导出功能
		// 增加指定模板
		$this->view ()->display ( "file:comment/list.tpl", $cid );
	}
	public static function getCommentService() {
		if (self::$commentService == null) {
			self::$commentService = new CommentService ();
		}
		return self::$commentService;
	}
}