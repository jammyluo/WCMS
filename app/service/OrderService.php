<?php
/**
 * 订单服务
 * Enter description here ...
 * @author Wolf
 *
 */
class OrderService {
	
	const SUCCESS = 'success';
	const ERROR = 'error';
	//订单一页显示条数
	private $_num = 40;
	
	private $_chargeType = array ("充值" => 0, "消费" => 1, "赠送" => 2 );
	private $_payment = array ("收入" => 0, "支出" => 1 );
	private $_status = array ("等待审核" => 1,"等待配货" => 8,"等待发货"=>9, "已发货"=>10,"关闭" => - 1, "确认收货"=>11 );



    /**
     * 对接购物车和产品库 创建订单和用户账户信息
     */
    public function createOrder($uid,$data)
    {
        // 获取用户信息
        if (empty($uid)) {
            return array(
                'status' => false,
                'message' => "请先登录"
            );
        }

        if(empty($_SESSION[$data['token']])||!$_SESSION[$data['token']]){
            return array('status'=>false,'message'=>"请勿重复提交订单");
        }else{
            $_SESSION[$data['token']]=false;
        }

        $remark=trim($data['remark']);


        // 获取提交的信息 只要产品id和产品数量
        // 获取产品
        $goods = $this->getGoods();

        if (empty($goods['goods'])) {

            return array(
                'status' => false,
                'message' => "购物车是空的"
            );
        }


        $stock= $this->checkStock($goods['goods']);
        if (!$stock['status']){
            return $stock;
        }

        $goodsData = array();

        // 判断产品类型
        // 判断用户积分或者金额是否足够
        // 获取sno号
        $sno=$this->getSNO();
        $ginfo = $this->getGoodsInfo($goodsData, $sno);//也是执行 $buy->getCart(2);


        $memberSer=new MemberService();
        $user=$memberSer->getMemberByUid($uid);

        if ($user['coupons'] < $ginfo['couponstotal']) {
            $msg='cart:'.$ginfo['couponstotal'].";user:".$user['coupons'];
            //释放重复提交
            $_SESSION[$data['token']]=true;
            return array(
                'status' => false,
                'message' => "幸福豆不够".$msg
            );
        }



        $memberSer->saveCoupons($user['uid'], $ginfo['couponstotal'], 1);
        // 增加积分记录
        $order=array('coupons'=> -$ginfo['couponstotal'],'sno'=>$sno,'remark'=>$ginfo['name'],'status'=>8,'chargetypes'=>1);

        $couponsSer=new CouponsService();

        $historyid= $couponsSer->reduceCoupons($user['uid'], $order);
        if ($historyid<1){
            $msg="财务历史无法添加";
            return array('status'=>false,'message'=>$msg);
        }

        // 订单列表 生成唯一sno号 判断库存是否有库存
        $this->addOrder($sno, $ginfo['name'], $user['uid'], $user['real_name'], $user['real_name'], $user['area'], $user['mobile_phone'], $ginfo['num'], $ginfo['couponstotal'], $ginfo['moneytotal'], $remark, 1);
        // 订单明细
        $this->addGoods($ginfo['goodslist']);
        // 增加操作日志
        setcookie("wcart", "", time() - 3600, "/");
        unset($_SESSION[$data['token']]);
        return array(
            'status' => true,
            'message' => "订单提交成功"
        );
    }


    //get ordersno
    public function getSNO(){
        $time = time();
        // 创建订单号
        $sjs = rand(1000, 9999);
        return  "XF" . date('YmdHis', $time) . $sjs;
    }


    private function getGoods()
    {
        $buy = new BuyService();
        $buy->_cookie = 'wcart';
        return $buy->getCart(2);
    }



