<?php
/**
 * 未知模型类型
 * Enter description here ...
 * @author Administrator
 *
 */
interface IModule {
	function getCon($nid); //获取内容模型
	function setCon($data); //设置内容模型
	function add($data); //添加
	function save($data, $nid); //更新
	function temp($type); //对应的模板
	function remove($where);
}