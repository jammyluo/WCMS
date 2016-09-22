<?php 
class BuyModel extends Db{
    
    private $_goods='w_news_goods';
    
    public function getGoodsNumByCid($cid){
        
        $sql="select a.id from $this->_goods a left join w_news_list b on a.nid=b.id where b.cid=$cid and a.status>-2";
        return $this->rowCount($sql);
    }
    
    
    public function getStockNum(){
        $sql="SELECT sum(stock) total FROM $this->_goods";
        return $this->fetch($sql);
    }
    
    public function getSalesNum(){
        $sql="SELECT sum(sales) total FROM $this->_goods";
        return $this->fetch($sql);
    }
    /**
     * 
     * 获得所有物资方便导出
     */
    public function getAllGoods(){
    	$sql = "select g.id, g.sku, g.goods_name, g.type, g.num, g.unit, g.price, g.stock, g.brand from $this->_goods as g order by g.id desc";
    	return $this->fetchAll($sql);
    }
    
    public function getGoodsNum(){
    
        $sql="select a.id from $this->_goods a left join w_news_list b on a.nid=b.id";
        return $this->rowCount($sql);
    }
    
    public function getGoodsByCid($start,$num,$cid){
        
        $sql="select a.*,b.cid from w_news_goods a left join w_news_list b on a.nid=b.id where b.cid=$cid and a.status>-1  ORDER BY a.id DESC LIMIT $start,$num";
        return $this->fetchAll($sql);
    }

    //获取产品明细信息
    public function getDetailBysku($sku){
        $sql = "select g.*, c.content from $this->_goods g left join w_news_content c on g.nid=c.nid where g.sku='$sku'";
        return $this->fetch($sql);
    }

    public function getGoodsByPage($start,$num){
    
        $sql="select a.*,b.cid from w_news_goods a left join w_news_list b on a.nid=b.id  ORDER BY a.id DESC LIMIT $start,$num";
        return $this->fetchAll($sql);
    }
    
    
    public function getGoodsBySKU($sku){
        return $this->getOne($this->_goods,array('sku'=>$sku));
    }
    
    public function getRecommendGoodsByCid($cid,$limit){
        $sql="SELECT a.* FROM $this->_goods a left join w_news_list b on a.nid=b.id WHERE b.cid=$cid AND a.recommend=1 ORDER BY a.id DESC LIMIT $limit";
        return $this->fetchAll($sql);
    }
    
    public function getGoodsByName($name){
        return $this->getOne($this->_goods,array('goods_name'=>$name));
        
    }
    
    public function addGoodsViewBySKU ($sku)
    {
        $sql = "UPDATE $this->_goods SET view=view+1 WHERE sku='$sku'";
        return $this->exec($sql);
    }
    public function getGoodsLikeTitle ($title)
    {
        $sql = "SELECT *,(sales*0.3+view*0.7+status*1000+recommend*10000) m  FROM $this->_goods WHERE goods_name LIKE \"%$title%\" AND status>=-1 ORDER BY add_time DESC,m DESC LIMIT 20";
        return $this->fetchAll($sql);
    }
    public function getGoodsLikePinyin ($title)
    {
        $sql = "SELECT *,(sales*0.3+view*0.7+status*1000+recommend*10000) m FROM $this->_goods WHERE pinyin LIKE \"%$title%\" AND status>=-1 ORDER BY add_time DESC,m DESC LIMIT 20";
        return $this->fetchAll($sql);
    }
    
   
    public function setGoodsStockBySKU($sku,$stock){
        $sql="UPDATE $this->_goods SET stock=$stock WHERE sku='$sku'";
        return $this->exec($sql);  
    }
    public function setGoodsSalesBySKU($sku,$sales){
        $sql="UPDATE $this->_goods SET sales=$sales WHERE sku='$sku'";
        return $this->exec($sql);
    }
    
    public function getGoodsById($goodsId){
        return $this->getOne($this->_goods,array('id'=>$goodsId)); 
    }
    
    public function setGoodsById($v,$id){  
        return $this->update($this->_goods,$v,array('id'=>$id));
    }
    //获取分类
    
    
    /**
     * 
     * @return BuyModel
     */
    public static function  instance(){
        return parent::_instance(__CLASS__);
    }
    
}