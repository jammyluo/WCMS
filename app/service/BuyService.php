<?php
class BuyService
{
    private $_num = 20; //每页显示40天
    private $_module = array(1 => "按件数");
    private $_status = array(0 => "正常", - 2 => "停产", - 1 => "无货", - 3 => "即将开抢",
    2 => "库存紧张", 3 => "限时特价");
    private $_cid = 9;
    private $_special = array(0 => "常规", 1 => "特价");
    public $_cookie = 'wcart';
    public $_priceFormat="%.2f";
    
    
    public function addGoods ($params)
    {
        $rs = $this->getGoodsByName($params['goods_name']);
        if (! empty($rs)) {
            return "产品名字重复了";
        }
        $params['add_time'] = time();
        $params['sales']=rand(500, 2000);
        $flag = BuyModel::instance()->addGoods($params);
        return $flag > 0 ? "新增成功" : "新增失败";
    }
   
   
    //获取图片
    public function getGoodsImageBySKU ($rs)
    {
        foreach ($rs as $k => $v) {
            $goods = GoodsModule::instance()->getConBySku($v['sku']);
            $rs[$k]['image'] = $goods['image'];
        }
        return $rs;
    }
    private function getGoodsNumByCid ($cid)
    {
        return BuyModel::instance()->getGoodsNumByCid($cid);
    }
    public function getGoodsByCid ($p, $cid)
    {
        $totalnum = $this->getGoodsNumByCid($cid);
        $page = $this->page($totalnum, $p, $this->_num);
        $rs = BuyModel::instance()->getGoodsByCid($page['start'], $this->_num,
        $cid);
        $rs = $this->parseGoodsStatus($rs);
        $cate = $this->getCateById($cid);//历史记录
        $data = array('goods' => $rs, 'page' => $page, 'cate' => $cate);
        return array('status'=>'true', 'message'=>'成功', 'data'=>$data);
    }

    //获取产品明细信息
    public function getDetailBysku($sku){
        $rs =  BuyModel::instance()->getDetailBysku($sku);
        if(!empty($rs)){
            return array('message'=>'成功', 'status'=>'true', 'data'=>$rs);
        }
        else{
            return array('status'=>false, 'message'=>'结果为空');
        }
    }

    //添加手机订单
    public function addMobileOrder($uid, $data){
        $remark=trim($data['remark']);
        $order = $data['order'];
        //通过id获取地址
        $iosSer = new IOSService();
        $address = $iosSer->getAddressById( $data['id']);
        // 获取用户信息
        if (empty($uid)) {
            return array(
                'status' => false,
                'message' => "请先登录"
            );
        }

        //TODO 防止重复提交订单






        //检查订单是否为空
        if(empty($order)){
            return array('status'=>false,'message'=>'订单为空' );
        }
        //检查货物是否存在、库存是否足够、幸福豆是否足够
        $total = 0;
        foreach($order as $key=>$value){
            $detail = BuyModel::instance()->getDetailBysku($order[$key]['sku']);
            if(empty($detail)){
                return array('status'=>false, 'message'=>"不存在编码为".$order[$key]['sku']."的货物");
            }else if($detail['stock']<$order[$key]['num']){
                return array('status'=>false, 'message'=>"编码为".$detail['sku']."的货物库存不足");
            }else{
                $total += $order[$key]['num'] * $detail['price'];
            }
        }
        $memberSer=new MemberService();
        $user=$memberSer->getMemberByUid($uid);
        if ($user['coupons'] < $total) {
            return array('status'=>false, 'message'=>'幸福豆不足');
        }
        $sno = $this->getSNO();
        $memberSer->saveCoupons($user['uid'], $total, 1);
        // 增加积分记录
        $record=array('coupons'=> -$total,'sno'=>$sno,'remark'=>$remark,'status'=>8,'chargetypes'=>1);

        $couponsSer=new CouponsService();

        $historyid= $couponsSer->reduceCoupons($user['uid'], $record);
        if ($historyid<1){
            return array('status'=>false,'message'=>"财务历史无法添加");
        }

        foreach($order as $key => $value){
            $sku = $order[$key]['sku'];
            $num = $order[$key]['num'];
            $detail = BuyModel::instance()->getDetailBysku($sku);
            // 添加订单
            $arr1 = array(
                'uid' => $user['uid'],
                'name' => $detail['goods_name'],
                'orderno' => $sno,
                'shr' => $user['real_name'],
                'address' => $address['address'],
                'mobile' => $user['mobile_phone'],
                'addtime' => time (),
                'remark' => $remark,
                'num' => $num,
                'coupons' => $total,
                'status' => 1
            );
            OrderModel::instance ()->addOrder ($arr1);
            // 添加订单明细
            $arr2 = array(
                'orderno'=>$sno,
                'goods_id'=>$sku,
                'goods_name'=>$detail['goods_name'],
                'num'=>$num,
                'coupons'=>$detail['price'],
                'coupons_total'=>$detail['price']*$num
            );
            OrderModel::instance ()->addGoods ($arr2);
            //修改库存
            $stock=$detail['stock']-$order[$key]['num'];
            self::setGoodsStockBySKU($sku, $stock);
            $sales=$detail['stock'] + $num;
            self::setGoodsSalesBySKU($sku, $sales);
        }


        return array(
            'status' => true,
            'message' => "订单提交成功"
        );

    }

