<?php
/**
 * 
 * 生成账号密钥
 * @author yych
 *
 */
class AppAccountModel extends Db{
	/**
	 * 账号签名表
	 */
	protected $_app_account = 'y_app_account';
	/**
	 * 新增账号
	 */
	public function addAccount($params){
		$this->add($this->_app_account, $params);
	}
	/**
	 * 查询账号
	 */
	public function getAccount($id){
		return $this->getOne($this->_app_account,array('id'=>$id));//'id'是否替换为"$this->_app_account.id"
	}
	/**
	 * 显示所有信息
	 */
	public function getAccounts($num = 50){
		$sql = "select * from $this->_app_account as account order by account.id desc limit $num ";
		return $this->fetchAll($sql);
	}
	/**
	 * @return AppAccountModel
	 */
	public static function instance(){
		return self::_instance(__CLASS__);
	}
}