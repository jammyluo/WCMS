<?php
/**
 * 
 * 生成账号密钥
 * @author yych
 *
 */
class AppAccountService{
	
	/**
	 * 
	 * 生产随机字符串
	 * @param int $length
	 */
  	protected function getRandChar($length){
	   $str = null;
	   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	   $max = strlen($strPol)-1;
	
	   for($i=0;$i<$length;$i++){
	    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	   }
	
	   return $str;
  	}
  	
	/**
	 * 
	 * 新增账号
	 * @param string $remark
	 * @param int $status
	 */
	public function add($remark, $status){
		$key = $this->getRandChar(20);
		$secrect = $this->getRandChar(20);
		
		$param = array(
			'app_key' => $key,
			'app_secrect' => $secrect,
			'add_time' => time(),
			'remark' => $remark,
			'status' => $status
		);
		AppAccountModel::instance()->addAccount($param);
	}
	/**
	 * 
	 * 查询单条密钥信息
	 * @param int $id
	 */
	public function getOne($id){
		return AppAccountModel::instance()->getAccount($id);
	}
	/**
	 * 
	 * 查询所有密钥信息
	 */
	public function getAll(){
		return AppAccountModel::instance()->getAccounts();
	}

 }
