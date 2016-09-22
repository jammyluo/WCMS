<?php
/**
 * 
 * 生成用户密钥
 * @author yych
 */

class AppaccountController extends Action{
	/**
	 * 
	 * 展示主页
	 */
	public function showIndex(){
		$this->view()->display('file:appaccount/index.tpl');
	}
	/**
	 * 
	 * 展示查询页面
	 */
	public function showSearch(){
		$this->view()->display('file:appaccount/search.tpl');
	}
	/**
	 * 
	 * 展示查看页面
	 */
	public function showView(){
		$var = self::getAccountService()->getAll();
		$this->view()->assign('arr', $var);
		$this->view()->display('file:appaccount/view.tpl');
	}
	/**
	 * 
	 * 添加数据
	 */
	public function add(){
		self::getAccountService()->add($_POST['name'], 1);
		$this->view()->assign('success',"注册成功!");
		$this->view()->display('file:appaccount/index.tpl');
	}
	/**
	 * 
	 * 查看单条数据
	 */
	public function getOne(){
		$var = self::getAccountService()->getOne($_POST['id']);
		$this->view()->assign('arr', $var);
		$this->view()->display('file:appaccount/search.tpl');
	}
	/**
	 * 
	 * 查看所有数据
	 */
	public function getAll(){
		$this->view()->display('file:appaccount/view.tpl');
	}
	/**
	 * 
	 * 调用service方法
	 */
	public static function getAccountService(){
		return new AppAccountService();
	}
}