<?php
/**
 * 面向操作  基础模型  抽象工厂模型
 * 继承权限  这里是逻辑算法
 */
class News {
	
	//文章模型 图片模型 专题模型等 包含了模板和内容
	public $_m;
	public $_base; //基本模型
	public $_extend; //扩展模型
	protected $_data; //提交之后存放的参数
	protected $_cid; //栏目id
	protected $_mid; //模型id
	

	public function __construct($cid, $mid) {
		$this->_base = BaseModule::instance ();
		$this->_extend = ExtendModule::instance ();
		$this->_cid = isset ( $cid ) ? $cid : 2;
		$this->_mid = isset ( $mid ) ? $mid : 1;
		$this->_m = $this->load ( $this->_mid ); //配置选择器
	

	}
	
	//只有在专题的时候才会祈祷作用 如果有其他组装 可以添加到这里
	private function load($type) {
		switch ($type) {
			case 1 :
				return ArticleModule::instance ();
				break;
			case 2 :
				return ImageModule::instance ();
				break;
			case 3 :
				return SpecialModule::instance ();
				break;
			case 5 :
				return ShopModule::instance ();
				break;
			default :
				return ArticleModule::instance ();
				break;
		
		}
	}
	
	/**
	 * 添加新闻
	 * @param unknown_type $data
	 */
	public function add($data) {
		$data ['mid'] = 1;//todo
		$data ['cid'] = 2;//todo
		if (! $this->checkModuleIsMatch ( $data ['mid'], $data ['cid'] )) {
			return "分类模型不一致";
		}
		
		//选择容器
		$lastInsertId = $this->_base->add ( $data );
		
		//增加flag
		$flagSer = new FlagService ();
		$flagSer->bindFlagValue ( $data ['flag'], $lastInsertId );
		
		//实例化内容模型
		$data ['nid'] = $lastInsertId;
		$this->_extend->add ( $data );
		$this->_m->add ( $data );
		return $lastInsertId;
	}
	
	/**
	 * 
	 * 检查提交的模型 和分类模型是否一致
	 * @param int $mid
	 * @param int $cid
	 * @return true 一致 false 不一致
	 */
	private function checkModuleIsMatch($mid, $cid) {
		$categoryInfo = $this->_base->getCategoryById ( $cid );
		return $categoryInfo ['module'] == $mid;
	}
	
	//删除内容
	public function remove($id) {
		
		$this->_base->remove ( array ('id' => $id ) );
		$this->_m->remove ( array ('nid' => $id ) );
		$flagSer = new FlagService ();
		$flagSer->removeFlagByNid ( $id );
		$this->_extend->remove ( array ('gid' => $id ) );
	}
	
	/**
	 * 汇总保存
	 */
	public function save($data, $id) {
		$data ['mid'] = 1;//todo
		$data ['cid'] = 2;//todo
		if (! $this->checkModuleIsMatch ( $data ['mid'], $data ['cid'] )) {
			return "分类模型不一致";
		}
		
		//实例化基本信息
		$this->_base->save ( $data, $id );
		
		//标签
		$flagSer = new FlagService ();
		$flagSer->saveFlagValue ( $data ['flag'], $id );
		//实例化内容模型
		$this->_extend->save ( $data, $id );
		//获取模型
		$categoryInfo = $this->_base->getCategoryById ( $data ['cid'] );
		
		$this->load ( $categoryInfo ['module'] )->save ( $data, $id );
		return $this->_mid;
	}
	
	/**
	 * 一键模版设定
	 * @param unknown_type $type
	 */
	public function temp($type) {
		return $this->_m->temp ( $type );
	}
	