    //创建订单号
    public function getSNO(){
        $time = time();
        // 创建订单号
        $sjs = rand(1000, 9999);
        return  "XF" . date('YmdHis', $time) . $sjs;
    }

    public function listing ($p)
    {
        $totalnum = BuyModel::instance()->getGoodsNum();
        $page = $this->page($totalnum, $p, $this->_num);
        $rs = BuyModel::instance()->getGoodsByPage($page['start'], $this->_num);
        $rs = $this->parseGoodsStatus($rs);
        return array('goods' => $rs, 'page' => $page);
    }

    //处理产品状态
    public function parseGoodsStatus ($goods)
    {
        $cart = $this->parseCOOKIE();
        $carts = array();
        if (! empty($cart)) {
            foreach ($cart as $v) {
                $carts[] = $v['id'];
            }
        }
        foreach ($goods as $k => $v) {

            if($v['stock']<1){
            unset($goods[$k]);
                continue;
            }

            $cate = $this->getCateById($v['cid']);
            $goods[$k]['categoryname'] = $cate['name'];
            $v['status']=$v['stock']>0?$v['status']:-1;
            $goods[$k]['status']=$v['status'];
           
            $goods[$k]['price']=sprintf($this->_priceFormat,$v['price']);
            $goods[$k]['flag'] = $this->_status[$v['status']];
            //加入图片
            if (in_array($v['sku'], $carts) && ! empty($carts)) {
                $goods[$k]['buy'] = 1;
            } else {
                $goods[$k]['buy'] = 0;
            }
        }
        return $goods;
    }
    public function getCateById ($cid)
    {
        return BuyCateModel::instance()->getCateById($cid);

    }
    public function getGoodsByName ($goodsName)
    {
        return BuyModel::instance()->getGoodsByName($goodsName);
    }
    public function getGoodsByRemark ($remark)
    {
        $remark = urldecode($remark);
        $rs = BuyModel::instance()->getGoodsByRemark($remark);
        $rs = $this->getGoodsImageBySKU($rs);
        return $this->parseGoodsStatus($rs);
    }


