<?php
/**
 * 新闻表 包含所有新闻的内容
 *@author wolf  [Email: 116311316@qq.com]
 *@since 2011-07-20   2014-07-31再次修正
 *@version 1.0
 */
class NewsModel extends Db {
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
	 * 新闻内容表
	 *
	 * @var string
	 */
	protected $_news_content = 'w_news_content';
	protected $_news_image = 'w_news_image';
	protected $_news_special = 'w_news_special';
	
	/**
	 * 多语言
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $_lang = 'w_lang';
	
	/**
	 * 获取语言
	 * Enter description here ...
	 * @param unknown_type $where
	 */
	public function getLang($where) {
		return $this->getAll ( $this->_lang, $where );
	}
	
	/**
	 * 查看新闻内容  以后版本会废弃
	 * 此方法用于标签 为了兼容旧版本
	 * @param int $id        	
	 * @param String $cid        	
	 * @return array $rs
	 */
	public function getNewsContent($id = null, $limit = 1, $cid = null, $lang) {
		
		$sql = "SELECT a.id,status,keyword,html,subtitle,groupid,a.css,a.sort,a.cid,a.thumb,a.pic,a.summary,a.views,b.title,a.date,a.author,b.content FROM $this->_news_list a,$this->_news_content b WHERE a.id=b.nid AND a.id=$id AND b.lang=$lang";
		$rs = $this->fetch ( $sql );
		$updatesql = "UPDATE $this->_news_list SET `views`=`views`+1 WHERE `id`=$id";
		$this->exec ( $updatesql );
		return $rs;
	}
	/**
	 * 获取多个分类中的新闻
	 *list 标签 fid 以后会废弃 兼容旧版本
	 * @param unknown_type $ids        	
	 */
	public function getNewsListByIds($ids, $limitNum, $order = "id") {
		$sql = "SELECT *,keyword,subtitle,a.id as id,b.id as category_id,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE `cid` IN ($ids) ORDER BY a.$order DESC LIMIT $limitNum  ";
		return $this->fetchAll ( $sql );
	}
	
	public function getNewsWhere($where, $key = NULL) {
		return $this->getOne ( $this->_news_list, $where, $key );
	}
	
	/**
	 * 用于删除文章时
	 * Enter description here ...
	 */
	public function getNewsIdsByCid($cid) {
		return $this->getAll ( $this->_news_list, array ('cid' => $cid ), 'id' );
	}
	
