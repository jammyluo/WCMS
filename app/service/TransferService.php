<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 16/2/1
 * Time: 上午9:35
 */
class TransferService{


    public function add($from,$to){
        $orderInfo=array('fromsno'=>$from['orderno'],
            'from_username'=>$from['real_name'],
            'tosno'=>$to['orderno'],
            'to_username'=>$to['real_name'],
            'add_time'=>time());
        return TransferModel::instance()->addHistory($orderInfo);
    }

    //转账信息
    public function getTansferByFromsno($fromsno){
        return TransferModel::instance()->getTansferByFromsno($fromsno);
    }

}

class TransferModel extends Db{

    private $_table='w_transfer_history';

    public function addHistory($params){
        return $this->add($this->_table,$params);
    }

    public function getTansferByFromsno($fromsno){
        return $this->getOne($this->_table,array('fromsno'=>$fromsno));
    }

    /**
     * @return TransferModel
     */
    public  static function instance(){
        return parent::_instance(__CLASS__);
    }


}