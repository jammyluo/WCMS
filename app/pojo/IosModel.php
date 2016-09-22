<?php
/**
 * Created by PhpStorm.
 * User: yych
 * Date: 2016/06/03
 * Time: 10:41
 */
class IosModel extends Db{

    protected $_goods = 'w_news_goods';
    protected $_address = 'w_stores';
    protected $_member = 'w_member_list';
    protected $_order = 'w_order_list';
    protected $_check = 'y_check_msg';

    /**
     * 发送推荐产品
     */
    public function getRecommend(){
        $sql = "select * from $this->_goods g WHERE g.recommend=1";
        return $this->fetchAll($sql);
    }

    /**
     * 收货地址列表
     */
    public function addressList($uid){
        $sql = "select * from $this->_address a where a.uid=$uid";
        return $this->fetchAll($sql);
    }

    //查找收货地址
    public function getAddressById($id){
        $sql = "select * from $this->_address a WHERE a.id=$id";
        return $this->fetch($sql);
    }

    /**
     * 添加收货地址
     */
    public function addAddress($params){
        return $this->add($this->_address,$params);
    }

    /**
     * @param $params
     * @return array 添加验证短信记录
     */
    public function addCheckMsg($params){
        return $this->add($this->_check, $params);
    }

    public function getCheckMsgByPhone($phone){
        $sql = "select * from $this->_check m where m.phone='$phone' order by m.add_time desc";
        return $this->fetchAll($sql);
    }

    /**
     * 修改收货地址
     */
    public function alterAddress($value, $where){
        return $this->update($this->_address, $value, $where);
    }

    //修改用户信息
    public function alterUserInfo($value, $where){
        return $this->update($this->_member,$value,$where);
    }

    /**
     * @param $value
     * @param $where
     * 修改密码
     */
    public function changePwd($value, $where){
        return $this->update($this->_member, $value, $where);
    }

    //头像上传
    public function headUpload($value, $where){
        return $this->update($this->_member, $value, $where);
    }

    //修改性别
    public function setSex($value, $where){
        return $this->update($this->_member, $value, $where);
    }

    //获得商品分类列表
    public function getClass(){
        $sql = "select c.id,c.name from w_news_category c WHERE c.fid=9";
         return $this->fetchAll($sql);
    }

    //确认收货
    public function confirmReceive($value, $where){
        return $this->update($this->_order, $value, $where);
    }

    /**
     * @return IosModel
     */
    public static function instance(){
        return parent::_instance(__CLASS__);
    }


}