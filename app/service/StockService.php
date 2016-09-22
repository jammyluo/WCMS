<?php

class StockService
{

    private $_num = 40;

    /**
     * 入库
     * 
     * @param unknown $data            
     * @return multitype:boolean string
     */
    public function addStock($data, $uid)
    {
        $buySer = new BuyService();
        $goods = $buySer->getGoodsBySKU($data['sku']);
        $stock = $goods['stock'] + $data['num'];
        $rs = $buySer->setGoodsStockBySKU($data['sku'], $stock);
        if ($rs > 0) {
            $this->addStockHistory($data, $uid);
            return array(
                'status' => true,
                'message' => "入库成功!"
            );
        } else {
            return array(
                'status' => false,
                'message' => "入库失败"
            );
        }
    }

    private function addStockHistory($goodsInfo, $uid)
    {
        $goodsInfo['uid'] = $uid;
        $goodsInfo['add_time'] = time();
        $goodsInfo['total_money'] = $goodsInfo['num'] * $goodsInfo['money'];
        
        return StockModel::instance()->addStockHistory($goodsInfo);
    }

    public function getStockBySKU($p,$sku)
    {
        $total = StockModel::instance()->getStockPageNum(array('sku'=>$sku));
        $page = $this->page($total, $p, $this->_num);
        $rs= StockModel::instance()->getStockBySKU($page['start'], $this->_num, $sku);
        $stock=$this->parseStock($rs);
        return array('page'=>$page,'data'=>$stock,'total'=>$total);
    }

    public function exportBySuppliers($suppliersId, $start_time, $end_time)
    {
        $suppliersSer = new SuppliersService();
        $suppliers = $suppliersSer->getSuppliersById($suppliersId);
        
        $rs = $this->getStockBySuppliers($suppliersId, $start_time, $end_time);
        $this->setCsvHeader($suppliers['username']);
        $format = "%s,%s,%s,%s,%s,%s,%s,%s\n";
        echo sprintf($format, "进货时间", "产品编码", "产品名", "供应商id", "供应商名", "单价", "进货数量", "总价");
        if (empty($rs)) {
            return;
        }
        
        foreach ($rs as $k => $v) {
            echo sprintf($format, date("Y-m-d", $v['add_time']), $v['sku'], $v['goods_name'], $suppliersId, $suppliers['username'], $v['money'], $v['num'], $v['total_money']);
        }
    }

    public function getStockByPage($p)
    {
        $total = StockModel::instance()->getStockPageNum(null);
        $page = $this->page($total, $p, $this->_num);
        $rs = StockModel::instance()->getStockByPage($page['start'], $this->_num);
        $stock=$this->parseStock($rs);
        return array('page'=>$page,'data'=>$stock,'total'=>$total);
    }

    
    
    private function parseStock($stock){
        $memberSer=new MemberService();
        foreach($stock as $k=>$v){
            $user=$memberSer->getMemberByUid($v['uid']);
            $stock[$k]['action_name']=$user['real_name'];
        }
        return $stock;
    }
    /**
     * 分页
     *
     * @return Array
     */
    private function page($total, $pageid, $num)
    {
        $pageid = isset($pageid) ? $pageid : 1;
        $start = ($pageid - 1) * $num;
        $pagenum = ceil($total / $num);
        /* 修正分类不包含内容 显示404错误 */
        $pagenum = $pagenum == 0 ? 1 : $pagenum;
        /* 如果超过了分类页数 404错误 */
        
        if ($pageid > $pagenum) {
            return false;
        }
        
        $page = array(
            'start' => $start,
            'num' => $num,
            'current' => $pageid,
            'page' => $pagenum
        );
        return $page;
    }

    private function getStockBySuppliers($suppliers, $start_time, $end_time)
    {
        return StockModel::instance()->getStockBySuppliers($suppliers, $start_time, $end_time);
    }

    private function setCsvHeader($filename)
    {
        header("Cache-Control: public");
        header("Pragma: public");
        header("Content-type:application/vnd.ms-excel");
        $file = $filename . date("md", time());
        header("Content-Disposition:attachment;filename=$file.csv");
    }

    public function getMoneyBySuppliers($suppliers, $start_time, $end_time)
    {
        return StockModel::instance()->getMoneyBySuppliers($suppliers, $start_time, $end_time);
    }
    
    // 获取库存
    public function getStockNum($addTime)
    {
        $rs = StockModel::instance()->getStockNum($addTime);
        return $rs['total'];
    }

    public function removeStockById($id,$actionName)
    {
        $history = StockModel::instance()->getStockById($id);
        if (empty($history)) {
            return array(
                'status' => false,
                'message' => "删除失败"
            );
        }
        
        $buy = new BuyService();
        $goods = $buy->getGoodsBySKU($history['sku']);
        if (empty($goods)) {
            return array(
                'status' => false,
                'message' => "没有找到产品档案!"
            );
        }
        
        $rs = StockModel::instance()->deleteById($id);
        $stock = $goods['stock'] - $history['num'];
        $ret = $buy->setGoodsStockBySKU($history['sku'], $stock);
        if ($ret > 0) {
            
            $log=new LogService();
            $event="取消入库".$goods['goods_name'].$history['num'];
            $log->add($actionName, $event);
            
            return array(
                'status' => true,
                'message' => "删除成功"
            );
        } else {
            return array(
                'status' => false,
                "message" => "删除失败"
            );
        }
    }
}

class StockModel extends Db
{

    private $_stock = 'w_goods_stock';

    private $_goods = 'w_news_goods';

    public function addStockHistory($params)
    {
        return $this->add($this->_stock, $params);
    }

    public function deleteById($id)
    {
        return $this->delete($this->_stock, array(
            'id' => $id
        ));
    }
    
    

    public function getStockById($id)
    {
        return $this->getOne($this->_stock, array(
            'id' => $id
        ));
    }

    public function getStockPageNum($where)
    {
        return $this->getNum($this->_stock, 'id',$where);
    }

    public function getStockByPage($start, $num)
    {
        $sql = "SELECT a.*,b.goods_name FROM $this->_stock a LEFT JOIN $this->_goods b ON a.sku=b.sku ORDER BY id DESC LIMIT $start,$num";
        return $this->fetchAll($sql);
    }

    public function getStockBySuppliers($suppliers, $start_time, $end_time)
    {
        $sql = "SELECT a.*,b.goods_name FROM $this->_stock a left join $this->_goods b on a.sku=b.sku WHERE a.suppliers=$suppliers AND a.add_time>$start_time  AND a.add_time<$end_time";
        return $this->fetchAll($sql);
    }

    public function getStockNum($addTime)
    {
        $sql = "SELECT sum(num) total FROM $this->_stock WHERE add_time>$addTime";
        return $this->fetch($sql);
    }

    public function getMoneyBySuppliers($suppliers, $start_time, $end_time)
    {
        $sql = "SELECT sum(total_money) total,sum(num) num FROM $this->_stock WHERE add_time>$start_time AND add_time<$end_time AND suppliers=$suppliers";
        return $this->fetch($sql);
    }

    public function getStockBySKU($start, $num, $sku)
    {
        $sql = "SELECT a.*,b.goods_name FROM $this->_stock a LEFT JOIN $this->_goods b ON a.sku=b.sku WHERE a.sku='$sku' ORDER BY id DESC LIMIT $start,$num";
        return $this->fetchAll($sql);
        
    }

    /**
     *
     * @return StockModel
     */
    public static function instance()
    {
        return parent::_instance(__CLASS__);
    }
}
?>