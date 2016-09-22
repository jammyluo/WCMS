<?php
/**
 * 
 * 特点 支持多语言
 * @author Wolf
 *
 */
class GoodsModule extends Module
{
    protected $_type = 4;
    //二维数组
    protected $_keys = array('nodeid', 'nid', 'sku', 'goods_name', 'weight',  'image');
    protected $_con;
    protected $_temp = array('add' => 'file:module/goods.add.tpl', 
    'edit' => 'file:module/goods.edit.tpl', 'list' => 'file:news/list.tpl');
    /* (non-PHPdoc)
     * @see IModule::edit()
     */
    public function edit ($nid)
    {}
    /* (non-PHPdoc)
     * @see Module::listing()
     */
    public function listing ($page, $cids, $order)
    {
        // TODO Auto-generated method stub
    }
    /* (non-PHPdoc) 可能的情况 只有一张图片的情况下 增加或减少
     * @see Module::save()
     */
    public function save ($data, $nid)
    {
       
        //检查是否 与原来是否
        $this->setCon($data);
        $where = array('nid' => $nid);
        $new = $this->getCon($nid); //提交数据
        $this->_con = null;
        $old = $this->getCon($nid); //旧数据
        //相等的
        if ($new == $old) {
            return;
        }
        //不相等 只有新增  删除方法 单独调用
        foreach ($new as $v) {
            //如果存在就更新 不存在就新增
            if (empty($v['id'])) {
                unset($v['id'], $v['nodeid']);
                ModuleModel::instance()->addModuleCon($v, $this->_type);
                continue;
            }
            //图片处理
            if (empty($v['image'])) {
                unset($v['image']);
            }
            //检测sku是否重复
            if ($this->checkSkuRepeat($v['sku'])) {
                $v['sku'] = "sku repeat";
            }
            $where = array('id' => $v['id']);
            unset($v['nid'], $v['id'], $v['nodeid']);
            ModuleModel::instance()->saveModuleCon($v, $where, $this->_type);
        }
        return;
    }
    /* (non-PHPdoc)
     * @see Module::temp()
     */
    public function temp ($type)
    {
        // TODO Auto-generated method stub
        return $this->_temp[$type];
    }
    /* (non-PHPdoc)
     * @see Module::add()
     */
    public function add ($data)
    {
        $this->setCon($data);
        foreach ($this->getCon(0) as $v) {
            //检测sku是否重复
            if ($this->checkSkuRepeat($v['sku'])) {
                $v['sku'] = "sku repeat";
            }
            
           
            unset($v['nodeid'], $v['id']);
            ModuleModel::instance()->addModuleCon($v, $this->_type);
        }
    }
    
   
   
    
    /**
     * 没有SKU时，自动生成一个SKU
     * @see Module::setCon()
     */
    public function setCon ($data)
    {
        $uploadfile = array();
        //空节点的情况
        foreach ($_FILES['image']['name'] as $k => $v) {
            $uploadfile[$k]['name'] = $v;
            $uploadfile[$k]['type'] = $_FILES['image']['type'][$k];
            $uploadfile[$k]['tmp_name'] = $_FILES['image']['tmp_name'][$k];
            $uploadfile[$k]['size'] = $_FILES['image']['size'][$k];
            $uploadfile[$k]['error'] = $_FILES['image']['error'][$k];
        }
        $rs = array();
        
        foreach ($data['goods_name'] as $k => $v) {
            foreach ($this->_keys as $kv) {
                $rs[$k][$kv] = $data[$kv][$k];
            }
            $upfile=$this->thumb($uploadfile[$k]);
            $rs[$k]['image'] =$upfile['message'];
            $rs[$k]['id'] = $data['nodeid'][$k];
            $rs[$k]['nid'] = $data['nid'];
        }
        $this->_con = $rs;
    }
    /* (non-PHPdoc)
     * @see IModule::getCon()
     */
    public function getCon ($nid)
    {
        if (! empty($this->_con))
            return $this->_con;
        $where = array('nid' => $nid);
        //递归获取其他专题的内容
        return ModuleModel::instance()->getModuleCon($where, 
        $this->_type);
    }
    /**
     * 
     * 根据SKU来获取产品信息
     * @param String $sku
     */
    public function getConBySku ($sku)
    {
        $rs = ModuleModel::instance()->getModuleCon(array('sku' => $sku), 
        $this->_type);
        return $rs[0];
    }
   
    /**
     * 
     * @param string $value
     * @param string $type
     */
    public function search ($value, $type)
    {
        if ($type == 'sku') {
            $rs = GoodsModel::instance()->getGoodsBySKU($value);
        } else 
            if ($type == 'name') {
                $rs = GoodsModel::instance()->getGoodsLikeName($value);
            }
        $cateServer = new CateService();
        foreach ($rs as $k => $v) {
            $cate = $cateServer->getCateById($v['cid']);
            $rs[$k]['mid'] = $cate['module'];
            $rs[$k]['category_name'] = $cate['name'];
        }
        return $rs;
    }
    /**
     * 
     * 检测sku是否重复
     * @param string $sku
     * @return Boolean true:是 false:否 
     */
    private function checkSkuRepeat ($sku)
    {
        $rs = ModuleModel::instance()->getModuleCon(array('sku' => $sku), 
        $this->_type);
        return count($rs) > 1;
    }
    /* (non-PHPdoc)
     * @see IModule::remove()
     */
    public function remove ($where)
    {
        // TODO Auto-generated method stub
        $rs = ModuleModel::instance()->getModuleCon($where, 
        $this->_type);
        foreach ($rs as $v) {
            @unlink(ROOT . $v['image']);
        }
        return ModuleModel::instance()->removeModuleCon($where, $this->_type);
    }
    /**
     * 
     * @return GoodsModule
     */
    public static function instance ()
    {
        return parent::getInstance(__CLASS__);
    }
}
class GoodsModel extends Db
{
    private $_goods = 'w_news_goods';
    public function getGoodsLikeName ($name)
    {
        $sql = "select b.* from $this->_goods a left join w_news_list b on a.nid=b.id where a.goods_name like '%$name%' group by a.nid ORDER BY id DESC";
        return $this->fetchAll($sql);
    }
    public function getGoodsBySKU ($sku)
    {
         $sql = "select b.* from $this->_goods a left join w_news_list b on a.nid=b.id where a.sku='$sku' group by a.nid ORDER BY id DESC";
        return $this->fetchAll($sql);
    }
    /**
     * 
     * @return GoodsModel
     */
    public static function instance ()
    {
        return parent::_instance(__CLASS__);
    }
}