<?php
/**
 * 基本模型 列表
 * 此模型只有基本的信息列表
 */
class BaseModule extends Module {
	private $_type; //名字
	private $_keys = array ('title', 'subtitle', 'cid', 'author', 'thumb', 'pic', 'date', 'keyword', 'groupid', 'summary', 'date', 'status', 'sort', 'css', 'views', 'template' );
	
	private $_con; //内容
	

	public function getKeys() {
		return $this->_keys;
	}
	/* (non-PHPdoc)
     * @see IModule::remove()
     */
	public function remove($where) {
		// TODO Auto-generated method stub
		$con = ModuleModel::instance ()->getModuleBase ( $where, 1 );
		//删除缩略图图片
		@unlink ( ROOT . $con [0] ['thumb'] );
		@unlink ( ROOT . $con [0] ['pic'] );
		ModuleModel::instance ()->removeModuleBase ( $where );
	
	}

	/**
	 * @return the $_con
	 */
	public function getCon($nid) {
		if (! empty ( $this->_con )) {
			$news = $this->_con;
			$this->_con = null;
			return $news;
		}
		
		$where = array ('id' => $nid );
		$news = NewsModel::instance ()->getNewsWhere ( $where );
		
		$news ['title'] = htmlspecialchars ( $news ['title'] );

		return $news;
	}
	
	/**
	 * @param field_type $_con
	 */
	public function setCon($data) {
		
		$uploadfile = $this->thumb ( $_FILES ['thumb'] ); // 检查是否存在缩略图
		$filePath = $uploadfile ['message'];
		unset ( $data ['content'] );
		/* bug fix 2013-4-23 增加替换全角字符 */
		
		// bug fix 2013-08-20如果标题中有引号 进行转移 修正放到html中 和html代码有冲突
		$title = htmlspecialchars ( trim ( $data ['title'] ) );
		$subtitle = htmlspecialchars ( trim ( $data ['subtitle'] ) );
		
		if (! empty ( $data ['summary'] )) {		    
			$data ['summary'] = str_replace ( "\n", "<br>", $data ['summary'] );
		}
		
		if (! empty ( $filePath ) && isset ( $data ['same'] )) {
			$data ['thumb'] = $filePath;
			$data ['pic'] = $filePath;
		} elseif (! empty ( $filePath ) && ! isset ( $data ['same'] )) {
			$thumb = $this->water ( $filePath, trim ( $data ['width'] ), trim ( $data ['height'] ) );
			$data ['thumb'] = $thumb;
			$data ['pic'] = $filePath;
		}
		
		$_SESSION ['width'] = trim ( $data ['width'] );
		$_SESSION ['height'] = trim ( $data ['height'] );
		unset ( $data ['width'], $data ['height'] );
		$data ['date'] = strtotime ( $data ['date'] );
		foreach ( $this->_keys as $v ) {
			$this->_con [$v] = $data [$v];
		}
	
	}
	
	/* (non-PHPdoc)
     * @see Module::add()
     */
	public function add($data) {
		//save baseinfo
		$this->setCon ( $data );
		return ModuleModel::instance ()->addModuleBase ( $this->getCon ( 0 ) );
	
	}
	
	/* (non-PHPdoc)
     * @see Module::listing()
     */
	public function listing($page, $params, $order) {
		// TODO Auto-generated method stub
		$newslist = NewsModel::instance ()->newsPage ( $page ['start'], $page ['num'], $params, $order );
		return $this->baseAndExtend ( $newslist );
	
	}
	
	/* (non-PHPdoc)
     * @see Module::temp()
     */
	public function temp($type) {
		// TODO Auto-generated method stub
	

	}
	/* (non-PHPdoc)
     * @see Module::save()
     */
	public function save($data, $id) {
		$old = $this->getCon ( $id );
		
		$this->setCon ( $data );
		
		$where = array ('id' => $id );
		$v = $this->getCon ( 0 );
		
		if (empty ( $v ['thumb'] )) {
			unset ( $v ['thumb'], $v ['pic'] );
		} else {
			//删除旧的图片
			@unlink ( ROOT . $old ['thumb'] );
			@unlink ( ROOT . $old ['pic'] );
			$old = null;
		}
		
		NewsModel::instance ()->saveNews ( $v, $where );
	
	}
	
	/**
	 * 将基础的新闻和扩展字段整合
	 * 
	 * @param Array $newslist
	 */
	private function baseAndExtend($newslist) {
		
		// 查找扩展字段
		foreach ( $newslist as $k => $v ) {
			$extend = array ();
			$extend1 = array ();
			$extend2 = array ();
			$extend3 = array ();
		
			$extend1 = ExtendModel::instance ()->getExtendVarcharByWhere ( $v ['id'], 1 );
			$extend2 = ExtendModel::instance ()->getExtendIntByWhere ( $v ['id'], 1 );
			
			$extend3 = ExtendModel::instance ()->getExtendDecimalByWhere ( $v ['id'], 1 );
			
			$extend = $extend1 + $extend2 + $extend3;
			
			if (strpos ( $newslist [$k] ['flag'], ',' )) {
				$f = explode ( ',', $newslist [$k] ['flag'] );
				$newslist [$k] ['flag'] = array_intersect_key ( $arrFlag, array_flip ( $f ) );
			} elseif (! empty ( $newslist [$k] ['flag'] ) && ! strpos ( $newslist [$k] ['flag'], ',' )) {
				/* 只有一个的情况 */
				$newslist [$k] ['flag'] = array_intersect_key ( $arrFlag, array ($newslist [$k] ['flag'] => 0 ) );
			}
			/* 对flag进行匹配 */
			// 重组 支持多个数组
			foreach ( $extend as $v ) {
				if (isset ( $newslist [$k] [$v ['key']] ) && is_array ( $newslist [$k] [$v ['key']] )) {
					array_push ( $newslist [$k] [$v ['key']], $v ['value'] );
				} elseif (isset ( $newslist [$k] [$v ['key']] ) && ! is_array ( $newslist [$k] [$v ['key']] )) {
					$newslist [$k] [$v ['key']] = array ($newslist [$k] [$v ['key']], $v ['value'] );
				} else {
					$newslist [$k] [$v ['key']] = $v ['value'];
				}
			}
		}
		return $newslist;
	}
	
	/**
	 * 
	 * @return BaseModule
	 */
	public static function instance() {
		return parent::getInstance ( __CLASS__ );
	}

}