	public function listing($p,$status) {
		$totalNum = OrderModel::instance ()->getOrderTotalNum (array('status'=>$status));
		$page = $this->page ( $totalNum, $p, $this->_num );
		$rs = OrderModel::instance ()->getOrderPageByStatus($page ['start'], $page ['num'], $status);
		$status = array_flip ( $this->_status );
		
	
		
		foreach ( $rs as $k => $v ) {
			$rs [$k] ['status'] = $status [$v ['status']];
		}
		return array ('list' => $rs, 'totalnum' => $totalNum ['num'], 'page' => $page, 'status' => $this->_status );
	}
	
	
	public function tjOrderByDate(){
	    $rs=OrderModel::instance()->tjOrderByDate(7);
	    return $rs;
	}
	
	public function search($type,$name) {
		
	if ($type=="shr"){
	    $name=urldecode($name);
	    $rs=OrderModel::instance()->getOrderLikeShr($name);
	}else{
	    $rs=OrderModel::instance()->getOrderLikeOrderno($name);
	}
	
	    return $this->parseOrderStatus($rs);
	}
	
	
	public function addOrder($sno, $name, $uid, $realname, $shr, $address, $mobile, $num, $coupons, $money, $remark, $status) {
	    $params = array ('uid' => $uid, 'name' => $name, 'orderno' => $sno, 'shr' => $shr, 'address' => $address, 'mobile' => $mobile, 'addtime' => time (), 'remark' => $remark, 'num' => $num, 'money' => $money, 'coupons' => $coupons, 'status' => $status );
	    return OrderModel::instance ()->addOrder ( $params );
	
	}
	
	private function parseOrderStatus($order){
	    
	    if (empty($order)){
	        return;
	    }
	    $status=array_flip($this->_status);
	    foreach ($order as $k=>$v){
	        
	        $order[$k]['status']=$status[$v['status']];
	    }
	    return $order;
	}
	
	
	public function status($orderno, $status,$actionName) {
		//检查当前状态
		$order = $this->getOrderByOrderno ( $orderno );
		
		//订单为成功或者失败后就不允许修改
		if ($order ['status'] ==-1) {
			return "订单无法修改";
		}
		
		//修改库存
		if ($status==-1){
		    $this->reBackStockByOrderno($orderno);
		    $couponsSer=new CouponsService();
		    $couponsSer->refund($orderno);
		    
		}
		
		//如果status为关闭 就归还积分
		OrderModel::instance ()->saveOrderByOrderno( array ('status' => $status, 'action_time' => time () ),  $orderno);
		
	    //增加操作记录
	    $orderHisotrySer=new OrderHistoryService();
	    $statusArr=array_flip($this->_status);
	    $msg="设置状态".$statusArr[$status];
	    $orderHisotrySer->addHistory($orderno,$actionName, $msg);
		return self::SUCCESS;
	}
	
	
	public function setRemarkByOrderno($remark,$orderno,$actionName){
	    
	   $orderHistory=new OrderHistoryService();
	   $msg="设置备注".$remark;
	   $orderHistory->addHistory($orderno, $actionName, $msg);
	    
	   $rs= OrderModel::instance()->saveOrderByOrderno(array('remark'=>$remark), $orderno);
	   if ($rs>0){
	       return array('status'=>true,'message'=>"更新成功!");
	   }else{
	       return array('status'=>false,'message'=>"更新失败");
	   }
	   
	}
	
	private function reBackStockByOrderno($orderno){
	   
	    $orderInfoSer=new OrderInfoService();
	    $goodslist=$orderInfoSer->getOrderInfoBySNO($orderno);
	    if (empty($goodslist)){
	        return;
	    }
	    $buySer=new BuyService();
	   
	    foreach ($goodslist as $k=>$v){
	      $goods=  $buySer->getGoodsBySKU($v['goods_id']);
	      $stock=$goods['stock']+$v['num']; 
	      $buySer->setGoodsStockBySKU($goods['sku'], $stock);
	      $sales=$goods['sales']-$v['num'];
	      $buySer->setGoodsSalesBySKU($goods['sku'], $sales);
	    }
	}
	
	
	public function getOrderByOrderno($orderno) {
		$order = OrderModel::instance ()->getOrderByWhere ( array ('orderno' => $orderno ) );
		return $order [0];
	}
	
