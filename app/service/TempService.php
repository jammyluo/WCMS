<?php
class TempService {
	//历史模板最多保留几条
	private $_hisotrysNum = 10;
	const SUCCESS = 'success';
	const ERROR = 'error';
	
	public function listing($p = 1, $type = "") {
		
		$num = 500;
		
		$totalNum = 500;
		$page = $this->page ( $totalNum, $p, $num );
		
		if ($type != "") {
			$where = array ('type' => $type );
		}
		
		$rs = TempModel::instance ()->getTemplateList ( $page ['start'], $page ['num'], 'id,remark,name,action,type,modified,version,direct', $where );
		
		$type = $this->getTemplateTypes ();
		
		$temptype = array ();
		foreach ( $type as $k => $v ) {
			$temptype [$v ['id']] = $v ['name'];
		}
		foreach ( $rs as $k => $v ) {
			$rs [$k] ['type'] = $temptype [$v ['type']];
		}
		return array ('list' => $rs, 'page' => $page, 'type' => $type );
	}
	
	//删除id
	public function remove($id) {
		$temp = $this->getTempFromMainById ( $id );
		
		if (( int ) $temp ['type'] === 4) {
			return array ('status' => false, 'message' => "系统模板无法删除" );
		}
		
		$rs = TempModel::instance ()->delTempById ( $id );
		
		if ($rs > 0) {
			return array ('status' => true, 'message' => "删除成功" );
		} else {
			return array ('status' => false, 'message' => "模板不存在，删除失败" );
		}
	}
	
	/**
	 * 
	 * 处理单个模板信息
	 * */
	public function parseTemp($param, $type) {
		switch ($type) {
			case 1 :
				$tempInfo = $this->getTempFromMainByName ( $param );
				break;
			case 2 :
				$tempInfo = $this->getTempFromHistoryById ( $param );
				break;
			default :
				$tempInfo = $this->getTempFromMainById ( $param );
				break;
		}
		//获取最新的更新记录
		if ($type != 2) {
			$history = TempModel::instance ()->getTempHistory ( array ('temp_id' => $tempInfo ['id'] ), 'id,temp_id,date,action', 1 );
		}
		
		if ($type == 2) {
			$tempInfo = $tempInfo [0];
			$tempInfo ['id'] = $tempInfo ['temp_id'];
		}
		// 并且记录日志
		// 修正bug 对$tempInfo 进行匹配
		$tempInfo ['source'] = preg_replace ( "#</textarea>#is", "<\/textarea>", $tempInfo ['source'] );
		$tempInfo ['size'] = $this->filesize ( strlen ( $tempInfo ['source'] ) );
		return $tempInfo;
	}
	/**
	 * 
	 * 添加模板
	 * @param Array $data
	 */
	public function add($data) {
		
		if (strlen ( $data ['name'] ) < 4) {
			return "模板名称不少于4个字符";
		}
		
		if (! $this->checkNameIsRepeat ( $data ['name'] )) {
			return "模板名称已经存在";
		}
		
		TempModel::instance ()->addTemp ( array ('name' => trim ( $data ['name'] ), 'remark' => $data ['remark'], 'type' => $data ['type'] ) );
		
		return self::SUCCESS;
	
	}
	
	/**
	 * 保存模板
	 * 
	 */
	public function saveTemp($data, $username) {
		$id = $data ['id'];
		// 编辑模板
		$tempInfo = TempModel::instance ()->getTemplateById ( $id );
		$source = preg_replace ( "#<\/textarea>#is", "</textarea>", $data ['source'] );
		
		$this->addTempHistory ( $id, $tempInfo, $username );
		
		if (preg_match ( "#[\)\(\+\"\.;\\\*\'\/\?]#iUs", $data ['remark'] )) {
			return array ('status' => false, 'message' => "备注包含特殊符号" );
		}
		
		// 如果没有开启转义  在引用View模板的时候反转
		if (! get_magic_quotes_gpc ()) {
			$error = TempModel::instance ()->saveTempSource ( addslashes ( $source ), $id, $username, $data ['remark'] );
		} else {
			$error = TempModel::instance ()->saveTempSource ( $source, $id, $username, $data ['remark'] );
		}
		
		$this->cleanHistory ( $id );
		
		return array ('status' => true, 'message' => '保存成功' );
	}
	
	public function getTemplateTypes() {
		return TempModel::instance ()->getTemplatesType ();
	
	}
	
	public function addTempType($params) {
		$rs = TempModel::instance ()->addTempType ( $params );
		if ($rs > 0) {
			return array ('status' => true, 'data' => $rs, 'message' => "添加成功!" );
		} else {
			return array ('status' => false, 'message' => "添加失败!" );
		}
	}
	
	public function removeTempTypeById($id) {
		
		$rs = TempModel::instance ()->removeTempTypeById ( $id );
		if ($rs > 0) {
			TempModel::instance ()->delTempByType ( $id );
			
			return array ('status' => true, 'message' => "删除成功!" );
		} else {
			return array ('status' => false, 'message' => "删除失败!" );
		}
	}
	
	public function search($name) {
		$name = urldecode ( $name );
		//检查名字是否全部英文	
		if (preg_match ( "/[\x7f-\xff]+/", $name )) {
			$rs = TempModel::instance ()->getTempLikeRemark ( $name, 20 );
		} else {
			$rs = TempModel::instance ()->getTempLikeName ( $name, 20 );
		}
		
		return $this->matchTempType ( $rs );
	}
	
	private function matchTempType($temp) {
		
		foreach ( $temp as $k => $v ) {
			$type = TempModel::instance ()->getTypeById ( $v ['type'] );
			$temp [$k] ['type'] = $type ['name'];
		}
		return $temp;
	
	}
	
	/**
	 * 清除历史模板
	 * @param int $id
	 */
	private function cleanHistory($id) {
		//只保留最新10条记录
		$num = TempModel::instance ()->getTempHistory ( array ('temp_id' => $id ), "id" );
		if (count ( $num ) >= $this->_hisotrysNum) {
			asort ( $num );
			TempModel::instance ()->deleteTempHistory ( $id, $num [10] [id] );
		}
	}
	
	private function addTempHistory($id, $data, $username) {
		TempModel::instance ()->addTempHistory ( array ('temp_id' => $id, 'source' => addslashes ( $data ['source'] ), 'date' => time (), 'remark' => $data ['remark'], 'action' => $username ) );
	}
	
	/**
	 * 检查模板名称是否重复
	 * @param String $name
	 * @return true 不存在 false 存在
	 */
	private function checkNameIsRepeat($name) {
		$rs = TempModel::instance ()->getTemplateByName ( trim ( $name ) );
		return empty ( $rs );
	}
	
	/**
	 * 从历史模板中获取
	 */
	private function getTempFromHistoryById($id) {
		return TempModel::instance ()->getTempHistory ( array ('id' => $id ), 'id,temp_id,date,remark,source,action' );
	}
	/**
	 * 从主模板中获取
	 */
	private function getTempFromMainById($id) {
		return TempModel::instance ()->getTemplateById ( $id );
	}
	private function getTempFromMainByName($name) {
		return TempModel::instance ()->getTemplateByName ( $name );
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
	
	/**
	 * 返回kb
	 * @param unknown_type $size
	 */
	private function filesize($size) {
		switch ($size) {
			case $size < 1024 :
				return $size . " Bytes";
				break;
			case $size >= 1024 :
				return round ( $size / 1024, 2 ) . " Kb";
				break;
		}
	}
}
