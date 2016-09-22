<?php
class PluginController extends NodeController {
	
	/**
	 * 调用api接口
	 */
	public function api() {
		self::getPluginService ( $_REQUEST ['filter'] )->api ( $_REQUEST ['plugin'] );
	}
	
	/**
	 * 调用api接口
	 */
	public function l() {
		
		if ($_REQUEST ['plugin']) {
			$service = $_REQUEST ['plugin'];
			$plugin = new $service ();
			$plugin->v ();
		
		} else {
			echo "not find plugin!";
		}
	
	}
}