	public function getUserOrder($uid, $p) {
		
		if (! isset ( $uid )) {
			return "请先登录";
		}
		
		$totalNum = OrderModel::instance ()->countOrder ( array('uid'=>$uid) );
		$page = $this->page ( $totalNum ['num'], $p, $this->_num );
		$rs = OrderModel::instance ()->getOrderPageByUid ($page ['start'], $page ['num'], $uid);
		
		$status = array_flip ( $this->_status );
		//匹配图片
		foreach ( $rs as $k => $v ) {
			$rs [$k] ['status'] = $status [$v ['status']];
			$rs [$k] ['goodslist'] = OrderModel::instance ()->getGoodsInfo ( $v ['orderno'] );
			$rs [$k] ['goodsnum'] = count ( $rs [$k] ['goodslist'] );
		}
		
		return array ('list' => $rs, 'page' => $page, 'totalnum' => $totalNum ['num'] );
	}

	
	private function setCsvHeader() {
		header ( "Cache-Control: public" );
		header ( "Pragma: public" );
		header ( "Content-type:application/vnd.ms-excel" );
		$file = date ( "md", time () );
		header ( "Content-Disposition:attachment;filename=$file.csv" );
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
	 * 获取产品信息
	 * @return 订单名称 总价  产品件数  产品列表
	 */
	public function getGoodsInfo($data, $sno) {
		$moneyTotal = 0;
		$couponsTotal = 0;
		$goodsArr = array ();
		$num = 0;
		$title = "";
		$buy = new BuyService ();
		$data = $buy->getCart ( 2 );

		foreach ( $data ['goods'] as $k => $v ) {
			if ($num == 0) {
				$title = $v ['goods_name'];
			}
			$goods = array ('orderno' => $sno, 'goods_id' => $v ['sku'], 'num' => $v ['num'] * $v ['count'], 'goods_name' => $v ['goods_name'], 'prices' => 0, 'coupons' => $v ['price'], 'money' => $v ['price'] * $v ['count'] * 100 * $v ['num'], 'coupons_total' => $v ['price']  * $v ['count'] * $v ['num'] );
			$moneyTotal += $goods ['money'];
			$couponsTotal += $goods ['coupons_total'];
			$goodsArr [] = $goods;
			$num += $v ['num'];
		}
		return array ('name' => $title, 'moneytotal' => $moneyTotal, 'couponstotal' => $couponsTotal, 'goodslist' => $goodsArr, 'num' => $num );
	}
	

	public function checkStock($goodslist){
	    $buySer=new BuyService();

	    foreach ($goodslist as $k=>$v){
	        if ($v['count']==0){
	            $goods=$buySer->getGoodsBySKU($v['sku']);
	        
	            $msg=$v['goods_name']."库存不足，为".$goods['stock'].$goods['unit'];
	            return array('status'=>false,'message'=>$msg);
	        }
	    }
	    return array('status'=>true);
	}

	/**
	 * 增加订单明细  蒋getGoodsInfo中的goodsList 传递进来即可
	 * @param unknown_type $goodsList
	 */
	public function addGoods($goodsList) {
	    //减去库存
	    $buySer=new BuyService();
	    
		foreach ( $goodsList as $v ) {
	     	$goods=$buySer->getGoodsBySKU($v['goods_id']);   	     	
	     	$stock=$goods['stock']-$v['num'];
	    
			OrderModel::instance ()->addGoods ( $v );
			$buySer->setGoodsStockBySKU($v['goods_id'], $stock);
			$sales=$goods['sales']+$v['num'];
			$buySer->setGoodsSalesBySKU($v['goods_id'], $sales);
		}
		return true;
	}
	
	
}