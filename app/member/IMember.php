<?php
interface IMember {
	
	//增加模块信息
	public function add($params);
	
	//删除模块信息
	public function remove($uid);
	//获取信息
	public function getCon($uid);
	//更新信息
	public function saveCon($v, $uid);
}