	/**
	 * 检测文章是否存在
	 * @param int $id
	 * @return boolean true 不存在  false 存在
	 */
	private function checkIsExisit($id) {
		
		$rs = NewsModel::instance ()->getNewsWhere ( array ('id' => $id ) );
		return empty ( $rs );
	
	}
	/**
	 * 获取内容
	 * 增加一个检测机制 如果新闻不存在
	 * @todo 专题中的内容机制
	 * @param int $nid
	 */
	public function getCon($nid) {
		if ($this->checkIsExisit ( $nid )) {
			return;
		}
		
		$news = $this->_base->getCon ( $nid );
		
		$categoryInfo = $this->_base->getCategoryById ( $news ['cid'] );
		$news ['mid'] = $categoryInfo ['module'];
		//检查内容模型
		$con = $this->load ( $categoryInfo ['module'] )->getCon ( $nid ); //内容	
		
		
		//增加flag
		$flagSer = new FlagService ();
		$news['flag']=$flagSer->getFlagByNid($nid) ;
		

		$extend = $this->_extend->getCon ( $nid );
		//文章
		if ($categoryInfo ['module'] == 1) {
			$news = $news + $con;
		}
		//图集
		if ($categoryInfo ['module'] == 2) {
			$news ['module'] = $con;
		}
		
		//产品
		if ($categoryInfo ['module'] == 5) {
			$news ['module'] = $con ['module'];
			$news = $news + $con ['content'];
		}
		
		//专题//这里到对专题内容再次解析
		if ($categoryInfo ['module'] == 3) {
			$news ['module'] = $this->parseSpecial ( $con );
		}
		
		$news ['extend'] = $extend; //将extend打入content中 形成一条
		

		//导入分组
		$news ['category_name'] = $categoryInfo ['name'];
		
		if ($extend == NULL) {
			return array ('content' => $news, 'extend' => NULL );
		
		}
		// 重组 支持多个数组
		foreach ( $extend as $v ) {
			if (isset ( $news [$v ['key']] ) && is_array ( $news [$v ['key']] )) {
				array_push ( $news [$v ['key']], $v ['value'] );
			} elseif (isset ( $news [$v ['key']] ) && ! is_array ( $news [$v ['key']] )) {
				$news [$v ['key']] = array ($news [$v ['key']], $v ['value'] );
			} else {
				$news [$v ['key']] = $v ['value'];
			}
		}
		
		
		
		return array ('content' => $news, 'extend' => $extend );
	
	}
	/**
	 * 解析专题节点为文章或者图集
	 * @param Array $con
	 * @return Array
	 */
	private function parseSpecial($con) {
		
		foreach ( $con as $ck => $cv ) {
			$newsIds = explode ( ",", $cv ['newsid'] );
			foreach ( $newsIds as $v ) {
				if (! is_numeric ( $v )) {
					continue;
				}
				$s = $this->getCon ( $v );
				$con [$ck] ['list'] [] = $s ['content'];
				$s = "";
			}
		}
		
		return $con;
	}
	
	/**
	 * 这里应该传递参数 而不是直接赋值
	 * @param int $cid
	 * @param int $p
	 * @param int $sort
	 * @param int $num
	 * @return false or rs  超出了分页数返回false
	 */
	public function listing($cid, $p, $params) {
		$cid = empty ( $cid ) ? 1 : $cid;
		
		$p = $p == 0 ? 1 : $p;
		// 默认设置为15条
		if ($params ['num'] <= 0) {
			$sys = new SysService ();
			$newsConfig = $sys->getConfig ();
			$num = $newsConfig ['pagenum'];
		} else {
			$num = $params ['num'];
		}
		
		//定义排序
		$sort = $params ['sort'] != NULL ? $params ['sort'] : 'id';
		
		//指定分类页面按什么排序
		// 递归获取子类 并且过滤
		$categoryInfo = $this->_base->getCategoryById ( $cid );
		$mid = $cid === 1 ? $this->_mid : $categoryInfo ['module'];
		$ids = $this->_base->getSonCate ( $cid, $mid );
		//进行缓存结果
		//先去找cache
		$totalNum = $this->getNewsNumCache ( $cid, array ('cid' => $ids, 'flag' => $params ['flag'] ) );
		$page = $this->page ( $totalNum, $p, $num );
		//超过了分页数
		if (! $page) {
			echo "超过了最大分页数";
			exit ();
		}
		//筛选条件
		$params = array ('cid' => $ids, 'flag' => $params ['flag'], 'username' => $params ['username']);
		$newslist = $this->_base->listing ( $page, $params, $sort ); //获取基础数据

		
		
		foreach ( $newslist as $newsitem ) {
			if ($params['username']=="" || $newsitem['author'] == $params ['username'])
			{
				$newslist_filterUser[] = $newsitem;
			}
		}

		return array ('newslist' => $newslist_filterUser, 'totalnum' => $totalNum, 'page' => $page, 'module' => $this->_mid );
	
	}
	
	/**
	 * 换回统计缓存
	 * @param unknown_type $cid
	 */
	private function getNewsNumCache($cid, $params) {
		
		$rs = CacheModel::instance ()->getCacheByCid ( array ('cid' => $cid ) );
		
		$sys = new SysService ();
		$config = $sys->getConfig ();
		if (! empty ( $rs ) && $config ['cache_num']) {
			return $rs ['value'];
		}
		$totalNum = NewsModel::instance ()->getNewsNum ($params );
		
		CacheModel::instance ()->addCache ( array ('cid' => $cid, 'value' => $totalNum ) );
		return $totalNum;
	}
	
	/**
	 * 分页
	 *
	 * @return void
	 */
	public function page($total, $pageid, $num) {
		$pageid = isset ( $pageid ) ? $pageid : 1;
		
		$start = ($pageid - 1) * $num;
		$pagenum = ceil ( $total / $num );
		/*修正分类不包含内容 显示404错误*/
		$pagenum = $pagenum == 0 ? 1 : $pagenum;
		/*如果超过了分类页数 404错误*/
		
		if ($pageid > $pagenum) {
			return false;
		}
		
		return array ('start' => $start, 'num' => $num, 'current' => $pageid, 'page' => $pagenum );
	}

}