    /**
     *
     * 购物车
     * @param int $type 1清空价格 2计算价格
     * @param decimal 折扣
     */
    public function getCart ($type, $discountCard = 1)
    {
        $rs = $this->parseCOOKIE();
        $total = 0; //订单总额
        $count = 0; //商品数
        if (empty($rs)) {
            return array('goods' => $rs, 'money1' => 0, 'money2' => 0,
            'count' => 0);
        }
        //注入特卖系统
        foreach ($rs as $k => $v) {
            $goods = $this->getGoodsBySKU($v['id']);
            //过滤掉已经停产或者售罄的产品
            if ($goods['status'] < 0) {
                unset($rs[$k]);
                continue;
            }
            //如果超过了库存 就不允许再拍了
            if ($goods['stock']<$goods['num']*$v['count']){
                $v['count']=0;
            }


            $cate = $this->getCateById($goods['cid']);
            $rs[$k]['sku'] = $goods['sku'];
            $goods['price'] = $goods['price'] * $discountCard;
            $rs[$k]['price'] = empty($v['snapshot']) || $type == 1 ? $goods['price'] *
             $goods['discount'] : $v['price'];
            $rs[$k]['goods_name'] = $goods['goods_name'];
            $rs[$k]['type'] = $goods['type'];
            $rs[$k]['cid'] = $goods['cid'];
            $rs[$k]['remark'] = $goods['remark'];
            $rs[$k]['count'] = $v['count'];
            $rs[$k]['module'] = $goods['module'];
            //检查快照
            $snapshot = $goods['type'] . " " . $goods['num'] .
             $goods['unit'] . '/件';
            $rs[$k]['snapshot'] = empty($v['snapshot']) ? $snapshot : $v['snapshot'];
            $rs[$k]['special'] = $goods['special'];
            $rs[$k]['num'] = $goods['num'];
            $rs[$k]['party'] = $goods['party'];
            $rs[$k]['unit'] = $goods['unit'];
            $count += $v['count'];
            //特价金额
            if ($goods['special'] == 0) {
                $money1 += $rs[$k]['price'] * $goods['num'] * $v['count'];
            } else {
                $money2 += $rs[$k]['price'] * $goods['num'] * $v['count'];
            }
             //常规金额
        }
        return array('goods' => $rs, 'money1' => $money1, 'money2' => $money2,
        'count' => $count);
    }
    //解析cookie
    private function parseCOOKIE ()
    {
        if (! isset($_COOKIE[$this->_cookie])) {
            return;
        }
        $cookie = $_COOKIE[$this->_cookie];
        $goods = json_decode($cookie);
        $rs = "";
        $i = 0;
        foreach ($goods as $k => $v) {
            if (empty($v->num)) {
                continue;
            }
            $rs[$i]['id'] = $v->sku;
            $rs[$i]['count'] = $v->num;
            $i ++;
        }
        return $rs;
    }
    //检查购物车中是否存在该产品
    private function findCartByGoodsid ($goods_id)
    {
        $goods = $this->parseCOOKIE();
      
        $flag = false;
        if (empty($goods)) {
            return $flag;
        }
        foreach ($goods as $v) {
            if ($goods_id == $v['id']) {
                $flag = true;
            }
        }
        return $flag;
    }
    public function getAllCate ()
    {
        return BuyCateModel::instance()->getAllCate();

    }
   

    public function getGoodsMXBySKU ($sku)
    {
        if (empty($sku) || $sku == "NULL") {
            return;
        }
        
        $info = $this->getGoodsBySKU($sku);  
      
        //主要的
        $newSer=new NewsService(1, 1);
        $news = $newSer->getCon($info['nid']);
        
        $info['title']=$news['content']['title'];
        //找到同款类型的产品
        $other = $this->getGoodsSameType($info['nid'],$info['title']);
        
        //存库为0时
        $info['status']=$info['stock']>0?$info['status']:-1;

        $cate = $this->getCateById($news['content']['cid']);
        $info['price']=sprintf($this->_priceFormat,$info['price']);
        $info['unit'] = $info['unit'];
        $info['buy'] = $this->findCartByGoodsid($info['sku']);
     
       
        //增加浏览量
        $this->addGoodsViewBySKU($sku);
        return array( 'info' => $info,'other' => $other,'category'=>$cate,'news'=>$news['content']);
    }

    //类型相同的
    private function getGoodsSameType ($nid,$title)
    {
        $rs = GoodsModule::instance()->getCon($nid);
        //对应价格和图片
        foreach ($rs as $k => $v) {
            if (empty($v['sku'])) {
                unset($rs[$k]);
                continue;
            }
            $goods = $this->getGoodsBySKU($v['sku']);
            if (empty($goods['sku']) || empty($goods['goods_name'])) {
                unset($rs[$k]);
                continue;
            }

            $rs[$k]['goods_name']=$goods['goods_name'];
            $rs[$k]['goods_id'] = $goods['id'];
            $rs[$k]['price'] = $goods['price'];
            $rs[$k]['num'] = $goods['num'];
        }
        return $rs;
    }
    public function getGoodsBySKU ($sku)
    {
        return BuyModel::instance()->getGoodsBySKU($sku);
    }
    
    public function getRecommendGoodsByCid($cid,$num){
        $rs= BuyModel::instance()->getRecommendGoodsByCid($cid, $num);
        return $this->parseGoodsStatus($rs);
    }
    
    private function addGoodsViewBySKU ($sku)
    {
        return BuyModel::instance()->addGoodsViewBySKU($sku);
    }
    
    //获取库存总数量
    public function getStockNum(){
        $rs= BuyModel::instance()->getStockNum();
        return $rs['total'];
    }
    
