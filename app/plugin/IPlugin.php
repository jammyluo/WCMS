<?php
interface IPlugin {
	//获取插件名字
	function getName();
	//获取插件类型
	function getType();
	//单独页面
	function v();
	//插件执行方法 输出值
	function run();
	//接受值
	function api();
}