	/**
	 * 获取新闻
	 * 用于list标签 以后版本会废弃
	 * @param unknown_type $where        	
	 * @param unknown_type $key        	
	 */
	public function getNewsByWhere($where, $key = NULL, $num = 10, $order = "id") {
		if (! empty ( $where ['cid'] )) {
			$sql = "SELECT a.id,keyword,subtitle,a.html,a.sort,a.summary,a.cid,a.views,a.thumb,a.pic,a.title,a.date,a.author,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE b.id=$where[cid] AND status=0 ORDER BY a.$order DESC LIMIT $num";
		} elseif (! empty ( $where ['title'] )) {
			$sql = "SELECT a.id,keyword,subtitle,a.html,a.sort,a.summary,a.cid,a.views,a.thumb,a.pic,a.title,a.date,a.author,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE a.title='$where[title]' AND status=0  ORDER BY a.$order DESC LIMIT $num";
		} else {
			$sql = "SELECT a.id,keyword,subtitle,a.html,a.sort,a.cid,a.summary,a.views,a.thumb,a.pic,a.title,a.date,a.author,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE  status=0  ORDER BY a.$order DESC LIMIT $num";
		}
		
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 更新属性
	 */
	public function setNewsSort($v, $id) {
		$sql = "UPDATE w_news_list SET `sort`='$v' WHERE `id`='$id'";
		return $this->exec ( $sql );
	}
	
	/**
	 * 更改新闻基本信息
	 * @param unknown_type $v        	
	 * @param unknown_type $where        	
	 */
	public function saveNews($v, $where) {
		$this->update ( $this->_news_list, $v, $where );
	}
	
	/**
	 * 获取图片集合
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function getNewsImage($id) {
		$sql = "SELECT * FROM $this->_news_image WHERE nid=$id";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 新闻总条数
	 *
	 * @param string $key
	 * 键名
	 * @param Array $params
	 * 条件
	 */
	public function getNewsNum($params) {
		if (empty ( $params )) {
			$sql = "SELECT id FROM $this->_news_list";
			return $this->rowCount ( $sql );
		}
		if (! empty ( $params ['cid'] ) && ! empty ( $params ['flag'] )) {
			$sql = "SELECT a.id FROM $this->_news_list a left join w_flag_value b ON a.id=b.nid WHERE `cid` IN ($params[cid]) AND
			b.id IN ($params[flag]) GROUP BY a.id";
			return $this->rowCount ( $sql );
		}
		
		$sql = "SELECT id FROM $this->_news_list  WHERE `cid` IN ($params[cid])";
		return $this->rowCount ( $sql );
	}

	/**
	 * 新的分页方法 2014-08-08
	 * @param int $start
	 * @param int $num
	 * @return array $rs
	 */
	public function newsPage($start, $num, $params, $order = 'id') {
		if (! empty ( $params ['flag'] ) && ! empty ( $params ['cid'] )) {
			$sql = "SELECT a.id,status,keyword,subtitle,a.html,a.css,a.sort,a.pic,a.thumb,a.summary,a.cid,a.views,a.title,a.date,a.author as author FROM w_flag_value c left join w_news_list a on a.id=c.nid
			 WHERE a.cid IN (" . $params ['cid'] . ") AND  c.id IN (" . $params ['flag'] . ")  ORDER BY a.$order DESC LIMIT $start,$num";
			return $this->fetchAll ( $sql );

		}

		if (! empty ( $params ['cid'] )) {
			$sql = "SELECT a.id,module as mid,status,keyword,subtitle,a.html,a.css,a.sort,a.pic,a.thumb,a.summary,a.cid,a.views,a.title,a.date,a.author as author ,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id
			 WHERE a.cid IN (" . $params ['cid'] . ") GROUP BY a.id   ORDER BY a.$order DESC LIMIT $start,$num";
			return $this->fetchAll ( $sql );
		}

		$sql = "SELECT  a.id,status,module as mid,keyword,subtitle,a.html,a.css,a.sort,a.pic,a.cid,a.title,a.views,a.summary,a.thumb,a.date,a.author as author,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id  ORDER BY a.$order DESC LIMIT $start,$num";

		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * 搜索标题
	 */
	public function getOneNewsLikeTitle($key, $value, $cid = NULL, $limit = 40) {
		if (! empty ( $cid )) {
			$sql = "SELECT  a.id,module,status,keyword,subtitle,a.cid,a.title,a.date,a.pic,a.author,a.views,b.id as category_id,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE $key like '%$value%'  AND  a.cid IN ($cid) ORDER BY a.id DESC LIMIT $limit";
		} else {
			// 考虑下属分类的情况
			$sql = "SELECT  a.id,status,module,keyword,subtitle,a.cid,a.title,a.date,a.pic,a.author,a.views,b.id as category_id,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE $key like '%$value%' ORDER BY a.id DESC LIMIT $limit";
		}
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 根据新闻ids获取
	 *
	 * @param unknown_type $ids        	
	 */
	public function getNewsListInIds($ids, $limitNum, $order = "id") {
		$sql = "SELECT a.*,b.id as category_id,b.name as category_name FROM w_news_list a LEFT JOIN w_news_category b ON a.cid=b.id WHERE  a.id IN ($ids) ORDER BY a.$order DESC LIMIT $limitNum  ";
		return $this->fetchAll ( $sql );
	}
	/**
	 * 
	 * 生成静态页面专用
	 * @param unknown_type $ids
	 */
	public function getNewsIdByIds($ids,$start,$num) {
		$sql = "SELECT id,date,html  FROM w_news_list WHERE cid IN ($ids)  ORDER BY id DESC LIMIT $start,$num";
		return $this->fetchAll ( $sql );
	}
	
	/**
	 * 返回NewsModel
	 *
	 * @return NewsModel
	 */
	public static function instance() {
		return parent::_instance ( __CLASS__ );
	}
}