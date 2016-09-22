<?php
class BuyController extends NodeController {
	
	static $buyService;
	

	
	public function add() {
		$cate = self::getBuyServie ()->getAllCate ();
		$this->view ()->assign ( 'cate', $cate );
		$status = self::getBuyServie ()->getGoodsStatus ();
		$this->view ()->assign ( 'status', $status );
		$this->view ()->display ( "file:buy/admin/add.tpl" );
	}
	
	public function addGoods() {
		$rs = self::getBuyServie ()->addGoods ( $_POST );
		$this->redirect ( $rs, "./index.php?buy/add" );
	}
	
	//编辑产品页面
	public function edit() {
		$rs = self::getBuyServie ()->getGoodsById ( $_GET ['id'] );
		$status = self::getBuyServie ()->getGoodsStatus ();
		$module = self::getBuyServie ()->getGoodsModule ();
		$cate = self::getBuyServie ()->getAllCate ();
		$this->view ()->assign ( 'goods', $rs );
		$this->view ()->assign ( 'cate', $cate );
		
		$this->view ()->assign ( "module", $module );
		$this->view ()->assign ( 'status', $status );
		$this->view ()->display ( "file:buy/admin/edit.tpl" );
	}
	
	public function upload() {
		$rs = self::getBuyServie ()->getGoodsMXBySKU ( $_GET ['sku'] );
		if (empty ( $rs ['base'] )) {
			echo "此产品尚未关联信息";
			exit ();
		}
		$this->view ()->assign ( 'content', $rs ['base'] );
		$this->view ()->display ( 'file:buy/img.tpl' );
	}
	
	//更新产品
	public function save() {
		$redirect = './index.php?buy/edit/?id=' . $_POST ['id'];
		
		$rs = self::getBuyServie ()->saveGoodsById ( $_POST );
		self::getLogService ()->add ( $this->_user_global ['real_name'], "更新产品$_POST[goods_name]" );
		$this->redirect ( $rs, $redirect );
	
	}
	
	//搜索
	public function find(){
	    $rs = self::getBuyServie ()->search ( $_GET ['title'] );
	    $title = urldecode ( $_GET ['title'] );
	    self::getLogService ()->add ( $this->_user_global ['real_name'], "搜索$title" );
	    $page = array ('num' => 50, 'current' => 1, 'page' => 1 );
	    $this->view ()->assign ( 'num', $page );
	    $this->view ()->assign ( 'goods', $rs ['data'] );
	    $this->view()->display("mysql:find.tpl");
	}
	
	//精确搜索还是模糊搜索	
	public function search() {
		$rs = self::getBuyServie ()->search ( $_GET ['title'] );
		$title = urldecode ( $_GET ['title'] );
		self::getLogService ()->add ( $this->_user_global ['real_name'], "搜索$title" );
		$page = array ('num' => 50, 'current' => 1, 'page' => 1 );
		$this->view ()->assign ( 'num', $page );
		$this->view ()->assign ( 'goods', $rs ['data'] );
		$this->view()->display("file:buy/admin/list.tpl");
	}
	/**
	 * jquery autocomplete api
	 * */
	public function api() {
		$rs = self::getBuyServie ()->getGoodsAPI ( $_GET ['term'] );
		echo json_encode ( $rs );
	}
	
	public function flag() {
		$rs = self::getBuyServie ()->getGoodsByRemark ( $_GET ['remark'] );
		self::getLogService ()->add ( $this->_user_global ['real_name'], "查询特价" );
		$page = array ('num' => 50, 'current' => 1, 'page' => 1 );
		
		$this->view ()->assign ( 'num', $page );
		$this->view ()->assign ( 'goods', $rs );
		$this->view ()->display ( "file:buy/goodsimg.tpl" );
	}
	
	public function goods() {
	    
		$rs = self::getBuyServie ()->getGoodsByCid ( $_GET ['p'], $_GET ['cid'] );
		
		$advService = new AdvService();
		$adv = $advService->getAdvByType(1);
		$this->view()->assign('adv', $adv);
		$this->view ()->assign ( 'cate', $rs ['cate'] );
		$this->view ()->assign ( 'num', $rs ['page'] );
		$this->view ()->assign ( 'goods', $rs ['goods'] );
		
		$catService=new CateService();
		$nInfo =$catService->getCateTemp($_GET['cid'], $_GET['cid'], 'temp_list'); // 调用内容
		$this->view ()->display ( $nInfo['tempname'] );
	}
	

	public function getGoodsBySKU(){
	    $buy=new BuyService();
	    $rs= $buy->getGoodsBySKU($_GET['sku']);
	    if (empty($rs)){
	        $ret= array('status'=>false,'message'=>"没有找到相应的产品");
	    }else{
	        $ret= array('status'=>true,'message'=>$rs['goods_name'],'data'=>$rs);
	    }
	    $this->sendNotice($ret['message'],$ret['data'],$ret['status']);
	
	}
	
	/**
	 * 后台管理产品列表
	 */
	public function listing(){
	    $rs=self::getBuyServie()->listing($_GET['p']);
	    $this->view ()->assign ( 'cate', $rs ['cate'] );
	    $this->view ()->assign ( 'num', $rs ['page'] );
	    
	    $this->view ()->assign ( 'goods', $rs ['goods'] );
	    $this->view ()->display ( "file:buy/admin/list.tpl" );
	}
	
	//查看产品明细 iframe
	public function mx() {
	    
	    $advService = new AdvService();
	    $adv = $advService->getAdvByType(4);
	    $this->view()->assign('adv', $adv);
	    
	    
		$goods = self::getBuyServie ()->getGoodsMXBySKU ( $_GET ['sku'] );
		
		self::getLogService ()->add ( $this->_user_global ['real_name'], "查看产品明细" );
		
		$this->view ()->assign ( "goods", $goods );
		$catService=new CateService();
		$nInfo =$catService->setConTemp($goods['news'], null);
		$this->view()->display($nInfo['tempname']);
	}
	
	//购买历史记录
	public function history() {
		$rs = self::getBuyServie ()->getGoodsHisotrySalse ( $_GET ['goods_id'] );
		$this->view ()->assign ( 'rs', $rs );
		$this->view ()->display ( 'file:buy/history.tpl' );
	}
	
	//导出所有内容
	public function export(){
		$rs = self::getBuyServie()->getAllGoods();
		self::getBuyServie()->export($rs);
		exit();
	}

	
	public static function getBuyServie() {
		if (self::$buyService == null) {
			self::$buyService = new BuyService ();
		}
		
		return self::$buyService;
	}

}