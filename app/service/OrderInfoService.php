<?php

class OrderInfoService
{

    public function getOrderInfoBySNO($sno)
    {
        return OrderInfoModel::instance()->getOrderInfoBySNO($sno);
    }

    //产品销售总计
    public function getGoodsByDate($start, $end)
   {
    $startTime = strtotime(str_replace(".", "-", $start));
    $endTime = strtotime(str_replace(".", "-", $end . " 23:59:59"));
    $this->setCsvHeader();
    $goods = $this->getGoodsNumByDate($startTime, $endTime);
    $format = "%s,%s,%s,%s\n";
    echo sprintf($format,"产品ID","产品编码","产品名称","销售数量","总金额");
    $buySer=new BuyService();

    foreach ($goods as $k => $v) {
        $buy=$buySer->getGoodsBySKU($v['goods_id']);
        echo sprintf($format,$buy['id'], $v['goods_id'], $v['goods_name'], $v['num'],$v['coupons_total']);
    }
    }

    //产品销售明细
    public function getGoodsMXByDate($start, $end)
    {
        $startTime = strtotime(str_replace(".", "-", $start));
        $endTime = strtotime(str_replace(".", "-", $end . " 23:59:59"));
        $this->setCsvHeader();
        $goods = OrderInfoModel::instance()->getGoodsMXByDate($startTime,$endTime);
        $format = "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n";
        $line= sprintf($format,"发货日期","客户编号","客户名称","订单号","产品编码","产品名称","销售数量","单价","金额","备注");
        echo iconv("UTF-8","GBK",$line);
        foreach ($goods as $k => $v) {
            $remark = str_replace ( ",", "", $v ['remark'] );
            $remark = str_replace ( "<br>", "", $remark );


            $line= sprintf($format,date("Y-m-d",$v['action_time']),$v['uid'],$v['shr'],$v['orderno'], $v['goods_id'], $v['goods_name'], $v['num'],$v['coupons'],$v['coupons_total'],$remark);
            echo iconv("UTF-8","GBK",$line);
        }
    }


    private function numToStr($num){
        if (stripos($num,'e')===false) return $num;
        $num = trim(preg_replace('/[=\'"]/','',$num,1),'"');//出现科学计数法，还原成字符串
        $result = "";
        while ($num > 0){
            $v = $num - floor($num / 10)*10;
            $num = floor($num / 10);
            $result   =   $v . $result;
        }
        return $result;
    }
    /**
     * 打印未确认的订单
     */
    public function export($status) {
        $verifyOrder = OrderInfoModel::instance()->getOrderInfoByStatus($status);
        $this->setCsvHeader ();
        echo "序号,收货人,商品名称,单位,单价,数量,总额,备注";
        echo "\n";
        $buySer=new BuyService();
        foreach ( $verifyOrder as $v ) {
            $goods=$buySer->getGoodsBySKU($v['goods_id']);
            //备注中不能存在,号 和换行
            $remark = str_replace ( ",", "", $v ['remark'] );
            $remark = str_replace ( "<br>", "", $remark );
            echo sprintf ( "%s,%s,%s,%s,%s,%s,%s,%s", $v ['id'], $v ['shr'], $v ['goods_name'],$goods['unit'], $v ['coupons'], $v ['num'], $v ['coupons_total'], $remark );
            echo "\n";
        }
    }



    /**
     * 打印未确认的订单
     */
    public function exportBySKU($sku) {
        $verifyOrder = OrderInfoModel::instance()->getOrderInfoBySKU($sku);
        $this->setCsvHeader ();
        echo "序号,下单时间,收货人,商品名称,单位,单价,数量,总额,备注";
        echo "\n";
        $buySer=new BuyService();
        foreach ( $verifyOrder as $v ) {
            $goods=$buySer->getGoodsBySKU($v['goods_id']);
            //备注中不能存在,号 和换行
            $remark = str_replace ( ",", "", $v ['remark'] );
            $remark = str_replace ( "<br>", "", $remark );
            echo sprintf ( "%s,%s,%s,%s,%s,%s,%s,%s", $v ['id'], date("Y-m-d",$v['addtime']),$v ['shr'], $v ['goods_name'],$goods['unit'], $v ['coupons'], $v ['num'], $v ['coupons_total'], $remark );
            echo "\n";
        }
    }
    
    
    private function setCsvHeader()
    {
        header("Cache-Control: public");
        header("Pragma: public");
        header("Content-type:application/vnd.ms-excel");
        $file = date("md", time());
        header("Content-Disposition:attachment;filename=$file.csv");
    }

    /**
     * 获取已经销售的产品
     */
    public function getGoodsNumByDate($startTime, $endTime)
    {
        return OrderInfoModel::instance()->getGoodsNumByDate($startTime, $endTime);
    }

    public function getSalesNumByDate($addTime){
       $rs=OrderInfoModel::instance()->getSalesNumByDate($addTime);
       return $rs['total'];
    }
}

class OrderInfoModel extends Db
{

    private $_table = 'w_order_info';

    public function getGoodsNumByDate($startTime, $endTime)
    {
        $sql = "select a.goods_id,a.goods_name,sum(a.num) num,sum(a.coupons_total) coupons_total from w_order_info a left join w_order_list b on a.orderno=b.orderno where b.addtime>$startTime and b.addtime<$endTime and status=10 group by goods_id";
        return $this->fetchAll($sql);
    }

    public function getGoodsMXByDate($startTime, $endTime)
    {
        $sql = "select a.num,a.goods_id,a.goods_name,a.coupons,a.coupons_total,b.orderno,b.shr,b.action_time,b.remark,b.uid from w_order_info a left join w_order_list b on a.orderno=b.orderno where b.action_time>$startTime and b.action_time<$endTime and status=10 order by b.action_time DESC";
        return $this->fetchAll($sql);
    }

    public function getOrderInfoBySNO($sno)
    {
       $sql="SELECT b.unit,a.* from $this->_table a left join w_news_goods b on a.goods_id=b.sku WHERE a.orderno='$sno'";
       return $this->fetchAll($sql);
    }
    
    
    public function getSalesNumByDate($addTime){
        $sql="SELECT sum(a.num) total from $this->_table a  left join w_order_list b on a.orderno=b.orderno WHERE b.addtime>$addTime AND b.status>0";
        return $this->fetch($sql);
    }
    

    /*获取等待审核的订单*/
    public function getOrderInfoByStatus($status) {
        $sql = "select a.uid,a.id,a.address,a.remark,a.addtime,a.orderno,shr,goods_name,b.goods_id,b.goods_name,b.prices,b.num,b.coupons,b.coupons_total from w_order_list a left join w_order_info b on a.orderno=b.orderno where  status=$status order by shr";
        return $this->fetchAll ( $sql );
    }
    
    /*获取等待审核的订单*/
    public function getOrderInfoBySKU($sku) {
        $sql = "select a.uid,a.id,a.address,a.remark,a.addtime,a.orderno,shr,goods_name,b.goods_id,b.goods_name,b.prices,b.num,b.coupons,b.coupons_total from w_order_list a left join w_order_info b on a.orderno=b.orderno where  b.goods_id='$sku' and status>0 order by addtime desc";
        return $this->fetchAll ( $sql );
    }
    
    
    /**
     *
     * @return OrderInfoModel
     */
    public static function instance()
    {
        return parent::_instance(__CLASS__);
    }
}

?>