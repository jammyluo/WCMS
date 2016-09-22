<?php
//插件服务类
class PluginService {
	const SUCCESS = 'success';
	const ERROR = 'error';
	//过滤类型
	protected $plugins;
	protected $filter;
	//
	protected $invaildPlugin;
	public function __construct($filter) {
		$this->plugins = require 'plugin.php';
		$this->filter = $filter;
		$this->init ();
	}
	//注册插件
	public function init() {
		
		if (empty ( $this->plugins [$this->filter] )) {
			return;
		}
		
		foreach ( $this->plugins [$this->filter] as $v ) {
			
			if (! class_exists ( $v )) {
				continue;
			}
			$iPlugin = new $v ();
			
			if ($iPlugin instanceof IPlugin) {
				$this->invaildPlugin [$v] = $iPlugin;
			}
		
		}
	
	}
	
	//调用单个插件的接口
	public function api($name) {

		if (! isset ( $this->invaildPlugin [$name] )) {
			echo "not found plugin!";
			return self::ERROR;
		}
		
		return $this->invaildPlugin [$name]->api ();
	}
	
	/**
	 * 参数
	 * @param Array $params
	 */
	public function run() {
		if (empty ( $this->invaildPlugin )) {
			return;
		}
		
		foreach ( $this->invaildPlugin as $v ) {
			$v->run ();
		}
	}

}