    //获取
    public function getSalesNum(){
        $rs= BuyModel::instance()->getSalesNum();
        return $rs['total'];
    }
    
    
    public function getGoodsStatus ()
    {
        return $this->_status;
    }
    
    public function getGoodsModule(){
        return $this->_module;
    }
  
    public function getGoodsById ($goodsId)
    {
        return BuyModel::instance()->getGoodsById($goodsId);
    }
    /**
     * 精确搜索还是模糊搜索
     * @param string $title
     * @return array 1精确  2模糊
     */
    public function search ($title)
    {
        if (empty($title)) {
            return ;
        }
        $title = urldecode($title);
       
        //是否是直接搜索

        $rs = $this->getGoodsLikeTitle($title);
        
        if (empty($rs)){
            $rs[]=$this->getGoodsBySKU($title);
        }
        
        return array('status' => 2, 'data' => $rs);
    }


    /**
     * 修改库存数量
     * @param unknown $sku
     * @param unknown $stock
     * @return number
     */
    public function setGoodsStockBySKU($sku,$stock){
        return BuyModel::instance()->setGoodsStockBySKU($sku, $stock);
    }
    
    public function setGoodsSalesBySKU($sku,$sales){
        return BuyModel::instance()->setGoodsSalesBySKU($sku, $sales);
    }

    //如果没有包含相同的字，那么，进行拼音搜索
    public function getGoodsLikeTitle ($title)
    {
        $rs = BuyModel::instance()->getGoodsLikeTitle($title);
        if (empty($rs)) {
            $py = Pinyin::utf8_to($title, true);
            $rs = BuyModel::instance()->getGoodsLikePinyin($py);
        }
        $goods = $this->parseGoodsStatus($rs);
        return $this->getGoodsImageBySKU($goods);
    }
    /**
     *jquery autocomplete api
     */
    public function getGoodsAPI ($title)
    {
        $rs = $this->search($title);
        if (count($rs) == 1) {
            $arr[0]['value'] = $rs['goods_name'];
            $arr[0]['label'] = $rs['goods_name'];
            return $arr;
        }
        foreach ($rs['data'] as $k => $v) {
            if ($k > 10) {
                break;
            }
            $arr[$k]['value'] = $v['goods_name'];
            $arr[$k]['label'] = $v['goods_name'] . '[' . $v['type'] . ']';
            $arr[$k]['sku'] = $v['sku'];
        }
        return $arr;
    }
    public function saveGoodsById ($value)
    {
        $id = $_POST['id'];
        unset($_POST['id'],$_POST['cid']);
        $data = $_POST;

        $data['recommend'] = ! isset($data['recommend']) ? 0 : 1;
        $flag = BuyModel::instance()->setGoodsById($data, $id);
        if ($flag > 0) {
            return "更新成功";
        } else {
            return "更新失败";
        }
    }
    /**
     * 
     * 拿到所有goods列表方便导出
     */
    public function getAllGoods(){
    	return BuyModel::instance()->getAllGoods();
    }
    
    /**
     * 
     * 导出内容
     * @param array $rs
     */
    public function export($rs){
    	$this->setCsvHeader();
    	$format = "%s,%s,%s,%s,%s,%s,%s,%s,%s\r\n";
    	echo sprintf($format,"产品ID","型号","名字","类型","数量","单位","单价","库存","品牌");
    	foreach ($rs as $value){
    		echo sprintf($format,$value['id'],$value['sku'],$value['goods_name'],$value['type'],$value['num'],$value['unit'],$value['price'],$value['stock'],$value['brand']);
    	}
    }
    
    //csv文件头部
	private function setCsvHeader()
    {
        header("Cache-Control: public");
        header("Pragma: public");
        header("Content-type:application/vnd.ms-excel");
        $file = date("m-d H:i:s", time());
        header("Content-Disposition:attachment;filename=$file.csv");
    }
  
    /**
     * 分页
     *
     * @return void
     */
    private function page ($total, $pageid, $num)
    {
        $pageid = isset($pageid) ? $pageid : 1;
        $start = ($pageid - 1) * $num;
        $pagenum = ceil($total / $num);
        /*修正分类不包含内容 显示404错误*/
        $pagenum = $pagenum == 0 ? 1 : $pagenum;
        /*如果超过了分类页数 404错误*/
        if ($pageid > $pagenum) {
            return false;
        }
        return array('start' => $start, 'num' => $num, 'current' => $pageid,
        'page' => $pagenum,'totalnum'=>$total);
    }
    
    
  
}
